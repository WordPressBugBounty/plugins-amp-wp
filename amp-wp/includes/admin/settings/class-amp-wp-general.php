<?php
/**
 * Amp_WP_General Class
 *
 * This is used to define AMP WP General setting.
 *
 * @link            http://pixelative.co
 * @since           1.0.4
 *
 * @package     Amp_WP_General
 * @subpackage  Amp_WP_General/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

class Amp_WP_General {
	/**
	 * The theme that's responsible for keeping the values of theme path of the plugin.
	 *
	 * @since       1.0.4
	 * @access  private
	 * @var     Amp_WP_General_Theme  $amp_wp_theme keep all the theme for the plugin.
	 */
	private $amp_wp_theme;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.4
	 */
	public function __construct() {

		$this->amp_wp_theme = array(
			'name'    => 'global_theme',
			'title'   => __( 'Global theme', 'amp-wp' ),
			'desc'    => __( 'Select design for your AMP pages, from the list of AMP WP theme plugins installed and activated.<br /><strong>Note:</strong>The AMP WP Customizer handles the built-in display. Additional AMP WP themes can be customized using their own customizers only.', 'amp-wp' ),
			'default' => 'Tez',
			'class'   => '',
			'content' => array(
				'attr'    => array(),
				'options' => array(
					'Tez' => __( 'tez', 'amp-wp' ),
				),
			),
		);

		// Filter -> Add General Settings Tab.
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_general_tab' ) );

		// Action -> Display General Settings.
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_general_settings' ) );

		// Action -> Save General Settings.
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_general_settings' ) );
	}

	/**
	 * Add General Settings Tab
	 *
	 * @since 1.0.4
	 *
	 * @param array $tabs Settings Tab.
	 * @return array $tabs Merge array of Settings Tab with General Tab.
	 */
	public function amp_wp_add_general_tab( $tabs ) {
		$tabs['general'] = __( '<i class="amp-wp-admin-icon-settings-1"></i><span>General</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display General Settings
	 *
	 * This function is used to display settings general section & also display
	 * the stored settings.
	 *
	 * @since 1.0.4
	 */
	public function amp_wp_add_general_settings() {

		// Get General Settings.
		$theme_name           = '';
		$amp_on_home          = '';
		$amp_on_search        = '';
		$amp_on_post_types    = array();
		$amp_on_taxonomies    = array();
		$exclude_urls         = '';
		$excluded_urls        = '';
		$mobile_auto_redirect = '';
		$url_structure        = 'start-point';

		if ( get_option( 'amp_wp_general_settings' ) ) {
			$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
			$amp_on_home             = ( isset( $amp_wp_general_settings['amp_on_home'] ) && ! empty( $amp_wp_general_settings['amp_on_home'] ) ) ? $amp_wp_general_settings['amp_on_home'] : '';
			$amp_on_search           = ( isset( $amp_wp_general_settings['amp_on_search'] ) && ! empty( $amp_wp_general_settings['amp_on_search'] ) ) ? $amp_wp_general_settings['amp_on_search'] : '';
			$amp_on_post_types       = ( isset( $amp_wp_general_settings['amp_on_post_types'] ) && ! empty( $amp_wp_general_settings['amp_on_post_types'] ) ) ? $amp_wp_general_settings['amp_on_post_types'] : array();
			$amp_on_taxonomies       = ( isset( $amp_wp_general_settings['amp_on_taxonomies'] ) && ! empty( $amp_wp_general_settings['amp_on_taxonomies'] ) ) ? $amp_wp_general_settings['amp_on_taxonomies'] : array();
			$exclude_urls            = ( isset( $amp_wp_general_settings['exclude_urls'] ) && ! empty( $amp_wp_general_settings['exclude_urls'] ) ) ? $amp_wp_general_settings['exclude_urls'] : '';
			$excluded_urls           = ( isset( $amp_wp_general_settings['excluded_urls'] ) && ! empty( $amp_wp_general_settings['excluded_urls'] ) ) ? $amp_wp_general_settings['excluded_urls'] : '';
			$url_structure           = ( isset( $amp_wp_general_settings ) && ! empty( $amp_wp_general_settings['url_structure'] ) ) ? $amp_wp_general_settings['url_structure'] : 'start-point';
			$mobile_auto_redirect    = ( isset( $amp_wp_general_settings['mobile_auto_redirect'] ) && ! empty( $amp_wp_general_settings['mobile_auto_redirect'] ) ) ? $amp_wp_general_settings['mobile_auto_redirect'] : '';
			$theme_name              = ( isset( $amp_wp_general_settings['theme_name'] ) && ! empty( $amp_wp_general_settings['theme_name'] ) ) ? esc_attr( $amp_wp_general_settings['theme_name'] ) : '';
		}

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-general.php';
	}

	/**
	 * Save General Settings
	 *
	 * @since       1.0.4
	 */
	public function amp_wp_save_general_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		$amp_wp_general_settings = filter_input_array( INPUT_POST );

		if ( $amp_wp_general_settings ) :
			foreach ( $amp_wp_general_settings as $key => $value ) {
				if ( strstr( $key, 'general_settings' ) ) {
					if ( isset( $value['amp_on_home'] ) ) {
						$value['amp_on_home'] = 1;
					}

					if ( isset( $value['amp_on_search'] ) ) {
						$value['amp_on_search'] = 1;
					}

					if ( isset( $value['mobile_auto_redirect'] ) ) {
						$value['mobile_auto_redirect'] = 1;
					}

					update_option( sanitize_key( $key ), $value );
				}
			}
		endif;
	}
}
new Amp_WP_General();
