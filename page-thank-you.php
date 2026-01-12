<?php
/* Template Name: Thank You Page */
get_header(); 
?>

<main class="min-h-screen flex items-center justify-center bg-slate-900 relative overflow-hidden">
    
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand rounded-full blur-3xl opacity-10"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-teal-500 rounded-full blur-3xl opacity-10"></div>

    <div class="relative z-10 text-center max-w-lg px-4">
        <div class="w-24 h-24 bg-green-500/20 border border-green-500/30 rounded-full flex items-center justify-center mx-auto mb-8 backdrop-blur-sm">
            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-bold text-white font-heading mb-6"><?php pll_e('Terima Kasih!'); ?></h1>
        <p class="text-slate-300 text-lg mb-10 leading-relaxed">
            <?php pll_e('Booking Anda telah kami terima. Tim kami akan segera menghubungi Anda melalui WhatsApp/Email untuk konfirmasi pembayaran.'); ?>
        </p>
        
        <a href="<?php echo home_url(); ?>" class="inline-block bg-brand hover:bg-brand-dark text-white font-bold py-3 px-8 rounded-full transition shadow-lg shadow-brand/20">
            <?php pll_e('Kembali ke Beranda'); ?>
        </a>
    </div>
</main>

<?php get_footer(); ?>