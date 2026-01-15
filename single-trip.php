<?php get_header(); ?>

<?php
// 1. DATA FETCHING
$id = get_the_ID();

// Header Info
$header = [
    'year'    => get_post_meta($id, '_trip_tag_year', true),
    'airline' => get_post_meta($id, '_trip_airline', true),
    'route'   => get_post_meta($id, '_trip_route', true),
    'price'   => get_post_meta($id, '_trip_price', true),
    'sub'     => get_post_meta($id, '_trip_subtitle', true),
];

// Highlights
$highlights = get_post_meta($id, '_trip_highlights', true);
$highlight_list = $highlights ? array_map('trim', explode(',', $highlights)) : [];

// Itinerary & Gallery
$itinerary = get_post_meta($id, '_trip_itinerary', true);
$gallery_ids = get_post_meta($id, '_trip_gallery', true);
$gallery_images = $gallery_ids ? explode(',', $gallery_ids) : [];

// Details
$details = [
    'includes' => get_post_meta($id, '_trip_includes', true),
    'excludes' => get_post_meta($id, '_trip_excludes', true),
    'optional' => get_post_meta($id, '_trip_optional', true),
    'terms'    => get_post_meta($id, '_trip_terms', true),
];

// Financials
$financials = [
    'min_pax'   => get_post_meta($id, '_trip_min_pax', true),
    'deposit'   => get_post_meta($id, '_trip_deposit', true),
    'infant'    => get_post_meta($id, '_trip_infant_price', true),
    'visa'      => get_post_meta($id, '_trip_visa_note', true),
    'pay_terms' => get_post_meta($id, '_trip_payment_terms', true),
];
?>

<main class="bg-slate-50 min-h-screen pb-24">

    <div class="relative min-h-[500px] lg:h-[65vh] flex items-end">
        <div class="absolute inset-0">
            <?php if(has_post_thumbnail()) { 
                the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); 
            } else { 
                echo '<div class="w-full h-full bg-slate-800"></div>'; 
            } ?>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-12 pt-24 lg:pt-0">
            
            <?php if($header['year']): ?>
                <span class="inline-block bg-brand text-white text-xs font-bold px-3 py-1 rounded-full mb-4 uppercase tracking-wider shadow-lg">
                    <?php echo esc_html($header['year']); ?>
                </span>
            <?php endif; ?>

            <h1 class="text-3xl md:text-6xl font-bold text-white font-heading leading-tight mb-2 drop-shadow-md">
                <?php the_title(); ?>
            </h1>
            
            <?php if($header['sub']): ?>
                <p class="text-lg md:text-2xl text-slate-300 font-serif italic mb-6 drop-shadow-sm">
                    <?php echo esc_html($header['sub']); ?>
                </p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-4 md:gap-6 text-sm text-slate-200 border-t border-white/20 pt-6">
                <?php if($header['airline']): ?>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <span class="font-semibold"><?php echo esc_html($header['airline']); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if($header['route']): ?>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span><?php echo esc_html($header['route']); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 lg:-mt-8 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <div class="lg:col-span-2 space-y-8 order-1">
                <?php if(!empty($highlight_list)): ?>
                <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-brand">
                    <h3 class="font-bold text-slate-900 mb-4 uppercase text-xs tracking-wider">Trip Highlights</h3>
                    <div class="grid md:grid-cols-2 gap-3">
                        <?php foreach($highlight_list as $hl): ?>
                            <div class="flex items-start gap-2 text-sm text-slate-700">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><?php echo esc_html($hl); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden min-h-[600px]" 
                     x-data="{ tab: 'itinerary', lightboxOpen: false, activeImage: '' }">
                    
                    <div class="flex border-b border-slate-200 overflow-x-auto no-scrollbar bg-slate-50/50">
                        <button @click="tab = 'itinerary'" 
                            :class="tab === 'itinerary' ? 'border-brand text-brand bg-white' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-4 px-4 font-bold text-sm border-b-2 transition whitespace-nowrap">
                            <?php pll_e('Itinerary'); ?>
                        </button>
                        <button @click="tab = 'inclusions'" 
                            :class="tab === 'inclusions' ? 'border-brand text-brand bg-white' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-4 px-4 font-bold text-sm border-b-2 transition whitespace-nowrap">
                            <?php pll_e('Fasilitas'); ?>
                        </button>
                        <button @click="tab = 'financials'" 
                            :class="tab === 'financials' ? 'border-brand text-brand bg-white' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-4 px-4 font-bold text-sm border-b-2 transition whitespace-nowrap">
                            <?php pll_e('Info Penting'); ?>
                        </button>
                        <button @click="tab = 'gallery'" 
                            :class="tab === 'gallery' ? 'border-brand text-brand bg-white' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-4 px-4 font-bold text-sm border-b-2 transition whitespace-nowrap">
                            <?php pll_e('Galeri'); ?>
                        </button>
                        <button @click="tab = 'terms'" 
                            :class="tab === 'terms' ? 'border-brand text-brand bg-white' : 'border-transparent text-slate-500 hover:text-slate-700'"
                            class="flex-1 py-4 px-4 font-bold text-sm border-b-2 transition whitespace-nowrap">
                            <?php pll_e('S&K'); ?>
                        </button>
                    </div>

                    <div class="p-6 md:p-8">
                        
                        <div x-show="tab === 'itinerary'" x-transition.opacity>
                            <?php if($itinerary): ?>
                                <div class="relative border-l-2 border-slate-100 ml-3 space-y-8">
                                    <?php foreach($itinerary as $day): ?>
                                    <div class="relative pl-8 group">
                                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-slate-200 border-2 border-white group-hover:bg-brand transition"></div>
                                        <div class="mb-2">
                                            <span class="text-xs font-bold text-brand uppercase tracking-wider mb-1 block">
                                                <?php echo esc_html($day['day']); ?>
                                            </span>
                                            <h3 class="text-lg font-bold text-slate-900">
                                                <?php echo esc_html($day['title']); ?>
                                            </h3>
                                        </div>
                                        <?php if(!empty($day['flight_info']) || !empty($day['meals'])): ?>
                                        <div class="flex flex-wrap gap-3 mb-3">
                                            <?php if(!empty($day['flight_info'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 text-blue-700 text-xs font-medium">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16v-2l-8-5V3.5A1.5 1.5 0 0 0 11.5 2 1.5 1.5 0 0 0 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/></svg>
                                                <?php echo esc_html($day['flight_info']); ?>
                                            </span>
                                            <?php endif; ?>
                                            <?php if(!empty($day['meals'])): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-amber-50 text-amber-700 text-xs font-medium">
                                                Meals: <?php echo esc_html($day['meals']); ?>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="prose prose-sm text-slate-600 leading-relaxed whitespace-pre-line max-w-none">
                                            <?php echo esc_html($day['desc']); ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-slate-400 italic">Itinerary details updating...</p>
                            <?php endif; ?>
                        </div>

                        <div x-show="tab === 'inclusions'" style="display:none" x-transition.opacity>
                            <div class="grid md:grid-cols-2 gap-10">
                                <div>
                                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xs">✓</div>
                                        Includes
                                    </h3>
                                    <div class="prose prose-sm prose-slate text-slate-600 prose-ul:list-disc prose-li:marker:text-green-500 pl-4 max-w-none">
                                        <?php echo wpautop($details['includes']); ?>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-xs">✕</div>
                                        Excludes
                                    </h3>
                                    <div class="prose prose-sm prose-slate text-slate-600 prose-ul:list-disc prose-li:marker:text-red-500 pl-4 max-w-none">
                                        <?php echo wpautop($details['excludes']); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if($details['optional']): ?>
                            <div class="mt-8 pt-6 border-t border-slate-100">
                                <h4 class="font-bold text-slate-900 mb-2">Optional Add-ons</h4>
                                <div class="prose prose-sm prose-slate text-slate-600 prose-ul:list-disc pl-4 max-w-none">
                                    <?php echo wpautop($details['optional']); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div x-show="tab === 'financials'" style="display:none" x-transition.opacity>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <?php if($financials['deposit']): ?>
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                    <span class="text-xs text-blue-600 font-bold uppercase">Deposit</span>
                                    <p class="font-bold text-slate-900"><?php echo esc_html($financials['deposit']); ?></p>
                                </div>
                                <?php endif; ?>
                                <?php if($financials['min_pax']): ?>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <span class="text-xs text-slate-500 font-bold uppercase">Min Pax</span>
                                    <p class="font-bold text-slate-900"><?php echo esc_html($financials['min_pax']); ?></p>
                                </div>
                                <?php endif; ?>
                                <?php if($financials['infant']): ?>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <span class="text-xs text-slate-500 font-bold uppercase">Infant Price</span>
                                    <p class="font-bold text-slate-900"><?php echo esc_html($financials['infant']); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <?php if($financials['visa']): ?>
                            <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 mb-6">
                                <h4 class="text-sm font-bold text-amber-800 mb-1">Visa Note</h4>
                                <p class="text-sm text-amber-900"><?php echo esc_html($financials['visa']); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if($financials['pay_terms']): ?>
                            <div class="mt-4">
                                <h4 class="font-bold text-slate-900 mb-2">Payment Terms</h4>
                                <p class="text-sm text-slate-600 whitespace-pre-line"><?php echo esc_html($financials['pay_terms']); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div x-show="tab === 'gallery'" style="display:none" x-transition.opacity>
                            <?php if(!empty($gallery_images)): ?>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <?php foreach($gallery_images as $img_id): 
                                        $full_img = wp_get_attachment_image_url($img_id, 'full');
                                        $thumb_img = wp_get_attachment_image_url($img_id, 'medium_large');
                                        if($full_img):
                                    ?>
                                        <div class="relative group cursor-pointer overflow-hidden rounded-xl bg-slate-100 aspect-square"
                                             @click="lightboxOpen = true; activeImage = '<?php echo esc_url($full_img); ?>'">
                                            <img src="<?php echo esc_url($thumb_img); ?>" 
                                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500" 
                                                 alt="Gallery Image">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition transform scale-75 group-hover:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                            </div>
                                        </div>
                                    <?php endif; endforeach; ?>
                                </div>

                                <div x-show="lightboxOpen" 
                                     class="fixed inset-0 z-[9999] bg-black/90 backdrop-blur-sm flex items-center justify-center p-4"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     style="display: none;">
                                    <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white transition">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <img :src="activeImage" 
                                         @click.outside="lightboxOpen = false"
                                         class="max-w-full max-h-[90vh] rounded-lg shadow-2xl"
                                         x-transition:enter="transition ease-out duration-300 delay-100"
                                         x-transition:enter-start="opacity-0 scale-90"
                                         x-transition:enter-end="opacity-100 scale-100">
                                </div>

                            <?php else: ?>
                                <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                    <p class="text-slate-400"><?php pll_e('Belum ada foto galeri untuk trip ini.'); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div x-show="tab === 'terms'" style="display:none" x-transition.opacity>
                            <div class="prose prose-sm prose-slate text-slate-600 prose-ul:list-disc prose-ol:list-decimal pl-4 max-w-none">
                                <?php echo wpautop($details['terms']); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 order-2 relative z-30 h-full">
                <div class="sticky top-28 space-y-4">
                    
                    <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand rounded-full blur-3xl opacity-20"></div>

                        <div class="relative z-10">
                            <p class="text-slate-400 text-xs font-bold uppercase mb-1">Start From</p>
                            <p class="text-4xl font-bold font-heading text-white mb-6">
                                <?php echo $header['price'] ? 'Rp ' . number_format($header['price'], 0, ',', '.') : 'Hubungi Kami'; ?>
                            </p>
                            
                            <div class="space-y-2 mb-6 text-sm text-slate-300">
                                <?php if($financials['deposit']): ?>
                                <div class="flex justify-between border-b border-white/10 pb-2">
                                    <span>Deposit</span>
                                    <span class="font-semibold text-white"><?php echo 'Rp ' . number_format($financials['deposit'], 0, ',', '.'); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div x-data="{ mode: 'form' }">
                                <div class="grid grid-cols-2 gap-2 p-1 bg-slate-800 rounded-lg mb-6">
                                    <button type="button" @click="mode = 'form'" :class="mode === 'form' ? 'bg-slate-600 text-white shadow-md' : 'text-slate-400 hover:text-white'" class="py-2 text-sm font-bold rounded-md transition duration-200">Email</button>
                                    <button type="button" @click="mode = 'wa'" :class="mode === 'wa' ? 'bg-green-600 text-white shadow-md' : 'text-slate-400 hover:text-white'" class="py-2 text-sm font-bold rounded-md transition duration-200">WhatsApp</button>
                                </div>

                                <div x-show="mode === 'form'" x-transition.opacity>
                                    <?php get_template_part('template-parts/booking-form'); ?>
                                </div>

                                <div x-show="mode === 'wa'" style="display: none;" x-transition.opacity>
                                    <button id="waButtonSide" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 transition shadow-lg transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        Book via WhatsApp
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center text-xs text-slate-500">
                            Licensed PT • Trusted • Quality
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('waButtonSide');
    const title = "<?php echo esc_js(get_the_title()); ?>";
    const phone = "6281234567890"; // Replace with real admin number
    
    if(btn) {
        btn.addEventListener('click', function() {
            const message = `Halo Nextur, saya tertarik dengan trip: ${title}. Mohon info availability.`;
            const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        });
    }
});
</script>


<?php get_footer(); ?>