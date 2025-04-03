<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://pixelative.co
 * @since      1.0.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/includes
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
 * @package    Amp_WP
 * @subpackage Amp_WP/includes
 * @author     Pixelative <mohsin@pixelative.co>
 */
class Amp_WP {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Amp_WP_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'AMP_WP_VERSION' ) ) {
			$this->version = AMP_WP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'amp-wp';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Amp_WP_Loader. Orchestrates the hooks of the plugin.
	 * - Amp_WP_i18n. Defines internationalization functionality.
	 * - Amp_WP_Admin. Defines all hooks for the admin area.
	 * - Amp_WP_Public. Defines all hooks for the public side of the site.
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
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once AMP_WP_DIR_PATH . 'admin/class-amp-wp-admin.php';

		/**
		 * All Function Files
		 *
		 * - Formatting Functions
		 * - Core Functions
		 * - Theme Functions
		 * - Utility Functions
		 * - Template Hook
		 * - Third Party Plugins Functions
		 * - Customizer Functions
		 */
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-formatting-functions.php';
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-core-functions.php';
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-theme-functions.php';
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-utility-functions.php';
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-ad-functions.php';
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-template-hooks.php';
		require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-third-party-plugins-functions.php';
		require_once AMP_WP_DIR_PATH . 'includes/customizer/amp-wp-core-customizer.php';

		/**
		 * All Classes
		 *
		 * - AMP Rewrite Rules
		 * - DOMDocument class have all utility functions for working with PHP
		 * - Strips blacklisted tags and attributes from content
		 * - All Styles for the Plugin
		 * - All Scripts for the Plugin
		 */
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-rewrite-rules.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-redirect-router.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-custom-script.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-html-util.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-content-sanitizer.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-plugin-compatibility.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-styles.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-scripts.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-menu-walker.php';

		/**
		 * All Component interface and classes
		 *
		 * - Base Contact of the AMP Component
		 * - Base Component class
		 * - Define all components for the plugin
		 * - IMG Component
		 */
		require_once AMP_WP_DIR_PATH . 'includes/interface-amp-wp-component.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-component-base.php';
		require_once AMP_WP_DIR_PATH . 'includes/class-amp-wp-component.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once AMP_WP_DIR_PATH . 'public/class-amp-wp-public.php';

		$this->loader = new Amp_WP_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Amp_WP_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Amp_WP_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Amp_WP_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Amp_WP_Public( $this->get_plugin_name(), $this->get_version() );
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
	 * @return    Amp_WP_Loader    Orchestrates the hooks of the plugin.
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
