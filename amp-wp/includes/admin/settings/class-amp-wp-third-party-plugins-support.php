<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly
/**
 * Amp_WP_Third_Party_Plugins_Support Class
 *
 * This is used to define AMP WP Structured Data setting.
 *
 * @link        http://pixelative.co
 * @since       1.5.11
 *
 * @package     Amp_WP_Third_Party_Plugins_Support
 * @subpackage  Amp_WP_Third_Party_Plugins_Support/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Third_Party_Plugins_Support {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.5.11
	 */
	public function __construct() {

		// Filter -> Add Structured Data Settings Tab.
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_third_party_plugins_support_tab' ) );

		// Action -> Display Structured Data Settings.
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_third_party_plugins_support_settings' ) );

		// Action -> Save Structured Data Settings.
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_third_party_plugins_support_settings' ) );
	}

	/**
	 * Add Structured Data Settings Tab
	 *
	 * @since   1.5.11
	 *
	 * @param   array $tabs  Settings Tab.
	 * @return  array  $tabs  Merge array of Settings Tab with Structured Data Tab.
	 */
	public function amp_wp_add_third_party_plugins_support_tab( $tabs ) {

		$tabs['third-party-plugins-support'] = __( '<i class="amp-wp-admin-icon-grid-alt"></i><span>3rd Party Plugins</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Structured Data Settings
	 *
	 * This function is used to display Structured Data settings.
	 *
	 * @since       1.5.11
	 */
	public function amp_wp_add_third_party_plugins_support_settings() {

		$onesignal_switch              = '';
		$onesignal_app_id              = '';
		$onesignal_position            = '';
		$positions                     = array(
			'below_the_content' => 'Below the Content',
			'above_the_content' => 'Above the Content',
		);
		$onesignal_http_site_switch    = '';
		$onesignal_http_site_subdomain = '';

		if ( get_option( 'amp_wp_third_party_plugins_support_settings' ) ) {
			$amp_wp_third_party_plugins_support_settings = get_option( 'amp_wp_third_party_plugins_support_settings' );
			$onesignal_switch                            = ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_switch'] ) && ! empty( $amp_wp_third_party_plugins_support_settings['onesignal_switch'] ) ) ? $amp_wp_third_party_plugins_support_settings['onesignal_switch'] : '';
			$onesignal_app_id                            = ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_app_id'] ) && ! empty( $amp_wp_third_party_plugins_support_settings['onesignal_app_id'] ) ) ? $amp_wp_third_party_plugins_support_settings['onesignal_app_id'] : '';
			$onesignal_position                          = ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_position'] ) && ! empty( $amp_wp_third_party_plugins_support_settings['onesignal_position'] ) ) ? $amp_wp_third_party_plugins_support_settings['onesignal_position'] : '';
			$onesignal_http_site_switch                  = ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_http_site_switch'] ) && ! empty( $amp_wp_third_party_plugins_support_settings['onesignal_http_site_switch'] ) ) ? $amp_wp_third_party_plugins_support_settings['onesignal_http_site_switch'] : '';
			$onesignal_http_site_subdomain               = ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_http_site_subdomain'] ) && ! empty( $amp_wp_third_party_plugins_support_settings['onesignal_app_id'] ) ) ? $amp_wp_third_party_plugins_support_settings['onesignal_http_site_subdomain'] : '';
		}

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-third-party-plugins-support.php';
	}

	/**
	 * Save Structured Data Settings
	 *
	 * @since   1.5.11
	 */
	public function amp_wp_save_third_party_plugins_support_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		$amp_wp_third_party_plugins_support_settings = filter_input_array( INPUT_POST );
		if ( $amp_wp_third_party_plugins_support_settings ) :
			foreach ( $amp_wp_third_party_plugins_support_settings as $key => $value ) {
				if ( strstr( $key, 'third_party_plugins_support_settings' ) ) {
					if ( isset( $value['onesignal_switch'] ) ) {
						$value['onesignal_switch'] = 1;
					}
					if ( isset( $value['onesignal_http_site_switch'] ) ) {
						$value['onesignal_http_site_switch'] = 1;
					}
					update_option( sanitize_key( $key ), $value );
				}
			}
		endif;
	}
}
new Amp_WP_Third_Party_Plugins_Support();
