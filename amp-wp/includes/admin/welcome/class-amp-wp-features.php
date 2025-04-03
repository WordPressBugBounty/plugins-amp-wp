<?php
/**
 * Amp_WP_Features Class
 *
 * This is used to define AMP WP Features Section.
 *
 * @link            https://pixelative.co
 * @since           1.4.0
 *
 * @package         Amp_WP_Features
 * @subpackage      Amp_WP_Features/includes
 * @author          Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class Amp_WP_Features {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.4.0
	 */
	public function __construct() {

		// Filter -> Add Features Tab.
		add_filter( 'amp_wp_welcome_tab_menus', array( $this, 'amp_wp_add_features_tab' ) );

		// Action -> Display Features.
		add_action( 'amp_wp_welcome_tab_section', array( $this, 'amp_wp_add_features_settings' ) );
	}

	/**
	 * Add Features Tab
	 *
	 * @since       1.4.0
	 *
	 * @param       array $tabs  Features Tab.
	 * @return      array  $tabs  Merge array of Welcome Tab with Features Tab.
	 */
	public function amp_wp_add_features_tab( $tabs ) {
		$tabs['features'] = __( '<i class="amp-wp-admin-icon-newspaper-alt"></i><span>Features</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Features
	 *
	 * This function is used to display Features section.
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_add_features_settings() {

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/welcome/amp-wp-admin-features.php';
	}
}
new Amp_WP_Features();
