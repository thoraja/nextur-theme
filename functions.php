<?php
function nextur_scripts() {
    // Tailwind CSS (CDN)
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), '3.4', false);
    
    // Alpine.js (CDN)
    wp_enqueue_script('alpine', '//unpkg.com/alpinejs', array(), '3.0', true);

    // Tailwind Config: Fonts & Colors
    wp_add_inline_script('tailwind', "
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0284C7', // Ocean Blue
                            dark: '#0C4A6E',
                        }
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'nextur_scripts');

// Menu Classes Helper (Adapts text color)
function nextur_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'primary') {
        $classes[] = 'text-current hover:text-brand font-medium transition duration-300';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'nextur_menu_classes', 10, 3);

// Basic Setup
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

function nextur_menus() {
    register_nav_menus(array('primary' => 'Primary Menu'));
}
add_action('init', 'nextur_menus');