<?php
/**
 * Amp_WP_Add_Ons Class
 *
 * This is used to define AMP WP Add-ons Page.
 *
 * @link        https://pixelative.co
 * @since       1.1.0
 *
 * @package     Amp_WP_Add_Ons
 * @subpackage  Amp_WP_Add_Ons/includes
 * @author      Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class Amp_WP_Add_Ons {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
	 */
	public function __construct() {

		// Action - Add Settings Menu.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 40 );
	}

	/**
	 * Add Add-ons Page Under AMP WP Admin Menu.
	 *
	 * @since   1.1.0
	 */
	public function admin_menu() {
		add_submenu_page(
			'amp-wp-welcome', // string $parent_slug.
			'Add-ons', // string $page_title.
			'Add-ons', // string $menu_title.
			'manage_options', // string $capability.
			'amp-wp-add-ons', // string $menu_slug.
			array( $this, 'amp_wp_add_ons' ) // Callable $function.
		);
	}

	/**
	 * Add Add-ons Page.
	 *
	 * @Since   1.1.0
	 */
	public function amp_wp_add_ons() {
		$page = filter_input( INPUT_GET, 'page' );
		
		$add_ons = array(
			array(
				'box-title'       => __( 'AMP WP - Contact Form 7', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/add-ons/contact-form-7-add-on.jpg',
				'box-description' => __( 'Enable Contact Form 7 plugin support in AMP WP.', 'amp-wp' ),
				'box-cta-url'     => 'https://mailchi.mp/24a568511ae5/amp-wp-cf7',
				'box-cta-title'   => __( 'Download', 'amp-wp' ),
			),
		);
		
		require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-add-ons.php';
	}
}
new Amp_WP_Add_Ons();
