<?php
/**
 * Amp_WP_Help Class
 *
 * This is used to define AMP WP Help Page.
 *
 * @link        https://pixelative.co
 * @since       1.2.0
 *
 * @package     Amp_WP_Help
 * @subpackage  Amp_WP_Help/includes
 * @author      Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class Amp_WP_Help {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.2.0
	 */
	public function __construct() {

		// Action - Add Settings Menu.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 50 );
	}

	/**
	 * Add Add-ons Page Under AMP WP Admin Menu.
	 *
	 * @since   1.2.0
	 */
	public function admin_menu() {
		add_submenu_page(
			'amp-wp-welcome', // string $parent_slug.
			'Help', // string $page_title.
			'Help', // string $menu_title.
			'manage_options', // string $capability.
			'amp-wp-help', // string $menu_slug.
			array( $this, 'amp_wp_help' ) // callable $function.
		);
	}

	/**
	 * Add Add-ons Page.
	 *
	 * @Since   1.2.0
	 */
	public function amp_wp_help() {
		$page = filter_input( INPUT_GET, 'page' );
		require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-help.php';
	}
}
new Amp_WP_Help();
