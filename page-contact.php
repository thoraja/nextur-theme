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

                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-white/10 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold font-heading"><?php pll_e('Telepon & WhatsApp'); ?></h3>
                                    <p class="text-slate-300 text-sm mt-1"><?php echo esc_html(nextur_get_company_info('phone')); ?></p>
                                </div>
                            </div>

                            <?php 
                            // Prepare WhatsApp Link
                            $phone_clean = preg_replace('/\D/', '', nextur_get_company_info('phone'));
                            ?>
                            <a href="<?php echo esc_url('https://wa.me/' . $phone_clean); ?>" target="_blank" class="flex-shrink-0 bg-green-500 hover:bg-green-600 text-white p-3 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition ml-3" aria-label="Contact via WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </a>
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