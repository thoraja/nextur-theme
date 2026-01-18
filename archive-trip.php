<?php get_header(); ?>

<section class="relative bg-slate-900 py-24 px-4 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
    <div class="relative max-w-7xl mx-auto text-center z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white font-heading mb-4">
            <?php echo function_exists('pll_e') ? pll__('Destinasi Pilihan') : 'Destinasi Pilihan'; ?>
        </h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto">
            <?php echo function_exists('pll_e') ? pll__('Temukan paket perjalanan terbaik sesuai impian Anda.') : 'Temukan paket perjalanan terbaik sesuai impian Anda.'; ?>
        </p>
    </div>
</section>

<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ( have_posts() ) : the_post(); 
                    $id = get_the_ID();
                    $price = get_post_meta($id, '_trip_price', true);
                    $formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
                    $airline = get_post_meta($id, '_trip_airline', true);
                    $year_tag = get_post_meta($id, '_trip_tag_year', true);
                    $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url($id, 'large') : 'https://via.placeholder.com/600x400';
                ?>
                
                <a href="<?php the_permalink(); ?>" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 flex flex-col h-full transform hover:-translate-y-1">
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?php echo esc_url($img_url); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 right-4 flex flex-col items-end gap-2">
                            <?php if($year_tag): ?>
                                <span class="bg-slate-900/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded-md border border-white/10 shadow-sm uppercase tracking-wide">
                                    <?php echo esc_html($year_tag); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-900 font-heading mb-3 leading-snug group-hover:text-brand transition">
                            <?php the_title(); ?>
                        </h3>
                        
                        <?php if($airline): ?>
                        <div class="flex items-center gap-2 mb-4 text-sm text-slate-500">
                            <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <span class="font-medium"><?php echo esc_html($airline); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Mulai dari</span>
                                <span class="block text-brand font-bold font-heading text-lg"><?php echo $formatted_price; ?></span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 hover:text-brand transition flex items-center gap-1 group-hover:translate-x-1 duration-300">
                                Detail <span class="text-lg">→</span>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endwhile; ?>
            </div>

            <div class="mt-12 flex justify-center">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '←',
                    'next_text' => '→',
                    'class'     => 'flex gap-2'
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-20">
                <h3 class="text-2xl font-bold text-slate-700">Belum ada trip.</h3>
                <p class="text-slate-500 mt-2">Silakan kembali lagi nanti.</p>
                <a href="<?php echo home_url(); ?>" class="inline-block mt-6 bg-brand text-white px-6 py-3 rounded-full font-bold hover:bg-sky-700 transition">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php get_footer(); ?>