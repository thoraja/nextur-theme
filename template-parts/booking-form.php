<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="space-y-4">
    <input type="hidden" name="action" value="submit_booking">
    <input type="hidden" name="trip_name" value="<?php the_title(); ?>">

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap</label>
        <input type="text" name="fullname" required 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1">Email</label>
        <input type="email" name="email" required 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">WhatsApp</label>
            <input type="tel" name="whatsapp" required placeholder="0812..." 
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">Jumlah Peserta</label>
            <input type="number" name="pax" min="1" value="1" required 
                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1">Tanggal Keberangkatan</label>
        <input type="date" name="date" required 
               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1">Catatan (Opsional)</label>
        <textarea name="notes" rows="3" 
                  class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand"></textarea>
    </div>

    <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-3 rounded-lg transition shadow-lg">
        Kirim Pesan Booking
    </button>
</form>