<?php
/**
 * Amp_WP_Credits Class
 *
 * This is used to define AMP WP Credits Section.
 *
 * @link            https://pixelative.co
 * @since           1.4.0
 *
 * @package         Amp_WP_Credits
 * @subpackage      Amp_WP_Credits/includes
 * @author          Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class Amp_WP_Credits {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.4.0
	 */
	public function __construct() {

		// Filter -> Add Credits Tab.
		add_filter( 'amp_wp_welcome_tab_menus', array( $this, 'amp_wp_add_credits_tab' ) );

		// Action -> Display Credits.
		add_action( 'amp_wp_welcome_tab_section', array( $this, 'amp_wp_add_credits_settings' ) );
	}

	/**
	 * Add Credits Tab
	 *
	 * @since       1.4.0
	 *
	 * @param       array $tabs  Credits Tab.
	 * @return      array  $tabs  Merge array of Welcome Tab with Credits Tab.
	 */
	public function amp_wp_add_credits_tab( $tabs ) {

		$tabs['credits'] = __( '<i class="amp-wp-admin-icon-users"></i><span>Credits</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Credits
	 *
	 * This function is used to display Credits section.
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_add_credits_settings() {

		$credit_leader = array(
			'0' => array(
				'name'  => __( 'Mohsin Rafique', 'neovantage-core' ),
				'role'  => 'Backend Engineer',
				'email' => 'mohsin.rafique@gmail.com',
				'url'   => 'https://profiles.wordpress.org/mohsinrafique',
			),
			'1' => array(
				'name'  => 'Arslan Akram',
				'role'  => 'Frontend Engineer',
				'email' => 'arslan@pixelative.co',
				'url'   => 'https://profiles.wordpress.org/arslanakram',
			),
		);

		$credit_team = array(
			'0' => array(
				'name'  => 'Wijdan Akram',
				'role'  => 'UI/UX Designer',
				'email' => 'wijdanakram@hotmail.com',
				'url'   => 'https://www.behance.net/wijdanakram',
			),
			'1' => array(
				'name'  => 'Nashmia Adnan',
				'role'  => 'Copy Writer',
				'email' => 'nashmiaadnan67@gmail.com',
				'url'   => 'https://www.linkedin.com/in/nashmia-adnan',
			),
		);

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/welcome/amp-wp-admin-credits.php';
	}
}
new Amp_WP_Credits();
