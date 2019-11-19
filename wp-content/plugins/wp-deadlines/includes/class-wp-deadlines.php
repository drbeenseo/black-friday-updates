<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://themesgrove.com/
 * @since      1.0.0
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/includes
 * @author     themesgrove <rafiqul@themexpert.com>
 */
class WP_Deadlines {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Deadlines_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-deadlines';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

        WP_Deadlines_Shortcode::init();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Deadlines_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Deadlines_i18n. Defines internationalization functionality.
	 * - WP_Deadlines_Admin. Defines all hooks for the admin area.
	 * - WP_Deadlines_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-deadlines-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-deadlines-i18n.php';

        /**
         * The class responsible for defining CMB2 tabs
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/cmb2-tabs/cmb2-tabs.php';

        /**
         * The file responsible for defining switcher metabox field.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/cmb2-switch/switch-metafield.php';

        /**
         * The file responsible for defining conditional metabox field.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/cmb2-conditionals/cmb2-conditionals.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-deadlines-admin.php';

        /**
         * The class responsible for defining widget.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-deadlines-widget.php';

		/**
		 * Countdown Shortcode
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-deadlines-shortcode.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-deadlines-public.php';

		$this->loader = new WP_Deadlines_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Deadlines_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP_Deadlines_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

    public static function deadline_pro_active() {
        return in_array( 'wp-deadlines-pro/wp-deadlines-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
    }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WP_Deadlines_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_admin, 'register_post_type' );
		$this->loader->add_action( 'cmb2_init', $plugin_admin, 'register_countdown_metabox' );
		$this->loader->add_action( 'new_to_publish', $plugin_admin, 'add_custom_field_automatically' );
		$this->loader->add_action( 'draft_to_publish', $plugin_admin, 'add_custom_field_automatically' );
		$this->loader->add_action( 'auto-draft_to_publish', $plugin_admin, 'add_custom_field_automatically' );
		$this->loader->add_action( 'pending_to_publish', $plugin_admin, 'add_custom_field_automatically' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'rest_api_init', $plugin_admin, 'rest_route');

        $this->loader->add_filter( 'mce_external_plugins', $plugin_admin, 'add_buttons' );
        $this->loader->add_filter( 'mce_buttons', $plugin_admin, 'register_buttons' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP_Deadlines_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enable_flyout' );
		$this->loader->add_action( 'wp', $plugin_public, 'process_gif_url' );

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
	 * @return    WP_Deadlines_Loader    Orchestrates the hooks of the plugin.
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
