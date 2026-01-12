<?php
/* Template Name: Contact Page */
get_header(); 
?>

<main>
    <section class="relative pt-48 pb-20 bg-slate-900">
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white font-heading"><?php pll_e('Hubungi Kami'); ?></h1>
            <p class="mt-4 text-slate-400"><?php pll_e('Kami siap membantu merencanakan liburan impian Anda.'); ?></p>
        </div>
    </section>

    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 bg-white rounded-3xl shadow-xl overflow-hidden">
                
                <div class="p-10 md:p-14 bg-slate-900 text-white flex flex-col justify-center">
                    <h2 class="text-3xl font-bold mb-8 font-heading"><?php pll_e('Informasi Kontak'); ?></h2>
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-white/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold font-heading"><?php pll_e('Kantor Pusat'); ?></h3>
                                <p class="text-slate-300 text-sm mt-1"><?php pll_e('Jl. Sudirman Kav 12, Jakarta Selatan, 12190'); ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-white/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold font-heading"><?php pll_e('Telepon & WhatsApp'); ?></h3>
                                <p class="text-slate-300 text-sm mt-1"><?php pll_e('+62 812 9988 7766'); ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-white/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold font-heading"><?php pll_e('Email'); ?></h3>
                                <p class="text-slate-300 text-sm mt-1"><?php pll_e('info@nextur.com'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-10 md:p-14">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 font-heading"><?php pll_e('Kirim Pesan'); ?></h2>
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2"><?php pll_e('Nama Lengkap'); ?></label>
                            <input type="text" class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-300 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" placeholder="<?php pll_e('Nama Anda'); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2"><?php pll_e('Email Address'); ?></label>
                            <input type="email" class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-300 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" placeholder="<?php pll_e('email@contoh.com'); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2"><?php pll_e('Pesan'); ?></label>
                            <textarea rows="4" class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-300 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" placeholder="<?php pll_e('Tulis pesan Anda disini...'); ?>"></textarea>
                        </div>
                        <button type="button" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-4 rounded-lg transition duration-300 shadow-lg">
                            <?php pll_e('Kirim'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="w-full h-96 bg-slate-200 flex items-center justify-center">
        <div class="text-center text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
            <p><?php pll_e('Google Maps Area'); ?></p>
        </div>
    </div>
</main>

<?php get_footer(); ?>