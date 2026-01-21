<?php
/**
 * Custom Post Types & Taxonomies
 */

function nextur_init_structure() {
    // 1. Post Type: Trip
    register_post_type('trip', array(
        'labels' => array('name' => 'Trips', 'singular_name' => 'Trip'),
        'public' => true,
        'has_archive' => 'trips', 
        'menu_icon' => 'dashicons-airplane',
        'supports' => array('title', 'thumbnail'),
        'rewrite' => array('slug' => 'trip'), 
    ));
    
    // 2. Taxonomy: Destinations (Updated Slug to Plural)
    register_taxonomy('destination', 'trip', array(
        'labels' => array('name' => 'Destinations', 'singular_name' => 'Destination'),
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'destinations'),
        'show_in_rest' => true,
    ));

    register_taxonomy('activity', 'trip', array(
        'labels' => array('name' => 'Activities', 'singular_name' => 'Activity'),
        'hierarchical' => false,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'tour-activity'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'nextur_init_structure');

/* -------------------------------------------------------------------------- */
/* PHASE 2 ADD-ON: INDONESIA HIGHLIGHTS (Dynamic Gallery)                     */
/* -------------------------------------------------------------------------- */

// 1. Register CPT
function nextur_register_gallery_cpt() {
    register_post_type('gallery_item', array(
        'labels' => array(
            'name' => 'Indo Highlights',
            'singular_name' => 'Highlight',
            'add_new_item' => 'Add New Destination',
            'edit_item' => 'Edit Destination'
        ),
        'public' => true,
        'exclude_from_search' => true, // Don't show in search results
        'publicly_queryable'  => false, // No single page needed
        'show_ui' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'thumbnail'), // Title = City Name, Thumbnail = Image
    ));
}
add_action('init', 'nextur_register_gallery_cpt');

// 3. Admin Columns (Show Image in List)
function nextur_gallery_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'thumbnail' => 'Image', // Add Image Column
        'title' => 'City Name',
        'link' => 'Target Link',
        'date' => $columns['date'],
    );
    return $new_columns;
}
function nextur_gallery_custom_column($column, $post_id) {
    if ($column === 'thumbnail') {
        echo get_the_post_thumbnail($post_id, array(80, 80), array('style' => 'border-radius:4px; object-fit:cover;'));
    }
    if ($column === 'link') {
        echo get_post_meta($post_id, '_gallery_link', true);
    }
}
add_filter('manage_gallery_item_posts_columns', 'nextur_gallery_columns');
add_action('manage_gallery_item_posts_custom_column', 'nextur_gallery_custom_column', 10, 2);
