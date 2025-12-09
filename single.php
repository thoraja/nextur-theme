<?php get_header(); ?>

<main class="bg-slate-50 min-h-screen pt-32 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php while (have_posts()) : the_post(); ?>
        
        <!-- Breadcrumb / Meta -->
        <div class="mb-8 text-center max-w-3xl mx-auto">
            <div class="flex items-center justify-center gap-3 text-sm text-slate-500 mb-4">
                <?php 
                $cat = get_the_category(); 
                if($cat) echo '<span class="text-brand font-bold uppercase tracking-wider">' . esc_html($cat[0]->name) . '</span>';
                ?>
                <span>•</span>
                <span><?php echo get_the_date(); ?></span>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-slate-900 font-heading leading-tight mb-6">
                <?php the_title(); ?>
            </h1>
        </div>

        <!-- Featured Image -->
        <?php if(has_post_thumbnail()): ?>
        <div class="mb-12 rounded-2xl overflow-hidden shadow-lg h-[400px] md:h-[500px]">
            <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
        </div>
        <?php endif; ?>

        <!-- Two Column Layout -->
        <div class="grid lg:grid-cols-12 gap-12 items-start">
            
            <!-- LEFT: Content (8 Cols) -->
            <div class="lg:col-span-8">
                <!-- Article Body -->
                <article class="prose prose-lg prose-slate max-w-none 
                                prose-headings:font-heading prose-headings:font-bold prose-headings:text-slate-900
                                prose-a:text-brand prose-a:no-underline hover:prose-a:underline
                                prose-img:rounded-xl prose-img:shadow-md">
                    <?php the_content(); ?>
                </article>

                <!-- Author Box -->
                <div class="mt-12 p-6 bg-white rounded-xl border border-slate-100 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                        <?php echo get_avatar(get_the_author_meta('ID'), 128); ?>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide font-bold mb-1">Ditulis Oleh</p>
                        <h4 class="text-lg font-bold text-slate-900"><?php the_author(); ?></h4>
                        <p class="text-sm text-slate-500"><?php echo get_the_author_meta('description'); ?></p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-8 grid grid-cols-2 gap-4 border-t border-slate-200 pt-8">
                    <div class="text-left">
                        <?php previous_post_link('%link', '<span class="text-xs text-slate-400 block mb-1">← Sebelumnya</span><span class="font-bold text-slate-800 text-sm hover:text-brand block truncate">%title</span>'); ?>
                    </div>
                    <div class="text-right">
                        <?php next_post_link('%link', '<span class="text-xs text-slate-400 block mb-1">Selanjutnya →</span><span class="font-bold text-slate-800 text-sm hover:text-brand block truncate">%title</span>'); ?>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Sidebar (4 Cols) -->
            <div class="lg:col-span-4 sticky top-28">
                <?php get_sidebar(); ?>
            </div>

        </div>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>