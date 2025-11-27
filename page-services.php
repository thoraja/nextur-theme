<?php
/* Template Name: Services Page */
get_header(); 
?>

<main>
    <section class="relative pt-48 pb-24 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&q=80&w=1920" 
                 class="w-full h-full object-cover opacity-20" alt="Services Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white font-heading">Layanan Kami</h1>
            <p class="mt-4 text-slate-400 max-w-2xl mx-auto">Pilih gaya perjalanan yang sesuai dengan kepribadian Anda.</p>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="relative grid grid-cols-2 gap-4 mb-12 lg:mb-0">
                    <img class="rounded-2xl shadow-lg transform translate-y-8" src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&q=80&w=600" alt="Open Trip">
                    <img class="rounded-2xl shadow-lg" src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&q=80&w=600" alt="Private Trip">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-8 font-heading">Open vs Private Trip</h2>
                    
                    <div class="space-y-8">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100 text-brand text-xl">👥</span>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-slate-900 font-heading">Open Trip (Gabungan)</h3>
                                <p class="mt-2 text-slate-600">
                                    Solusi hemat biaya. Anda akan digabung dengan peserta lain dalam satu grup. Cocok untuk solo traveler atau grup kecil yang ingin menambah teman baru.
                                </p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-lg bg-amber-100 text-amber-600 text-xl">👑</span>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-slate-900 font-heading">Private Trip (Eksklusif)</h3>
                                <p class="mt-2 text-slate-600">
                                    Jadwal bebas, destinasi bebas. Mobil dan guide khusus hanya untuk Anda dan rombongan Anda. Privasi terjamin 100%.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand rounded-full blur-3xl opacity-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="md:w-2/3">
                <span class="text-brand font-bold tracking-widest uppercase text-sm mb-2 block font-heading">B2B Solutions</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-6 font-heading">Corporate Gathering & Outing</h2>
                <p class="text-slate-300 text-lg mb-8 leading-relaxed">
                    Tingkatkan kekompakan tim Anda melalui kegiatan outdoor yang menyenangkan. Kami menyediakan paket lengkap mulai dari transportasi, penginapan, hingga instruktur team building profesional.
                </p>
                <ul class="space-y-4 mb-10 text-slate-300">
                    <li class="flex items-center"><span class="text-brand mr-3">✓</span> Kapasitas hingga 500 pax</li>
                    <li class="flex items-center"><span class="text-brand mr-3">✓</span> Dokumentasi Drone & Video Cinematic</li>
                    <li class="flex items-center"><span class="text-brand mr-3">✓</span> Custom Itinerary sesuai budget perusahaan</li>
                </ul>
                <a href="<?php echo site_url('/contact'); ?>" class="inline-block bg-brand hover:bg-white hover:text-brand text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                    Minta Penawaran
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>