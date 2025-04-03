<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly
/**
 * Amp_WP_GDPR Class
 *
 * This is used to define AMP WP GDBR setting.
 *
 * @link        http://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP_GDPR
 * @subpackage  Amp_WP_GDPR/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_GDPR {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {

		// Filter -> Add GDPR Settings Tab
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_gdpr_tab' ) );

		// Action -> Display GDPR Settings
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_gdpr_settings' ) );

		// Action -> Save GDPR Settings
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_gdpr_settings' ) );
	}

	/**
	 * Add GDPR Settings Tab
	 *
	 * @since   1.4.0
	 *
	 * @param   array $tabs  Settings Tab
	 * @return  array  $tabs  Merge array of Settings Tab with Notice Bar & GDPR Tab.
	 */
	public function amp_wp_add_gdpr_tab( $tabs ) {

		$tabs['gdpr'] = __( '<i class="amp-wp-admin-icon-information-white"></i><span>GDPR</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display GDPR Settings
	 *
	 * This function is used to display stored Notice Bar & GDPR settings.
	 *
	 * @since       1.1.0
	 */
	public function amp_wp_add_gdpr_settings() {

		// Get GDPR Values
		$gdpr_switch                   = '';
		$gdpr_headline_text            = '';
		$gdpr_message                  = '';
		$gdpr_accept_button_text       = '';
		$gdpr_reject_button_text       = '';
		$gdpr_for_more_privacy_info    = '';
		$gdpr_privacy_page             = 0;
		$gdpr_privacy_page_button_text = '';

		if ( get_option( 'amp_wp_gdpr_settings' ) ) {
			$amp_wp_gdpr_settings          = get_option( 'amp_wp_gdpr_settings' );
			$gdpr_switch                   = ( isset( $amp_wp_gdpr_settings['gdpr_switch'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_switch'] ) ) ? $amp_wp_gdpr_settings['gdpr_switch'] : '';
			$gdpr_headline_text            = ( isset( $amp_wp_gdpr_settings['headline_text'] ) && ! empty( $amp_wp_gdpr_settings['headline_text'] ) ) ? $amp_wp_gdpr_settings['headline_text'] : '';
			$gdpr_message                  = ( isset( $amp_wp_gdpr_settings['gdpr_message'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_message'] ) ) ? $amp_wp_gdpr_settings['gdpr_message'] : '';
			$gdpr_accept_button_text       = ( isset( $amp_wp_gdpr_settings['gdpr_accept_button_text'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_accept_button_text'] ) ) ? $amp_wp_gdpr_settings['gdpr_accept_button_text'] : '';
			$gdpr_reject_button_text       = ( isset( $amp_wp_gdpr_settings['gdpr_reject_button_text'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_reject_button_text'] ) ) ? $amp_wp_gdpr_settings['gdpr_reject_button_text'] : '';
			$gdpr_for_more_privacy_info    = ( isset( $amp_wp_gdpr_settings['gdpr_for_more_privacy_info'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_for_more_privacy_info'] ) ) ? $amp_wp_gdpr_settings['gdpr_for_more_privacy_info'] : '';
			$gdpr_privacy_page             = ( isset( $amp_wp_gdpr_settings['gdpr_privacy_page'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_privacy_page'] ) ) ? $amp_wp_gdpr_settings['gdpr_privacy_page'] : 0;
			$gdpr_privacy_page_button_text = ( isset( $amp_wp_gdpr_settings['gdpr_privacy_page_button_text'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_privacy_page_button_text'] ) ) ? $amp_wp_gdpr_settings['gdpr_privacy_page_button_text'] : '';
		}

		// Set Arguments for Dropdown Pages
		$args = array(
			'depth'                 => 0,
			'child_of'              => 0,
			'selected'              => $gdpr_privacy_page,
			'echo'                  => 1,
			'name'                  => 'amp_wp_gdpr_settings[gdpr_privacy_page]',
			'id'                    => 'gdpr_privacy_page', // string
			'class'                 => 'amp-wp-select', // string
			'show_option_none'      => amp_wp_translation_get( 'select-the-privacy-page' ), // string
			'show_option_no_change' => null, // string
			'option_none_value'     => null, // string
		);

		// Load View
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-gdpr.php';
	}

	/**
	 * Save GDPR Settings
	 *
	 * @since   1.4.0
	 */
	public function amp_wp_save_gdpr_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		$amp_wp_gdpr_settings = filter_input_array( INPUT_POST );

		if ( $amp_wp_gdpr_settings ) :
			foreach ( $amp_wp_gdpr_settings as $key => $value ) {
				if ( strstr( $key, 'gdpr_settings' ) ) {
					if ( isset( $value['gdpr_switch'] ) ) {
						$value['gdpr_switch'] = 1;
					}
					update_option( sanitize_key( $key ), $value );
				}
			}
		endif;

		remove_theme_mod( 'amp-wp-gdpr-compliance' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-headline-text' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-textarea' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-accept-button-text' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-reject-button-text' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-settings-text' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-for-more-privacy-info' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-select-privacy-page' );
		remove_theme_mod( 'amp-wp-gdpr-compliance-privacy-page-button-text' );
	}
}
new Amp_WP_GDPR();
