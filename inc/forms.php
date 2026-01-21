<?php
/**
 * Form Handlers & Customizer
 */

// 0. REGISTER CUSTOMIZER SETTINGS (Email Targets)
function nextur_customize_register($wp_customize) {
    // Section: Company Settings
    $wp_customize->add_section('nextur_company_settings', array(
        'title'    => __('Company Settings', 'nextur'),
        'priority' => 30,
    ));

    // Setting: Primary Email
    $wp_customize->add_setting('company_email', array(
        'default'   => get_option('admin_email'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control('company_email', array(
        'label'    => __('Primary Notification Email', 'nextur'),
        'section'  => 'nextur_company_settings',
        'type'     => 'email',
    ));

    // Setting: Secondary Email
    $wp_customize->add_setting('company_secondary_email', array(
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control('company_secondary_email', array(
        'label'    => __('Secondary Notification Email (CC)', 'nextur'),
        'section'  => 'nextur_company_settings',
        'type'     => 'email',
        'description' => __('Optional. Add a second email to receive form submissions.', 'nextur'),
    ));
}
add_action('customize_register', 'nextur_customize_register');


// 1. HANDLE CONTACT FORM (Styled Email + Multiple Recipients)
function nextur_handle_contact() {
    // Security Check (Optional)
    // if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'submit_contact')) wp_die('Security check failed');

    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $message_content = sanitize_textarea_field($_POST['contact_message']);

    // --- DOUBLE EMAIL CONFIGURATION ---
    $primary_email = nextur_get_target_email(); // From Helpers
    $secondary_email = get_theme_mod('company_secondary_email'); // Retrieved from Customizer
    
    // Combine them into an array
    $to = array($primary_email);
    if (!empty($secondary_email)) {
        $to[] = $secondary_email;
    }
    // ----------------------------------

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

// 2. HANDLE BOOKING FORM (Updated + Multiple Recipients)
function nextur_handle_booking() {
    $name = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['whatsapp']);
    $pax = intval($_POST['pax']);
    $date = sanitize_text_field($_POST['date']);
    $trip = sanitize_text_field($_POST['trip_name']);
    $notes = sanitize_textarea_field($_POST['notes']);

    // --- DOUBLE EMAIL CONFIGURATION ---
    $primary_email = nextur_get_target_email(); // From Helpers
    $secondary_email = get_theme_mod('company_secondary_email'); // Retrieved from Customizer
    
    // Combine them into an array
    $to = array($primary_email);
    if (!empty($secondary_email)) {
        $to[] = $secondary_email;
    }
    // ----------------------------------

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
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Participants</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$pax.' Pax</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Preferred Date</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.$date.'</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold; color: #64748b;">Notes</td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">'.nl2br($notes).'</td>
                    </tr>
                </table>
                
                <p style="margin-top: 20px;">Please contact the customer shortly.</p>
            </div>
            <div style="background-color: #f1f5f9; padding: 10px; text-align: center; font-size: 12px; color: #64748b;">
                &copy; '.date("Y").' Nextur. All rights reserved.
            </div>
        </div>
    </body>
    </html>
    ';

    wp_mail($to, $subject, $message, $headers); // Send to Array of emails

    // Redirect to Thank You Page
    wp_redirect(home_url('/thank-you'));
    exit;
}
add_action('admin_post_submit_booking', 'nextur_handle_booking');
add_action('admin_post_nopriv_submit_booking', 'nextur_handle_booking');
