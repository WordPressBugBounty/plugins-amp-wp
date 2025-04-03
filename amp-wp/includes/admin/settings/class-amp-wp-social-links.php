<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly
/**
 * Amp_WP_Social_Links Class
 *
 * This is used to define AMP WP Social Links setting.
 *
 * @link        http://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP_Social_Links
 * @subpackage  Amp_WP_Social_Links/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Social_Links {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {

		// Filter -> Add Social Links Settings Tab
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_social_links_tab' ) );

		// Action -> Display Social Links Settings.
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_social_links_settings' ) );

		// Action -> Save Social Links Settings.
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_social_links_settings' ) );
	}

	/**
	 * Add Social Links Settings Tab
	 *
	 * @since   1.4.0
	 *
	 * @param   array $tabs  Settings Tab.
	 * @return  array  $tabs  Merge array of Settings Tab with Social Links Tab.
	 */
	public function amp_wp_add_social_links_tab( $tabs ) {

		$tabs['social-links'] = __( '<i class="amp-wp-admin-icon-hyperlink"></i><span>Social Links</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Social Links Settings
	 *
	 * This function is used to display stored Social Links settings.
	 *
	 * @since   1.4.0
	 */
	public function amp_wp_add_social_links_settings() {

		$facebook_switch  = '';
		$facebook         = '';
		$twitter          = '';
		$twitter_switch   = '';
		$pinterest        = '';
		$pinterest_switch = '';
		$instagram        = '';
		$instagram_switch = '';
		$linkedin         = '';
		$linkedin_switch  = '';
		$youtube          = '';
		$youtube_switch   = '';
		$email            = '';
		$email_switch     = '';

		if ( get_option( 'amp_wp_social_links_settings' ) ) {

			$amp_wp_social_links_settings = get_option( 'amp_wp_social_links_settings' );

			$facebook_switch = ( isset( $amp_wp_social_links_settings['facebook_switch'] ) && ! empty( $amp_wp_social_links_settings['facebook_switch'] ) ) ? $amp_wp_social_links_settings['facebook_switch'] : '';
			$facebook        = ( isset( $amp_wp_social_links_settings['facebook'] ) && ! empty( $amp_wp_social_links_settings['facebook'] ) ) ? $amp_wp_social_links_settings['facebook'] : '';

			$twitter_switch = ( isset( $amp_wp_social_links_settings['twitter_switch'] ) && ! empty( $amp_wp_social_links_settings['twitter_switch'] ) ) ? $amp_wp_social_links_settings['twitter_switch'] : '';
			$twitter        = ( isset( $amp_wp_social_links_settings['twitter'] ) && ! empty( $amp_wp_social_links_settings['twitter'] ) ) ? $amp_wp_social_links_settings['twitter'] : '';

			$pinterest_switch = ( isset( $amp_wp_social_links_settings['pinterest_switch'] ) && ! empty( $amp_wp_social_links_settings['pinterest_switch'] ) ) ? $amp_wp_social_links_settings['pinterest_switch'] : '';
			$pinterest        = ( isset( $amp_wp_social_links_settings['pinterest'] ) && ! empty( $amp_wp_social_links_settings['pinterest'] ) ) ? $amp_wp_social_links_settings['pinterest'] : '';

			$instagram_switch = ( isset( $amp_wp_social_links_settings['instagram_switch'] ) && ! empty( $amp_wp_social_links_settings['instagram_switch'] ) ) ? $amp_wp_social_links_settings['instagram_switch'] : '';
			$instagram        = ( isset( $amp_wp_social_links_settings['instagram'] ) && ! empty( $amp_wp_social_links_settings['instagram'] ) ) ? $amp_wp_social_links_settings['instagram'] : '';

			$linkedin_switch = ( isset( $amp_wp_social_links_settings['linkedin_switch'] ) && ! empty( $amp_wp_social_links_settings['linkedin_switch'] ) ) ? $amp_wp_social_links_settings['linkedin_switch'] : '';
			$linkedin        = ( isset( $amp_wp_social_links_settings['linkedin'] ) && ! empty( $amp_wp_social_links_settings['linkedin'] ) ) ? $amp_wp_social_links_settings['linkedin'] : '';

			$youtube_switch = ( isset( $amp_wp_social_links_settings['youtube_switch'] ) && ! empty( $amp_wp_social_links_settings['youtube_switch'] ) ) ? $amp_wp_social_links_settings['youtube_switch'] : '';
			$youtube        = ( isset( $amp_wp_social_links_settings['youtube'] ) && ! empty( $amp_wp_social_links_settings['youtube'] ) ) ? $amp_wp_social_links_settings['youtube'] : '';

			$email_switch = ( isset( $amp_wp_social_links_settings['email_switch'] ) && ! empty( $amp_wp_social_links_settings['email_switch'] ) ) ? $amp_wp_social_links_settings['email_switch'] : '';
			$email        = ( isset( $amp_wp_social_links_settings['email'] ) && ! empty( $amp_wp_social_links_settings['email'] ) ) ? $amp_wp_social_links_settings['email'] : '';

		}

		// Load View
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-social-links.php';
	}

	/**
	 * Save Social Links Settings
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_save_social_links_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		$amp_wp_social_links_settings = filter_input_array( INPUT_POST );

		if ( $amp_wp_social_links_settings ) :
			foreach ( $amp_wp_social_links_settings as $key => $value ) {
				if ( strstr( $key, 'social_links_settings' ) ) {
					if ( isset( $value['facebook_switch'] ) ) {
						$value['facebook_switch'] = 1;
					}

					if ( isset( $value['twitter_switch'] ) ) {
						$value['twitter_switch'] = 1;
					}

					if ( isset( $value['pinterest_switch'] ) ) {
						$value['pinterest_switch'] = 1;
					}

					if ( isset( $value['instagram_switch'] ) ) {
						$value['instagram_switch'] = 1;
					}

					if ( isset( $value['linkedin_switch'] ) ) {
						$value['linkedin_switch'] = 1;
					}

					if ( isset( $value['youtube_switch'] ) ) {
						$value['youtube_switch'] = 1;
					}

					if ( isset( $value['email_switch'] ) ) {
						$value['email_switch'] = 1;
					}

					update_option( sanitize_key( $key ), $value );
				}
			}
		endif;
	}
}
new Amp_WP_Social_Links();
