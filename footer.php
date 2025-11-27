</div> <footer class="bg-slate-900 text-slate-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h3 class="text-white text-lg font-bold mb-4">Nextur.</h3>
            <p class="text-sm">Partner perjalanan terbaik Anda. Menjelajahi keindahan Indonesia dan Dunia.</p>
        </div>
        <div>
            <h3 class="text-white text-lg font-bold mb-4">Navigasi</h3>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'space-y-2 text-sm',
                'fallback_cb'    => false
            ));
            ?>
        </div>
        <div>
            <h3 class="text-white text-lg font-bold mb-4">Kontak</h3>
            <p class="text-sm mb-2">📍 Jakarta Selatan, Indonesia</p>
            <p class="text-sm mb-2">📧 info@nextur.com</p>
            <p class="text-sm">📱 +62 812 3456 7890</p>
        </div>
    </div>
    <div class="border-t border-slate-800 mt-12 pt-8 text-center text-sm">
        &copy; <?php echo date('Y'); ?> Nextur Travel Agency. All rights reserved.
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>