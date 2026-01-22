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
                                <p class="text-slate-300 text-sm mt-1"><?php echo nl2br(esc_html(nextur_get_company_info('address'))); ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-white/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold font-heading"><?php pll_e('Telepon & WhatsApp'); ?></h3>
                                <p class="text-slate-300 text-sm mt-1"><?php echo esc_html(nextur_get_company_info('phone')); ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-white/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold font-heading"><?php pll_e('Email'); ?></h3>
                                <p class="text-slate-300 text-sm mt-1"><?php echo esc_html(nextur_get_company_info('email')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-10 md:p-14">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 font-heading"><?php pll_e('Kirim Pesan'); ?></h2>
                    
                    <?php if (isset($_GET['sent']) && $_GET['sent'] == 'success') : ?>
                        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 border border-green-200">
                            ✅ Message sent successfully! We will reply shortly.
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="space-y-6">
                        
                        <input type="hidden" name="action" value="submit_contact">

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2"><?php pll_e('Nama Lengkap'); ?></label>
                            <input type="text" name="contact_name" required class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-300 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" placeholder="<?php pll_e('Nama Anda'); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2"><?php pll_e('Email Address'); ?></label>
                            <input type="email" name="contact_email" required class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-300 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" placeholder="<?php pll_e('email@contoh.com'); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2"><?php pll_e('Pesan'); ?></label>
                            <textarea name="contact_message" rows="4" required class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-300 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" placeholder="<?php pll_e('Tulis pesan Anda disini...'); ?>"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-4 rounded-lg transition duration-300 shadow-lg">
                            <?php pll_e('Kirim'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>