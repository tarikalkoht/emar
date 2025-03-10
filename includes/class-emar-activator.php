<?php
/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 * @package    Emar
 * @subpackage Emar/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Emar
 * @subpackage Emar/includes
 */
class Emar_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        // Create necessary database tables or options if needed
        
        // Set default options
        if (!get_option('emar_version')) {
            add_option('emar_version', EMAR_VERSION);
        }
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}