<?php
/**
 * Nextur Theme Functions
 * Refactored to load from inc/ directory.
 */

/* -------------------------------------------------------------------------- */
/* INCLUDES                                                                   */
/* -------------------------------------------------------------------------- */

$nextur_includes = array(
    'inc/setup.php',      // Scripts, Menus, Supports
    'inc/post-types.php', // CPTs & Taxonomies
    'inc/meta-boxes.php', // Meta Boxes & Save Logic
    'inc/polylang.php',   // Polylang String Config
    'inc/helpers.php',    // Helper Functions
    'inc/forms.php',      // Form Handling & Customizer
    'inc/company-info.php', // Company Info Settings
    'inc/documentation.php', // Theme Documentation & User Guide
    'inc/theme-settings.php' // General Theme Settings
);

foreach ($nextur_includes as $file) {
    $filepath = locate_template($file);
    if (!$filepath) {
        trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
    }
    require_once $filepath;
}

/* -------------------------------------------------------------------------- */
/* THAT'S IT!                                                                 */
/* All logic is now handled in the included files above.                      */
/* -------------------------------------------------------------------------- */