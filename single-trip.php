<?php get_header(); ?>

<?php 
$price = get_post_meta(get_the_ID(), '_trip_price', true); 
$formatted_price = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Hubungi Kami';
?>

<main class="bg-slate-50 min-h-screen pb-24">
    
    <div class="relative h-[60vh] min-h-[500px]">
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url('full'); ?>" class="w-full h-full object-cover" alt="<?php the_title(); ?>">
        <?php else : ?>
            <div class="w-full h-full bg-slate-800"></div>
        <?php endif; ?>
        
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12">
            <div class="max-w-7xl mx-auto">
                <span class="inline-block bg-brand text-white text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Open Trip</span>
                <h1 class="text-4xl md:text-6xl font-bold text-white font-heading mb-2"><?php the_title(); ?></h1>
                <p class="text-2xl text-slate-200 font-medium"><?php echo $formatted_price; ?> <span class="text-sm text-slate-400">/pax</span></p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4 font-heading">Deskripsi Trip</h2>
                    <div class="prose max-w-none text-slate-600 font-sans">
                        <?php the_content(); ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 font-heading">Itinerary Perjalanan</h2>
                    
                    <div class="space-y-4" x-data="{ active: 1 }">
                        <?php 
                        // Loop 5 days
                        $has_itinerary = false;
                        for ($i = 1; $i <= 5; $i++) :
                            $day_title = get_post_meta(get_the_ID(), "_itinerary_day_{$i}_title", true);
                            $day_desc = get_post_meta(get_the_ID(), "_itinerary_day_{$i}_desc", true);
                            
                            if ($day_title) : 
                                $has_itinerary = true;
                        ?>
                            <div class="border border-slate-200 rounded-lg overflow-hidden">
                                <button @click="active = <?php echo $i; ?>" class="w-full flex justify-between items-center p-4 bg-slate-50 hover:bg-slate-100 transition text-left">
                                    <span class="font-bold text-slate-800">Hari <?php echo $i; ?>: <?php echo esc_html($day_title); ?></span>
                                    <span x-show="active !== <?php echo $i; ?>">+</span>
                                    <span x-show="active === <?php echo $i; ?>">-</span>
                                </button>
                                <div x-show="active === <?php echo $i; ?>" class="p-4 text-slate-600 border-t border-slate-200 text-sm">
                                    <?php echo nl2br(esc_html($day_desc)); ?>
                                </div>
                            </div>
                        <?php 
                            endif; 
                        endfor; 
                        
                        if (!$has_itinerary) {
                            echo '<p class="text-slate-500 italic">Detail itinerary akan segera diupdate.</p>';
                        }
                        ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4 font-heading">Fasilitas</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center text-green-600"><span class="mr-2">✓</span> Transportasi AC</li>
                            <li class="flex items-center text-green-600"><span class="mr-2">✓</span> Hotel Bintang 3/4</li>
                            <li class="flex items-center text-green-600"><span class="mr-2">✓</span> Makan Sesuai Jadwal</li>
                        </ul>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center text-red-500"><span class="mr-2">✕</span> Tiket Pesawat</li>
                            <li class="flex items-center text-red-500"><span class="mr-2">✕</span> Pengeluaran Pribadi</li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    
                    <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
                        <div class="mb-6 border-b border-slate-700 pb-4">
                            <p class="text-slate-400 text-sm">Harga Mulai</p>
                            <p class="text-3xl font-bold font-heading text-brand"><?php echo $formatted_price; ?></p>
                        </div>
                        
                        <div x-data="{ mode: 'form' }">
                            <div class="grid grid-cols-2 gap-2 p-1 bg-slate-800 rounded-lg mb-6">
                                <button @click="mode = 'form'" :class="mode === 'form' ? 'bg-slate-600 text-white' : 'text-slate-400 hover:text-white'" class="py-2 text-sm font-bold rounded-md transition">Email</button>
                                <button @click="mode = 'wa'" :class="mode === 'wa' ? 'bg-green-600 text-white' : 'text-slate-400 hover:text-white'" class="py-2 text-sm font-bold rounded-md transition">WhatsApp</button>
                            </div>

                            <div x-show="mode === 'form'">
                                <p class="text-sm text-slate-400 mb-4">Isi form untuk booking via email.</p>
                                <?php get_template_part('template-parts/booking-form'); ?>
                            </div>

                            <div x-show="mode === 'wa'" style="display: none;">
                                <p class="text-sm text-slate-400 mb-4">Chat langsung dengan admin kami.</p>
                                <button id="waButton" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg flex items-center justify-center gap-2 transition shadow-lg">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    Chat via WhatsApp
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm text-center">
                        <p class="text-sm text-slate-500 mb-2">Butuh bantuan?</p>
                        <p class="font-bold text-slate-900">+62 812 3456 7890</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('waButton');
        const title = "<?php echo esc_js(get_the_title()); ?>";
        const phone = "6281234567890"; 
        
        if(button) {
            button.addEventListener('click', function() {
                const message = `Halo Nextur, saya tertarik dengan trip: ${title}. Boleh minta info lebih lanjut?`;
                const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                window.open(url, '_blank');
            });
        }
    });
</script>

<?php get_footer(); ?>