<?php
/**
 * Theme Settings
 * General settings for the theme.
 */

// 1. REGISTER SETTINGS
function nextur_theme_settings() {
    // --- GROUP: SITE PROTECTION ---
    register_setting('nextur_theme_options', 'nextur_enable_content_protection');

    // --- SECTIONS ---
    add_settings_section(
        'nextur_protection_section',
        'Content Protection',
        null,
        'nextur-theme-settings'
    );

    // --- FIELDS ---
    add_settings_field(
        'nextur_enable_content_protection',
        'Enable Copy Protection',
        'nextur_enable_content_protection_cb',
        'nextur-theme-settings',
        'nextur_protection_section'
    );
}
add_action('admin_init', 'nextur_theme_settings');

// 2. FIELD CALLBACKS
function nextur_enable_content_protection_cb() {
    $value = get_option('nextur_enable_content_protection', '');
    ?>
    <input type="checkbox" name="nextur_enable_content_protection" value="1" <?php checked($value, 1); ?>>
    <p class="description">
        If enabled, users will be unable to:
        <ul style="list-style: disc; margin-left: 20px;">
            <li>Select text</li>
            <li>Right-click (Context Menu)</li>
            <li>Copy, Cut, or Paste content</li>
            <li>Drag images or text</li>
        </ul>
    </p>
    <?php
}

// 3. REGISTER MENU PAGE
function nextur_theme_settings_menu() {
    add_menu_page(
        'Theme Settings',        // Page Title
        'Theme Settings',        // Menu Title
        'manage_options',        // Capability
        'nextur-theme-settings', // Menu Slug
        'nextur_theme_settings_page_html', // Callback
        'dashicons-admin-generic', // Icon
        60                       // Position
    );
}
add_action('admin_menu', 'nextur_theme_settings_menu');

// 4. RENDER SETTINGS PAGE
function nextur_theme_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('nextur_theme_options');
            do_settings_sections('nextur-theme-settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}
