<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
    <style>
        .hero-clip { clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%); }
        /* Only targets the menu links now */
        .mobile-menu-link a { color: #1e293b !important; }
    </style>
</head>
<body <?php body_class('font-sans text-slate-800 antialiased'); ?>>

<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 50) ? true : false"
        class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-7xl transition-all duration-500 ease-in-out"
        @click.outside="mobileMenuOpen = false">
    
    <div class="rounded-full px-6 py-3 border border-white/40 transition-all duration-500 backdrop-blur-xl"
         :class="scrolled ? 'bg-white/90 shadow-2xl' : 'bg-white/70 shadow-lg'">
         
        <div class="flex justify-between items-center h-10">
            
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

            <div class="hidden md:flex items-center">
                <div class="font-heading text-sm font-semibold tracking-wide mr-8 text-slate-600">
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'flex gap-8 list-none m-0 p-0 items-center',
                            'echo'           => true,
                            'depth'          => 1,
                        ));
                    ?>
                </div>
                <a href="<?php echo site_url('/contact'); ?>" 
                   class="bg-brand text-white hover:bg-brand-dark px-6 py-2.5 rounded-full font-bold text-sm transition shadow-lg hover:shadow-xl font-heading transform hover:-translate-y-0.5">
                    Hubungi Kami
                </a>
            </div>

            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" 
                        class="focus:outline-none p-2 rounded-full hover:bg-slate-100 transition-colors text-slate-600">
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

    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         class="md:hidden mt-2 rounded-2xl bg-white/95 backdrop-blur-xl border border-white/50 shadow-2xl overflow-hidden" 
         style="display: none;">
        
        <div class="px-6 pt-6 pb-8 space-y-1">
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    // Applied class ONLY to the menu list
                    'menu_class'     => 'flex flex-col space-y-4 font-heading font-semibold text-lg list-none m-0 p-0 mobile-menu-link',
                    'echo'           => true,
                ));
            ?>
             <div class="pt-6 mt-4 border-t border-slate-200/50">
                <a href="<?php echo site_url('/contact'); ?>" class="block w-full text-center px-6 py-3 bg-brand !text-white font-bold rounded-xl shadow-md">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</header>