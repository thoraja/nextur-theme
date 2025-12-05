<?php
/* Template Name: Accommodation Page */
get_header(); 
?>

<main class="min-h-screen flex items-center justify-center bg-slate-900 relative overflow-hidden">
    
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Luxury Hotel" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-slate-900/40"></div>
    </div>

    <div class="relative z-10 text-center max-w-lg px-6">
        
        <div class="w-20 h-20 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-2xl">
            <svg class="w-10 h-10 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-bold text-white font-heading mb-4 tracking-tight">
            Accommodation
        </h1>
        
        <p class="text-slate-300 text-lg mb-10 leading-relaxed font-light">
            We are currently curating the best stay partners for you. <br/>
            <span class="text-brand font-semibold">Coming Soon.</span>
        </p>
        
        <a href="<?php echo home_url(); ?>" class="inline-flex items-center gap-2 bg-white text-slate-900 font-bold py-3 px-8 rounded-full hover:bg-slate-200 transition shadow-lg">
            <span>←</span> Back to Home
        </a>
    </div>
</main>

<?php get_footer(); ?>