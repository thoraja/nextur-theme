<?php
/**
 * Polylang String Registration
 */

function nextur_register_strings() {
    if (function_exists('pll_register_string')) {
        
        // --- GROUP 1: GLOBAL COMPANY INFO (Editable Contact Details) ---
        // Use group 'Company Info' to find these quickly
        pll_register_string('Nextur Info', 'Jl. Sudirman Kav 12, Jakarta Selatan, 12190', 'Company Info', true); // Multiline address
        pll_register_string('Nextur Info', '+62 812 3456 7890', 'Company Info'); // Phone Display
        pll_register_string('Nextur Info', 'info@nextur.com', 'Company Info'); // Email
        pll_register_string('Nextur Info', 'https://wa.me/6281234567890', 'Company Info'); // WhatsApp Link URL

        // --- GROUP 2: NAVIGATION & MENUS ---
        pll_register_string('Nextur Nav', 'Beranda', 'Navigation');
        pll_register_string('Nextur Nav', 'Tentang Kami', 'Navigation');
        pll_register_string('Nextur Nav', 'Layanan', 'Navigation');
        pll_register_string('Nextur Nav', 'Artikel', 'Navigation'); 
        pll_register_string('Nextur Nav', 'Hubungi Kami', 'Navigation');

        // --- GROUP 3: HOMEPAGE MARKETING ---
        pll_register_string('Nextur Home', 'Jelajahi Pesona Indonesia', 'Homepage'); 
        pll_register_string('Nextur Home', 'Temukan paket perjalanan terbaik sesuai impian Anda.', 'Homepage'); 
        pll_register_string('Nextur Home', 'Jelajahi Sekarang', 'Homepage'); 
        pll_register_string('Nextur Home', 'Destinasi Pilihan', 'Homepage'); 
        pll_register_string('Nextur Home', 'Eksplorasi berdasarkan negara atau wilayah.', 'Homepage');
        pll_register_string('Nextur Home', 'Lihat Semua', 'Homepage'); 
        pll_register_string('Nextur Home', 'Jelajahi Indonesia', 'Homepage'); 
        pll_register_string('Nextur Home', 'Surga tropis di negeri sendiri.', 'Homepage'); 
        pll_register_string('Nextur Home', 'Gaya Liburan', 'Homepage');
        pll_register_string('Nextur Home', 'Temukan pengalaman sesuai minat Anda.', 'Homepage');
        // Lifestyle Section
        pll_register_string('Nextur Home', 'Kami mengintegrasikan estetika destinasi, nilai budaya, dan teknologi yang menciptakan pengalaman yang autentik dan berkelanjutan.', 'Homepage', true);
        pll_register_string('Nextur Home', 'Lifestyle Creator', 'Homepage');
        pll_register_string('Nextur Home', 'Fokus pada penyusunan liburan yang berkesan dan berdampak.', 'Homepage'); 
        pll_register_string('Nextur Home', 'Personalized', 'Homepage');
        pll_register_string('Nextur Home', 'Perjalanan dimaksimalkan sepenuhnya sesuai minat Anda.', 'Homepage'); 
        pll_register_string('Nextur Home', 'One-Stop Solution', 'Homepage');
        pll_register_string('Nextur Home', 'Mulai dari liburan impian hingga insentif perusahaan.', 'Homepage'); 

        // --- GROUP 4: TRIP CARDS & DETAILS ---
        pll_register_string('Nextur Card', 'Mulai dari', 'Trip Card'); 
        pll_register_string('Nextur Card', 'Lihat Detail', 'Trip Card');
        pll_register_string('Nextur Card', 'Paket', 'Trip Card'); // The badge count label
        pll_register_string('Nextur Trip', 'Trip Highlights', 'Trip Detail');
        pll_register_string('Nextur Trip', 'Itinerary', 'Trip Detail');
        pll_register_string('Nextur Trip', 'Fasilitas', 'Trip Detail'); 
        pll_register_string('Nextur Trip', 'Info Penting', 'Trip Detail');
        pll_register_string('Nextur Trip', 'S&K', 'Trip Detail'); 
        pll_register_string('Nextur Trip', 'Galeri', 'Trip Detail');
        pll_register_string('Nextur Trip', 'Unduh PDF', 'Trip Detail'); 
        pll_register_string('Nextur Trip', 'Pesan via WhatsApp', 'Trip Detail');
        pll_register_string('Nextur Trip', 'Belum ada foto galeri untuk trip ini.', 'Trip Detail');

        // --- GROUP 5: BLOG SECTION ---
        pll_register_string('Nextur Home', 'Artikel & Inspirasi', 'Homepage'); 
        pll_register_string('Nextur Blog', 'Inspirasi, tips, dan cerita perjalanan terbaru.', 'Blog'); 
        pll_register_string('Nextur Blog', 'Lihat Semua Artikel', 'Blog'); 
        pll_register_string('Nextur Home', 'Baca Selengkapnya', 'Homepage'); 

        // --- GROUP 6: FOOTER ---
        pll_register_string('Nextur Footer', 'Alamat Kantor', 'Footer');
        pll_register_string('Nextur Footer', 'Ikuti Kami', 'Footer');
        pll_register_string('Nextur Footer', 'Hak Cipta Dilindungi', 'Footer');
        pll_register_string('Nextur Footer', 'Partner perjalanan terbaik Anda. Kami berkomitmen memberikan pengalaman wisata yang tak terlupakan dengan standar keamanan dan kenyamanan tertinggi.', 'Footer', true);
        pll_register_string('Nextur Footer', 'Perusahaan', 'Footer');
        pll_register_string('Nextur Footer', 'Newsletter', 'Footer');
        pll_register_string('Nextur Footer', 'Dapatkan info promo trip terbaru.', 'Footer');
        pll_register_string('Nextur Footer', 'Email Anda', 'Footer'); 
        pll_register_string('Nextur Footer', 'Langganan', 'Footer'); 
        pll_register_string('Nextur Footer', 'Privacy Policy', 'Footer');
        pll_register_string('Nextur Footer', 'Terms of Service', 'Footer');

        // --- GROUP 7: PAGE - ABOUT ---
        // Filter by 'Page: About'
        pll_register_string('Nextur About', 'Tentang Nextur', 'Page: About');
        pll_register_string('Nextur About', 'Visi & Filosofi', 'Page: About');
        pll_register_string('Nextur About', 'Bagi kami, masa depan bukan sekadar tujuan, tetapi jembatan antara keindahan destinasi dan kebutuhan pelanggan.', 'Page: About', true); // Quote
        pll_register_string('Nextur About', 'Suatu perjalanan bukan lagi sekadar perpindahan, tetapi transformasi yang memperkaya perspektif. Kami berkomitmen untuk menghadirkan pengalaman yang tidak hanya membawa Anda ke tempat baru, tetapi juga memberikan nilai baru dalam hidup Anda.', 'Page: About', true); 
        // About Values
        pll_register_string('Nextur About', 'Innovation with Purpose', 'Page: About');
        pll_register_string('Nextur About', 'Solusi desain untuk nilai nyata dan kebutuhan pasar.', 'Page: About', true);
        pll_register_string('Nextur About', 'Partnership for Growth', 'Page: About');
        pll_register_string('Nextur About', 'Kolaborasi sebagai perjalanan bersama. Pertumbuhan klien adalah keberhasilan kami.', 'Page: About', true);
        pll_register_string('Nextur About', 'Sustainable Impact', 'Page: About');
        pll_register_string('Nextur About', 'Memprioritaskan keberlanjutan untuk manfaat masa depan.', 'Page: About', true);
        pll_register_string('Nextur About', 'Tim Kami', 'Page: About');
        pll_register_string('Nextur About', 'Orang-orang di balik perjalanan seru Anda.', 'Page: About');

        // --- GROUP 8: PAGE - SERVICES (Merged & Cleaned) ---
        // Filter by 'Page: Services'
        pll_register_string('Nextur Services', 'Layanan Kami', 'Page: Services');
        pll_register_string('Nextur Services', 'Solusi perjalanan komprehensif untuk kebutuhan Anda.', 'Page: Services');
        // Service Card 1
        pll_register_string('Nextur Services', 'Tailored Travel Experiences', 'Page: Services');
        pll_register_string('Nextur Services', 'Perencanaan perjalanan personal untuk individu, kelompok, maupun korporasi.', 'Page: Services', true);
        // Service Card 2
        pll_register_string('Nextur Services', 'Destination Management', 'Page: Services');
        pll_register_string('Nextur Services', 'Pengelolaan destinasi autentik dengan kolaborasi komunitas lokal.', 'Page: Services', true);
        // Service Card 3
        pll_register_string('Nextur Services', 'Smart Travel Technology', 'Page: Services');
        pll_register_string('Nextur Services', 'Solusi teknologi untuk efisiensi, keamanan, dan kenyamanan.', 'Page: Services', true);
        // Service Card 4
        pll_register_string('Nextur Services', 'Premium Hospitality', 'Page: Services');
        pll_register_string('Nextur Services', 'Perancangan pengalaman premium dari retret mewah hingga eksplorasi budaya.', 'Page: Services', true);
        // Service Card 5
        pll_register_string('Nextur Services', 'Sustainable Tourism', 'Page: Services');
        pll_register_string('Nextur Services', 'Pengembangan pariwisata berkelanjutan untuk ketahanan jangka panjang.', 'Page: Services', true);

        // --- GROUP 9: PAGE - CONTACT ---
        // Filter by 'Page: Contact'
        pll_register_string('Nextur Contact', 'Hubungi Kami', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Kami siap membantu merencanakan liburan impian Anda.', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Informasi Kontak', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Kantor Pusat', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Telepon & WhatsApp', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Email', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Kirim Pesan', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Nama Lengkap', 'Page: Contact'); 
        pll_register_string('Nextur Contact', 'Nama Anda', 'Page: Contact'); // Placeholder
        pll_register_string('Nextur Contact', 'Email Address', 'Page: Contact');
        pll_register_string('Nextur Contact', 'email@contoh.com', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Pesan', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Tulis pesan Anda disini...', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Kirim', 'Page: Contact');
        pll_register_string('Nextur Contact', 'Google Maps Area', 'Page: Contact');

        // --- GROUP 10: SYSTEM PAGES (Thank You, Accommodation, Errors) ---
        // Filter by 'Page: System'
        pll_register_string('Nextur System', 'Terima Kasih!', 'Page: System');
        pll_register_string('Nextur System', 'Booking Anda telah kami terima. Tim kami akan segera menghubungi Anda melalui WhatsApp/Email untuk konfirmasi pembayaran.', 'Page: System', true);
        pll_register_string('Nextur System', 'Kembali ke Beranda', 'Page: System');
        pll_register_string('Nextur System', 'Accommodation', 'Page: System');
        pll_register_string('Nextur System', 'We are currently curating the best stay partners for you.', 'Page: System');
        pll_register_string('Nextur System', 'Coming Soon.', 'Page: System');
        pll_register_string('Nextur System', 'Back to Home', 'Page: System');
        // Empty States
        pll_register_string('Nextur System', 'Belum ada trip.', 'Page: System');
        pll_register_string('Nextur System', 'Belum ada kategori destinasi.', 'Page: System');
        pll_register_string('Nextur System', 'Upload Trip baru untuk memunculkan destinasi.', 'Page: System');
        pll_register_string('Nextur System', 'Belum ada destinasi highlight.', 'Page: System');
        pll_register_string('Nextur System', 'Belum ada artikel terbaru.', 'Page: System');
        pll_register_string('Nextur System', 'Belum ada kategori aktivitas.', 'Page: System');

        // --- GROUP 11: BOOKING FORM ---
        pll_register_string('Nextur Booking', 'Nama Lengkap', 'Booking Form');
        pll_register_string('Nextur Booking', 'Email', 'Booking Form');
        pll_register_string('Nextur Booking', 'WhatsApp', 'Booking Form');
        pll_register_string('Nextur Booking', '0812...', 'Booking Form');
        pll_register_string('Nextur Booking', 'Jumlah Peserta', 'Booking Form');
        pll_register_string('Nextur Booking', 'Tanggal Keberangkatan', 'Booking Form');
        pll_register_string('Nextur Booking', 'DD/MM/YYYY', 'Booking Form');
        pll_register_string('Nextur Booking', 'Catatan (Opsional)', 'Booking Form');
        pll_register_string('Nextur Booking', 'Kirim Pesan Booking', 'Booking Form');
    }
}
add_action('init', 'nextur_register_strings');
