<?php
/* Template Name: Interactive Trip Importer (Bilingual + Activities) */

// SECURITY CHECK
if (!current_user_can('edit_posts')) {
    wp_die('You do not have permission to access this tool.');
}

$results = [];

/**
 * HELPER: Handle Bilingual Taxonomy Terms (Destinations & Activities)
 */
function nextur_ensure_bilingual_terms($term_names, $taxonomy = 'destination') {
    $lang_terms = ['id' => [], 'en' => []];

    if (!is_array($term_names)) return $lang_terms;

    foreach ($term_names as $name) {
        $name = trim($name);
        if (empty($name)) continue;

        // 1. Check/Create INDONESIAN Term
        $term_id_id = nextur_get_or_create_term($name, $taxonomy, 'id');

        // 2. Check/Create ENGLISH Term
        $term_id_en = nextur_get_or_create_term($name, $taxonomy, 'en');

        // 3. Link them if both exist
        if ($term_id_id && $term_id_en && function_exists('pll_save_term_translations')) {
            pll_save_term_translations([
                'id' => $term_id_id,
                'en' => $term_id_en
            ]);
        }

        if ($term_id_id) $lang_terms['id'][] = (int) $term_id_id;
        if ($term_id_en) $lang_terms['en'][] = (int) $term_id_en;
    }

    return $lang_terms;
}

/**
 * HELPER: Get or Create a specific term in a specific language
 */
function nextur_get_or_create_term($name, $taxonomy, $lang_code) {
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'name' => $name,
        'hide_empty' => false,
        'lang' => $lang_code
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        return $terms[0]->term_id;
    }

    // Not found? Create it.
    $new_term = wp_insert_term($name, $taxonomy);
    
    if (is_wp_error($new_term)) {
        if (isset($new_term->error_data['term_exists'])) {
            $existing_id = $new_term->error_data['term_exists'];
            pll_set_term_language($existing_id, $lang_code);
            return $existing_id;
        }
        return false;
    }

    $term_id = $new_term['term_id'];
    if (function_exists('pll_set_term_language')) {
        pll_set_term_language($term_id, $lang_code);
    }

    return $term_id;
}

/**
 * MAIN: Process a single language trip post
 */
function nextur_create_trip_post($lang_data, $common_data, $lang_code, $dest_ids, $activity_ids) {
    if (empty($lang_data['title'])) return new WP_Error('missing_title', 'Title is required');

    // 1. Check if post exists
    $args = [
        'post_type' => 'trip',
        'title'     => $lang_data['title'],
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'numberposts' => 1,
        'lang' => $lang_code 
    ];
    $existing = get_posts($args);

    if ($existing) {
        $post_id = $existing[0]->ID;
        $is_update = true;
        wp_update_post(['ID' => $post_id, 'post_title' => $lang_data['title']]);
    } else {
        $post_id = wp_insert_post([
            'post_title'   => $lang_data['title'],
            'post_type'    => 'trip',
            'post_status'  => 'publish',
        ]);
        $is_update = false;
    }

    if (is_wp_error($post_id)) return $post_id;

    // 2. Set Language
    if (function_exists('pll_set_post_language')) {
        pll_set_post_language($post_id, $lang_code);
    }

    // 3. Meta Data
    $all_meta = array_merge(
        isset($common_data['meta']) ? $common_data['meta'] : [],
        isset($lang_data['meta']) ? $lang_data['meta'] : []
    );
    $html_fields = ['_trip_includes', '_trip_excludes', '_trip_optional', '_trip_terms', '_trip_payment_terms'];

    foreach ($all_meta as $key => $value) {
        if (in_array($key, $html_fields)) {
            update_post_meta($post_id, $key, wp_kses_post($value));
        } else {
            update_post_meta($post_id, $key, sanitize_text_field($value));
        }
    }

    // 4. Itinerary
    if (!empty($lang_data['itinerary']) && is_array($lang_data['itinerary'])) {
        update_post_meta($post_id, '_trip_itinerary', $lang_data['itinerary']);
    }

    // 5. Assign Destinations
    if (!empty($dest_ids)) {
        wp_set_object_terms($post_id, array_map('intval', $dest_ids), 'destination');
    }

    // 6. Assign Activities (NEW)
    if (!empty($activity_ids)) {
        wp_set_object_terms($post_id, array_map('intval', $activity_ids), 'activity');
    }

    return ['id' => $post_id, 'status' => $is_update ? 'Updated' : 'Created'];
}

// HANDLE SUBMISSION
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
                $results[] = ['type' => 'error', 'msg' => "Item #$index skipped: Data incomplete."];
                continue;
            }

            $common = isset($trip_pair['common']) ? $trip_pair['common'] : [];
            
            // A. Prepare Terms
            $dest_ids = ['id' => [], 'en' => []];
            if (!empty($common['destination'])) {
                $dest_ids = nextur_ensure_bilingual_terms($common['destination'], 'destination');
            }

            $act_ids = ['id' => [], 'en' => []];
            if (!empty($common['activities'])) {
                $act_ids = nextur_ensure_bilingual_terms($common['activities'], 'activity');
            }

            // B. Process Posts
            $res_id = nextur_create_trip_post($trip_pair['id'], $common, 'id', $dest_ids['id'], $act_ids['id']);
            $res_en = nextur_create_trip_post($trip_pair['en'], $common, 'en', $dest_ids['en'], $act_ids['en']);

            if (is_wp_error($res_id) || is_wp_error($res_en)) {
                $results[] = ['type' => 'error', 'msg' => "Error processing Item #$index."];
                continue;
            }

            // C. Link Translations
            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations(['id' => $res_id['id'], 'en' => $res_en['id']]);
            }

            $results[] = [
                'type' => 'success', 
                'msg' => "<strong>Success:</strong> ID & EN Linked. Dest: " . count($dest_ids['id']) . ", Act: " . count($act_ids['id'])
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
                <p class="text-slate-400 text-sm mt-1">Paste your AI-generated JSON. Now supports <strong>Activities</strong> & Destinations.</p>
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