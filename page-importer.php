<?php
/* Template Name: Interactive Trip Importer (Bilingual) */

// SECURITY CHECK: Only Admins/Editors can access this
if (!current_user_can('edit_posts')) {
    wp_die('You do not have permission to access this tool.');
}

$results = [];

// HELPER: Process a single language trip
function nextur_create_trip_post($lang_data, $common_data, $lang_code) {
    if (empty($lang_data['title'])) return new WP_Error('missing_title', 'Title is required');

    // 1. Check if post exists (by Title)
    $existing = get_posts([
        'post_type' => 'trip',
        'title'     => $lang_data['title'],
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'numberposts' => 1,
        'lang' => '' // Query all languages
    ]);

    if ($existing) {
        $post_id = $existing[0]->ID;
        $is_update = true;
    } else {
        // 2. Create New Post (DRAFT)
        $post_id = wp_insert_post([
            'post_title'   => $lang_data['title'],
            'post_type'    => 'trip',
            'post_status'  => 'draft', 
        ]);
        $is_update = false;
    }

    if (is_wp_error($post_id)) return $post_id;

    // 3. Set Polylang Language
    if (function_exists('pll_set_post_language')) {
        pll_set_post_language($post_id, $lang_code);
    }

    // 4. Merge Meta Data (Common + Specific)
    $all_meta = array_merge(
        isset($common_data['meta']) ? $common_data['meta'] : [],
        isset($lang_data['meta']) ? $lang_data['meta'] : []
    );

    // Define fields that contain HTML (Inclusions, Terms, etc.)
    $html_fields = ['_trip_includes', '_trip_excludes', '_trip_optional', '_trip_terms', '_trip_payment_terms'];

    foreach ($all_meta as $key => $value) {
        if (in_array($key, $html_fields)) {
            // Allow HTML tags for these specific fields
            update_post_meta($post_id, $key, wp_kses_post($value));
        } else {
            // Standard sanitization for text fields
            update_post_meta($post_id, $key, sanitize_text_field($value));
        }
    }

    // 5. Handle Itinerary
    if (!empty($lang_data['itinerary']) && is_array($lang_data['itinerary'])) {
        update_post_meta($post_id, '_trip_itinerary', $lang_data['itinerary']);
    }

    // 6. Handle Destination (Common)
    if (!empty($common_data['destination'])) {
        wp_set_object_terms($post_id, $common_data['destination'], 'destination');
    }

    return ['id' => $post_id, 'status' => $is_update ? 'Updated' : 'Created'];
}

// HANDLE FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json_data'])) {
    
    $json_raw = stripslashes($_POST['json_data']);
    $trips = json_decode($json_raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $results[] = ['type' => 'error', 'msg' => 'Invalid JSON Format: ' . json_last_error_msg()];
    } elseif (!is_array($trips)) {
        $results[] = ['type' => 'error', 'msg' => 'JSON must be an array of objects.'];
    } else {
        
        foreach ($trips as $index => $trip_pair) {
            
            if (!isset($trip_pair['id']) || !isset($trip_pair['en'])) {
                $results[] = ['type' => 'error', 'msg' => "Item #$index skipped: Must contain keys 'id' and 'en'."];
                continue;
            }

            $common = isset($trip_pair['common']) ? $trip_pair['common'] : [];

            // Process ID & EN
            $res_id = nextur_create_trip_post($trip_pair['id'], $common, 'id');
            $res_en = nextur_create_trip_post($trip_pair['en'], $common, 'en');

            if (is_wp_error($res_id) || is_wp_error($res_en)) {
                $results[] = ['type' => 'error', 'msg' => "Error processing Item #$index."];
                continue;
            }

            // Link Translations
            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations([
                    'id' => $res_id['id'],
                    'en' => $res_en['id']
                ]);
                $linked_msg = " & Linked";
            } else {
                $linked_msg = " (Polylang missing)";
            }

            $results[] = [
                'type' => 'success', 
                'msg' => "<strong>Success:</strong> ID [{$res_id['status']}] + EN [{$res_en['status']}]$linked_msg for '{$trip_pair['id']['title']}'"
            ];
        }
    }
}

get_header(); 
?>

<div class="min-h-screen bg-slate-100 py-20">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 border-b border-slate-700">
                <h1 class="text-2xl font-bold text-white font-heading">Bilingual Trip Vessel Creator</h1>
                <p class="text-slate-400 text-sm mt-1">Paste your AI-generated JSON below. Supports HTML lists for Terms/Inclusions.</p>
            </div>
            <div class="p-8">
                <?php if (!empty($results)): ?>
                    <div class="mb-8 space-y-2 bg-slate-50 p-4 rounded-lg border border-slate-200 max-h-60 overflow-y-auto shadow-inner">
                        <?php foreach ($results as $res): ?>
                            <div class="text-sm p-3 rounded border <?php echo $res['type'] === 'success' ? 'bg-green-50 text-green-800 border-green-200' : 'bg-red-50 text-red-800 border-red-200'; ?>">
                                <?php echo $res['msg']; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">JSON Payload</label>
                        <textarea name="json_data" rows="20" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-4 font-mono text-xs focus:ring-2 focus:ring-brand focus:border-brand outline-none" placeholder="Paste JSON here..."></textarea>
                    </div>
                    <button type="submit" class="bg-brand hover:bg-brand-dark text-white font-bold py-3 px-8 rounded-lg shadow-lg">Run Importer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>