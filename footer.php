<footer class="bg-slate-900 text-slate-300 pt-20 pb-10 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="space-y-4">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-8 h-8 bg-blue-600 text-white flex items-center justify-center rounded-lg font-bold text-lg">N</span>
                    <span class="font-bold text-2xl text-white">Nextur<span class="text-blue-600">.</span></span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">
                    <?php pll_e('Partner perjalanan terbaik Anda. Kami berkomitmen memberikan pengalaman wisata yang tak terlupakan dengan standar keamanan dan kenyamanan tertinggi.'); ?>
                </p>
                <div class="flex space-x-4 pt-2">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition"><span class="sr-only">IG</span>📸</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition"><span class="sr-only">FB</span>fb</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition"><span class="sr-only">TW</span>𝕏</a>
                </div>
            </div>

            <div>
                <h3 class="text-white text-lg font-bold mb-6"><?php pll_e('Perusahaan'); ?></h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'space-y-3',
                    'link_before'    => '<span class="hover:text-blue-400 transition duration-300 text-sm">',
                    'link_after'     => '</span>',
                    'depth'          => 1
                ));
                ?>
            </div>

            <div>
                <h3 class="text-white text-lg font-bold mb-6"><?php pll_e('Hubungi Kami'); ?></h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start">
                        <span class="mr-3 text-blue-500">📍</span>
                        <span><?php pll_e('Jl. Sudirman Kav 12, Jakarta Selatan, 12190'); ?></span>
                    </li>
                    <li class="flex items-center">
                        <span class="mr-3 text-blue-500">📧</span>
                        <a href="mailto:info@nextur.com" class="hover:text-blue-400 transition"><?php pll_e('info@nextur.com'); ?></a>
                    </li>
                    <li class="flex items-center">
                        <span class="mr-3 text-blue-500">📱</span>
                        <span><?php pll_e('+62 812 3456 7890'); ?></span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-white text-lg font-bold mb-6"><?php pll_e('Newsletter'); ?></h3>
                <p class="text-slate-400 text-sm mb-4"><?php pll_e('Dapatkan info promo trip terbaru.'); ?></p>
                <form class="space-y-2">
                    <input type="email" placeholder="<?php pll_e('Email Anda'); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg focus:outline-none focus:border-blue-500 text-white text-sm">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition text-sm"><?php pll_e('Langganan'); ?></button>
                </form>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-xs text-slate-500">&copy; <?php echo date('Y'); ?> Nextur Travel Agency. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-xs text-slate-500">
                <a href="#" class="hover:text-white"><?php pll_e('Privacy Policy'); ?></a>
                <a href="#" class="hover:text-white"><?php pll_e('Terms of Service'); ?></a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>