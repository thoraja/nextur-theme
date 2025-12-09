<?php get_header(); ?>

<main class="bg-slate-50 min-h-screen pt-32 pb-24">
    <div class="max-w-4xl mx-auto px-4">
        
        <?php if ( have_posts() ) : ?>
            
            <div class="space-y-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">
                            <a href="<?php the_permalink(); ?>" class="hover:text-brand"><?php the_title(); ?></a>
                        </h2>
                        <div class="text-sm text-slate-500 mb-4"><?php echo get_the_date(); ?></div>
                        <div class="prose max-w-none text-slate-600">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="mt-8">
                <?php the_posts_pagination(); ?>
            </div>

        <?php else : ?>
            <div class="text-center py-20">
                <h1 class="text-2xl font-bold text-slate-900">Nothing Found</h1>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>