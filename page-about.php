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
            <span class="text-brand font-bold tracking-widest uppercase text-sm mb-2 block font-heading">Our Story</span>
            <h1 class="text-4xl md:text-6xl font-bold text-white font-heading">Tentang Nextur</h1>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-6 font-heading">Nextur <br><span class="text-brand">Awaits You</span></h2>
                    <div class="prose text-slate-600 font-sans space-y-4">
                        <p>
                            Nextur menggabungkan visi perjalanan masa depan dengan pengalaman yang dikurasi secara premium. Tagline “Awaits You” menegaskan bahwa setiap destinasi, petualangan, dan pengalaman eksklusif telah disiapkan dan sedang menunggu Anda. Nextur adalah undangan personal menuju eksplorasi baru—lebih terarah, lebih bermakna, dan berkelas.
                        </p>
                        <p>
                            Nextur berasal dari kata next (berikutnya/masa depan) dan tour (perjalanan). Nama ini mencerminkan sebuah brand perjalanan yang selalu bergerak maju, menghadirkan pengalaman baru, dan menjadi pintu menuju destinasi serta petualangan selanjutnya.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-brand/10 rounded-full blur-xl"></div>
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800" 
                         alt="Our Team" class="relative rounded-2xl shadow-xl z-10">
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 font-heading">Kenapa Memilih Kami?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-blue-50 text-brand rounded-xl flex items-center justify-center text-3xl mb-6 mx-auto">✈️</div>
                    <h3 class="text-xl font-bold mb-3 font-heading">Itinerary Terencana</h3>
                    <p class="text-slate-600 text-sm">Jadwal padat dan efisien agar Anda tidak membuang waktu.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-blue-50 text-brand rounded-xl flex items-center justify-center text-3xl mb-6 mx-auto">🛡️</div>
                    <h3 class="text-xl font-bold mb-3 font-heading">Aman & Terpercaya</h3>
                    <p class="text-slate-600 text-sm">Legalitas resmi PT dan asuransi perjalanan included.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-16 h-16 bg-blue-50 text-brand rounded-xl flex items-center justify-center text-3xl mb-6 mx-auto">💰</div>
                    <h3 class="text-xl font-bold mb-3 font-heading">Harga Transparan</h3>
                    <p class="text-slate-600 text-sm">Tidak ada biaya tersembunyi. Apa yang Anda lihat adalah yang Anda bayar.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 font-heading">Tim Kami</h2>
                <p class="mt-4 text-slate-600">Orang-orang di balik perjalanan seru Anda.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group text-center">
                    <div class="overflow-hidden rounded-2xl mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400" 
                             class="w-full h-80 object-cover transform group-hover:scale-110 transition duration-500" alt="CEO">
                    </div>
                    <h3 class="text-xl font-bold font-heading">Budi Santoso</h3>
                    <p class="text-brand font-medium text-sm">Founder & CEO</p>
                </div>
                <div class="group text-center">
                    <div class="overflow-hidden rounded-2xl mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400" 
                             class="w-full h-80 object-cover transform group-hover:scale-110 transition duration-500" alt="Ops">
                    </div>
                    <h3 class="text-xl font-bold font-heading">Sarah Wijaya</h3>
                    <p class="text-brand font-medium text-sm">Head of Operations</p>
                </div>
                <div class="group text-center">
                    <div class="overflow-hidden rounded-2xl mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400" 
                             class="w-full h-80 object-cover transform group-hover:scale-110 transition duration-500" alt="Guide">
                    </div>
                    <h3 class="text-xl font-bold font-heading">Doni Pratama</h3>
                    <p class="text-brand font-medium text-sm">Senior Tour Guide</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>