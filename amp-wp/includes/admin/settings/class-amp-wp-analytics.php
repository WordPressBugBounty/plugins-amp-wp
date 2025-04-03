<?php
/**
 * Amp_WP_Analytics Class
 *
 * This is used to define AMP WP Analytics setting.
 *
 * @link            https://pixelative.co
 * @since           1.0.4
 *
 * @package     Amp_WP_Analytics
 * @subpackage  Amp_WP_Analytics/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Amp_WP_Analytics {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.4
	 */
	public function __construct() {

		// Filter -> Add Analytic Settings Tab.
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_analytic_tab' ) );

		// Action -> Display Analytic Settings.
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_analytic_settings' ) );

		// Action -> Save Analytic Settings.
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_analytic_settings' ) );
	}

	/**
	 * Add Analytic Settings Tab
	 *
	 * @param   array $tabs  Settings Tab.
	 * @since       1.0.4
	 *
	 * @return  array  $tabs  Merge array of Settings Tab with General Tab..
	 */
	public function amp_wp_add_analytic_tab( $tabs ) {

		$tabs['analytics'] = __( '<i class="amp-wp-admin-icon-list"></i><span>Analytics</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Analytic Settings
	 *
	 * This function is used to display stored Analytic settings.
	 *
	 * @since       1.0.4
	 */
	public function amp_wp_add_analytic_settings() {

		/**
		 * Get Google Analytic Values
		 */
		$ga_switch = '';
		$ga_value  = '';
		if ( get_option( 'amp_wp_ga' ) ) {
			$amp_wp_ga = get_option( 'amp_wp_ga' );
			$ga_switch = $amp_wp_ga['ga_switch'];
			$ga_value  = $amp_wp_ga['ga'];
		}

		/**
		 * Get Facebook Pixel Values
		 */
		$fbp_switch = '';
		$fbp_value  = '';
		if ( get_option( 'amp_wp_fbp' ) ) {
			$amp_wp_fbp = get_option( 'amp_wp_fbp' );
			$fbp_switch = $amp_wp_fbp['fbp_switch'];
			$fbp_value  = $amp_wp_fbp['fbp'];
		}

		/**
		 * Get Segment Analytic Values
		 */
		$sa_switch = '';
		$sa_value  = '';
		if ( get_option( 'amp_wp_sa' ) ) {
			$amp_wp_sa = get_option( 'amp_wp_sa' );
			$sa_switch = $amp_wp_sa['sa_switch'];
			$sa_value  = $amp_wp_sa['sa'];
		}

		/**
		 * Get Segment Analytic Values
		 */
		$qc_switch = '';
		$qc_value  = '';
		if ( get_option( 'amp_wp_qc' ) ) {
			$amp_wp_qc = get_option( 'amp_wp_qc' );
			$qc_switch = $amp_wp_qc['qc_switch'];
			$qc_value  = $amp_wp_qc['qc'];
		}

		/**
		 * Get Alexa Metrics Values
		 */
		$acm_switch  = '';
		$acm_account = '';
		$acm_domain  = '';
		if ( get_option( 'amp_wp_acm' ) ) {
			$amp_wp_acm  = get_option( 'amp_wp_acm' );
			$acm_switch  = $amp_wp_acm['acm_switch'];
			$acm_account = $amp_wp_acm['acm_account'];
			$acm_domain  = $amp_wp_acm['acm_domain'];
		}

		/**
		 * Get Chartbeat Analytics Values
		 */
		$cb_switch   = '';
		$cb_analytic = '';
		$cb_domain   = '';
		if ( get_option( 'amp_wp_cb' ) ) {
			$amp_wp_cb   = get_option( 'amp_wp_cb' );
			$cb_switch   = $amp_wp_cb['cb_switch'];
			$cb_analytic = $amp_wp_cb['cb_analytic'];
			$cb_domain   = $amp_wp_cb['cb_domain'];
		}

		/**
		 * Get comScore Values
		 */
		$comscore_switch      = '';
		$comscore_tracking_id = '';
		if ( get_option( 'amp_wp_comscore' ) ) {
			$amp_wp_comscore      = get_option( 'amp_wp_comscore' );
			$comscore_switch      = $amp_wp_comscore['comscore_switch'];
			$comscore_tracking_id = $amp_wp_comscore['comscore_tracking_id'];
		}

		/**
		 * Get Yandex Metrica Values
		 */
		$yandex_metrica_switch     = '';
		$yandex_metrica_counter_id = '';
		if ( get_option( 'amp_wp_yandex_metrica' ) ) {
			$amp_wp_yandex_metrica     = get_option( 'amp_wp_yandex_metrica' );
			$yandex_metrica_switch     = $amp_wp_yandex_metrica['yandex_metrica_switch'];
			$yandex_metrica_counter_id = $amp_wp_yandex_metrica['yandex_metrica_counter_id'];
		}

		/**
		 * Get AFS Analytics Values
		 */
		$afs_switch     = '';
		$afs_website_id = '';
		if ( get_option( 'amp_wp_afs' ) ) {
			$amp_wp_afs     = get_option( 'amp_wp_afs' );
			$afs_switch     = $amp_wp_afs['afs_switch'];
			$afs_website_id = $amp_wp_afs['afs_website_id'];
		}

		/**
		 * Get Adobe Analytics Values
		 */
		$adobe_switch          = '';
		$adobe_host_name       = '';
		$adobe_report_suite_id = '';
		if ( get_option( 'amp_wp_adobe' ) ) {
			$amp_wp_adobe          = get_option( 'amp_wp_adobe' );
			$adobe_switch          = $amp_wp_adobe['adobe_switch'];
			$adobe_host_name       = $amp_wp_adobe['adobe_host_name'];
			$adobe_report_suite_id = $amp_wp_adobe['adobe_report_suite_id'];
		}

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-analytics.php';
	}

	/**
	 * Save Analytic Settings
	 *
	 * @since       1.0.4
	 */
	public function amp_wp_save_analytic_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		if ( isset( $_POST ) && ! empty( $_POST ) ) {

			$amp_wp_ga_switch = filter_input( INPUT_POST, 'amp_wp_ga_switch' );
			$amp_wp_ga        = filter_input( INPUT_POST, 'amp_wp_ga' );

			$amp_wp_fbp_switch = filter_input( INPUT_POST, 'amp_wp_fbp_switch' );
			$amp_wp_fbp        = filter_input( INPUT_POST, 'amp_wp_fbp' );

			$amp_wp_sa_switch = filter_input( INPUT_POST, 'amp_wp_sa_switch' );
			$amp_wp_sa        = filter_input( INPUT_POST, 'amp_wp_sa' );

			$amp_wp_qc_switch = filter_input( INPUT_POST, 'amp_wp_qc_switch' );
			$amp_wp_qc        = filter_input( INPUT_POST, 'amp_wp_qc' );

			$amp_wp_acm_switch  = filter_input( INPUT_POST, 'amp_wp_acm_switch' );
			$amp_wp_acm_account = filter_input( INPUT_POST, 'amp_wp_acm_account' );
			$amp_wp_acm_domain  = filter_input( INPUT_POST, 'amp_wp_acm_domain' );

			$amp_wp_cb_switch   = filter_input( INPUT_POST, 'amp_wp_cb_switch' );
			$amp_wp_cb_analytic = filter_input( INPUT_POST, 'amp_wp_cb_analytic' );
			$amp_wp_cb_domain   = filter_input( INPUT_POST, 'amp_wp_cb_domain' );

			$amp_wp_comscore_switch      = filter_input( INPUT_POST, 'amp_wp_comscore_switch' );
			$amp_wp_comscore_tracking_id = filter_input( INPUT_POST, 'amp_wp_comscore_tracking_id' );

			$amp_wp_yandex_metrica_switch     = filter_input( INPUT_POST, 'amp_wp_yandex_metrica_switch' );
			$amp_wp_yandex_metrica_counter_id = filter_input( INPUT_POST, 'amp_wp_yandex_metrica_counter_id' );

			$amp_wp_afs_switch     = filter_input( INPUT_POST, 'amp_wp_afs_switch' );
			$amp_wp_afs_website_id = filter_input( INPUT_POST, 'amp_wp_afs_website_id' );

			$amp_wp_adobe_switch          = filter_input( INPUT_POST, 'amp_wp_adobe_switch' );
			$amp_wp_adobe_host_name       = filter_input( INPUT_POST, 'amp_wp_adobe_host_name' );
			$amp_wp_adobe_report_suite_id = filter_input( INPUT_POST, 'amp_wp_adobe_report_suite_id' );

			if ( isset( $amp_wp_ga_switch ) ) {
				if ( ! empty( $amp_wp_ga ) ) {
					$analytic_ga_array = array(
						'ga_switch' => '1',
						'ga'        => $amp_wp_ga,
					);
					update_option( 'amp_wp_ga', $analytic_ga_array );
				} else {
					delete_option( 'amp_wp_ga' );
				}
				remove_theme_mod( 'amp-wp-ga-switch' );
				remove_theme_mod( 'amp-wp-ga-analytic' );
			}

			if ( isset( $amp_wp_fbp_switch ) ) {
				if ( ! empty( $amp_wp_fbp ) ) {
					$analytic_fbp_array = array(
						'fbp_switch' => '1',
						'fbp'        => sanitize_text_field( $amp_wp_fbp ),
					);
					update_option( 'amp_wp_fbp', $analytic_fbp_array );
				} else {
					delete_option( 'amp_wp_fbp' );
				}
				remove_theme_mod( 'amp-wp-fbp-switch' );
				remove_theme_mod( 'amp-wp-fbp-analytic' );
			}

			if ( isset( $amp_wp_sa_switch ) ) {
				if ( ! empty( $amp_wp_sa ) ) {
					$analytic_sa_array = array(
						'sa_switch' => '1',
						'sa'        => sanitize_text_field( $amp_wp_sa ),
					);
					update_option( 'amp_wp_sa', $analytic_sa_array );
				} else {
					delete_option( 'amp_wp_sa' );
				}

				remove_theme_mod( 'amp-wp-sa-switch' );
				remove_theme_mod( 'amp-wp-sa-analytic' );
			}

			if ( isset( $amp_wp_qc_switch ) ) {
				if ( ! empty( $amp_wp_qc ) ) {
					$analytic_qc_array = array(
						'qc_switch' => '1',
						'qc'        => sanitize_text_field( $amp_wp_qc ),
					);
					update_option( 'amp_wp_qc', $analytic_qc_array );
				} else {
					delete_option( 'amp_wp_qc' );
				}

				remove_theme_mod( 'amp-wp-qc-switch' );
				remove_theme_mod( 'amp-wp-qc-analytic' );
			}

			if ( isset( $amp_wp_acm_switch ) ) {
				if ( ! empty( $amp_wp_acm_account ) && ! empty( $amp_wp_acm_domain ) ) {
					$analytic_acm_array = array(
						'acm_switch'  => '1',
						'acm_account' => sanitize_text_field( $amp_wp_acm_account ),
						'acm_domain'  => esc_url( $amp_wp_acm_domain ),
					);
					update_option( 'amp_wp_acm', $analytic_acm_array );
				} else {
					delete_option( 'amp_wp_acm' );
				}

				remove_theme_mod( 'amp-wp-acm-switch' );
				remove_theme_mod( 'amp-wp-acm-account' );
				remove_theme_mod( 'amp-wp-acm-domain' );
			}

			if ( isset( $amp_wp_cb_switch ) ) {
				if ( ! empty( $amp_wp_cb_analytic ) && ! empty( $amp_wp_cb_domain ) ) {
					$analytic_cb_array = array(
						'cb_switch'   => '1',
						'cb_analytic' => sanitize_text_field( $amp_wp_cb_analytic ),
						'cb_domain'   => esc_url( $amp_wp_cb_domain ),
					);
					update_option( 'amp_wp_cb', $analytic_cb_array );
				} else {
					delete_option( 'amp_wp_cb' );
				}

				remove_theme_mod( 'amp-wp-cb-switch' );
				remove_theme_mod( 'amp-wp-cb-analytic' );
				remove_theme_mod( 'amp-wp-cb-domain' );
			}

			if ( isset( $amp_wp_comscore_switch ) ) {
				if ( ! empty( $amp_wp_comscore_tracking_id ) ) {
					$analytic_comscore_array = array(
						'comscore_switch'      => '1',
						'comscore_tracking_id' => sanitize_text_field( $amp_wp_comscore_tracking_id ),
					);
					update_option( 'amp_wp_comscore', $analytic_comscore_array );
				} else {
					delete_option( 'amp_wp_comscore' );
				}

				remove_theme_mod( 'amp-wp-comscore-switch' );
				remove_theme_mod( 'amp-wp-comscore-tracking-id' );
			}

			if ( isset( $amp_wp_yandex_metrica_switch ) ) {
				if ( ! empty( $amp_wp_yandex_metrica_counter_id ) ) {
					$analytic_yandex_metrica_array = array(
						'yandex_metrica_switch'     => '1',
						'yandex_metrica_counter_id' => sanitize_text_field( $amp_wp_yandex_metrica_counter_id ),
					);
					update_option( 'amp_wp_yandex_metrica', $analytic_yandex_metrica_array );
				} else {
					delete_option( 'amp_wp_yandex_metrica' );
				}
			}

			if ( isset( $amp_wp_afs_switch ) ) {
				if ( ! empty( $amp_wp_afs_website_id ) ) {
					$analytic_afs_array = array(
						'afs_switch'     => '1',
						'afs_website_id' => sanitize_text_field( $amp_wp_afs_website_id ),
					);
					update_option( 'amp_wp_afs', $analytic_afs_array );
				} else {
					delete_option( 'amp_wp_afs' );
				}
			}

			if ( isset( $amp_wp_adobe_switch ) ) {
				if ( ! empty( $amp_wp_adobe_host_name ) && ! empty( $amp_wp_adobe_report_suite_id ) ) {
					$analytic_adobe_array = array(
						'adobe_switch'          => '1',
						'adobe_host_name'       => sanitize_text_field( $amp_wp_adobe_host_name ),
						'adobe_report_suite_id' => sanitize_text_field( $amp_wp_adobe_report_suite_id ),
					);
					update_option( 'amp_wp_adobe', $analytic_adobe_array );
				} else {
					delete_option( 'amp_wp_adobe' );
				}
			}
		}
	}
}
new Amp_WP_Analytics();
