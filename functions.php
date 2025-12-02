<?php
/* -------------------------------------------------------------------------- */
/* PHASE 1: THEME SETUP (Tailwind, Menus, Etc)                                */
/* -------------------------------------------------------------------------- */
function nextur_scripts() {
    // Tailwind CSS (CDN)
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com?plugins=typography', array(), '3.4', false); // Added typography plugin
    // Alpine.js (CDN)
    wp_enqueue_script('alpine', '//unpkg.com/alpinejs', array(), '3.0', true);

    // Config
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
/* PHASE 2: NEXTUR TRIP DATA ARCHITECT (Native Meta Boxes)                    */
/* -------------------------------------------------------------------------- */

// 1. CPT & Taxonomy
function nextur_init_structure() {
    register_post_type('trip', array(
        'labels' => array('name' => 'Trips', 'singular_name' => 'Trip'),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-airplane',
        'supports' => array('title', 'thumbnail'), 
        'rewrite' => array('slug' => 'trip'),
    ));
    
    register_taxonomy('destination', 'trip', array(
        'labels' => array('name' => 'Destinations', 'singular_name' => 'Destination'),
        'hierarchical' => true,
        'public' => true,
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

/* --- SAVE LOGIC --- */
function save_trip_meta($post_id) {
    if (!isset($_POST['trip_nonce']) || !wp_verify_nonce($_POST['trip_nonce'], 'save_trip_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['_trip_tag_year', '_trip_airline', '_trip_route', '_trip_price', '_trip_subtitle', '_trip_highlights', '_trip_min_pax', '_trip_deposit', '_trip_infant_price', '_trip_visa_note', '_trip_payment_terms'];
    foreach($fields as $f) { if(isset($_POST[$f])) update_post_meta($post_id, $f, sanitize_text_field($_POST[$f])); }

    $rich = ['_trip_includes', '_trip_excludes', '_trip_optional', '_trip_terms'];
    foreach($rich as $r) { if(isset($_POST[$r])) update_post_meta($post_id, $r, wp_kses_post($_POST[$r])); }

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
/* PHASE 2: BOOKING LOGIC (RESTORED FROM YOUR CODE)                           */
/* -------------------------------------------------------------------------- */
function nextur_handle_booking() {
    $name = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['whatsapp']);
    $pax = intval($_POST['pax']);
    $date = sanitize_text_field($_POST['date']);
    $trip = sanitize_text_field($_POST['trip_name']);
    $notes = sanitize_textarea_field($_POST['notes']);

    $to = get_option('admin_email');
    $subject = "New Booking: $trip ($name)";
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Styled HTML Email
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
    wp_redirect(home_url('/thank-you'));
    exit;
}
add_action('admin_post_submit_booking', 'nextur_handle_booking');
add_action('admin_post_nopriv_submit_booking', 'nextur_handle_booking');