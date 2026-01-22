<?php
/* Template Name: About Page */
get_header(); 
?>

<main>
    <section class="relative h-[50vh] min-h-[400px] flex items-center justify-center overflow-hidden bg-slate-900">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?auto=format&fit=crop&q=80&w=1920" 
                 class="w-full h-full object-cover opacity-40" alt="About Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white font-heading"><?php pll_e('Tentang Nextur'); ?></h1>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-8 font-heading"><?php pll_e('Visi & Filosofi'); ?></h2>
                    <div class="prose text-lg text-slate-600 font-sans leading-relaxed space-y-6">
                        <p class="font-medium text-slate-800">
                            "<?php pll_e('Bagi kami, masa depan bukan sekadar tujuan, tetapi jembatan antara keindahan destinasi dan kebutuhan pelanggan.'); ?>"
                        </p>
                        <p>
                            <?php pll_e('Suatu perjalanan bukan lagi sekadar perpindahan, tetapi transformasi yang memperkaya perspektif. Kami berkomitmen untuk menghadirkan pengalaman yang tidak hanya membawa Anda ke tempat baru, tetapi juga memberikan nilai baru dalam hidup Anda.'); ?>
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex gap-4 p-6 bg-slate-50 rounded-xl border-l-4 border-brand hover:shadow-md transition">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 font-heading"><?php pll_e('Innovation with Purpose'); ?></h3>
                            <p class="text-slate-600 text-sm mt-1"><?php pll_e('Solusi desain untuk nilai nyata dan kebutuhan pasar.'); ?></p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-6 bg-slate-50 rounded-xl border-l-4 border-teal-500 hover:shadow-md transition">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 font-heading"><?php pll_e('Partnership for Growth'); ?></h3>
                            <p class="text-slate-600 text-sm mt-1"><?php pll_e('Kolaborasi sebagai perjalanan bersama. Pertumbuhan klien adalah keberhasilan kami.'); ?></p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-6 bg-slate-50 rounded-xl border-l-4 border-green-500 hover:shadow-md transition">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 font-heading"><?php pll_e('Sustainable Impact'); ?></h3>
                            <p class="text-slate-600 text-sm mt-1"><?php pll_e('Memprioritaskan keberlanjutan untuk manfaat masa depan.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 font-heading"><?php pll_e('Tim Kami'); ?></h2>
                <p class="text-slate-600 mt-4 max-w-2xl mx-auto">
                    <?php pll_e('Orang-orang di balik perjalanan seru Anda.'); ?>
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $team_query = new WP_Query(array(
                    'post_type' => 'team_member',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ($team_query->have_posts()) :
                    while ($team_query->have_posts()) : $team_query->the_post();
                        $role = get_post_meta(get_the_ID(), '_team_role', true);
                        $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : 'https://via.placeholder.com/400x500?text=No+Image';
                ?>
                <div class="group text-center">
                    <div class="overflow-hidden rounded-2xl mb-6 shadow-lg aspect-[3/4]">
                        <img src="<?php echo esc_url($img_url); ?>" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500" alt="<?php the_title(); ?>">
                    </div>
                    <h3 class="text-xl font-bold font-heading"><?php the_title(); ?></h3>
                    <p class="text-brand font-medium text-sm"><?php echo esc_html($role); ?></p>
                </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>