<?php
/* Template Name: Interactive Trip Importer */

// SECURITY CHECK: Only Admins/Editors can access this
if (!current_user_can('edit_posts')) {
    wp_die('You do not have permission to access this tool.');
}

$results = [];

// HANDLE FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json_data'])) {
    
    // 1. Decode JSON
    $json_raw = stripslashes($_POST['json_data']); // Remove escape characters if added by WP
    $trips = json_decode($json_raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $results[] = ['type' => 'error', 'msg' => 'Invalid JSON Format: ' . json_last_error_msg()];
    } elseif (!is_array($trips)) {
        $results[] = ['type' => 'error', 'msg' => 'JSON must be an array of objects.'];
    } else {
        
        // 2. Loop through Trips
        foreach ($trips as $index => $trip_data) {
            
            // Validation
            if (empty($trip_data['title'])) {
                $results[] = ['type' => 'error', 'msg' => "Item #$index missing 'title'."];
                continue;
            }

            // A. Duplicate Check
            $existing_post = get_posts([
                'post_type' => 'trip',
                'title'     => $trip_data['title'],
                'post_status' => 'any',
                'numberposts' => 1
            ]);

            if ($existing_post) {
                // Update Existing
                $post_id = $existing_post[0]->ID;
                $action_log = "Updated existing trip";
            } else {
                // Insert New
                $post_id = wp_insert_post([
                    'post_title'   => $trip_data['title'],
                    'post_type'    => 'trip',
                    'post_status'  => 'publish',
                    'post_content' => '' // Content will be filled via Meta/Tabs usually
                ]);
                $action_log = "Created new trip";
            }

            if (is_wp_error($post_id)) {
                $results[] = ['type' => 'error', 'msg' => "Failed to save: " . $trip_data['title']];
                continue;
            }

            // B. Save Meta Fields (Simple & Rich Text)
            if (!empty($trip_data['meta']) && is_array($trip_data['meta'])) {
                foreach ($trip_data['meta'] as $key => $value) {
                    // Sanitize logic based on key could go here, but for import tool we assume trusted input
                    update_post_meta($post_id, $key, $value); // wp_kses_post applied on output usually, but allow HTML here
                }
            }

            // C. Save Itinerary (The Array)
            // Logic: Your Native Meta Box expects a serialized array in '_trip_itinerary'
            if (!empty($trip_data['itinerary']) && is_array($trip_data['itinerary'])) {
                update_post_meta($post_id, '_trip_itinerary', $trip_data['itinerary']);
            }

            // D. Handle Taxonomy (Destination)
            if (!empty($trip_data['destination'])) {
                $term_name = $trip_data['destination'];
                $term = term_exists($term_name, 'destination');
                
                if (!$term) {
                    $term = wp_insert_term($term_name, 'destination');
                }
                
                if (!is_wp_error($term)) {
                    $term_id = isset($term['term_id']) ? $term['term_id'] : $term;
                    wp_set_object_terms($post_id, (int)$term_id, 'destination');
                }
            }

            $results[] = ['type' => 'success', 'msg' => "<strong>$action_log:</strong> " . $trip_data['title']];
        }
    }
}

get_header(); 
?>

<div class="min-h-screen bg-slate-100 py-20">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6">
                <h1 class="text-2xl font-bold text-white font-heading">Interactive Trip Importer</h1>
                <p class="text-slate-400 text-sm mt-1">Paste your AI-generated JSON below to populate the database.</p>
            </div>

            <div class="p-8">
                
                <!-- Feedback Log -->
                <?php if (!empty($results)): ?>
                    <div class="mb-8 space-y-2 bg-slate-50 p-4 rounded-lg border border-slate-200 max-h-60 overflow-y-auto">
                        <?php foreach ($results as $res): ?>
                            <div class="text-sm p-2 rounded <?php echo $res['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $res['msg']; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Import Form -->
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">JSON Payload</label>
                        <textarea name="json_data" rows="15" 
                                  class="w-full bg-slate-50 border border-slate-300 rounded-lg p-4 font-mono text-xs focus:ring-2 focus:ring-brand focus:border-brand outline-none"
                                  placeholder='[
    {
        "title": "8D Enjoy Beautiful China",
        "destination": "China",
        "meta": {
            "_trip_subtitle": "Chongqing Chengdu",
            "_trip_price": 14500000
        },
        "itinerary": [
            {"title": "Day 1", "desc": "Arrival..."}
        ]
    }
]'></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-500">Ensure JSON is valid before clicking Import.</span>
                        <button type="submit" class="bg-brand hover:bg-brand-dark text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                            Run Import Process
                        </button>
                    </div>
                </form>

            </div>
        </div>
        
    </div>
</div>

<?php get_footer(); ?>