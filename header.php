<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- FAVICON -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" type="image/png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
    <style>
        .hero-clip { clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%); }
        .mobile-menu-link a { color: #1e293b !important; }
        
        /* FIX: Force Flatpickr wrapper to be full width */
        .flatpickr-wrapper { width: 100% !important; display: block !important; }
        
        /* FIX: Ensure Menu Items are Horizontal even with Polylang */
        .menu-flex-fix { display: flex !important; gap: 2rem; align-items: center; list-style: none; margin: 0; padding: 0; }
        .menu-flex-fix li { display: inline-block; }
    </style>
</head>
<body <?php body_class('font-sans text-slate-800 antialiased'); ?>>

<!-- PERMANENT GLASS PILL HEADER -->
<!-- Ensure z-index is very high (50) -->
<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 50) ? true : false"
        class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-7xl transition-all duration-500 ease-in-out"
        @click.outside="mobileMenuOpen = false">
    
    <!-- The Pill Container -->
    <div class="rounded-full px-6 py-3 border border-white/40 transition-all duration-500 backdrop-blur-xl relative z-50"
         :class="scrolled ? 'bg-white/90 shadow-2xl' : 'bg-white/70 shadow-lg'">
         
        <div class="flex justify-between items-center h-10">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="<?php echo home_url(); ?>" class="flex items-center gap-3 group">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" 
                         alt="Nextur Logo" 
                         class="h-9 w-auto object-contain">
                    <span class="font-heading font-bold text-2xl tracking-tight text-slate-900">
                        NEXTUR
                    </span>
                </a>
            </div>

            <!-- Desktop Nav (Hidden on Tablet/Mobile) -->
            <div class="hidden lg:flex items-center">
                <div class="font-heading text-sm font-semibold tracking-wide mr-6 text-slate-600">
                    <?php
                        // FIX: Explicitly add a class to the UL to force flexbox layout
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'menu-flex-fix', // Changed from Tailwind classes to custom class for safety
                            'echo'           => true,
                            'depth'          => 1,
                            'fallback_cb'    => false, // Prevent default page list if menu is missing
                        ));
                    ?>
                </div>

                <!-- Language Switcher (Desktop Dropdown) -->
                <div class="mr-6 border-r border-slate-300 pr-6 hidden lg:block relative" x-data="{ langOpen: false }">
                    <?php 
                    if(function_exists('pll_current_language')) {
                        $current_lang = pll_current_language('slug'); // 'id' or 'en'
                        $langs = pll_the_languages(array('raw' => 1)); // Get data array
                    ?>
                        <!-- Trigger -->
                        <button @click="langOpen = !langOpen" class="flex items-center gap-1 font-heading font-bold text-sm text-slate-600 hover:text-brand uppercase transition">
                            <?php echo esc_html($current_lang); ?>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="langOpen" 
                             @click.outside="langOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute top-full right-0 mt-2 w-24 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-1">
                            <?php foreach ($langs as $lang) : ?>
                                <a href="<?php echo esc_url($lang['url']); ?>" class="block px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-brand uppercase">
                                    <?php echo esc_html($lang['slug']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- CTA Button -->
                <a href="<?php
                    if (function_exists('pll_current_language') && pll_current_language('slug') === 'en') {
                        echo site_url('/contact');
                    } else {
                        echo site_url('/hubungi-kami');
                    }
                ?>"
                   class="bg-brand text-white hover:bg-brand-dark px-6 py-2.5 rounded-full font-bold text-sm transition shadow-lg hover:shadow-xl font-heading transform hover:-translate-y-0.5">
                    <?php function_exists('pll_e') ? pll_e('Hubungi Kami') : _e('Hubungi Kami', 'nextur'); ?>
                </a>
            </div>

            <!-- Mobile Trigger -->
            <div class="flex items-center lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="focus:outline-none p-2 rounded-full hover:bg-slate-100 transition-colors text-slate-600 z-50 relative">
                    <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown (Floating Bubble) -->
    <!-- Fixed: Added z-40 to sit behind the pill but above content -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         class="lg:hidden mt-2 rounded-2xl bg-white/95 backdrop-blur-xl border border-white/50 shadow-2xl overflow-hidden relative z-40" 
         style="display: none;">
        
        <div class="px-6 pt-6 pb-8 space-y-1">
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col space-y-4 font-heading font-semibold text-lg list-none m-0 p-0 mobile-menu-link',
                    'echo'           => true,
                    'fallback_cb'    => false, // Prevent default page list if menu is missing
                ));
            ?>
            
            <!-- Mobile Language Switcher (Row) -->
            <div class="py-4 border-b border-slate-200/50 mb-4 flex gap-4 justify-center">
                 <?php 
                 if(function_exists('pll_the_languages')) {
                     $langs = pll_the_languages(array('raw' => 1));
                     foreach ($langs as $lang) : ?>
                        <a href="<?php echo esc_url($lang['url']); ?>" 
                           class="text-sm font-bold uppercase px-3 py-1 rounded-md <?php echo $lang['current_lang'] ? 'bg-brand text-white' : 'text-slate-500 hover:bg-slate-100'; ?>">
                            <?php echo esc_html($lang['slug']); ?>
                        </a>
                     <?php endforeach;
                 }
                 ?>
            </div>

             <div class="pt-2">
                <a href="<?php
                    if (function_exists('pll_current_language') && pll_current_language('slug') === 'en') {
                        echo site_url('/contact');
                    } else {
                        echo site_url('/hubungi-kami');
                    }
                ?>" class="block w-full text-center px-6 py-3 bg-brand !text-white font-bold rounded-xl shadow-md">
                    <?php function_exists('pll_e') ? pll_e('Hubungi Kami') : _e('Hubungi Kami', 'nextur'); ?>
                </a>
            </div>
        </div>
    </div>
</header>