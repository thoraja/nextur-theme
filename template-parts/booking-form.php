<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="space-y-4">
    <input type="hidden" name="action" value="submit_booking">
    <input type="hidden" name="trip_name" value="<?php the_title(); ?>">

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1"><?php pll_e('Nama Lengkap'); ?></label>
        <input type="text" name="fullname" required 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1"><?php pll_e('Email'); ?></label>
        <input type="email" name="email" required 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1"><?php pll_e('WhatsApp'); ?></label>
            <input type="tel" name="whatsapp" required placeholder="<?php echo esc_attr(pll__('0812...')); ?>" 
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1"><?php pll_e('Jumlah Peserta'); ?></label>
            <input type="number" name="pax" min="1" value="1" required 
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1"><?php pll_e('Tanggal Keberangkatan'); ?></label>
        
        <div class="relative w-full">
            <input type="text" name="date" required 
                   placeholder="<?php echo esc_attr(pll__('DD/MM/YYYY')); ?>"
                   x-data
                   x-init="$nextTick(() => { 
                        flatpickr($el, { 
                            dateFormat: 'd/m/Y', 
                            minDate: 'today',
                            disableMobile: true,
                            static: true 
                        });
                   })"
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand cursor-pointer block">
            
            <div class="absolute right-3 top-2.5 pointer-events-none text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1"><?php pll_e('Catatan (Opsional)'); ?></label>
        <textarea name="notes" rows="1" 
                  class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand"></textarea>
    </div>

    <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-3 rounded-lg transition shadow-lg">
        <?php pll_e('Kirim Pesan Booking'); ?>
    </button>
</form>