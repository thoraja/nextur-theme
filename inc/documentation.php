<?php
/**
 * Theme Documentation Page
 * 
 * Adds a "Theme Docs" menu item to the admin dashboard.
 * Contains guides for:
 * 1. Trip Importer (with AI Prompt)
 * 2. Trips & Destinations
 * 3. Activities
 * 4. Indo Highlights (Gallery)
 * 5. Articles (Journal)
 * 
 * Features a Bilingual Toggle (ID/EN) for accessibility.
 */

// 1. Register Menu
function nextur_register_docs_page() {
    add_menu_page(
        'Theme Documentation',  // Page Title
        'Theme Docs',           // Menu Title
        'edit_posts',           // Capability (Editors can see)
        'nextur-docs',          // Menu Slug
        'nextur_render_docs_page', // Callback
        'dashicons-book',       // Icon
        3                       // Position (Below Dashboard)
    );
}
add_action('admin_menu', 'nextur_register_docs_page');

// 2. Render Page
function nextur_render_docs_page() {
    // Get Importer Page URL dynamically
    $importer_page = get_pages([
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-importer.php',
        'number' => 1
    ]);
    $importer_url = $importer_page ? get_permalink($importer_page[0]->ID) : '#';
    ?>
    <style>
        .nextur-docs-wrap { max-width: 1000px; margin: 20px auto; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; color: #1d2327; }
        .nextur-header { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .nextur-title h1 { margin: 0 0 10px 0; font-size: 24px; font-weight: 700; color: #2271b1; }
        .nextur-title p { margin: 0; color: #646970; font-size: 14px; }
        
        /* Language Toggle */
        .lang-toggle { display: flex; background: #f0f0f1; border-radius: 20px; padding: 4px; border: 1px solid #c3c4c7; }
        .lang-btn { text-decoration: none; border: none; background: transparent; padding: 6px 16px; font-size: 13px; font-weight: 600; color: #50575e; cursor: pointer; border-radius: 16px; transition: all 0.2s; }
        .lang-btn.active { background: #2271b1; color: white; shadow: 0 1px 2px rgba(0,0,0,0.2); }
        .lang-btn:hover:not(.active) { background: #fff; }

        /* Content Grid */
        .docs-grid { display: grid; grid-template-columns: 250px 1fr; gap: 20px; }
        .docs-nav { position: sticky; top: 20px; align-self: start; }
        .docs-nav ul { background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin: 0; }
        .docs-nav li { margin: 0; border-bottom: 1px solid #f0f0f1; }
        .docs-nav li:last-child { border-bottom: none; }
        .docs-nav a { display: block; padding: 12px 20px; text-decoration: none; color: #1d2327; font-weight: 500; font-size: 14px; border-left: 3px solid transparent; transition: all 0.2s; }
        .docs-nav a:hover, .docs-nav a.current { background: #f6f7f7; color: #2271b1; border-left-color: #2271b1; }
        .docs-nav a .dashicon { margin-right: 8px; color: #a7aaad; }

        /* Sections */
        .docs-content { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .docs-section { display: none; margin-bottom: 40px; } /* Updated: display none by default, JS toggles */
        .docs-section.active { display: block; animation: fadeIn 0.3s ease-out; }
        
        .docs-section h2 { font-size: 22px; border-bottom: 2px solid #f0f0f1; padding-bottom: 10px; margin-bottom: 20px; color: #1d2327; }
        .docs-section h3 { font-size: 16px; font-weight: 700; margin: 25px 0 10px 0; color: #2c3338; }
        .docs-section p { font-size: 15px; line-height: 1.6; color: #3c434a; margin-bottom: 15px; }
        
        /* Feature Box */
        .feature-box { background: #f6f7f7; border-left: 4px solid #72aee6; padding: 20px; border-radius: 0 4px 4px 0; margin: 20px 0; }
        .feature-box.location { border-left-color: #00a32a; background: #edfaef; } /* Green for location */
        .feature-title { font-weight: 700; display: block; margin-bottom: 5px; color: #1d2327; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }

        /* Code Block */
        .prompt-container { position: relative; margin: 20px 0; }
        .prompt-block { background: #1e1e1e; color: #d4d4d4; padding: 20px; border-radius: 6px; font-family: 'Consolas', 'Monaco', monospace; font-size: 13px; line-height: 1.5; white-space: pre-wrap; overflow-x: auto; max-height: 400px; overflow-y: auto; border: 1px solid #333; }
        .copy-btn { position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 4px 10px; font-size: 12px; border-radius: 4px; cursor: pointer; transition: all 0.2s; }
        .copy-btn:hover { background: rgba(255,255,255,0.2); }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="nextur-docs-wrap">
        <div class="nextur-header">
            <div class="nextur-title">
                <h1>Nextur Theme Guide</h1>
                <p>Panduan Penggunaan Tema & Fitur</p>
            </div>
            <div class="lang-toggle">
                <button class="lang-btn active" onclick="switchLang('id')">INDONESIA</button>
                <button class="lang-btn" onclick="switchLang('en')">ENGLISH</button>
            </div>
        </div>

        <div class="docs-grid">
            <nav class="docs-nav">
                <ul>
                    <li><a href="#intro" class="nav-link current" onclick="showSection('intro')"><span class="dashicons dashicons-welcome-learn-more"></span> <span class="txt-id">Pengantar</span><span class="txt-en" style="display:none">Introduction</span></a></li>
                    <li><a href="#company" class="nav-link" onclick="showSection('company')"><span class="dashicons dashicons-building"></span> <span class="txt-id">Info Perusahaan</span><span class="txt-en" style="display:none">Company Info</span></a></li>
                    <li><a href="#importer" class="nav-link" onclick="showSection('importer')"><span class="dashicons dashicons-database-import"></span> <span class="txt-id">Import Tool (AI)</span><span class="txt-en" style="display:none">Import Tool (AI)</span></a></li>
                    <li><a href="#trips" class="nav-link" onclick="showSection('trips')"><span class="dashicons dashicons-airplane"></span> <span class="txt-id">Paket Trip</span><span class="txt-en" style="display:none">Trip Packages</span></a></li>
                    <li><a href="#activities" class="nav-link" onclick="showSection('activities')"><span class="dashicons dashicons-palmtree"></span> <span class="txt-id">Gaya Liburan</span><span class="txt-en" style="display:none">Vacation Styles</span></a></li>
                    <li><a href="#highlights" class="nav-link" onclick="showSection('highlights')"><span class="dashicons dashicons-images-alt2"></span> <span class="txt-id">Indo Highlights</span><span class="txt-en" style="display:none">Indo Highlights</span></a></li>
                    <li><a href="#journal" class="nav-link" onclick="showSection('journal')"><span class="dashicons dashicons-welcome-write-blog"></span> <span class="txt-id">Artikel / Jurnal</span><span class="txt-en" style="display:none">Articles / Journal</span></a></li>
                </ul>
            </nav>

            <main class="docs-content">
                
                <!-- SECTION: INTRODUCTION -->
                <div id="sec-intro" class="docs-section active">
                    <!-- ID -->
                    <div class="lang-content-id">
                        <h2>Selamat Datang di Nextur</h2>
                        <p>Tema ini dirancang khusus untuk Travel Agent modern. Dokumen ini akan memandu Anda (Administrator) dalam mengelola konten website dengan mudah, tanpa perlu pengetahuan coding.</p>
                        
                        <div class="feature-box">
                            <span class="feature-title">Akses Cepat</span>
                            <p>Gunakan menu di sebelah kiri untuk melompat ke panduan yang Anda butuhkan.</p>
                        </div>
                    </div>
                    <!-- EN -->
                    <div class="lang-content-en" style="display:none">
                        <h2>Welcome to Nextur</h2>
                        <p>This theme is designed specifically for modern Travel Agents. This document will guide you (the Administrator) in managing website content easily, without any coding knowledge.</p>
                        
                        <div class="feature-box">
                            <span class="feature-title">Quick Access</span>
                            <p>Use the menu on the left to jump to the guide you need.</p>
                        </div>
                    </div>
                </div>

                <!-- SECTION: COMPANY INFO -->
                <div id="sec-company" class="docs-section">
                    <!-- ID -->
                    <div class="lang-content-id">
                        <h2>Info Perusahaan (Kontak & Sosmed)</h2>
                        <p>Atur alamat, nomor telepon, email, dan link sosial media Anda dari satu tempat.</p>
                        
                        <div class="feature-box location">
                            <span class="feature-title">TAMPIL DI:</span>
                            <ul>
                                <li><strong>Footer:</strong> Alamat, kontak, dan ikon sosmed.</li>
                                <li><strong>Halaman Kontak:</strong> Detail informasi kantor.</li>
                                <li><strong>Formulir Booking:</strong> Email notifikasi akan dikirim ke alamat yang diatur di sini.</li>
                            </ul>
                        </div>

                        <h3>Cara Mengubah Data</h3>
                        <ol>
                            <li>Klik menu <strong>Company Info</strong> di sidebar admin (di bawah Dashboard).</li>
                            <li>Isi kolom yang tersedia:
                                <ul>
                                    <li><strong>Contact Details:</strong> Alamat, Telepon (tampilan), Email, Secondary Email (CC), WhatsApp Link.</li>
                                    <li><strong>Social Media:</strong> Masukkan URL lengkap (https://...) profil sosial media Anda.</li>
                                </ul>
                            </li>
                            <li>Klik <strong>Save Company Information</strong>.</li>
                        </ol>
                        <p><em>Perubahan akan otomatis muncul di seluruh website tanpa perlu edit tema.</em></p>
                    </div>
                    <!-- EN -->
                    <div class="lang-content-en" style="display:none">
                        <h2>Company Info (Contact & Socials)</h2>
                        <p>Manage your address, phone, email, and social media links from one central place.</p>
                        
                        <div class="feature-box location">
                            <span class="feature-title">SHOWN AT:</span>
                            <ul>
                                <li><strong>Footer:</strong> Address, contact info, and social icons.</li>
                                <li><strong>Contact Page:</strong> Office details.</li>
                                <li><strong>Booking Forms:</strong> Notification emails will use the email set here.</li>
                            </ul>
                        </div>

                        <h3>How to Update</h3>
                        <ol>
                            <li>Click <strong>Company Info</strong> menu in the admin sidebar (below Dashboard).</li>
                            <li>Fill in the fields:
                                <ul>
                                    <li><strong>Contact Details:</strong> Address, Phone (display), Email, Secondary Email (CC), WhatsApp Link.</li>
                                    <li><strong>Social Media:</strong> Enter full URLs (https://...) for your profiles.</li>
                                </ul>
                            </li>
                            <li>Click <strong>Save Company Information</strong>.</li>
                        </ol>
                        <p><em>Changes will automatically appear across the website without editing the theme.</em></p>
                    </div>
                </div>

                <!-- SECTION: IMPORTER TOOL -->
                <div id="sec-importer" class="docs-section">
                    <!-- ID -->
                    <div class="lang-content-id">
                        <h2>Interactive Trip Importer</h2>
                        <p>Fitur paling canggih di tema ini. Anda bisa membuat banyak Trip sekaligus hanya dengan copy-paste dokumen dari Microsoft Word/PDF.</p>
                        
                        <h3>Bagaimana Cara Kerjanya?</h3>
                        <ol>
                            <li>Siapkan dokumen Itinerary Anda (PDF/Doc).</li>
                            <li>Buka <strong>ChatGPT</strong> atau <strong>Gemini</strong> (AI).</li>
                            <li>Copy <strong>System Instruction</strong> di bawah ini, dan paste ke AI.</li>
                            <li>Upload/Paste dokumen itinerary Anda ke AI.</li>
                            <li>AI akan memberikan kode <strong>JSON</strong>. Copy kode tersebut.</li>
                            <li>Buka halaman <a href="<?php echo esc_url($importer_url); ?>" target="_blank" style="font-weight:bold; color:#2271b1;">Import Tool Di Sini &rarr;</a></li>
                            <li>Paste JSON ke kotak yang tersedia, lalu klik "Run Importer".</li>
                        </ol>

                        <div class="feature-box location">
                            <span class="feature-title">LOKASI DI WEBSITE</span>
                            <p>Ini adalah alat backend (Admin). Hasil import akan muncul sebagai <strong>Trip Baru</strong> di menu Trips.</p>
                        </div>

                        <h3>System Instruction (Copy Ini ke AI)</h3>
                        <div class="prompt-container">
                            <button class="copy-btn" onclick="copyPrompt()">Copy Prompt</button>
                            <pre id="ai-prompt" class="prompt-block">SYSTEM INSTRUCTION: NEXTUR BATCH DATA ENGINE (WITH ACTIVITIES)

Role:
You are the "Nextur Extraction Engine." Your task is to process travel documents into a strict JSON format for the Nextur Importer.

Input:
I will paste one or more travel documents (Indonesian text).

Output Rules:
1. NO CITATIONS: Do not include [cite] or source markers. Output clean JSON only.
2. NO TRUNCATION: Extract ALL terms, conditions, and itinerary details verbatim.
3. HTML LISTS: Format all lists (includes, excludes, terms) as &lt;ul&gt;&lt;li&gt;Item&lt;/li&gt;&lt;/ul&gt;.

---

DATA STRUCTURE (common, id, en)
Your output must be a single JSON array [...].

1. GLOBAL DATA (common)
- destination: Array of strings (e.g., ["Thailand", "Bangkok"]).
- activities: Array of strings. INFER 3-5 Activities based on the itinerary. (e.g., ["Shopping", "City Tour", "Culinary", "Adventure", "Nature"]).
- meta: Shared numeric/code data.
  - _trip_price: Raw number (e.g. 10500000).
  - _trip_deposit: Raw number.
  - _trip_infant_price: Raw number.
  - _trip_min_pax: Number (default "1").
  - _trip_tag_year: e.g. "2025".
  - _trip_airline: Airline Name.
  - _trip_route: Flight Code.
  - _trip_is_featured: "0".

2. INDONESIAN DATA (id)
- title: Original Title.
- itinerary: Array of objects (day, title, flight_info, meals, desc).
- meta:
  - _trip_subtitle, _trip_highlights, _trip_visa_note.
  - HTML LISTS (Verbatim): _trip_includes, _trip_excludes, _trip_optional, _trip_terms, _trip_payment_terms.

3. ENGLISH DATA (en)
- title: Translated Title.
- itinerary: Translated Itinerary objects.
- meta: Translated meta text and HTML lists.

---

JSON SCHEMA TEMPLATE

```json
[
  {
    "common": {
      "destination": ["INSERT_COUNTRY", "INSERT_CITY"],
      "activities": ["INSERT_ACTIVITY_1", "INSERT_ACTIVITY_2", "INSERT_ACTIVITY_3"],
      "meta": {
        "_trip_tag_year": "INSERT_YEAR",
        "_trip_airline": "INSERT_AIRLINE",
        "_trip_route": "INSERT_ROUTE",
        "_trip_price": "INSERT_RAW_PRICE",
        "_trip_min_pax": "INSERT_MIN_PAX",
        "_trip_deposit": "INSERT_RAW_DEPOSIT",
        "_trip_infant_price": "INSERT_RAW_INFANT_PRICE",
        "_trip_is_featured": "0"
      }
    },
    "id": {
      "title": "INSERT_INDONESIAN_TITLE",
      "itinerary": [
        {
          "day": "Hari 1",
          "title": "INSERT_TITLE",
          "flight_info": "INSERT_FLIGHT",
          "meals": "INSERT_MEALS",
          "desc": "INSERT_FULL_DESCRIPTION"
        }
      ],
      "meta": {
        "_trip_subtitle": "INSERT_SUBTITLE",
        "_trip_highlights": "INSERT_HIGHLIGHTS",
        "_trip_visa_note": "INSERT_VISA_NOTE",
        "_trip_payment_terms": "&lt;ul&gt;&lt;li&gt;INSERT_PAYMENT_TERMS&lt;/li&gt;&lt;/ul&gt;",
        "_trip_includes": "&lt;ul&gt;&lt;li&gt;INSERT_INCLUDES&lt;/li&gt;&lt;/ul&gt;",
        "_trip_excludes": "&lt;ul&gt;&lt;li&gt;INSERT_EXCLUDES&lt;/li&gt;&lt;/ul&gt;",
        "_trip_optional": "&lt;ul&gt;&lt;li&gt;INSERT_OPTIONAL&lt;/li&gt;&lt;/ul&gt;",
        "_trip_terms": "&lt;ul&gt;&lt;li&gt;INSERT_TERMS_AND_CONDITIONS&lt;/li&gt;&lt;/ul&gt;"
      }
    },
    "en": {
      "title": "INSERT_TRANSLATED_TITLE",
      "itinerary": [
        {
          "day": "Day 1",
          "title": "INSERT_TRANSLATED_TITLE",
          "flight_info": "INSERT_FLIGHT",
          "meals": "INSERT_TRANSLATED_MEALS",
          "desc": "INSERT_TRANSLATED_DESCRIPTION"
        }
      ],
      "meta": {
        "_trip_subtitle": "INSERT_TRANSLATED_SUBTITLE",
        "_trip_highlights": "INSERT_TRANSLATED_HIGHLIGHTS",
        "_trip_visa_note": "INSERT_TRANSLATED_VISA_NOTE",
        "_trip_payment_terms": "&lt;ul&gt;&lt;li&gt;INSERT_TRANSLATED_PAYMENT_TERMS&lt;/li&gt;&lt;/ul&gt;",
        "_trip_includes": "&lt;ul&gt;&lt;li&gt;INSERT_TRANSLATED_INCLUDES&lt;/li&gt;&lt;/ul&gt;",
        "_trip_excludes": "&lt;ul&gt;&lt;li&gt;INSERT_TRANSLATED_EXCLUDES&lt;/li&gt;&lt;/ul&gt;",
        "_trip_optional": "&lt;ul&gt;&lt;li&gt;INSERT_TRANSLATED_OPTIONAL&lt;/li&gt;&lt;/ul&gt;",
        "_trip_terms": "&lt;ul&gt;&lt;li&gt;INSERT_TRANSLATED_TERMS&lt;/li&gt;&lt;/ul&gt;"
      }
    }
  }
]
CONFIRMATION:
Reply only with:"Nextur Extraction Engine (with Activities) Ready. Please upload your trip document."
```</pre>
                        </div>
                    </div>

                    <!-- EN -->
                    <div class="lang-content-en" style="display:none">
                        <h2>Interactive Trip Importer</h2>
                        <p>The most advanced feature of this theme. Create multiple Trips at once by simply copy-pasting documents from Microsoft Word/PDF.</p>
                        
                        <h3>How it Works</h3>
                        <ol>
                            <li>Prepare your Itinerary document (PDF/Doc).</li>
                            <li>Open <strong>ChatGPT</strong> or <strong>Gemini</strong> (AI).</li>
                            <li>Copy the <strong>System Instruction</strong> below, and paste it into the AI.</li>
                            <li>Upload/Paste your itinerary document to the AI.</li>
                            <li>The AI will generate <strong>JSON</strong> code. Copy that code.</li>
                            <li>Open the <a href="<?php echo esc_url($importer_url); ?>" target="_blank" style="font-weight:bold; color:#2271b1;">Import Tool Here &rarr;</a></li>
                            <li>Paste the JSON into the box and click "Run Importer".</li>
                        </ol>

                        <div class="feature-box location">
                            <span class="feature-title">WEBSITE LOCATION</span>
                            <p>This is a backend tool. The result will appear as <strong>New Trips</strong> in the Trips menu.</p>
                        </div>
                        
                        <h3>System Instruction (Copy this to AI)</h3>
                        <p><em>(See the code block above - content is the same for both languages)</em></p>
                    </div>
                </div>

                <!-- SECTION: TRIPS -->
                <div id="sec-trips" class="docs-section">
                    <div class="lang-content-id">
                        <h2>Paket Trip & Destinasi</h2>
                        <p>Segala produk wisata Anda diatur di sini.</p>

                        <div class="feature-box location">
                            <span class="feature-title">TAMPIL DI:</span>
                            <ul>
                                <li><strong>Hero Section (Homepage):</strong> Trip dengan status "Featured".</li>
                                <li><strong>Destinations List (Homepage):</strong> Trip dikelompokkan berdasarkan Destinasi.</li>
                                <li><strong>Halaman Arsip Trip:</strong> Semua trip yang tersedia.</li>
                            </ul>
                        </div>

                        <h3>Cara Menambah Trip</h3>
                        <ol>
                            <li>Masuk ke <a href="<?php echo admin_url('post-new.php?post_type=trip'); ?>">Trips > Add New</a>.</li>
                            <li>Isi Judul, Harga, dan Detail Itinerary.</li>
                            <li>Centang <strong>Destination</strong> di kolom kanan (Contoh: Japan, Korea, Europe).</li>
                            <li>Set <strong>Featured Image</strong> untuk gambar utama.</li>
                        </ol>

                        <h3>Mengatur Destinasi</h3>
                        <p>Destinasi (Negara/Kota) muncul sebagai filter di halaman depan. Untuk menambah destinasi baru, buat saja Trip baru dan ketik nama Destinasi baru di kolom Destination.</p>
                    </div>
                    <div class="lang-content-en" style="display:none">
                        <h2>Trips & Destinations</h2>
                        <p>All your travel products are managed here.</p>

                        <div class="feature-box location">
                            <span class="feature-title">SHOWN AT:</span>
                            <ul>
                                <li><strong>Hero Section (Homepage):</strong> Trips marked as "Featured".</li>
                                <li><strong>Destinations List (Homepage):</strong> Trips grouped by Destination.</li>
                                <li><strong>Trip Archive Page:</strong> All available trips.</li>
                            </ul>
                        </div>

                        <h3>How to Add a Trip</h3>
                        <ol>
                            <li>Go to <a href="<?php echo admin_url('post-new.php?post_type=trip'); ?>">Trips > Add New</a>.</li>
                            <li>Fill in Title, Price, and Itinerary Details.</li>
                            <li>Check <strong>Destination</strong> in the right column (e.g., Japan, Europe).</li>
                            <li>Set <strong>Featured Image</strong> for the main cover.</li>
                        </ol>
                    </div>
                </div>

                <!-- SECTION: ACTIVITIES -->
                <div id="sec-activities" class="docs-section">
                    <div class="lang-content-id">
                        <h2>Gaya Liburan (Activities)</h2>
                        <p>Kategori berdasarkan jenis aktivitas, seperti "Shopping", "Adventure", "Nature".</p>

                        <div class="feature-box location">
                            <span class="feature-title">TAMPIL DI:</span>
                            <p>Slider <strong>"Gaya Liburan"</strong> di Homepage.</p>
                        </div>

                        <h3>Cara Mengatur</h3>
                        <ol>
                            <li>Masuk ke <a href="<?php echo admin_url('edit-tags.php?taxonomy=activity&post_type=trip'); ?>">Trips > Activities</a>.</li>
                            <li>Tambah aktivitas baru (Nama & Gambar).</li>
                            <li>Saat membuat Trip, centang kategori Activity yang sesuai.</li>
                        </ol>
                    </div>
                    <div class="lang-content-en" style="display:none">
                        <h2>Vacation Styles (Activities)</h2>
                        <p>Categories based on activity type, e.g., "Shopping", "Adventure".</p>

                        <div class="feature-box location">
                            <span class="feature-title">SHOWN AT:</span>
                            <p>The <strong>"Gaya Liburan"</strong> slider on Homepage.</p>
                        </div>
                    </div>
                </div>

                <!-- SECTION: HIGHLIGHTS -->
                <div id="sec-highlights" class="docs-section">
                    <div class="lang-content-id">
                        <h2>Indo Highlights (Jelajahi Indonesia)</h2>
                        <p>Fitur khusus untuk menampilkan destinasi lokal terbaik dalam bentuk galeri slider.</p>

                        <div class="feature-box location">
                            <span class="feature-title">TAMPIL DI:</span>
                            <p>Bagian <strong>"Jelajahi Indonesia"</strong> di Homepage (Slider kedua).</p>
                        </div>

                        <h3>Cara Menambah</h3>
                        <ol>
                            <li>Masuk ke <a href="<?php echo admin_url('post-new.php?post_type=gallery_item'); ?>">Indo Highlights > Add New</a>.</li>
                            <li><strong>Judul:</strong> Nama Tempat (Contoh: "Labuan Bajo").</li>
                            <li><strong>Featured Image:</strong> Foto tempat tersebut.</li>
                            <li><strong>Link URL:</strong> (Opsional) Link ke paket trip terkait.</li>
                        </ol>
                    </div>
                    <div class="lang-content-en" style="display:none">
                        <h2>Indo Highlights</h2>
                        <p>Special feature to showcase top local destinations in a gallery slider.</p>

                        <div class="feature-box location">
                            <span class="feature-title">SHOWN AT:</span>
                            <p>The <strong>"Jelajahi Indonesia"</strong> section on Homepage (Second slider).</p>
                        </div>

                        <h3>How to Add</h3>
                        <ol>
                            <li>Go to <a href="<?php echo admin_url('post-new.php?post_type=gallery_item'); ?>">Indo Highlights > Add New</a>.</li>
                            <li><strong>Title:</strong> Place Name (e.g., "Labuan Bajo").</li>
                            <li><strong>Featured Image:</strong> Photo of the place.</li>
                        </ol>
                    </div>
                </div>

                <!-- SECTION: JOURNAL -->
                <div id="sec-journal" class="docs-section">
                    <div class="lang-content-id">
                        <h2>Artikel & Inspirasi</h2>
                        <p>Blog post untuk SEO dan memberikan tips perjalanan kepada pelanggan.</p>

                        <div class="feature-box location">
                            <span class="feature-title">TAMPIL DI:</span>
                            <p>Bagian terbawah Homepage <strong>"Artikel & Inspirasi"</strong> dan halaman Blog.</p>
                        </div>

                        <h3>Cara Menulis Artikel</h3>
                        <ol>
                            <li>Masuk ke <a href="<?php echo admin_url('post-new.php'); ?>">Posts > Add New</a>.</li>
                            <li>Tulis artikel seperti biasa.</li>
                            <li>Jangan lupa set <strong>Category</strong> dan <strong>Featured Image</strong> agar tampil cantik di depan.</li>
                        </ol>
                    </div>
                    <div class="lang-content-en" style="display:none">
                        <h2>Articles & Inspiration</h2>
                        <p>Blog posts for SEO and travel tips.</p>

                        <div class="feature-box location">
                            <span class="feature-title">SHOWN AT:</span>
                            <p>Bottom section of Homepage <strong>"Artikel & Inspirasi"</strong>.</p>
                        </div>

                        <h3>How to Write</h3>
                        <ol>
                            <li>Go to <a href="<?php echo admin_url('post-new.php'); ?>">Posts > Add New</a>.</li>
                            <li>Write your article.</li>
                            <li>Set <strong>Category</strong> and <strong>Featured Image</strong>.</li>
                        </ol>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- JS for Tabs & Copy -->
    <script>
    function switchLang(lang) {
        // 1. Update Buttons
        document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
        document.querySelector(`.lang-btn[onclick="switchLang('${lang}')"]`).classList.add('active');

        // 2. Update Nav Text
        document.querySelectorAll('.txt-id').forEach(el => el.style.display = lang === 'id' ? 'inline' : 'none');
        document.querySelectorAll('.txt-en').forEach(el => el.style.display = lang === 'en' ? 'inline' : 'none');

        // 3. Update Content Areas
        document.querySelectorAll('.lang-content-id').forEach(el => el.style.display = lang === 'id' ? 'block' : 'none');
        document.querySelectorAll('.lang-content-en').forEach(el => el.style.display = lang === 'en' ? 'block' : 'none');
    }

    function showSection(id) {
        event.preventDefault();
        // 1. Hide all
        document.querySelectorAll('.docs-section').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('current'));

        // 2. Show Target
        document.getElementById('sec-' + id).classList.add('active');
        document.querySelector(`a[href="#${id}"]`).classList.add('current');
        
        // 3. Scroll top
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function copyPrompt() {
        const text = document.getElementById('ai-prompt').innerText;
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.querySelector('.copy-btn');
            btn.textContent = 'Copied!';
            setTimeout(() => btn.textContent = 'Copy Prompt', 2000);
        });
    }
    
    // Init: Ensure ID is default
    switchLang('id');
    </script>
    <?php
}
