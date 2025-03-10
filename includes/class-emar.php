<?php
/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    Emar
 * @subpackage Emar/includes
 */

class Emar {

    /**
     * The loader that's responsible for maintaining and registering all hooks.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Emar_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('EMAR_VERSION')) {
            $this->version = EMAR_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'emar';

        $this->load_dependencies();
        $this->set_locale();
        $this->register_widgets();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once EMAR_PLUGIN_PATH . 'includes/class-emar-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once EMAR_PLUGIN_PATH . 'includes/class-emar-i18n.php';

        /**
         * Create a new loader instance
         */
        $this->loader = new Emar_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new Emar_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());
        
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register Elementor widgets
     *
     * @since 1.0.0
     * @access private
     */
    private function register_widgets() {
        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'register_emar_widgets']);
        
        // Register widget scripts and styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
        
        // Register widget categories
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }

    /**
     * Register Emar widgets with Elementor
     */
    public function register_emar_widgets() {
        // Make sure the Elementor autoloader is ready
        if (!class_exists('\\Elementor\\Widget_Base')) {
            return;
        }
        
        // Include widget files
        require_once EMAR_PLUGIN_PATH . 'widgets/class-emar-timeline-slider.php';
        
        // Register the widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Emar_Timeline_Slider());
    }

    /**
     * Register widget styles
     */
    public function widget_styles() {
        wp_register_style('emar-public', EMAR_PLUGIN_URL . 'assets/css/emar-public.css', [], $this->version);
        wp_enqueue_style('emar-public');
    }

    /**
     * Register widget scripts
     */
    public function widget_scripts() {
        wp_register_script('emar-public', EMAR_PLUGIN_URL . 'assets/js/emar-public.js', ['jquery'], $this->version, true);
        wp_localize_script('emar-public', 'emarParams', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('emar-nonce')
        ]);
    }

    /**
     * Add a custom category for Emar widgets
     */
    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'emar',
            [
                'title' => __('Emar', 'emar'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        // Admin specific hooks
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_admin_styles');
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_admin_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        // Public facing hooks
        $this->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_public_styles');
        $this->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_public_scripts');
    }

    /**
     * Enqueue admin styles
     */
    public function enqueue_admin_styles() {
        wp_enqueue_style('emar-admin', EMAR_PLUGIN_URL . 'assets/css/emar-admin.css', [], $this->version, 'all');
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_script('emar-admin', EMAR_PLUGIN_URL . 'assets/js/emar-admin.js', ['jquery'], $this->version, true);
    }

    /**
     * Enqueue public styles
     */
    public function enqueue_public_styles() {
        // Only enqueue in frontend, not in admin
        if (!is_admin()) {
            wp_enqueue_style('emar-public');
        }
    }

    /**
     * Enqueue public scripts
     */
    public function enqueue_public_scripts() {
        // Only enqueue in frontend, not in admin
        if (!is_admin()) {
            wp_enqueue_script('emar-public');
        }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Emar_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}