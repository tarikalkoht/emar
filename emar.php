<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://example.com
 * @since             1.0.1
 * @package           Emar
 *
 * @wordpress-plugin
 * Plugin Name:       Emar
 * Plugin URI:        https://example.com/emar/
 * Description:       A plugin that adds custom Elementor widgets including a timeline slider widget.
 * Version:           1.0.1
 * Author:            Your Name
 * Author URI:        https://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       emar
 * Domain Path:       /languages
 * Requires PHP:      7.4
 * Requires at least: 5.8
 * Elementor tested up to: 3.14.0
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Current plugin version.
 */
define('EMAR_VERSION', '1.0.1');
define('EMAR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('EMAR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('EMAR_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Check if Elementor is installed and activated
 */
function emar_check_elementor_dependency() {
    // Check if Elementor is installed and activated
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', 'emar_elementor_missing_notice');
        return false;
    }
    
    // Check Elementor version
    if (!version_compare(ELEMENTOR_VERSION, '3.5.0', '>=')) {
        add_action('admin_notices', 'emar_elementor_version_notice');
        return false;
    }
    
    return true;
}

/**
 * Admin notice for missing Elementor
 */
function emar_elementor_missing_notice() {
    $message = sprintf(
        __('"%1$s" requires "%2$s" to be installed and activated. %3$s', 'emar'),
        '<strong>Emar</strong>',
        '<strong>Elementor</strong>',
        '<a href="' . esc_url(admin_url('plugin-install.php?tab=search&s=elementor')) . '">' . __('Install Elementor', 'emar') . '</a>'
    );
    
    printf('<div class="notice notice-error"><p>%1$s</p></div>', $message);
}

/**
 * Admin notice for Elementor version requirement
 */
function emar_elementor_version_notice() {
    $message = sprintf(
        __('"%1$s" requires "%2$s" version %3$s or greater.', 'emar'),
        '<strong>Emar</strong>',
        '<strong>Elementor</strong>',
        '3.5.0'
    );
    
    printf('<div class="notice notice-error"><p>%1$s</p></div>', $message);
}

/**
 * Initialize Emar plugin
 */
function emar_init() {
    if (!emar_check_elementor_dependency()) {
        return;
    }
    
    // Include the main plugin class
    require_once EMAR_PLUGIN_PATH . 'includes/class-emar.php';
    
    // Include activator and deactivator classes
    require_once EMAR_PLUGIN_PATH . 'includes/class-emar-activator.php';
    require_once EMAR_PLUGIN_PATH . 'includes/class-emar-deactivator.php';
    
    // Run the plugin
    $plugin = new Emar();
    $plugin->run();
    
    // Create placeholder image if needed
    emar_ensure_placeholder_image();
}
add_action('plugins_loaded', 'emar_init');

/**
 * Ensure the placeholder image exists
 */
function emar_ensure_placeholder_image() {
    $placeholder_dir = EMAR_PLUGIN_PATH . 'assets/images';
    $placeholder_path = $placeholder_dir . '/placeholder.jpg';
    
    // If the placeholder image doesn't exist, create it
    if (!file_exists($placeholder_path)) {
        // Make sure the directory exists
        if (!file_exists($placeholder_dir)) {
            wp_mkdir_p($placeholder_dir);
        }
        
        // Create placeholder creator file and include it
        $placeholder_creator = EMAR_PLUGIN_PATH . 'assets/placeholder-creator.php';
        if (!file_exists($placeholder_creator)) {
            // Save the placeholder creator file
            $placeholder_content = '<?php
// Create a blank image
$image = imagecreatetruecolor(800, 600);
$bg_color = imagecolorallocate($image, 233, 30, 99);
$text_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bg_color);
imagestring($image, 5, 300, 280, "Timeline Slider", $text_color);
imagestring($image, 3, 300, 320, "Placeholder Image", $text_color);
imagejpeg($image, "' . $placeholder_path . '", 90);
imagedestroy($image);
?>';
            file_put_contents($placeholder_creator, $placeholder_content);
        }
        
        // Try to generate the image
        if (function_exists('imagecreatetruecolor')) {
            include_once $placeholder_creator;
        } else {
            // If GD is not available, create an empty file
            file_put_contents($placeholder_path, '');
        }
    }
}

/**
 * The code that runs during plugin activation.
 */
function activate_emar() {
    require_once EMAR_PLUGIN_PATH . 'includes/class-emar-activator.php';
    Emar_Activator::activate();
    
    // Ensure placeholder image on activation
    emar_ensure_placeholder_image();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'activate_emar');

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_emar() {
    require_once EMAR_PLUGIN_PATH . 'includes/class-emar-deactivator.php';
    Emar_Deactivator::deactivate();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'deactivate_emar');

/**
 * Register scripts for admin
 */
function emar_register_admin_scripts() {
    // Admin CSS
    wp_register_style(
        'emar-admin',
        EMAR_PLUGIN_URL . 'assets/css/emar-admin.css',
        [],
        EMAR_VERSION
    );
    
    // Admin JS
    wp_register_script(
        'emar-admin',
        EMAR_PLUGIN_URL . 'assets/js/emar-admin.js',
        ['jquery', 'wp-color-picker'],
        EMAR_VERSION,
        true
    );
    
    // Localize script
    wp_localize_script('emar-admin', 'emar_admin_params', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('emar-admin-nonce'),
        'required_field_message' => __('This field is required.', 'emar'),
        'media_title' => __('Select or Upload Media', 'emar'),
        'media_button' => __('Use this media', 'emar')
    ]);
}
add_action('admin_enqueue_scripts', 'emar_register_admin_scripts');

/**
 * Add settings link on plugin page
 */
function emar_add_settings_link($links) {
    $settings_link = '<a href="' . admin_url('admin.php?page=emar-settings') . '">' . __('Settings', 'emar') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . EMAR_PLUGIN_BASENAME, 'emar_add_settings_link');

/**
 * Load plugin textdomain directly if needed before the main class is initialized
 */
function emar_load_textdomain() {
    load_plugin_textdomain('emar', false, dirname(EMAR_PLUGIN_BASENAME) . '/languages/');
}
add_action('plugins_loaded', 'emar_load_textdomain', 0);