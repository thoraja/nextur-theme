<?php
/**
 * Helper Functions
 */

/* -------------------------------------------------------------------------- */
/* HELPER: SMART TERM IMAGE (Manual Upload > Latest Trip > Fallback)          */
/* -------------------------------------------------------------------------- */
function nextur_get_term_image_url($term_id = null, $taxonomy = 'destination') {
    // 1. Auto-detect ID if on an archive page
    if (!$term_id && is_tax()) {
        $obj = get_queried_object();
        $term_id = $obj->term_id;
        $taxonomy = $obj->taxonomy;
    }

    // 2. CHECK MANUAL UPLOAD FIRST (New Logic)
    // We check if you uploaded a specific image for this Activity/Destination in Admin
    $manual_img_id = get_term_meta($term_id, 'activity_image_id', true);
    if ($manual_img_id) {
        $img_src = wp_get_attachment_image_url($manual_img_id, 'large');
        if ($img_src) return $img_src;
    }

    // 3. Fallback: Query the latest trip in this term
    $args = array(
        'post_type'      => 'trip',
        'posts_per_page' => 1,
        'tax_query'      => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
    );
    
    $latest_trip = new WP_Query($args);
    
    if ($latest_trip->have_posts()) {
        $latest_trip->the_post();
        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        wp_reset_postdata();
        if ($img_url) return $img_url;
    }

    // 4. Final Fallback (Placeholder)
    return 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&q=80'; 
}

// 2. Helper: Get Random Trips for Sidebar Cross-Sell
function nextur_get_random_trips($count = 3) {
    $args = array(
        'post_type'      => 'trip',
        'posts_per_page' => $count,
        'orderby'        => 'rand',
    );
    return new WP_Query($args);
}

// 3. Helper: Get the Target Email
function nextur_get_target_email() {
    // Try to get the email from the Customizer setting we made earlier
    $target = get_theme_mod('company_email');
    
    // If empty, fallback to the main WordPress Admin Email
    if (empty($target)) {
        $target = get_option('admin_email');
    }
    return $target;
}

/* -------------------------------------------------------------------------- */
/* NEW HELPERS for Templates                                                  */
/* -------------------------------------------------------------------------- */

// 4. Helper: Get Featured Trips (Hero)
function nextur_get_featured_trips() {
    $hero_args = array(
        'post_type'      => 'trip',
        'posts_per_page' => 5,
        'meta_key'       => '_trip_is_featured',
        'meta_value'     => '1'
    );
    return new WP_Query($hero_args);
}

// 5. Helper: Get All Trips (Slider)
function nextur_get_all_trips() {
    $args = array('post_type' => 'trip', 'posts_per_page' => 12, 'orderby' => 'date', 'order' => 'DESC');
    return new WP_Query($args);
}

// 6. Helper: Get Highlight Destinations (Gallery items CPT)
function nextur_get_highlight_destinations() {
    $args = array('post_type' => 'gallery_item', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC');
    return new WP_Query($args);
}

// 7. Helper: Get Journal Posts
function nextur_get_journal_posts($count = 3) {
    return new WP_Query(array('post_type' => 'post', 'posts_per_page' => $count, 'ignore_sticky_posts' => 1));
}

// 8. Helper: Get Formatted Price or "Contact Us" string
function nextur_get_formatted_price($post_id) {
    $price = get_post_meta($post_id, '_trip_price', true);
    if ($price) {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
    return function_exists('pll_e') ? pll__('Hubungi Kami') : __('Hubungi Kami', 'nextur');
}
