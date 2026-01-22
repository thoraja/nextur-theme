<?php
/**
 * Company Information Settings
 * Registers a dedicated admin menu for managing company details.
 */

// 1. ADD MENU ITEM
function nextur_company_info_menu() {
    add_menu_page(
        'Company Info',          // Page Title
        'Company Info',          // Menu Title
        'manage_options',        // Capability
        'nextur-company-info',   // Menu Slug
        'nextur_company_info_page_html', // Callback
        'dashicons-building',    // Icon
        25                       // Position (below Dashboard)
    );
}
add_action('admin_menu', 'nextur_company_info_menu');

// 2. REGISTER SETTINGS
function nextur_company_info_settings() {
    // --- GROUP: CONTACT DETAILS ---
    register_setting('nextur_company_options', 'nextur_company_address');
    register_setting('nextur_company_options', 'nextur_company_phone');
    register_setting('nextur_company_options', 'nextur_company_email');
    register_setting('nextur_company_options', 'nextur_company_secondary_email');
    register_setting('nextur_company_options', 'nextur_company_whatsapp_url');

    // --- GROUP: SOCIAL MEDIA ---
    register_setting('nextur_company_options', 'nextur_company_facebook');
    register_setting('nextur_company_options', 'nextur_company_instagram');
    register_setting('nextur_company_options', 'nextur_company_linkedin');

    // --- SECTIONS ---
    add_settings_section(
        'nextur_company_contact_section',
        'Contact Details',
        null,
        'nextur-company-info'
    );

    add_settings_section(
        'nextur_company_social_section',
        'Social Media Links',
        null,
        'nextur-company-info'
    );

    // --- FIELDS ---
    add_settings_field(
        'nextur_company_address',
        'Address',
        'nextur_company_address_cb',
        'nextur-company-info',
        'nextur_company_contact_section'
    );

    add_settings_field(
        'nextur_company_phone',
        'Phone Number (Display)',
        'nextur_company_phone_cb',
        'nextur-company-info',
        'nextur_company_contact_section'
    );

    add_settings_field(
        'nextur_company_email',
        'Email Address',
        'nextur_company_email_cb',
        'nextur-company-info',
        'nextur_company_contact_section'
    );

    add_settings_field(
        'nextur_company_secondary_email',
        'Secondary Email (CC)',
        'nextur_company_secondary_email_cb',
        'nextur-company-info',
        'nextur_company_contact_section',
        array('help' => 'Optional. Add a second email to receive form submissions.')
    );

    add_settings_field(
        'nextur_company_whatsapp_url',
        'WhatsApp Link URL',
        'nextur_company_whatsapp_url_cb',
        'nextur-company-info',
        'nextur_company_contact_section',
        array('help' => 'e.g., https://wa.me/6281234567890')
    );

    add_settings_field(
        'nextur_company_facebook',
        'Facebook URL',
        'nextur_company_facebook_cb',
        'nextur-company-info',
        'nextur_company_social_section'
    );

    add_settings_field(
        'nextur_company_instagram',
        'Instagram URL',
        'nextur_company_instagram_cb',
        'nextur-company-info',
        'nextur_company_social_section'
    );

    add_settings_field(
        'nextur_company_linkedin',
        'LinkedIn URL',
        'nextur_company_linkedin_cb',
        'nextur-company-info',
        'nextur_company_social_section'
    );
}
add_action('admin_init', 'nextur_company_info_settings');

// 3. FIELD CALLBACKS
function nextur_company_address_cb() {
    $value = get_option('nextur_company_address', '');
    echo '<textarea name="nextur_company_address" rows="3" class="large-text code">' . esc_textarea($value) . '</textarea>';
}

function nextur_company_phone_cb() {
    $value = get_option('nextur_company_phone', '');
    echo '<input type="text" name="nextur_company_phone" value="' . esc_attr($value) . '" class="regular-text" placeholder="+62 812 3456 7890">';
}

function nextur_company_email_cb() {
    $value = get_option('nextur_company_email', '');
    echo '<input type="email" name="nextur_company_email" value="' . esc_attr($value) . '" class="regular-text" placeholder="info@company.com">';
}

function nextur_company_secondary_email_cb($args) {
    $value = get_option('nextur_company_secondary_email', '');
    echo '<input type="email" name="nextur_company_secondary_email" value="' . esc_attr($value) . '" class="regular-text" placeholder="cc@company.com">';
    if (!empty($args['help'])) {
        echo '<p class="description">' . esc_html($args['help']) . '</p>';
    }
}

function nextur_company_whatsapp_url_cb($args) {
    $value = get_option('nextur_company_whatsapp_url', '');
    echo '<input type="url" name="nextur_company_whatsapp_url" value="' . esc_attr($value) . '" class="regular-text">';
    if (!empty($args['help'])) {
        echo '<p class="description">' . esc_html($args['help']) . '</p>';
    }
}

function nextur_company_facebook_cb() {
    $value = get_option('nextur_company_facebook', '');
    echo '<input type="url" name="nextur_company_facebook" value="' . esc_attr($value) . '" class="regular-text">';
}

function nextur_company_instagram_cb() {
    $value = get_option('nextur_company_instagram', '');
    echo '<input type="url" name="nextur_company_instagram" value="' . esc_attr($value) . '" class="regular-text">';
}

function nextur_company_linkedin_cb() {
    $value = get_option('nextur_company_linkedin', '');
    echo '<input type="url" name="nextur_company_linkedin" value="' . esc_attr($value) . '" class="regular-text">';
}


// 4. RENDER SETTINGS PAGE
function nextur_company_info_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('nextur_company_options');
            do_settings_sections('nextur-company-info');
            submit_button('Save Company Information');
            ?>
        </form>
    </div>
    <?php
}

// 5. HELPER FUNCTION FOR FRONTEND
/**
 * Retrieve company information safely.
 * 
 * @param string $key The specific field key (address, phone, email, whatsapp, facebook, instagram, linkedin).
 * @return string The stored value or empty string.
 */
function nextur_get_company_info($key) {
    // Map short keys to full option names
    $map = array(
        'address'   => 'nextur_company_address',
        'phone'     => 'nextur_company_phone',
        'email'     => 'nextur_company_email',
        'secondary_email' => 'nextur_company_secondary_email',
        'whatsapp'  => 'nextur_company_whatsapp_url',
        'facebook'  => 'nextur_company_facebook',
        'instagram' => 'nextur_company_instagram',
        'linkedin'  => 'nextur_company_linkedin',
    );

    if (isset($map[$key])) {
        return get_option($map[$key], '');
    }

    return '';
}
