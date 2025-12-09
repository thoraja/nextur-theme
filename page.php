<?php get_header(); ?>

<main class="bg-slate-50 min-h-screen pt-32 pb-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php while ( have_posts() ) : the_post(); ?>
            
            <article class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                
                <!-- Page Header -->
                <div class="bg-slate-900 px-8 py-10 md:py-16 text-center">
                    <h1 class="text-3xl md:text-5xl font-bold text-white font-heading">
                        <?php the_title(); ?>
                    </h1>
                </div>

                <!-- Page Content -->
                <div class="p-8 md:p-12 prose prose-lg prose-slate max-w-none
                            prose-headings:font-heading prose-headings:font-bold prose-headings:text-slate-900
                            prose-a:text-brand prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-xl">
                    <?php the_content(); ?>
                </div>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>