<?php get_header(); ?>

<section class="relative bg-brand-dark text-white py-32">
    <div class="absolute inset-0 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
             alt="Travel Background" class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4">
            Jelajahi Dunia Bersama <span class="text-brand-light">Nextur</span>
        </h1>
        <p class="mt-4 text-xl max-w-2xl mx-auto text-gray-200">
            Solusi perjalanan Open Trip dan Private Trip terpercaya untuk liburan impian Anda.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="#destinations" class="bg-brand hover:bg-brand-light text-white font-bold py-3 px-8 rounded-lg shadow-lg transition">
                Lihat Destinasi
            </a>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Kenapa Memilih Kami?</h2>
            <p class="mt-2 text-gray-600">Pelayanan terbaik untuk kenyamanan Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 bg-slate-50 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="text-brand text-4xl mb-4">✈️</div>
                <h3 class="text-xl font-bold mb-2">Itinerary Terencana</h3>
                <p class="text-gray-600">Kami menyusun jadwal perjalanan yang efisien dan menyenangkan.</p>
            </div>
             <div class="p-6 bg-slate-50 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="text-brand text-4xl mb-4">🛡️</div>
                <h3 class="text-xl font-bold mb-2">Aman & Terpercaya</h3>
                <p class="text-gray-600">Legalitas resmi dan pengalaman bertahun-tahun.</p>
            </div>
             <div class="p-6 bg-slate-50 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="text-brand text-4xl mb-4">💰</div>
                <h3 class="text-xl font-bold mb-2">Harga Terbaik</h3>
                <p class="text-gray-600">Penawaran Open Trip dengan harga yang kompetitif.</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>