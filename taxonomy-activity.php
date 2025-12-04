<?php get_header(); ?>

<?php
// 1. Get Current Term Info
$term = get_queried_object();
$term_id = $term->term_id;
$title = $term->name;
$desc = $term->description;

// 2. Get Smart Background Image
$hero_bg = nextur_get_term_image_url($term_id);
?>

<main class="bg-slate-50 min-h-screen">

    <section class="relative bg-slate-900 pt-32 pb-32 lg:pt-48 lg:pb-48 overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-40 transition-transform duration-[20s] hover:scale-110 ease-linear transform origin-center" 
                 src="<?php echo esc_url($hero_bg); ?>" 
                 alt="<?php echo esc_attr($title); ?>">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-900"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold uppercase tracking-wider mb-4 backdrop-blur-md">
                <?php echo esc_html($term->taxonomy === 'destination' ? 'Explore Destination' : 'Explore Activity'); ?>
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4 font-heading">
                Wisata <?php echo esc_html($title); ?>
            </h1>
            <?php if ($desc) : ?>
                <p class="mt-2 max-w-2xl mx-auto text-lg text-slate-200 leading-relaxed font-sans">
                    <?php echo esc_html($desc); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php if (have_posts()) : ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while (have_posts()) : the_post(); 
                        // Fetch Meta Data
                        $id = get_the_ID();
                        $price = get_post_meta($id, '_trip_price', true);
                        $formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
                        $airline = get_post_meta($id, '_trip_airline', true);
                        $year_tag = get_post_meta($id, '_trip_tag_year', true);
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url($id, 'large') : 'https://via.placeholder.com/600x400';
                    ?>
                        <a href="<?php the_permalink(); ?>" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 flex flex-col h-full">
                            
                            <div class="relative h-64 overflow-hidden">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                                
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
                                    <span class="text-sm font-bold text-slate-900 hover:text-brand transition flex items-center gap-1">
                                        Detail <span class="text-lg">→</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>

                <div class="mt-16 flex justify-center">
                    <?php 
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '←',
                        'next_text' => '→',
                        'class'     => '' 
                    )); 
                    ?>
                </div>

            <?php else : ?>
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                    <div class="text-6xl mb-4">🌏</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada paket wisata.</h3>
                    <p class="text-slate-500 mb-6">Kami sedang menyiapkan paket terbaik untuk destinasi ini.</p>
                    <a href="<?php echo home_url(); ?>" class="inline-block bg-brand text-white px-6 py-3 rounded-full font-bold hover:bg-brand-dark transition">
                        Kembali ke Beranda
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>