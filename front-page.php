<?php get_header(); ?>

<main>
    <?php
    // 1. Fetch Featured Trips
    $hero_args = array(
        'post_type'      => 'trip',
        'posts_per_page' => 5,
        'meta_key'       => '_trip_is_featured',
        'meta_value'     => '1'
    );
    $hero_query = new WP_Query($hero_args);
    $slides_data = [];

    if ($hero_query->have_posts()) {
        while ($hero_query->have_posts()) {
            $hero_query->the_post();
            $slides_data[] = [
                'id'    => get_the_ID(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'title' => get_the_title(),
                'link'  => get_permalink(),
                'price' => get_post_meta(get_the_ID(), '_trip_price', true)
            ];
        }
        wp_reset_postdata();
    }

    if (empty($slides_data)) {
        $slides_data[] = [
            'id'    => 0,
            'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80',
            'title' => 'Jelajahi Dunia',
            'link'  => '#destinations',
            'price' => ''
        ];
    }
    ?>

    <section class="relative bg-slate-900 h-screen min-h-[600px] overflow-hidden group" 
             x-data="{ 
                active: 0,
                slides: <?php echo htmlspecialchars(json_encode($slides_data), ENT_QUOTES, 'UTF-8'); ?>,
                timer: null,
                touchStartX: 0,
                touchEndX: 0,
                init() { this.startTimer(); },
                startTimer() { this.timer = setInterval(() => { this.next() }, 6000); },
                stopTimer() { clearInterval(this.timer); },
                next() { this.active = (this.active + 1) % this.slides.length; },
                prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length; },
                handleSwipe() {
                    if (this.touchEndX < this.touchStartX - 50) this.next(); // Swipe Left -> Next
                    if (this.touchEndX > this.touchStartX + 50) this.prev(); // Swipe Right -> Prev
                }
             }"
             @mouseenter="stopTimer()" 
             @mouseleave="startTimer()"
             @touchstart="touchStartX = $event.changedTouches[0].screenX; stopTimer()"
             @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe(); startTimer()">
        
        <div class="absolute inset-0 w-full h-full">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out"
                     :class="active === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                    <img :src="slide.image" class="w-full h-full object-cover" alt="Hero Background">
                </div>
            </template>
        </div>

        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-slate-900/30 z-20"></div>

        <div class="absolute inset-0 z-30 flex flex-col items-center justify-center text-center px-4 pt-16">
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold text-white tracking-tight mb-6 leading-none font-heading drop-shadow-2xl">
                NEXTUR<br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-teal-400">
                    Awaits You
                </span>
            </h1>

            <div class="h-16 mb-8 flex items-center justify-center overflow-hidden w-full max-w-4xl px-4">
                <template x-for="(slide, index) in slides" :key="index">
                    <h2 x-show="active === index"
                       x-transition:enter="transition ease-out duration-700 delay-200"
                       x-transition:enter-start="opacity-0 translate-y-8"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       class="text-xl md:text-3xl text-slate-100 font-medium font-sans tracking-wide leading-tight">
                        <span x-text="slide.title"></span>
                    </h2>
                </template>
            </div>

            <div class="relative h-14 w-48">
                <template x-for="(slide, index) in slides" :key="index">
                    <a :href="slide.link"
                       x-show="active === index"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 scale-90"
                       x-transition:enter-end="opacity-100 scale-100"
                       class="absolute inset-0 flex items-center justify-center bg-white text-slate-900 hover:bg-brand hover:text-white font-bold text-base uppercase tracking-widest rounded-full shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(2,132,199,0.6)] transition-all duration-300">
                        Lihat Detail
                    </a>
                </template>
            </div>

        </div>

        <button @click="prev()" 
                class="hidden md:flex absolute left-8 top-1/2 -translate-y-1/2 z-40 p-4 text-white/50 hover:text-white hover:scale-110 transition duration-300 focus:outline-none">
            <svg class="w-12 h-12 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="next()" 
                class="hidden md:flex absolute right-8 top-1/2 -translate-y-1/2 z-40 p-4 text-white/50 hover:text-white hover:scale-110 transition duration-300 focus:outline-none">
            <svg class="w-12 h-12 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <div class="absolute bottom-8 left-0 w-full z-40 flex justify-center gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="active = index; stopTimer(); startTimer()" 
                        class="h-1 rounded-full transition-all duration-500 shadow-sm"
                        :class="active === index ? 'w-12 bg-white' : 'w-4 bg-white/30 hover:bg-white/60'">
                </button>
            </template>
        </div>

    </section>

    <section id="destinations" class="py-16 md:py-20 bg-white" 
             x-data="{ 
                activeCategory: 'all',
                atStart: true, 
                atEnd: false,
                updateScroll() {
                    const el = $refs.tripSlider;
                    this.atStart = el.scrollLeft <= 5;
                    this.atEnd = Math.ceil(el.scrollLeft + el.clientWidth) >= el.scrollWidth - 10;
                }
             }"
             x-init="$nextTick(() => updateScroll())"
             @resize.window.debounce.100ms="updateScroll()">
             
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
                <div class="w-full md:w-auto">
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-heading mb-2">Destinasi Pilihan</h2>
                    <p class="text-slate-600 mb-6">Temukan paket perjalanan terbaik sesuai impian Anda.</p>
                    <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar max-w-full mask-linear">
                        <button @click="activeCategory = 'all'; $refs.tripSlider.scrollTo({ left: 0, behavior: 'smooth' }); setTimeout(() => updateScroll(), 500)" :class="activeCategory === 'all' ? 'bg-brand text-white shadow-lg shadow-brand/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-5 py-2 rounded-full text-sm font-bold transition whitespace-nowrap flex-shrink-0">Semua</button>
                        <?php
                        $terms = get_terms(array('taxonomy' => 'destination', 'hide_empty' => true));
                        if (!empty($terms) && !is_wp_error($terms)) : foreach ($terms as $term) : ?>
                            <button @click="activeCategory = '<?php echo esc_js($term->slug); ?>'; $refs.tripSlider.scrollTo({ left: 0, behavior: 'smooth' }); setTimeout(() => updateScroll(), 500)" :class="activeCategory === '<?php echo esc_js($term->slug); ?>' ? 'bg-brand text-white shadow-lg shadow-brand/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-5 py-2 rounded-full text-sm font-bold transition whitespace-nowrap flex-shrink-0"><?php echo esc_html($term->name); ?></button>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>

            <div class="relative -mx-4 md:mx-0">
                <button @click="$refs.tripSlider.scrollBy({ left: -400, behavior: 'smooth' })" :disabled="atStart" :class="atStart ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-20 -ml-5 w-12 h-12 rounded-full items-center justify-center transition-all duration-300 bg-white/80 backdrop-blur-md border border-white/50 shadow-xl text-slate-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                <button @click="$refs.tripSlider.scrollBy({ left: 400, behavior: 'smooth' })" :disabled="atEnd" :class="atEnd ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-20 -mr-5 w-12 h-12 rounded-full items-center justify-center transition-all duration-300 bg-white/80 backdrop-blur-md border border-white/50 shadow-xl text-slate-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>

                <div x-ref="tripSlider" @scroll.debounce.10ms="updateScroll()" class="flex gap-4 md:gap-8 overflow-x-auto pb-12 pt-4 px-4 md:px-0 snap-x snap-mandatory no-scrollbar scroll-smooth">
                    <?php
                    $args = array('post_type' => 'trip', 'posts_per_page' => 12, 'orderby' => 'date', 'order' => 'DESC');
                    $trips = new WP_Query($args);
                    if ($trips->have_posts()) : while ($trips->have_posts()) : $trips->the_post();
                        $id = get_the_ID();
                        $price = get_post_meta($id, '_trip_price', true);
                        $formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
                        $airline = get_post_meta($id, '_trip_airline', true);
                        $year_tag = get_post_meta($id, '_trip_tag_year', true);
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url($id, 'large') : 'https://via.placeholder.com/600x400';
                        $post_terms = get_the_terms($id, 'destination');
                        $term_slugs = []; if ($post_terms) { foreach ($post_terms as $t) { $term_slugs[] = $t->slug; } }
                        $js_terms = json_encode($term_slugs);
                    ?>
                        <a href="<?php the_permalink(); ?>" 
                           x-show="activeCategory === 'all' || <?php echo htmlspecialchars($js_terms); ?>.includes(activeCategory)"
                           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
                           class="flex-shrink-0 w-[85vw] md:w-96 snap-center md:snap-start group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 flex flex-col relative z-10 block">
                            
                            <div class="relative h-48 md:h-64 overflow-hidden">
                                <img src="<?php echo esc_url($img_url); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                                <div class="absolute top-4 right-4 flex flex-col items-end gap-2">
                                    <?php if($year_tag): ?><span class="bg-slate-900/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded-md border border-white/10 shadow-sm uppercase tracking-wide"><?php echo esc_html($year_tag); ?></span><?php endif; ?>
                                </div>
                            </div>
                            <div class="p-5 md:p-6 flex flex-col flex-grow">
                                <h3 class="text-base md:text-xl font-bold text-slate-900 font-heading mb-3 leading-snug line-clamp-3 group-hover:text-brand transition min-h-[3.5rem]"><?php the_title(); ?></h3>
                                <?php if($airline): ?>
                                <div class="flex items-center gap-2 mb-4 text-xs md:text-sm text-slate-500">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></div>
                                    <span class="font-medium"><?php echo esc_html($airline); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <div><span class="block text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Start from</span><span class="block text-brand font-bold font-heading text-lg"><?php echo $formatted_price; ?></span></div>
                                    <span class="text-sm font-bold text-slate-900 hover:text-brand transition flex items-center gap-1 group-hover:translate-x-1 duration-300">Detail <span class="text-lg">→</span></span>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); else : ?>
                        <div class="w-full text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-300"><p class="text-slate-500">Belum ada trip.</p></div>
                    <?php endif; ?>
                    
                    <a href="<?php echo site_url('/trips'); ?>" x-show="activeCategory === 'all'" class="flex-shrink-0 w-48 md:w-64 snap-center md:snap-start rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center hover:border-brand hover:bg-blue-50 transition group cursor-pointer relative z-10">
                        <span class="text-3xl text-slate-400 group-hover:text-brand transition mb-2">➜</span><span class="font-bold text-slate-500 group-hover:text-brand transition">Lihat Semua</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-slate-50 border-t border-slate-200" 
             x-data="{ 
                atStart: true, atEnd: false,
                updateScroll() { const el = $refs.activitySlider; this.atStart = el.scrollLeft <= 5; this.atEnd = Math.ceil(el.scrollLeft + el.clientWidth) >= el.scrollWidth - 10; }
             }" x-init="$nextTick(() => updateScroll())" @resize.window.debounce.100ms="updateScroll()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 font-heading">Gaya Liburan</h2>
                    <p class="mt-1 text-slate-600 text-sm">Temukan pengalaman sesuai minat Anda.</p>
                </div>
                <div class="hidden md:flex gap-2">
                    <button @click="$refs.activitySlider.scrollBy({ left: -320, behavior: 'smooth' })" :disabled="atStart" :class="atStart ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="w-9 h-9 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-brand hover:border-brand hover:text-white transition">←</button>
                    <button @click="$refs.activitySlider.scrollBy({ left: 320, behavior: 'smooth' })" :disabled="atEnd" :class="atEnd ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="w-9 h-9 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-brand hover:border-brand hover:text-white transition">→</button>
                </div>
            </div>
            <div class="relative -mx-4 md:mx-0">
                <div x-ref="activitySlider" @scroll.debounce.10ms="updateScroll()" class="flex gap-4 md:gap-6 overflow-x-auto pb-4 pt-2 px-4 md:px-0 snap-x snap-mandatory no-scrollbar scroll-smooth">
                    <?php
                    $activities = get_terms(array('taxonomy' => 'activity', 'hide_empty' => true));
                    if (!empty($activities) && !is_wp_error($activities)) : foreach ($activities as $term) :
                        $img_url = nextur_get_term_image_url($term->term_id);
                        $link = get_term_link($term);
                    ?>
                        <a href="<?php echo esc_url($link); ?>" class="relative flex-shrink-0 w-60 md:w-72 aspect-[4/3] snap-center md:snap-start rounded-xl overflow-hidden group bg-slate-200 shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <img src="<?php echo esc_url($img_url); ?>" class="h-full w-full object-cover transition duration-700 group-hover:scale-110 filter brightness-90 group-hover:brightness-100">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-4">
                                <h3 class="text-lg font-bold text-white font-heading tracking-wide drop-shadow-md text-center"><?php echo esc_html($term->name); ?></h3>
                                <span class="mt-2 text-[10px] font-medium text-white/90 bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full border border-white/30 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition duration-300"><?php echo $term->count; ?> Trips</span>
                            </div>
                        </a>
                    <?php endforeach; else : ?>
                        <div class="w-full text-center py-8 bg-white border border-dashed border-slate-300 rounded-xl"><p class="text-slate-400 text-xs">Belum ada kategori aktivitas.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-white border-t border-slate-200" 
             x-data="{ 
                atStart: true, atEnd: false,
                updateScroll() { const el = $refs.destSlider; this.atStart = el.scrollLeft <= 5; this.atEnd = Math.ceil(el.scrollLeft + el.clientWidth) >= el.scrollWidth - 10; }
             }" x-init="$nextTick(() => updateScroll())" @resize.window.debounce.100ms="updateScroll()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 font-heading">Destinasi Populer</h2>
                    <p class="mt-1 text-slate-600 text-sm">Eksplorasi berdasarkan negara atau wilayah.</p>
                </div>
                <div class="hidden md:flex gap-2">
                    <button @click="$refs.destSlider.scrollBy({ left: -240, behavior: 'smooth' })" :disabled="atStart" :class="atStart ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="w-9 h-9 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-brand hover:border-brand hover:text-white transition">←</button>
                    <button @click="$refs.destSlider.scrollBy({ left: 240, behavior: 'smooth' })" :disabled="atEnd" :class="atEnd ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="w-9 h-9 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-brand hover:border-brand hover:text-white transition">→</button>
                </div>
            </div>
            <div class="relative -mx-4 md:mx-0">
                <div x-ref="destSlider" @scroll.debounce.10ms="updateScroll()" class="flex gap-4 md:gap-6 overflow-x-auto pb-4 pt-1 px-4 md:px-0 snap-x snap-mandatory no-scrollbar scroll-smooth">
                    <?php
                    $destinations = get_terms(array('taxonomy' => 'destination', 'hide_empty' => true, 'number' => 10));
                    if (!empty($destinations) && !is_wp_error($destinations)) : foreach ($destinations as $term) :
                        $img_url = nextur_get_term_image_url($term->term_id);
                        $link = get_term_link($term);
                    ?>
                        <a href="<?php echo esc_url($link); ?>" class="relative flex-shrink-0 w-44 md:w-52 aspect-[3/4] snap-center md:snap-start rounded-xl overflow-hidden group bg-slate-200 shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($term->name); ?>" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition"></div>
                            <div class="absolute bottom-0 left-0 p-4 w-full">
                                <h3 class="text-lg font-bold text-white font-heading tracking-wide leading-tight"><?php echo esc_html($term->name); ?></h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-medium text-white/80 bg-white/20 backdrop-blur-sm px-2 py-0.5 rounded-full"><?php echo $term->count; ?> Paket</span>
                                    <div class="h-0.5 w-0 bg-brand transition-all duration-300 group-hover:w-6"></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; else : ?>
                        <div class="w-full text-center py-8 bg-white border border-dashed border-slate-300 rounded-xl"><p class="text-slate-400 text-xs">Belum ada kategori destinasi.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-end mb-6">
                <div class="w-full md:w-auto">
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 font-heading mb-1">Jelajahi Indonesia</h2>
                    <p class="text-slate-600 text-sm">Surga tropis di negeri sendiri.</p>
                </div>
            </div>

            <div class="relative -mx-4 md:mx-0" 
                 x-data="{ 
                    atStart: true, 
                    atEnd: false,
                    updateScroll() { 
                        const el = $refs.indoSlider; 
                        this.atStart = el.scrollLeft <= 5; 
                        this.atEnd = Math.ceil(el.scrollLeft + el.clientWidth) >= el.scrollWidth - 10; 
                    } 
                 }" 
                 x-init="$nextTick(() => updateScroll())" 
                 @resize.window.debounce.100ms="updateScroll()">
                
                <button @click="$refs.indoSlider.scrollBy({ left: -280, behavior: 'smooth' })" :disabled="atStart" :class="atStart ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-20 -ml-5 w-12 h-12 rounded-full items-center justify-center transition-all duration-300 bg-white/80 backdrop-blur-md border border-white/50 shadow-xl text-slate-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                <button @click="$refs.indoSlider.scrollBy({ left: 280, behavior: 'smooth' })" :disabled="atEnd" :class="atEnd ? 'opacity-0 pointer-events-none' : 'opacity-100 hover:scale-110 hover:bg-white'" class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-20 -mr-5 w-12 h-12 rounded-full items-center justify-center transition-all duration-300 bg-white/80 backdrop-blur-md border border-white/50 shadow-xl text-slate-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                
                <div x-ref="indoSlider" @scroll.debounce.10ms="updateScroll()" class="flex gap-4 md:gap-6 overflow-x-auto pb-8 pt-2 px-4 md:px-0 snap-x snap-mandatory no-scrollbar scroll-smooth">
                    <?php
                    $args = array('post_type' => 'gallery_item', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC');
                    $highlights = new WP_Query($args);
                    if ($highlights->have_posts()) : while ($highlights->have_posts()) : $highlights->the_post();
                        $link = get_post_meta(get_the_ID(), '_gallery_link', true) ?: '#';
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : 'https://via.placeholder.com/600x800?text=No+Image';
                    ?>
                        <a href="<?php echo esc_url($link); ?>" class="flex-shrink-0 w-[60vw] md:w-64 aspect-[3/4] snap-center md:snap-start relative overflow-hidden rounded-xl bg-slate-200 group block shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 z-10">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition"></div>
                            <div class="absolute bottom-0 left-0 p-5 w-full">
                                <h3 class="text-lg font-bold text-white font-heading tracking-wide mb-1"><?php the_title(); ?></h3>
                                <div class="h-0.5 w-8 bg-brand transition-all duration-300 group-hover:w-16"></div>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); else : ?>
                        <div class="w-full text-center py-8 bg-white border border-dashed border-slate-300 rounded-xl"><p class="text-slate-400 text-xs">Belum ada destinasi highlight.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <p class="text-xl md:text-2xl font-serif italic text-slate-800 leading-relaxed">
                    "Kami mengintegrasikan estetika destinasi, nilai budaya, dan teknologi yang menciptakan pengalaman yang autentik dan berkelanjutan."
                </p>
                <div class="w-16 h-1 bg-brand mx-auto mt-6"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-6 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-brand rounded-xl flex items-center justify-center text-xl mb-4">✨</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Lifestyle Creator</h3>
                    <p class="text-slate-600 text-sm">Fokus pada penyusunan liburan yang berkesan dan berdampak.</p>
                </div>
                <div class="group p-6 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl mb-4">🎯</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Personalized</h3>
                    <p class="text-slate-600 text-sm">Perjalanan dimaksimalkan sepenuhnya sesuai minat Anda.</p>
                </div>
                <div class="group p-6 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl mb-4">💼</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">One-Stop Solution</h3>
                    <p class="text-slate-600 text-sm">Mulai dari liburan impian hingga insentif perusahaan.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>