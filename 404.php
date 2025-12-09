<?php get_header(); ?>

<main class="min-h-screen flex items-center justify-center bg-slate-50 relative overflow-hidden">
    
    <!-- Decorative Blobs -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand rounded-full blur-3xl opacity-10"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-teal-500 rounded-full blur-3xl opacity-10"></div>

    <div class="relative z-10 text-center max-w-lg px-4">
        <h1 class="text-9xl font-extrabold text-slate-200 font-heading mb-4">404</h1>
        <h2 class="text-3xl font-bold text-slate-900 font-heading mb-4">Halaman Tidak Ditemukan</h2>
        <p class="text-slate-600 text-lg mb-8 leading-relaxed">
            Maaf, halaman yang Anda cari mungkin telah dihapus atau URL yang Anda masukkan salah.
        </p>
        
        <a href="<?php echo home_url(); ?>" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-dark text-white font-bold py-3 px-8 rounded-full transition shadow-lg shadow-brand/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</main>

<?php get_footer(); ?>