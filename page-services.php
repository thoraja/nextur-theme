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
            <p class="mt-4 text-slate-400 max-w-2xl mx-auto">Solusi perjalanan komprehensif untuk kebutuhan Anda.</p>
        </div>
    </section>

    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-slate-100">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-2xl mb-6">✈️</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Tailored Travel Experiences</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Perencanaan perjalanan personal untuk individu, kelompok, maupun korporasi.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-slate-100">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-2xl mb-6">🗺️</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Destination Management</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Pengelolaan destinasi autentik dengan kolaborasi komunitas lokal.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-slate-100">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-2xl mb-6">📱</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Smart Travel Technology</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Solusi teknologi untuk efisiensi, keamanan, dan kenyamanan.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-slate-100 lg:col-start-1 lg:col-end-2 lg:translate-x-[50%]">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-2xl mb-6">💎</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Premium Hospitality</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Perancangan pengalaman premium dari retret mewah hingga eksplorasi budaya.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-slate-100 lg:col-start-2 lg:col-end-3 lg:translate-x-[50%]">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-2xl mb-6">🌿</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Sustainable Tourism</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Pengembangan pariwisata berkelanjutan untuk ketahanan jangka panjang.
                    </p>
                </div>

            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>