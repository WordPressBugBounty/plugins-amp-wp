<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly
/**
 * Amp_WP_Structured_Data Class
 *
 * This is used to define AMP WP Structured Data setting.
 *
 * @link        http://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP_Structured_Data
 * @subpackage  Amp_WP_Structured_Data/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Structured_Data {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {

		// Filter -> Add Structured Data Settings Tab
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_structured_data_tab' ) );

		// Action -> Display Structured Data Settings
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_structured_data_settings' ) );

		// Action -> Save Structured Data Settings
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_structured_data_settings' ) );
	}

	/**
	 * Add Structured Data Settings Tab
	 *
	 * @since   1.4.0
	 *
	 * @param   array $tabs  Settings Tab
	 * @return  array  $tabs  Merge array of Settings Tab with Structured Data Tab.
	 */
	public function amp_wp_add_structured_data_tab( $tabs ) {

		$tabs['structured-data'] = __( '<i class="amp-wp-admin-icon-grid-alt"></i><span>Structured Data</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Structured Data Settings
	 *
	 * This function is used to display Structured Data settings.
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_add_structured_data_settings() {

		$structured_data_switch = '';
		$structured_post_type   = array();
		$schema_type_for_post   = '';
		$schema_type            = array(
			'Article'     => 'Article',
			'NewsArticle' => 'NewsArticle',
			'BlogPosting' => 'BlogPosting',
		);

		if ( get_option( 'amp_wp_structured_data_settings' ) ) {
			$amp_wp_structured_data_settings = get_option( 'amp_wp_structured_data_settings' );
			$structured_data_switch          = ( isset( $amp_wp_structured_data_settings['structured_data_switch'] ) && ! empty( $amp_wp_structured_data_settings['structured_data_switch'] ) ) ? $amp_wp_structured_data_settings['structured_data_switch'] : '';
			$schema_type_for_post            = ( isset( $amp_wp_structured_data_settings['schema_type_for_post'] ) && ! empty( $amp_wp_structured_data_settings['schema_type_for_post'] ) ) ? $amp_wp_structured_data_settings['schema_type_for_post'] : 'BlogPosting';
		}

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-structured-data.php';
	}

	/**
	 * Save Structured Data Settings
	 *
	 * @since   1.4.0
	 */
	public function amp_wp_save_structured_data_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		$amp_wp_structured_data_settings = filter_input_array( INPUT_POST );
		if ( $amp_wp_structured_data_settings ) :
			foreach ( $amp_wp_structured_data_settings as $key => $value ) {
				if ( strstr( $key, 'structured_data_settings' ) ) {
					if ( isset( $value['structured_data_switch'] ) ) {
						$value['structured_data_switch'] = 1;
					}
					update_option( sanitize_key( $key ), $value );
				}
			}
		endif;
	}
}
new Amp_WP_Structured_Data();
