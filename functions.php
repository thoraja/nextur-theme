<?php
function nextur_scripts() {
    // Tailwind CSS (CDN - Development Mode)
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), '3.4', false);
    
    // Alpine.js (CDN)
    wp_enqueue_script('alpine', '//unpkg.com/alpinejs', array(), '3.0', true);

    // Tailwind Configuration for Custom Colors
    wp_add_inline_script('tailwind', "
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            light: '#E0F2FE', // Light Blue
                            DEFAULT: '#0284C7', // Ocean Blue
                            dark: '#0C4A6E', // Deep Navy
                        }
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'nextur_scripts');

// Enable Title Tag and Post Thumbnails
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// Register Navigation Menus
function nextur_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'nextur'),
    ));
}
add_action('init', 'nextur_menus');