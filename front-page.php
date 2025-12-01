<?php get_header(); ?>

<main>
    <section class="relative bg-slate-900 pt-32 pb-40 lg:pt-48 lg:pb-64 overflow-hidden hero-clip">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-40" src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80" alt="Travel Background">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/20 to-slate-900"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-brand/20 border border-brand/30 text-sky-300 text-sm font-semibold mb-6 backdrop-blur-sm font-heading">
                #1 Travel Agency di Indonesia
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-8 leading-tight font-heading">
                Temukan Keajaiban <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-teal-400">Dunia Baru.</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-300 mb-10 leading-relaxed font-sans">
                Kami menyediakan pengalaman Open Trip dan Private Trip premium dengan pelayanan standar internasional.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 font-heading">
                <a href="#destinations" class="px-8 py-4 bg-brand hover:bg-brand-dark text-white font-bold rounded-xl transition shadow-lg transform hover:-translate-y-1">
                    Lihat Destinasi
                </a>
                <a href="#services" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold rounded-xl backdrop-blur-md transition">
                    Layanan Kami
                </a>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl p-8 grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
            <div class="text-center">
                <p class="text-4xl font-bold text-brand font-heading">500+</p>
                <p class="text-slate-500 text-sm font-medium">Trip Sukses</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold text-brand font-heading">10k+</p>
                <p class="text-slate-500 text-sm font-medium">Traveler Bahagia</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold text-brand font-heading">50+</p>
                <p class="text-slate-500 text-sm font-medium">Destinasi</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold text-brand font-heading">4.9</p>
                <p class="text-slate-500 text-sm font-medium">Rating Google</p>
            </div>
        </div>
    </div>

    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="relative grid grid-cols-2 gap-4">
                    <img class="rounded-2xl shadow-lg transform translate-y-12" src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&q=80&w=600" alt="Service 1">
                    <img class="rounded-2xl shadow-lg" src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&q=80&w=600" alt="Service 2">
                </div>
                <div class="mt-12 lg:mt-0">
                    <h2 class="text-brand font-bold tracking-wide uppercase text-sm mb-2 font-heading">Layanan Kami</h2>
                    <h3 class="text-3xl font-extrabold text-slate-900 sm:text-4xl mb-6 font-heading">Pengalaman Wisata Tanpa Batas</h3>
                    <div class="space-y-6 font-sans">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-brand text-white">✈️</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg leading-6 font-bold text-slate-900 font-heading">Open Trip</h4>
                                <p class="mt-2 text-base text-slate-500">Bergabung dengan traveler lain, hemat biaya, dan temukan teman baru.</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-brand text-white">⭐</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg leading-6 font-bold text-slate-900 font-heading">Private Trip</h4>
                                <p class="mt-2 text-base text-slate-500">Fleksibilitas penuh untuk Anda dan keluarga. Atur jadwal sesuka hati.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="destinations" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-heading">Destinasi Populer</h2>
                <p class="mt-4 text-lg text-slate-600">Pilihan liburan favorit para traveler bulan ini.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                // THE DYNAMIC LOOP
                $args = array(
                    'post_type' => 'trip',
                    'posts_per_page' => 6, // Limit to 6 items
                );
                $trips = new WP_Query($args);

                if ($trips->have_posts()) :
                    while ($trips->have_posts()) : $trips->the_post();
                        // Get Meta Data
                        $price = get_post_meta(get_the_ID(), '_trip_price', true);
                        $duration = get_post_meta(get_the_ID(), '_trip_duration', true);
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : 'https://via.placeholder.com/600x400?text=No+Image';
                        $formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Ask for Price';
                ?>
                
                <a href="<?php the_permalink(); ?>" class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 block">
                    <div class="relative h-64 overflow-hidden">
                        <img class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700" 
                             src="<?php echo esc_url($img_url); ?>" 
                             alt="<?php the_title(); ?>">
                        
                        <?php if($duration): ?>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-brand font-heading">
                            <?php echo esc_html($duration); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-slate-900 font-heading group-hover:text-brand transition">
                                <?php the_title(); ?>
                            </h3>
                            <div class="flex items-center text-amber-400">
                                <span>★</span><span class="text-slate-600 text-sm ml-1">5.0</span>
                            </div>
                        </div>
                        
                        <div class="text-slate-500 text-sm mb-4 mt-2 line-clamp-2">
                             <?php echo get_the_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 10); ?>
                        </div>
                        
                        <div class="flex justify-between items-center border-t pt-4">
                            <span class="text-slate-400 text-xs">Mulai dari</span>
                            <span class="text-brand font-bold text-lg font-heading"><?php echo $formatted_price; ?></span>
                        </div>
                    </div>
                </a>

                <?php 
                    endwhile; 
                    wp_reset_postdata(); 
                else : 
                ?>
                    <div class="col-span-3 text-center py-10 text-slate-500">
                        <p>Belum ada trip yang tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>