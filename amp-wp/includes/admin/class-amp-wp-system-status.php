<?php
/**
 * Amp_WP_System_Status Class
 *
 * This is used to define AMP WP System Status Page.
 *
 * @link        http://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP_System_Status
 * @subpackage  Amp_WP_System_Status/includes
 * @author      Pixelative <mohsin@pixelative.co>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly

class Amp_WP_System_Status {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {

		// Action - Add System Status Menu.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 50 );
	}

	/**
	 * Add System Status Menu Under AMP WP Admin Menu.
	 *
	 * @since   1.4.0
	 */
	public function admin_menu() {
		add_submenu_page(
			'amp-wp-welcome', // string $parent_slug.
			'System Status', // string $page_title.
			'System Status', // string $menu_title.
			'manage_options', // string $capability.
			'amp-wp-system-status', // string $menu_slug.
			array( $this, 'amp_wp_system_status' ) // callable $function.
		);
	}

	/**
	 * Add System Status Page.
	 *
	 * @Since   1.4.0
	 */
	public function amp_wp_system_status() {
		$page        = filter_input( INPUT_GET, 'page' );
		$environment = $this->get_environment_info();
		$theme       = $this->get_theme_info();
		require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-system-status.php';
	}

	/**
	 * Get array of environment information. Includes thing like software
	 * versions, and various server settings.
	 *
	 * @return array
	 */
	public function get_environment_info() {
		global $wpdb;

		// Figure out cURL version, if installed.
		$curl_version = '';
		if ( function_exists( 'curl_version' ) ) {
			$curl_version = curl_version();
			$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
		}

		// WP memory limit.
		$wp_memory_limit = amp_wp_let_to_num( WP_MEMORY_LIMIT );
		if ( function_exists( 'memory_get_usage' ) ) {
			$wp_memory_limit = max( $wp_memory_limit, amp_wp_let_to_num( @ini_get( 'memory_limit' ) ) );
		}

		// Test POST requests.
		$post_response            = wp_safe_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'decompress' => false,
				'user-agent' => 'amp-wp-remote-post-test',
			)
		);
		$post_response_successful = false;
		if ( ! is_wp_error( $post_response ) && $post_response['response']['code'] >= 200 && $post_response['response']['code'] < 300 ) {
			$post_response_successful = true;
		}

		// Test GET requests.
		$get_response            = wp_safe_remote_get(
			'https://ampwp.io/',
			array(
				'decompress' => false,
				'user-agent' => 'amp-wp-remote-get-test',
			)
		);
		$get_response_successful = false;
		if ( ! is_wp_error( $post_response ) && $post_response['response']['code'] >= 200 && $post_response['response']['code'] < 300 ) {
			$get_response_successful = true;
		}

		$database_version = amp_wp_get_server_database_version();

		// Return all environment info. Described by JSON Schema.
		return array(
			'home_url'                  => get_option( 'home' ),
			'site_url'                  => get_option( 'siteurl' ),
			'version'                   => AMP_WP_VERSION,
			'wp_version'                => get_bloginfo( 'version' ),
			'wp_multisite'              => is_multisite(),
			'wp_memory_limit'           => $wp_memory_limit,
			'wp_debug_mode'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
			'wp_cron'                   => ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ),
			'language'                  => get_locale(),
			'external_object_cache'     => wp_using_ext_object_cache(),
			'server_info'               => isset( $_SERVER['SERVER_SOFTWARE'] ) ? amp_wp_clean( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '',
			'php_version'               => phpversion(),
			'php_post_max_size'         => amp_wp_let_to_num( ini_get( 'post_max_size' ) ),
			'php_max_execution_time'    => ini_get( 'max_execution_time' ),
			'php_max_input_vars'        => ini_get( 'max_input_vars' ),
			'curl_version'              => $curl_version,
			'suhosin_installed'         => extension_loaded( 'suhosin' ),
			'max_upload_size'           => wp_max_upload_size(),
			'mysql_version'             => $database_version['number'],
			'mysql_version_string'      => $database_version['string'],
			'default_timezone'          => date_default_timezone_get(),
			'fsockopen_or_curl_enabled' => ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ),
			'soapclient_enabled'        => class_exists( 'SoapClient' ),
			'domdocument_enabled'       => class_exists( 'DOMDocument' ),
			'gzip_enabled'              => is_callable( 'gzopen' ),
			'mbstring_enabled'          => extension_loaded( 'mbstring' ),
			'remote_post_successful'    => $post_response_successful,
			'remote_post_response'      => ( is_wp_error( $post_response ) ? $post_response->get_error_message() : $post_response['response']['code'] ),
			'remote_get_successful'     => $get_response_successful,
			'remote_get_response'       => ( is_wp_error( $get_response ) ? $get_response->get_error_message() : $get_response['response']['code'] ),
		);
	}

	/**
	 * Get info on the current active theme, info on parent theme (if present)
	 * and a list of template overrides.
	 *
	 * @return array
	 */
	public function get_theme_info() {
		$active_theme = wp_get_theme();

		// Get parent theme info if this theme is a child theme, otherwise
		// pass empty info in the response.
		if ( is_child_theme() ) {
			$parent_theme      = wp_get_theme( $active_theme->template );
			$parent_theme_info = array(
				'parent_name'           => $parent_theme->name,
				'parent_version'        => $parent_theme->version,
				'parent_version_latest' => self::get_latest_theme_version( $parent_theme ),
				'parent_author_url'     => $parent_theme->{'Author URI'},
			);
		} else {
			$parent_theme_info = array(
				'parent_name'           => '',
				'parent_version'        => '',
				'parent_version_latest' => '',
				'parent_author_url'     => '',
			);
		}

		$active_theme_info = array(
			'name'           => $active_theme->name,
			'version'        => $active_theme->version,
			'version_latest' => self::get_latest_theme_version( $active_theme ),
			'author_url'     => esc_url_raw( $active_theme->{'Author URI'} ),
			'is_child_theme' => is_child_theme(),
		);

		return array_merge( $active_theme_info, $parent_theme_info );
	}

	/**
	 * Get latest version of a theme by slug.
	 *
	 * @param  object $theme WP_Theme object.
	 * @return string Version number if found.
	 */
	public static function get_latest_theme_version( $theme ) {
		include_once ABSPATH . 'wp-admin/includes/theme.php';

		$api = themes_api(
			'theme_information',
			array(
				'slug'   => $theme->get_stylesheet(),
				'fields' => array(
					'sections' => false,
					'tags'     => false,
				),
			)
		);

		$update_theme_version = 0;

		// Check .org for updates.
		if ( is_object( $api ) && ! is_wp_error( $api ) ) {
			$update_theme_version = $api->version;
		}

		return $update_theme_version;
	}
}
new Amp_WP_System_Status();
