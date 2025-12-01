<?php
function nextur_scripts() {
    // Tailwind CSS (CDN)
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), '3.4', false);
    
    // Alpine.js (CDN)
    wp_enqueue_script('alpine', '//unpkg.com/alpinejs', array(), '3.0', true);

    // Tailwind Config: Fonts & Colors
    wp_add_inline_script('tailwind', "
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0284C7', // Ocean Blue
                            dark: '#0C4A6E',
                        }
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'nextur_scripts');

// Menu Classes Helper (Adapts text color)
function nextur_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'primary') {
        $classes[] = 'text-current hover:text-brand font-medium transition duration-300';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'nextur_menu_classes', 10, 3);

// Basic Setup
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

function nextur_menus() {
    register_nav_menus(array('primary' => 'Primary Menu'));
}
add_action('init', 'nextur_menus');

/* -------------------------------------------------------------------------- */
/* PHASE 2: TRIP CPT, ITINERARY META, & EMAIL LOGIC                          */
/* -------------------------------------------------------------------------- */

// 1. Register "Trip" CPT
function nextur_register_trip_cpt() {
    register_post_type('trip', array(
        'labels' => array(
            'name' => 'Trips',
            'singular_name' => 'Trip',
            'add_new_item' => 'Add New Trip',
            'edit_item' => 'Edit Trip'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-airplane',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), // Added excerpt
        'rewrite' => array('slug' => 'trip'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'nextur_register_trip_cpt');

// 2. Add Meta Boxes (Price, Duration, Itinerary)
function nextur_add_trip_meta() {
    add_meta_box('trip_details', 'Trip Details', 'nextur_trip_meta_callback', 'trip', 'normal', 'high');
}

function nextur_trip_meta_callback($post) {
    wp_nonce_field('nextur_save_trip_meta', 'nextur_trip_nonce');
    
    $price = get_post_meta($post->ID, '_trip_price', true);
    $duration = get_post_meta($post->ID, '_trip_duration', true); // NEW FIELD
    
    echo '<div style="display:flex; gap:20px; margin-bottom: 20px;">';
    
    echo '<div>';
    echo '<label style="font-weight:bold; display:block; margin-bottom:5px;">Price (IDR)</label>';
    echo '<input type="number" name="trip_price" value="' . esc_attr($price) . '" placeholder="2500000">';
    echo '</div>';

    echo '<div>';
    echo '<label style="font-weight:bold; display:block; margin-bottom:5px;">Duration</label>';
    echo '<input type="text" name="trip_duration" value="' . esc_attr($duration) . '" placeholder="e.g. 3 Hari 2 Malam">';
    echo '</div>';
    
    echo '</div>';
    
    echo '<hr style="margin: 20px 0;">';
    echo '<h3>Itinerary Details</h3>';
    
    for ($i = 1; $i <= 5; $i++) {
        $title = get_post_meta($post->ID, "_itinerary_day_{$i}_title", true);
        $desc = get_post_meta($post->ID, "_itinerary_day_{$i}_desc", true);
        echo '<div style="margin-bottom: 15px; border:1px solid #ddd; padding:15px; background:#f9f9f9;">';
        echo "<strong>Day $i</strong><br>";
        echo '<input type="text" name="itinerary_day_'.$i.'_title" value="'.esc_attr($title).'" placeholder="Title" style="width:100%; margin: 5px 0;"><br>';
        echo '<textarea name="itinerary_day_'.$i.'_desc" placeholder="Description..." style="width:100%; height:50px;">'.esc_textarea($desc).'</textarea>';
        echo '</div>';
    }
}

function nextur_save_trip_meta($post_id) {
    if (!isset($_POST['nextur_trip_nonce']) || !wp_verify_nonce($_POST['nextur_trip_nonce'], 'nextur_save_trip_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['trip_price'])) update_post_meta($post_id, '_trip_price', sanitize_text_field($_POST['trip_price']));
    if (isset($_POST['trip_duration'])) update_post_meta($post_id, '_trip_duration', sanitize_text_field($_POST['trip_duration'])); // SAVE DURATION

    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST["itinerary_day_{$i}_title"])) {
            update_post_meta($post_id, "_itinerary_day_{$i}_title", sanitize_text_field($_POST["itinerary_day_{$i}_title"]));
            update_post_meta($post_id, "_itinerary_day_{$i}_desc", sanitize_textarea_field($_POST["itinerary_day_{$i}_desc"]));
        }
    }
}
add_action('add_meta_boxes', 'nextur_add_trip_meta');
add_action('save_post', 'nextur_save_trip_meta');

// 3. Handle Booking Form (With Styled HTML Email)
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