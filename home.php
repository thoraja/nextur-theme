<?php get_header(); ?>

<main class="bg-slate-50 min-h-screen">

    <!-- 1. BLOG HERO -->
    <section class="relative bg-slate-900 pt-32 pb-24 overflow-hidden">
        <!-- Abstract Background -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-teal-500 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold uppercase tracking-wider mb-4 backdrop-blur-md">
                Our Blog
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white font-heading mb-4 tracking-tight">
                The Explorer's Journal
            </h1>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto font-light">
                Tips, panduan, dan cerita perjalanan inspiratif dari tim Nextur untuk petualangan Anda berikutnya.
            </p>
        </div>
    </section>

    <!-- 2. MAIN CONTENT & SIDEBAR -->
    <section class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- LEFT COLUMN: CONTENT (8 Cols) -->
                <div class="lg:col-span-8">
                    
                    <?php if ( have_posts() ) : ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <?php 
                            $i = 0; 
                            while ( have_posts() ) : the_post(); 
                                $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : 'https://via.placeholder.com/800x600?text=Nextur';
                                $cats = get_the_category();
                                $cat_name = !empty($cats) ? $cats[0]->name : 'Travel';
                                $i++;

                                // FEATURED POST (First Item) - Spans 2 Columns
                                if ($i === 1 && !is_paged()) : 
                            ?>
                                <article class="col-span-1 md:col-span-2 group bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 border border-slate-100 grid md:grid-cols-2 h-full">
                                    <a href="<?php the_permalink(); ?>" class="relative h-64 md:h-auto overflow-hidden block">
                                        <img src="<?php echo esc_url($img_url); ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-white/90 backdrop-blur text-slate-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-slate-100 shadow-sm">
                                                Featured
                                            </span>
                                        </div>
                                    </a>
                                    <div class="p-8 flex flex-col justify-center">
                                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                                            <span class="text-brand"><?php echo esc_html($cat_name); ?></span>
                                            <span>•</span>
                                            <span><?php echo get_the_date(); ?></span>
                                        </div>
                                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 font-heading mb-4 leading-tight group-hover:text-brand transition">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <p class="text-slate-600 mb-6 line-clamp-3 leading-relaxed">
                                            <?php echo get_the_excerpt(); ?>
                                        </p>
                                        <div>
                                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center font-bold text-slate-900 hover:text-brand transition border-b-2 border-brand pb-0.5">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </article>

                            <?php 
                                // STANDARD GRID ITEMS (Remaining Posts)
                                else : 
                            ?>
                                <article class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 group">
                                    <a href="<?php the_permalink(); ?>" class="relative h-56 overflow-hidden block">
                                        <img src="<?php echo esc_url($img_url); ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                    </a>
                                    <div class="p-6 flex flex-col flex-grow">
                                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                                            <span class="text-brand"><?php echo esc_html($cat_name); ?></span>
                                            <span>•</span>
                                            <span><?php echo get_the_date(); ?></span>
                                        </div>
                                        <h2 class="text-lg font-bold text-slate-900 font-heading mb-3 leading-snug group-hover:text-brand transition line-clamp-2">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-grow">
                                            <?php echo get_the_excerpt(); ?>
                                        </p>
                                        <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-slate-900 hover:text-brand transition inline-flex items-center gap-1">
                                            Read More →
                                        </a>
                                    </div>
                                </article>
                            <?php endif; endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-16 flex justify-center">
                            <?php
                            echo paginate_links(array(
                                'prev_text' => '<span class="px-4 py-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">← Prev</span>',
                                'next_text' => '<span class="px-4 py-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Next →</span>',
                                'before_page_number' => '<span class="px-4 py-2 bg-white border border-slate-200 rounded-lg hover:bg-brand hover:text-white hover:border-brand transition mx-1 block">',
                                'after_page_number'  => '</span>',
                            ));
                            ?>
                        </div>

                    <?php else : ?>
                        <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada artikel.</h3>
                            <p class="text-slate-500">Silakan kembali lagi nanti untuk cerita terbaru.</p>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- RIGHT COLUMN: SIDEBAR (Sales Engine) -->
                <div class="lg:col-span-4 sticky top-28">
                    <?php get_sidebar(); ?>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>