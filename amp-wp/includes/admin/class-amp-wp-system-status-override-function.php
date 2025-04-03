<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly
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
class Amp_WP_System_Status {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 * @param   string $plugin_name       The name of this plugin.
	 * @param   string $version    The version of this plugin.
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
			'amp-wp-welcome', // string $parent_slug
			'System Status', // string $page_title
			'System Status', // string $menu_title
			'manage_options', // string $capability
			'amp-wp-system-status', // string $menu_slug
			array( $this, 'amp_wp_system_status' ) // callable $function
		);
	}

	/**
	 * Add System Status Page.
	 *
	 * @Since   1.4.0
	 */
	public function amp_wp_system_status() {
		$page = filter_input( INPUT_GET, 'page' );
		require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-system-status.php';
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

		/**
		 * Scan the theme directory for all WC templates to see if our theme
		 * overrides any of them.
		 */
		$override_files     = array();
		$outdated_templates = false;
		$scan_files         = self::scan_template_files( AMP_WP_TEMPLATE_DIR . '/' );
		foreach ( $scan_files as $file ) {
			$located = apply_filters( 'amp_wp_get_template', $file, $file, array(), WC()->template_path(), AMP_WP_TEMPLATE_DIR . '/' );

			if ( file_exists( $located ) ) {
				$theme_file = $located;
			} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
				$theme_file = get_stylesheet_directory() . '/' . $file;
			} elseif ( file_exists( get_stylesheet_directory() . '/' . WC()->template_path() . $file ) ) {
				$theme_file = get_stylesheet_directory() . '/' . WC()->template_path() . $file;
			} elseif ( file_exists( get_template_directory() . '/' . $file ) ) {
				$theme_file = get_template_directory() . '/' . $file;
			} elseif ( file_exists( get_template_directory() . '/' . WC()->template_path() . $file ) ) {
				$theme_file = get_template_directory() . '/' . WC()->template_path() . $file;
			} else {
				$theme_file = false;
			}

			if ( ! empty( $theme_file ) ) {
				$core_version  = WC_Admin_Status::get_file_version( WC()->plugin_path() . '/templates/' . $file );
				$theme_version = WC_Admin_Status::get_file_version( $theme_file );
				if ( $core_version && ( empty( $theme_version ) || version_compare( $theme_version, $core_version, '<' ) ) ) {
					if ( ! $outdated_templates ) {
						$outdated_templates = true;
					}
				}
				$override_files[] = array(
					'file'         => str_replace( WP_CONTENT_DIR . '/themes/', '', $theme_file ),
					'version'      => $theme_version,
					'core_version' => $core_version,
				);
			}
		}

		$active_theme_info = array(
			'name'           => $active_theme->name,
			'version'        => $active_theme->version,
			'version_latest' => self::get_latest_theme_version( $active_theme ),
			'author_url'     => esc_url_raw( $active_theme->{'Author URI'} ),
			'is_child_theme' => is_child_theme(),
			/*
			'has_woocommerce_support' => current_theme_supports( 'woocommerce' ),
			'has_woocommerce_file'    => ( file_exists( get_stylesheet_directory() . '/woocommerce.php' ) || file_exists( get_template_directory() . '/woocommerce.php' ) ),
			'has_outdated_templates'  => $outdated_templates,
			'overrides'               => $override_files,
			*/
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
