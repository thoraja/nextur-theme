<aside class="space-y-8">
    
    <!-- WIDGET 1: SEARCH TRIPS -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="font-heading font-bold text-lg text-slate-900 mb-4">Cari Destinasi</h3>
        <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="relative">
            <input type="hidden" name="post_type" value="articles" /> <!-- Force search to look for Trips -->
            <input type="search" name="s" placeholder="Jepang, Korea, Bali..." 
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 pl-11 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
    </div>

    <!-- WIDGET 2: CROSS-SELL (Random Trips) -->
    <div class="bg-slate-900 p-6 rounded-2xl shadow-xl text-white relative overflow-hidden">
        <!-- Background Blob -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand rounded-full blur-3xl opacity-20"></div>
        
        <h3 class="font-heading font-bold text-lg text-white mb-6 relative z-10">Paket Terpopuler</h3>
        
        <div class="space-y-4 relative z-10">
            <?php 
            $random_trips = nextur_get_random_trips(3);
            if ($random_trips->have_posts()) :
                while ($random_trips->have_posts()) : $random_trips->the_post();
                    $price = get_post_meta(get_the_ID(), '_trip_price', true);
                    $price_fmt = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
            ?>
                <a href="<?php the_permalink(); ?>" class="flex gap-4 items-center group">
                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-slate-800">
                        <?php if(has_post_thumbnail()) { the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition duration-500']); } ?>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-100 group-hover:text-brand transition line-clamp-2 leading-tight mb-1">
                            <?php the_title(); ?>
                        </h4>
                        <span class="text-xs text-brand font-semibold"><?php echo $price_fmt; ?></span>
                    </div>
                </a>
            <?php 
                endwhile; 
                wp_reset_postdata();
            endif; 
            ?>
        </div>

        <a href="<?php echo site_url('/trips'); ?>" class="block w-full text-center mt-6 py-3 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl text-xs font-bold transition relative z-10">
            Lihat Semua Paket
        </a>
    </div>

</aside>