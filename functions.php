<?php
/* -------------------------------------------------------------------------- */
/* PHASE 1: THEME SETUP (Tailwind, Menus, Etc)                                */
/* -------------------------------------------------------------------------- */
function nextur_scripts() {
    // 1. Tailwind CSS
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com?plugins=typography', array(), '3.4', false);
    
    // 2. Register & Load Flatpickr (Datepicker) FIRST
    wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
    wp_enqueue_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), '4.6', true);

    // 3. Load Alpine.js (DEPENDS on flatpickr)
    // This forces Alpine to wait until Flatpickr is ready
    wp_enqueue_script('alpine', '//unpkg.com/alpinejs', array('flatpickr'), '3.0', true);

    // 4. Tailwind Config
    wp_add_inline_script('tailwind', "
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: { DEFAULT: '#0284C7', dark: '#0C4A6E' }
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'nextur_scripts');

// NEW: Ensure Media Uploader scripts are loaded in Admin for the Gallery
function nextur_admin_scripts() {
    if (is_admin()) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'nextur_admin_scripts');

function nextur_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'primary') {
        $classes[] = 'text-current hover:text-brand font-medium transition duration-300 cursor-pointer';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'nextur_menu_classes', 10, 3);

add_theme_support('title-tag');
add_theme_support('post-thumbnails');

function nextur_menus() {
    register_nav_menus(array('primary' => 'Primary Menu'));
}
add_action('init', 'nextur_menus');


/* -------------------------------------------------------------------------- */
/* PHASE 2: NEXTUR TRIP DATA ARCHITECT (Updated Taxonomies)                   */
/* -------------------------------------------------------------------------- */

function nextur_init_structure() {
    // 1. Post Type: Trip
    register_post_type('trip', array(
        'labels' => array('name' => 'Trips', 'singular_name' => 'Trip'),
        'public' => true,
        'has_archive' => 'trips', // <--- CHANGED from true to 'trips'
        'menu_icon' => 'dashicons-airplane',
        'supports' => array('title', 'thumbnail'),
        'rewrite' => array('slug' => 'trip'), // Keeps single URL as /trip/bali...
    ));
    
    // 2. Taxonomy: Destinations (Updated Slug to Plural)
    register_taxonomy('destination', 'trip', array(
        'labels' => array('name' => 'Destinations', 'singular_name' => 'Destination'),
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'destinations'),
        'show_in_rest' => true,
    ));

    register_taxonomy('activity', 'trip', array(
        'labels' => array('name' => 'Activities', 'singular_name' => 'Activity'),
        'hierarchical' => false,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'tour-activity'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'nextur_init_structure');

// 2. Register Meta Boxes
function nextur_add_meta_boxes() {
    add_meta_box('trip_header_box', '1. Header & Taxonomy', 'render_trip_header_box', 'trip', 'side', 'high');
    add_meta_box('trip_context_box', '2. Subtitle & Highlights', 'render_trip_context_box', 'trip', 'normal', 'high');
    add_meta_box('trip_itinerary_box', '3. Dynamic Itinerary', 'render_trip_itinerary_box', 'trip', 'normal', 'high');
    add_meta_box('trip_financial_box', '4. Financials & Rules', 'render_trip_financial_box', 'trip', 'normal', 'high');
    add_meta_box('trip_details_box', '5. Full Details', 'render_trip_details_box', 'trip', 'normal', 'high');
    // RESTORED: Gallery Box
    add_meta_box('trip_gallery_box', '6. Trip Gallery', 'render_trip_gallery_box', 'trip', 'normal', 'high');
}
add_action('add_meta_boxes', 'nextur_add_meta_boxes');

/* --- RENDER CALLBACKS --- */
function render_trip_header_box($post) {
    wp_nonce_field('save_trip_meta', 'trip_nonce');
    $year = get_post_meta($post->ID, '_trip_tag_year', true);
    $airline = get_post_meta($post->ID, '_trip_airline', true);
    $route = get_post_meta($post->ID, '_trip_route', true);
    $price = get_post_meta($post->ID, '_trip_price', true);
    ?>
    <p><label><strong>Tag/Year</strong></label><input type="text" name="_trip_tag_year" value="<?php echo esc_attr($year); ?>" class="widefat"></p>
    <p><label><strong>Airline</strong></label><input type="text" name="_trip_airline" value="<?php echo esc_attr($airline); ?>" class="widefat"></p>
    <p><label><strong>Route</strong></label><input type="text" name="_trip_route" value="<?php echo esc_attr($route); ?>" class="widefat"></p>
    <p><label><strong>Start Price (IDR)</strong></label><input type="number" name="_trip_price" value="<?php echo esc_attr($price); ?>" class="widefat"></p>
    <?php
    $featured = get_post_meta($post->ID, '_trip_is_featured', true);
    ?>
    <p>
        <label><strong>Featured on Homepage?</strong></label>
        <br>
        <label>
            <input type="checkbox" name="_trip_is_featured" value="1" <?php checked($featured, '1'); ?>>
            Yes, show in Hero Slider
        </label>
    </p>
    <?php
}

function render_trip_context_box($post) {
    $subtitle = get_post_meta($post->ID, '_trip_subtitle', true);
    $highlights = get_post_meta($post->ID, '_trip_highlights', true);
    ?>
    <p><label><strong>Subtitle</strong></label><input type="text" name="_trip_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="widefat"></p>
    <p><label><strong>Highlights</strong> (Comma separated)</label><textarea name="_trip_highlights" rows="3" class="widefat"><?php echo esc_textarea($highlights); ?></textarea></p>
    <?php
}

function render_trip_itinerary_box($post) {
    $itinerary = get_post_meta($post->ID, '_trip_itinerary', true);
    if (!$itinerary || !is_array($itinerary)) $itinerary = array(array('day'=>'Day 1','title'=>'','flight'=>'','meals'=>'','desc'=>''));
    ?>
    <div id="itinerary-wrapper">
        <?php foreach ($itinerary as $i => $row) : ?>
        <div class="itinerary-row" style="background:#f8f9fa; padding:15px; margin-bottom:15px; border:1px solid #ddd; border-left:4px solid #2271b1;">
            <div style="display:flex; gap:10px; margin-bottom:10px;">
                <input type="text" name="itinerary[<?php echo $i; ?>][day]" value="<?php echo esc_attr($row['day']); ?>" placeholder="Day 1" style="width:15%;">
                <input type="text" name="itinerary[<?php echo $i; ?>][title]" value="<?php echo esc_attr($row['title']); ?>" placeholder="Title" style="width:85%;">
            </div>
            <div style="display:flex; gap:10px; margin-bottom:10px;">
                <input type="text" name="itinerary[<?php echo $i; ?>][flight]" value="<?php echo esc_attr($row['flight_info'] ?? ''); ?>" placeholder="Flight Info" style="width:70%;">
                <input type="text" name="itinerary[<?php echo $i; ?>][meals]" value="<?php echo esc_attr($row['meals']); ?>" placeholder="Meals" style="width:30%;">
            </div>
            <textarea name="itinerary[<?php echo $i; ?>][desc]" rows="4" style="width:100%;"><?php echo esc_textarea($row['desc']); ?></textarea>
            <button type="button" class="button remove-row" style="margin-top:10px; color:#b32d2e;">Remove Day</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-day" class="button button-primary">+ Add Day</button>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrap = document.getElementById('itinerary-wrapper');
        document.getElementById('add-day').addEventListener('click', () => {
            const count = wrap.querySelectorAll('.itinerary-row').length;
            const html = `
                <div class="itinerary-row" style="background:#f8f9fa; padding:15px; margin-bottom:15px; border:1px solid #ddd; border-left:4px solid #2271b1;">
                    <div style="display:flex; gap:10px; margin-bottom:10px;">
                        <input type="text" name="itinerary[${count}][day]" value="Day ${count+1}" style="width:15%;">
                        <input type="text" name="itinerary[${count}][title]" placeholder="Title" style="width:85%;">
                    </div>
                    <div style="display:flex; gap:10px; margin-bottom:10px;">
                        <input type="text" name="itinerary[${count}][flight]" placeholder="Flight Info" style="width:70%;">
                        <input type="text" name="itinerary[${count}][meals]" placeholder="Meals" style="width:30%;">
                    </div>
                    <textarea name="itinerary[${count}][desc]" rows="4" style="width:100%;"></textarea>
                    <button type="button" class="button remove-row" style="margin-top:10px; color:#b32d2e;">Remove Day</button>
                </div>`;
            wrap.insertAdjacentHTML('beforeend', html);
        });
        wrap.addEventListener('click', e => { if(e.target.classList.contains('remove-row')) e.target.closest('.itinerary-row').remove(); });
    });
    </script>
    <?php
}

function render_trip_financial_box($post) {
    $min_pax = get_post_meta($post->ID, '_trip_min_pax', true);
    $deposit = get_post_meta($post->ID, '_trip_deposit', true);
    $infant = get_post_meta($post->ID, '_trip_infant_price', true);
    $visa = get_post_meta($post->ID, '_trip_visa_note', true);
    $terms = get_post_meta($post->ID, '_trip_payment_terms', true);
    ?>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
        <p><label><strong>Min Pax</strong></label><br><input type="text" name="_trip_min_pax" value="<?php echo esc_attr($min_pax); ?>" class="widefat"></p>
        <p><label><strong>Deposit Amount</strong></label><br><input type="text" name="_trip_deposit" value="<?php echo esc_attr($deposit); ?>" class="widefat"></p>
        <p><label><strong>Infant Price</strong></label><br><input type="text" name="_trip_infant_price" value="<?php echo esc_attr($infant); ?>" class="widefat"></p>
        <p><label><strong>Visa Note</strong></label><br><input type="text" name="_trip_visa_note" value="<?php echo esc_attr($visa); ?>" class="widefat"></p>
    </div>
    <p><label><strong>Payment Terms Note</strong></label><br><textarea name="_trip_payment_terms" rows="3" class="widefat"><?php echo esc_textarea($terms); ?></textarea></p>
    <?php
}

function render_trip_details_box($post) {
    $includes = get_post_meta($post->ID, '_trip_includes', true);
    $excludes = get_post_meta($post->ID, '_trip_excludes', true);
    $optional = get_post_meta($post->ID, '_trip_optional', true);
    $terms = get_post_meta($post->ID, '_trip_terms', true);
    $args = array('textarea_rows' => 6, 'media_buttons' => false, 'teeny' => true);
    echo '<h4>Includes</h4>'; wp_editor($includes, '_trip_includes', $args);
    echo '<hr><h4>Excludes</h4>'; wp_editor($excludes, '_trip_excludes', $args);
    echo '<hr><h4>Optional / Add-ons</h4>'; wp_editor($optional, '_trip_optional', $args);
    echo '<hr><h4>Terms & Conditions</h4>'; wp_editor($terms, '_trip_terms', $args);
}

// RESTORED: Gallery Render Callback
function render_trip_gallery_box($post) {
    $gallery_ids = get_post_meta($post->ID, '_trip_gallery', true);
    ?>
    <div id="trip_gallery_wrapper">
        <input type="hidden" id="trip_gallery" name="_trip_gallery" value="<?php echo esc_attr($gallery_ids); ?>">
        <div id="gallery_preview" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
            <?php if($gallery_ids):
                $ids = explode(',', $gallery_ids);
                foreach($ids as $id):
                    $img = wp_get_attachment_image_url($id, 'thumbnail');
                    if($img) echo '<div style="position:relative;"><img src="'.$img.'" style="width:80px; height:80px; object-fit:cover; border-radius:4px; border:1px solid #ddd;"></div>';
                endforeach;
            endif; ?>
        </div>
        <button type="button" class="button" id="manage_gallery">Select/Edit Images</button>
        <p class="description">Select multiple images to appear in the "Gallery" tab.</p>
    </div>
    <script>
    jQuery(document).ready(function($){
        var frame;
        $('#manage_gallery').click(function(e){
            e.preventDefault();
            if(frame) { frame.open(); return; }
            frame = wp.media({
                title: 'Select Trip Gallery Images',
                button: { text: 'Use these images' },
                multiple: true
            });
            frame.on('select', function(){
                var selection = frame.state().get('selection');
                var ids = [];
                $('#gallery_preview').html('');
                selection.map(function(attachment){
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if(attachment.type === 'image'){
                        var url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                        $('#gallery_preview').append('<img src="'+url+'" style="width:80px; height:80px; object-fit:cover; border-radius:4px; border:1px solid #ddd; margin-right:5px;">');
                    }
                });
                $('#trip_gallery').val(ids.join(','));
            });
            frame.open();
        });
    });
    </script>
    <?php
}

/* --- SAVE LOGIC (FIXED) --- */
function save_trip_meta($post_id) {
    if (!isset($_POST['trip_nonce']) || !wp_verify_nonce($_POST['trip_nonce'], 'save_trip_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // 1. Handle Checkbox Explicitly (The Fix)
    // If the box is checked, $_POST has '1'. If unchecked, it has nothing.
    // We must force '0' if it is missing.
    $featured = isset($_POST['_trip_is_featured']) ? '1' : '0';
    update_post_meta($post_id, '_trip_is_featured', $featured);

    // 2. Handle Text Fields (Removed _trip_is_featured from this list)
    $fields = ['_trip_tag_year', '_trip_airline', '_trip_route', '_trip_price', '_trip_subtitle', '_trip_highlights', '_trip_min_pax', '_trip_deposit', '_trip_infant_price', '_trip_visa_note', '_trip_payment_terms', '_trip_gallery'];
    foreach($fields as $f) { 
        if(isset($_POST[$f])) {
            update_post_meta($post_id, $f, sanitize_text_field($_POST[$f])); 
        }
    }

    // 3. Handle Rich Text Areas
    $rich = ['_trip_includes', '_trip_excludes', '_trip_optional', '_trip_terms'];
    foreach($rich as $r) { 
        if(isset($_POST[$r])) {
            update_post_meta($post_id, $r, wp_kses_post($_POST[$r])); 
        }
    }

    // 4. Handle Itinerary (Array)
    if(isset($_POST['itinerary']) && is_array($_POST['itinerary'])) {
        $clean = [];
        foreach($_POST['itinerary'] as $day) {
            if(!empty($day['title'])) {
                $clean[] = [
                    'day' => sanitize_text_field($day['day']),
                    'title' => sanitize_text_field($day['title']),
                    'flight_info' => sanitize_text_field($day['flight']),
                    'meals' => sanitize_text_field($day['meals']),
                    'desc' => sanitize_textarea_field($day['desc'])
                ];
            }
        }
        update_post_meta($post_id, '_trip_itinerary', $clean);
    }
}
add_action('save_post', 'save_trip_meta');

/* -------------------------------------------------------------------------- */
/* PHASE 2 ADD-ON: INDONESIA HIGHLIGHTS (Dynamic Gallery)                     */
/* -------------------------------------------------------------------------- */

// 1. Register CPT
function nextur_register_gallery_cpt() {
    register_post_type('gallery_item', array(
        'labels' => array(
            'name' => 'Indo Highlights',
            'singular_name' => 'Highlight',
            'add_new_item' => 'Add New Destination',
            'edit_item' => 'Edit Destination'
        ),
        'public' => true,
        'exclude_from_search' => true, // Don't show in search results
        'publicly_queryable'  => false, // No single page needed
        'show_ui' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'thumbnail'), // Title = City Name, Thumbnail = Image
    ));
}
add_action('init', 'nextur_register_gallery_cpt');

// 2. Add Link Meta Box
function nextur_add_gallery_meta() {
    add_meta_box('gallery_link_box', 'Destination Link', 'nextur_render_gallery_meta', 'gallery_item', 'normal', 'high');
}
function nextur_render_gallery_meta($post) {
    $link = get_post_meta($post->ID, '_gallery_link', true);
    ?>
    <p>
        <label style="font-weight:bold; display:block; margin-bottom:5px;">Target URL</label>
        <input type="text" name="_gallery_link" value="<?php echo esc_attr($link); ?>" class="widefat" placeholder="e.g. https://nextur.com/trips/bali or #">
        <span class="description">Enter the URL this card should link to.</span>
    </p>
    <?php
}
function nextur_save_gallery_meta($post_id) {
    if (isset($_POST['_gallery_link'])) {
        update_post_meta($post_id, '_gallery_link', sanitize_text_field($_POST['_gallery_link']));
    }
}
add_action('add_meta_boxes', 'nextur_add_gallery_meta');
add_action('save_post', 'nextur_save_gallery_meta');

// 3. Admin Columns (Show Image in List)
function nextur_gallery_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'thumbnail' => 'Image', // Add Image Column
        'title' => 'City Name',
        'link' => 'Target Link',
        'date' => $columns['date'],
    );
    return $new_columns;
}
function nextur_gallery_custom_column($column, $post_id) {
    if ($column === 'thumbnail') {
        echo get_the_post_thumbnail($post_id, array(80, 80), array('style' => 'border-radius:4px; object-fit:cover;'));
    }
    if ($column === 'link') {
        echo get_post_meta($post_id, '_gallery_link', true);
    }
}
add_filter('manage_gallery_item_posts_columns', 'nextur_gallery_columns');
add_action('manage_gallery_item_posts_custom_column', 'nextur_gallery_custom_column', 10, 2);

/* -------------------------------------------------------------------------- */
/* HELPER: SMART TERM IMAGE (Manual Upload > Latest Trip > Fallback)          */
/* -------------------------------------------------------------------------- */
function nextur_get_term_image_url($term_id = null, $taxonomy = 'destination') {
    // 1. Auto-detect ID if on an archive page
    if (!$term_id && is_tax()) {
        $obj = get_queried_object();
        $term_id = $obj->term_id;
        $taxonomy = $obj->taxonomy;
    }

    // 2. CHECK MANUAL UPLOAD FIRST (New Logic)
    // We check if you uploaded a specific image for this Activity/Destination in Admin
    $manual_img_id = get_term_meta($term_id, 'activity_image_id', true);
    if ($manual_img_id) {
        $img_src = wp_get_attachment_image_url($manual_img_id, 'large');
        if ($img_src) return $img_src;
    }

    // 3. Fallback: Query the latest trip in this term
    $args = array(
        'post_type'      => 'trip',
        'posts_per_page' => 1,
        'tax_query'      => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
    );
    
    $latest_trip = new WP_Query($args);
    
    if ($latest_trip->have_posts()) {
        $latest_trip->the_post();
        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        wp_reset_postdata();
        if ($img_url) return $img_url;
    }

    // 4. Final Fallback (Placeholder)
    return 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&q=80'; 
}

/* -------------------------------------------------------------------------- */
/* PHASE 3: BLOG & UTILITIES                                                  */
/* -------------------------------------------------------------------------- */

// 1. Customize Excerpt Length (20 words)
function nextur_custom_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'nextur_custom_excerpt_length', 999);

// 2. Customize Excerpt "Read More" String
function nextur_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'nextur_excerpt_more');

// 3. Helper: Get Random Trips for Sidebar Cross-Sell
function nextur_get_random_trips($count = 3) {
    $args = array(
        'post_type'      => 'trip',
        'posts_per_page' => $count,
        'orderby'        => 'rand',
    );
    return new WP_Query($args);
}

/* -------------------------------------------------------------------------- */
/* PHASE 3: MULTILINGUAL SUPPORT (POLYLANG)                                   */
/* -------------------------------------------------------------------------- */

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

// --- REGISTER MENUS ---
function nextur_register_menus() {
    register_nav_menus(array(
        'header_menu' => 'Header Main Menu', // The new slot for the top menu
        'footer_menu' => 'Footer Menu'       // Good practice to define this too
    ));
}
add_action('after_setup_theme', 'nextur_register_menus');

/* -------------------------------------------------------------------------- */
/* PHASE 6: FORM HANDLERS (Contact & Booking)                                 */
/* -------------------------------------------------------------------------- */

// Helper: Get the Target Email
function nextur_get_target_email() {
    // Try to get the email from the Customizer setting we made earlier
    $target = get_theme_mod('company_email');
    
    // If empty, fallback to the main WordPress Admin Email
    if (empty($target)) {
        $target = get_option('admin_email');
    }
    return $target;
}

// 1. HANDLE CONTACT FORM
// 1. HANDLE CONTACT FORM (Styled Email)
function nextur_handle_contact() {
    // Security Check (Optional)
    // if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'submit_contact')) wp_die('Security check failed');

    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $message_content = sanitize_textarea_field($_POST['contact_message']);

    $to = nextur_get_target_email(); // Sends to info@nextur.id (or customizer setting)
    $subject = "New Inquiry from: $name";
    
    // Required headers for HTML email
    $headers = array('Content-Type: text/html; charset=UTF-8', "Reply-To: $name <$email>");

    // Styled HTML Email Template
    $body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>New Contact Message</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; background-color: #f3f4f6;">
        <div style="padding: 40px 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                
                <div style="background-color: #0f172a; padding: 30px; text-align: center;">
                    <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600; letter-spacing: 0.5px;">New Message</h1>
                    <p style="color: #94a3b8; margin: 5px 0 0 0; font-size: 14px;">Nextur Website Inquiry</p>
                </div>

                <div style="padding: 32px; color: #334155;">
                    
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
                        <tr>
                            <td width="50%" style="vertical-align: top; padding-right: 10px;">
                                <p style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: bold; margin: 0 0 5px 0; letter-spacing: 1px;">Sender Name</p>
                                <p style="font-size: 16px; color: #0f172a; margin: 0; font-weight: 500;">' . $name . '</p>
                            </td>
                            <td width="50%" style="vertical-align: top;">
                                <p style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: bold; margin: 0 0 5px 0; letter-spacing: 1px;">Email Address</p>
                                <p style="font-size: 16px; color: #0284c7; margin: 0;">
                                    <a href="mailto:' . $email . '" style="color: #0284c7; text-decoration: none;">' . $email . '</a>
                                </p>
                            </td>
                        </tr>
                    </table>

                    <div style="border-top: 1px solid #e2e8f0; padding-top: 24px;">
                        <p style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: bold; margin: 0 0 12px 0; letter-spacing: 1px;">Message Content</p>
                        <div style="background-color: #f8fafc; border-left: 4px solid #0284c7; padding: 20px; border-radius: 4px; color: #334155; line-height: 1.6;">
                            ' . nl2br($message_content) . '
                        </div>
                    </div>

                </div>

                <div style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;">
                    <p style="font-size: 12px; color: #94a3b8; margin: 0;">
                        &copy; ' . date("Y") . ' Nextur. All rights reserved.<br>
                        Sent automatically from your website.
                    </p>
                </div>
            </div>
        </div>
    </body>
    </html>
    ';

    wp_mail($to, $subject, $body, $headers);

    // Redirect back with success flag
    wp_redirect(add_query_arg('sent', 'success', wp_get_referer()));
    exit;
}
add_action('admin_post_submit_contact', 'nextur_handle_contact'); // For logged in users
add_action('admin_post_nopriv_submit_contact', 'nextur_handle_contact'); // For guests

// 2. HANDLE BOOKING FORM (Updated)
function nextur_handle_booking() {
    $name = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['whatsapp']);
    $pax = intval($_POST['pax']);
    $date = sanitize_text_field($_POST['date']);
    $trip = sanitize_text_field($_POST['trip_name']);
    $notes = sanitize_textarea_field($_POST['notes']);

    $to = nextur_get_target_email(); // Sends to info@nextur.id
    $subject = "New Booking Request: $trip";
    $headers = array('Content-Type: text/html; charset=UTF-8', "Reply-To: $name <$email>");
    
    $message = '
    <html>
    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <div style="max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #0f172a; color: #ffffff; padding: 20px; text-align: center;">
                <h2 style="margin:0;">Nextur Booking</h2>
            </div>
            <div style="padding: 20px; background-color: #f8fafc;">
                <p style="margin-top:0;">Hello Admin,</p>
                <p>You have received a new booking request. Here are the details:</p>
                
                <table style="width: 100%; border-collapse: collapse; background: #fff; margin-top: 15px;">
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; width: 140px; color: #64748b;">Trip Name</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; color: #0f172a;"><strong>'.$trip.'</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Customer Name</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$name.'</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Email</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$email.'</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">WhatsApp</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$phone.'</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Pax</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$pax.' Person(s)</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Date</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$date.'</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Notes</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.nl2br($notes).'</td>
                    </tr>
                </table>
                
                <p style="margin-top: 25px; font-size: 12px; color: #999; text-align: center;">
                    Sent automatically from your website.
                </p>
            </div>
        </div>
    </body>
    </html>
    ';

    wp_mail($to, $subject, $message, $headers);
    
    // Redirect to Thank You Page
    wp_redirect(home_url('/thank-you')); // Ensure you have a page with slug 'thank-you'
    exit;
}
add_action('admin_post_submit_booking', 'nextur_handle_booking');
add_action('admin_post_nopriv_submit_booking', 'nextur_handle_booking');

/* -------------------------------------------------------------------------- */
/* PHASE 2 ADD-ON: ACTIVITY TAXONOMY IMAGE UPLOADER                           */
/* -------------------------------------------------------------------------- */

// 1. Add Field to "Add New Activity" Screen
function nextur_activity_add_image_field() {
    ?>
    <div class="form-field term-group">
        <label><?php _e('Activity Image (For Homepage)', 'nextur'); ?></label>
        <input type="hidden" id="activity-image-id" name="activity_image_id" value="">
        <div id="activity-image-wrapper" style="margin-bottom:10px;"></div>
        <p>
            <input type="button" class="button button-secondary nextur_media_button" value="<?php _e( 'Select Image', 'nextur' ); ?>" />
            <input type="button" class="button button-secondary nextur_media_remove" value="<?php _e( 'Remove', 'nextur' ); ?>" style="display:none;" />
        </p>
    </div>
    <?php
}
add_action('activity_add_form_fields', 'nextur_activity_add_image_field', 10, 2);

// 2. Add Field to "Edit Activity" Screen
function nextur_activity_edit_image_field($term, $taxonomy) {
    $image_id = get_term_meta($term->term_id, 'activity_image_id', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label><?php _e( 'Activity Image', 'nextur' ); ?></label></th>
        <td>
            <input type="hidden" id="activity-image-id" name="activity_image_id" value="<?php echo esc_attr($image_id); ?>">
            <div id="activity-image-wrapper" style="margin-bottom:10px;">
                <?php if ( $image_id ) { echo wp_get_attachment_image ( $image_id, 'thumbnail' ); } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary nextur_media_button" value="<?php _e( 'Select Image', 'nextur' ); ?>" />
                <input type="button" class="button button-secondary nextur_media_remove" value="<?php _e( 'Remove', 'nextur' ); ?>" style="<?php echo $image_id ? '' : 'display:none;'; ?>" />
            </p>
        </td>
    </tr>
    <?php
}
add_action('activity_edit_form_fields', 'nextur_activity_edit_image_field', 10, 2);

// 3. Save the Image Data
function nextur_save_activity_image($term_id) {
    if (isset($_POST['activity_image_id']) && '' !== $_POST['activity_image_id']){
        update_term_meta($term_id, 'activity_image_id', absint($_POST['activity_image_id']));
    } else {
        update_term_meta($term_id, 'activity_image_id', ''); // Delete if empty
    }
}
add_action('created_activity', 'nextur_save_activity_image', 10, 2);
add_action('edited_activity', 'nextur_save_activity_image', 10, 2);

// 4. Javascript for the Media Uploader (Admin Only)
function nextur_activity_admin_script() {
    $screen = get_current_screen();
    if ( $screen->taxonomy == 'activity' ) {
        ?>
        <script>
            jQuery(document).ready(function($) {
                var frame;
                $('.nextur_media_button').click(function(e) {
                    e.preventDefault();
                    if ( frame ) { frame.open(); return; }
                    frame = wp.media({
                        title: 'Select Activity Image',
                        button: { text: 'Use this image' },
                        multiple: false
                    });
                    frame.on('select', function() {
                        var attachment = frame.state().get('selection').first().toJSON();
                        $('#activity-image-id').val(attachment.id);
                        $('#activity-image-wrapper').html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width:150px; border-radius:4px; border:1px solid #ddd;"/>');
                        $('.nextur_media_remove').show();
                    });
                    frame.open();
                });
                $('.nextur_media_remove').click(function(e) {
                    e.preventDefault();
                    $('#activity-image-id').val('');
                    $('#activity-image-wrapper').html('');
                    $(this).hide();
                });
            });
        </script>
        <?php
    }
}
add_action('admin_footer', 'nextur_activity_admin_script');

/* -------------------------------------------------------------------------- */
/* PHASE 4: SECURITY HARDENING                                                */
/* -------------------------------------------------------------------------- */
// 1. Hide WordPress Version (Prevents scanners from knowing your vulnerability level)
remove_action('wp_head', 'wp_generator');

// 2. Disable XML-RPC (Stops automated brute-force attacks)
add_filter('xmlrpc_enabled', '__return_false');

// 3. Block User Enumeration (Prevents bots from fishing for usernames)
if (!is_admin()) {
    if (preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'])) die('Access Denied');
    add_filter('redirect_canonical', 'nextur_block_enum', 10, 2);
}
function nextur_block_enum($redirect, $request) {
    if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) die('Access Denied');
    return $redirect;
}