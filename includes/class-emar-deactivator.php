<?php
/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 * @package    Emar
 * @subpackage Emar/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Emar
 * @subpackage Emar/includes
 */
class Emar_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // Clean up operations if needed
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}