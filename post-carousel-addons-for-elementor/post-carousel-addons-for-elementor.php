<?php
/**
 * Plugin Name: Post Carousel Addons For Elementor
 * Description: Post Carousel Slider for Elementor Lets you display your WordPress Posts as Slider. You can now show your posts using this plugin easily to your users as a Carousel Slider
 * Author: QualArch
 * Author URI: https://www.qualarch.com/
 * Version: 1.0.9
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: post-carousel-addons-for-elementor
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

final class Post_Carousel_Addons_For_Elementor {

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.9';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.5.11';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '6.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * The single instance of the class.
     */
    protected static $instance = null;

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */

    protected function __construct() {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }
        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        require_once('inc/custom_function.php');
        require_once('widgets/post-carousel-addons.php');

        // Register Widget
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

        // Register Widget Styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
    }

    public static function get_instance() {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public function register_widgets() {
        \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Post_Carousel_Addons());
    }

    public function widget_styles() {
        wp_enqueue_style('eshuzu_slick_style', plugins_url('assets/slick/slick.css', __FILE__), false, rand());
        wp_enqueue_style('eshuzu-widget-stylesheet', plugins_url('assets/css/post-carousel-addons-for-elementor.css', __FILE__), false, self::VERSION);
    }

    public function widget_scripts() {
        wp_enqueue_script('eshuzu_slick_js', plugins_url('assets/slick/slick.min.js', __FILE__), array('jquery'), '1.0.4', true);
        wp_enqueue_script('eshuzu_custom_script', plugins_url('assets/js/app.js', __FILE__), array('jquery'), self::VERSION, true);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin() {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'post-carousel-addons-for-elementor'),
            '<strong>' . esc_html__('Post Carousel Addons For Elementor', 'post-carousel-addons-for-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'post-carousel-addons-for-elementor') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'post-carousel-addons-for-elementor'),
            '<strong>' . esc_html__('Post Carousel Addons For Elementor', 'post-carousel-addons-for-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'post-carousel-addons-for-elementor') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version() {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'post-carousel-addons-for-elementor'),
            '<strong>' . esc_html__('Post Carousel Addons For Elementor', 'post-carousel-addons-for-elementor') . '</strong>',
            '<strong>' . esc_html__('PHP', 'post-carousel-addons-for-elementor') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

}

add_action('init', 'eshuzu_pcae_elementor_init');
function eshuzu_pcae_elementor_init() {
    Post_Carousel_Addons_For_Elementor::get_instance();
}

    