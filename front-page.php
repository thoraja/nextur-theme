<?php get_header(); ?>

<main>
    <section class="relative bg-slate-900 pt-32 pb-40 lg:pt-48 lg:pb-64 overflow-hidden hero-clip">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-40" src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80" alt="Travel Background">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/20 to-slate-900"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight font-heading">
                NEXTUR: <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-teal-400">A Journey That Awaits You</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-300 mb-10 leading-relaxed font-sans">
                Era baru dalam inovasi, efisiensi, dan berkelanjutan di industri pariwisata modern.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 font-heading">
                <a href="#destinations" class="px-8 py-4 bg-brand hover:bg-brand-dark text-white font-bold rounded-xl transition shadow-lg transform hover:-translate-y-1">
                    Jelajahi Sekarang
                </a>
            </div>
        </div>
    </section>

    <section id="destinations" class="py-20 bg-white" x-data="{ activeCategory: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-heading">Destinasi Pilihan</h2>
                <p class="mt-2 text-slate-600">Temukan paket perjalanan terbaik sesuai impian Anda.</p>
            </div>

            <div class="flex justify-center mb-12">
                <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar max-w-full">
                    <button @click="activeCategory = 'all'" 
                            :class="activeCategory === 'all' ? 'bg-brand text-white shadow-lg shadow-brand/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition whitespace-nowrap">
                        Semua
                    </button>

                    <?php
                    // GET DESTINATION TERMS
                    $terms = get_terms(array(
                        'taxonomy' => 'destination',
                        'hide_empty' => true,
                    ));

                    if (!empty($terms) && !is_wp_error($terms)) :
                        foreach ($terms as $term) :
                    ?>
                        <button @click="activeCategory = '<?php echo esc_js($term->slug); ?>'" 
                                :class="activeCategory === '<?php echo esc_js($term->slug); ?>' ? 'bg-brand text-white shadow-lg shadow-brand/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                class="px-6 py-2.5 rounded-full text-sm font-bold transition whitespace-nowrap">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                // TRIP QUERY
                $args = array(
                    'post_type' => 'trip',
                    'posts_per_page' => 12,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $trips = new WP_Query($args);

                if ($trips->have_posts()) :
                    while ($trips->have_posts()) : $trips->the_post();
                        
                        // Meta Data
                        $id = get_the_ID();
                        $price = get_post_meta($id, '_trip_price', true);
                        $formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
                        $airline = get_post_meta($id, '_trip_airline', true);
                        $year_tag = get_post_meta($id, '_trip_tag_year', true);
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url($id, 'large') : 'https://via.placeholder.com/600x400';
                        
                        // Get Terms for Filtering logic
                        $post_terms = get_the_terms($id, 'destination');
                        $term_slugs = [];
                        if ($post_terms) {
                            foreach ($post_terms as $t) {
                                $term_slugs[] = $t->slug;
                            }
                        }
                        // Encode terms for Alpine check: ['japan', 'asia']
                        $js_terms = json_encode($term_slugs);
                ?>
                    <div x-show="activeCategory === 'all' || <?php echo htmlspecialchars($js_terms); ?>.includes(activeCategory)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 flex flex-col h-full">
                        
                        <div class="relative h-56 overflow-hidden">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                            
                            <div class="absolute top-4 right-4 flex flex-col items-end gap-2">
                                <?php if($year_tag): ?>
                                    <span class="bg-slate-900/80 backdrop-blur text-white text-xs font-bold px-3 py-1 rounded-full border border-white/20">
                                        <?php echo esc_html($year_tag); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-slate-900 font-heading mb-3 leading-snug line-clamp-2 group-hover:text-brand transition">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
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
                                    <span class="block text-xs text-slate-400 mb-0.5">Start from</span>
                                    <span class="block text-brand font-bold font-heading text-lg">
                                        <?php echo $formatted_price; ?>
                                    </span>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-slate-900 hover:text-brand transition flex items-center gap-1">
                                    Detail <span class="text-lg">→</span>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php 
                    endwhile; 
                    wp_reset_postdata(); 
                else : 
                ?>
                    <div class="col-span-full text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                        <p class="text-slate-500">Belum ada trip yang tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo site_url('/trips'); // Assuming you have an archive page ?>" class="inline-block border border-slate-300 text-slate-600 px-8 py-3 rounded-full font-bold hover:bg-slate-900 hover:text-white hover:border-slate-900 transition">
                    Lihat Semua Trip
                </a>
            </div>

        </div>
    </section>

    <section class="py-16 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8" x-data>
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 font-heading">Explore Indonesia</h2>
                    <p class="mt-1 text-slate-600 text-sm">Surga tropis di negeri sendiri.</p>
                </div>
                <div class="hidden md:flex gap-2">
                    <button @click="$refs.slider.scrollBy({ left: -300, behavior: 'smooth' })" class="w-10 h-10 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-brand hover:border-brand hover:text-white transition">←</button>
                    <button @click="$refs.slider.scrollBy({ left: 300, behavior: 'smooth' })" class="w-10 h-10 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-brand hover:border-brand hover:text-white transition">→</button>
                </div>
            </div>

            <div x-ref="slider" class="flex gap-4 overflow-x-auto pb-4 snap-x snap-mandatory no-scrollbar scroll-smooth">
                <?php
                $indo_destinations = [
                    ['name' => 'Jogja',       'img' => '1584959635032-4464cc693c68'],
                    ['name' => 'Bandung',     'img' => '1634998088015-46325509930f'],
                    ['name' => 'Bali',        'img' => '1577717903315-16d11e63d953'],
                    ['name' => 'Labuan Bajo', 'img' => '1589308078059-be1415eab4c3'],
                    ['name' => 'Raja Ampat',  'img' => '1516690561799-46d8f74f9dab'],
                    ['name' => 'Bromo',       'img' => '1589318180630-34991508db42'],
                    ['name' => 'Sumba',       'img' => '1634563432924-42b79a0b0642'],
                    ['name' => 'Lombok',      'img' => '1571994145973-d326da13d72b'],
                    ['name' => 'Borneo',      'img' => '1582268611958-ebfd161ef9cf'],
                    ['name' => 'Sulawesi',    'img' => '1518182177546-0766199a22f5'],
                    ['name' => 'Flores',      'img' => '1539656209503-4c90b6397395'],
                ];
                foreach ($indo_destinations as $place) : 
                ?>
                    <a href="#" class="relative flex-shrink-0 w-64 md:w-56 aspect-[3/4] rounded-xl overflow-hidden group snap-start bg-slate-200">
                        <img src="https://images.unsplash.com/photo-<?php echo $place['img']; ?>?auto=format&fit=crop&w=400&q=80" alt="<?php echo $place['name']; ?>" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80"></div>
                        <div class="absolute bottom-0 left-0 p-4 w-full">
                            <h3 class="text-xl font-bold text-white font-heading tracking-wide"><?php echo $place['name']; ?></h3>
                            <div class="h-0.5 w-8 bg-brand mt-2 transition-all duration-300 group-hover:w-full"></div>
                        </div>
                    </a>
                <?php endforeach; ?>
                <a href="#" class="relative flex-shrink-0 w-64 md:w-56 aspect-[3/4] rounded-xl overflow-hidden group snap-start bg-slate-100 border-2 border-dashed border-slate-300 flex flex-col items-center justify-center hover:border-brand hover:bg-blue-50 transition">
                    <span class="text-3xl text-slate-400 group-hover:text-brand transition mb-2">➜</span>
                    <span class="font-bold text-slate-500 group-hover:text-brand transition">Lihat Semua</span>
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <p class="text-2xl md:text-3xl font-serif italic text-slate-800 leading-relaxed">
                    "Kami mengintegrasikan estetika destinasi, nilai budaya, dan teknologi yang menciptakan pengalaman yang autentik dan berkelanjutan."
                </p>
                <div class="w-24 h-1 bg-brand mx-auto mt-8"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group p-8 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 bg-blue-100 text-brand rounded-xl flex items-center justify-center text-2xl mb-6">✨</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Lifestyle Creator</h3>
                    <p class="text-slate-600">Fokus pada penyusunan liburan yang berkesan dan berdampak.</p>
                </div>
                <div class="group p-8 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-2xl mb-6">🎯</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Personalized</h3>
                    <p class="text-slate-600">Perjalanan dimaksimalkan sepenuhnya sesuai minat Anda.</p>
                </div>
                <div class="group p-8 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-2xl mb-6">💼</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">One-Stop Solution</h3>
                    <p class="text-slate-600">Mulai dari liburan impian hingga insentif perusahaan.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>