<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-slate-50 text-slate-800 font-sans'); ?>>

<nav class="bg-white shadow-md fixed w-full z-50 top-0" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <a href="<?php echo home_url(); ?>" class="text-2xl font-bold text-brand-dark">
                    NEXTUR<span class="text-brand">.</span>
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex space-x-6',
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => false,
                    'link_before'    => '<span class="hover:text-brand transition duration-300">',
                    'link_after'     => '</span>'
                ));
                ?>
                <a href="<?php echo site_url('/contact'); ?>" class="bg-brand hover:bg-brand-dark text-white px-4 py-2 rounded-lg transition">
                    Hubungi Kami
                </a>
            </div>

            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = !open" class="text-gray-500 hover:text-brand focus:outline-none p-2">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" class="md:hidden bg-white border-t" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 flex flex-col">
             <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'link_before'    => '<span class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-brand hover:bg-gray-50">',
                    'link_after'     => '</span>'
                ));
            ?>
        </div>
    </div>
</nav>
<div class="pt-16">