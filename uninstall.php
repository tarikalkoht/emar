<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 * @package    Emar
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Clean up plugin options
delete_option('emar_settings');
delete_option('emar_version');

// For site options in Multisite
delete_site_option('emar_settings');
delete_site_option('emar_version');