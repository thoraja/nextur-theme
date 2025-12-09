<?php get_header(); ?>

<main class="bg-slate-50 min-h-screen pt-32 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Header -->
        <div class="text-center mb-16">
            <span class="inline-block py-1 px-3 rounded-full bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider mb-4">
                Search Results
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-slate-900 font-heading">
                "<?php echo get_search_query(); ?>"
            </h1>
            <p class="text-slate-500 mt-2">
                Found <?php echo $wp_query->found_posts; ?> result(s).
            </p>
        </div>

        <?php if ( have_posts() ) : ?>
            
            <!-- TRIP GRID RESULTS -->
            <?php if ( isset($_GET['post_type']) && $_GET['post_type'] === 'trip' ) : ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ( have_posts() ) : the_post(); 
                        // Trip Card Data
                        $id = get_the_ID();
                        $price = get_post_meta($id, '_trip_price', true);
                        $formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
                        $airline = get_post_meta($id, '_trip_airline', true);
                        $year_tag = get_post_meta($id, '_trip_tag_year', true);
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url($id, 'large') : 'https://via.placeholder.com/600x400';
                    ?>
                        <!-- Reusing the Trip Card Layout -->
                        <a href="<?php the_permalink(); ?>" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 flex flex-col h-full">
                            <div class="relative h-64 overflow-hidden">
                                <img src="<?php echo esc_url($img_url); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                                <div class="absolute top-4 right-4 flex flex-col items-end gap-2">
                                    <?php if($year_tag): ?>
                                        <span class="bg-slate-900/80 backdrop-blur text-white text-xs font-bold px-3 py-1 rounded-full border border-white/20 shadow-sm">
                                            <?php echo esc_html($year_tag); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-lg font-bold text-slate-900 font-heading mb-3 leading-snug line-clamp-2 group-hover:text-brand transition">
                                    <?php the_title(); ?>
                                </h3>
                                <?php if($airline): ?>
                                <div class="flex items-center gap-2 mb-4 text-sm text-slate-500">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></div>
                                    <span class="font-medium"><?php echo esc_html($airline); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <div><span class="block text-xs text-slate-400 mb-0.5">Start from</span><span class="block text-brand font-bold font-heading text-lg"><?php echo $formatted_price; ?></span></div>
                                    <span class="text-sm font-bold text-slate-900 hover:text-brand transition flex items-center gap-1">Detail <span class="text-lg">→</span></span>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>

            <!-- STANDARD BLOG RESULTS -->
            <?php else : ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                            <h2 class="text-xl font-bold text-slate-900 mb-2 font-heading">
                                <a href="<?php the_permalink(); ?>" class="hover:text-brand"><?php the_title(); ?></a>
                            </h2>
                            <div class="text-xs text-slate-400 mb-4 uppercase tracking-wide"><?php echo get_the_date(); ?></div>
                            <div class="prose prose-sm text-slate-600 mb-4 line-clamp-3">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-brand hover:underline">Read Article →</a>
                        </article>
                    <?php endwhile; ?>
                </div>

            <?php endif; ?>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                <?php 
                echo paginate_links(array(
                    'prev_text' => '←',
                    'next_text' => '→',
                )); 
                ?>
            </div>

        <?php else : ?>
            
            <!-- Empty State -->
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300 max-w-2xl mx-auto">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak ada hasil yang ditemukan.</h3>
                <p class="text-slate-500 mb-8">Coba kata kunci lain atau kembali ke beranda.</p>
                <a href="<?php echo home_url(); ?>" class="inline-block bg-brand text-white px-8 py-3 rounded-full font-bold hover:bg-brand-dark transition">
                    Kembali ke Beranda
                </a>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>