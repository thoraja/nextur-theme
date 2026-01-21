<?php
/**
 * Theme Setup: Scripts, Menus, Supports
 */

function nextur_scripts() {
    // 1. Tailwind CSS
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com?plugins=typography', array(), '3.4', false);
    
    // 2. Register & Load Flatpickr (Datepicker) FIRST
    wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
    wp_enqueue_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), '4.6', true);

    // 3. Load Alpine.js (DEPENDS on flatpickr)
    // This forces Alpine to wait until Flatpickr is ready
    wp_enqueue_script('alpine', '//unpkg.com/alpinejs', array('flatpickr'), '3.0', true);

    // 4. Tailwind Config
    wp_add_inline_script('tailwind', "
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: { DEFAULT: '#0284C7', dark: '#0C4A6E' }
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'nextur_scripts');

// NEW: Ensure Media Uploader scripts are loaded in Admin for the Gallery
function nextur_admin_scripts() {
    if (is_admin()) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'nextur_admin_scripts');

function nextur_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'primary' || $args->theme_location == 'header_menu') {
        $classes[] = 'text-current hover:text-brand font-medium transition duration-300 cursor-pointer';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'nextur_menu_classes', 10, 3);

add_theme_support('title-tag');
add_theme_support('post-thumbnails');

function nextur_register_menus() {
    register_nav_menus(array(
        'primary' => 'Primary Menu (Old)',
        'header_menu' => 'Header Main Menu', 
        'footer_menu' => 'Footer Menu'
    ));
}
add_action('after_setup_theme', 'nextur_register_menus');

// Backwards compatibility for the init hook menu registration if needed, 
// but nextur_register_menus covers it. The original code had both.
// I will keep nextur_register_menus as the source of truth.

/**
 * UTILITIES: Excerpt
 */
function nextur_custom_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'nextur_custom_excerpt_length', 999);

function nextur_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'nextur_excerpt_more');
