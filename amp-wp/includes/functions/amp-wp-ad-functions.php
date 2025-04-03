<?php
/**
 *  AMP WP functions to show ads in AMP.
 *
 *  This feature is depended to our AMP WP Ads Manager plugin (AMP WP Ads Manager v1.0.0)
 *  For more information about AMP WP Ads Manager you can contact us contact@ampwp.io
 *
 * @package     Amp_WP/Functions
 */

if ( ! function_exists( 'is_amp_wp_ads_manager_plugin_active' ) ) {

	/**
	 * Detect the "AMP WP Ads Manager" v1.0.0 is active or not
	 *
	 * @staticvar   type $state
	 * @version     1.0.0
	 * @since       1.0.0
	 *
	 * @return      boolean
	 */
	function is_amp_wp_ads_manager_plugin_active() {

		static $state;
		if ( ! is_null( $state ) ) {
			return $state; }

		$state = class_exists( 'Amp_WP_Ads_Manager' ) && ( defined( 'AMP_WP_ADS_MANAGER' ) && AMP_WP_ADS_MANAGER );
		if ( $state && ! function_exists( 'amp_wp_ads_manager_inject_ad_repeater_field_to_fields' ) ) {
			$state = false;
		}
		return $state;
	}
}

if ( ! function_exists( 'amp_wp_get_ad_location_data' ) ) {
	/**
	 * Return data of Ad location by its ID prefix
	 *
	 * @param   string $ad_location_prefix
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  array
	 */
	function amp_wp_get_ad_location_data( $ad_location_prefix = '' ) {
		if ( ! is_amp_wp_ads_manager_plugin_active() ) {
			return array(
				'format'          => '',
				'type'            => '',
				'banner'          => '',
				'campaign'        => '',
				'active_location' => '',
			);
		}

		if ( function_exists( 'amp_wp_ads_manager_get_ad_location_data' ) ) :
			return amp_wp_ads_manager_get_ad_location_data( $ad_location_prefix );
		endif;
	}
}


if ( ! function_exists( 'amp_wp_show_ad_location' ) ) {
	/**
	 * Return data of Ad location by its ID prefix
	 *
	 * @param  string $ad_location_prefix
	 * @param  array  $args
	 *
	 * @return  array
	 */
	function amp_wp_show_ad_location( $ad_location_prefix = '', $args = array() ) {
		if ( ! is_amp_wp_ads_manager_plugin_active() ) {
			return;
		}

		if ( function_exists( 'amp_wp_ads_manager_get_ad_location_data' ) ) :
			$ad_data = amp_wp_ads_manager_get_ad_location_data( $ad_location_prefix );
			if ( ! $ad_data['active_location'] ) {
				return;
			}
		endif;

		if ( function_exists( 'amp_wp_ads_manager_show_ad_location' ) ) :
			amp_wp_ads_manager_show_ad_location( $ad_location_prefix, $ad_data, $args );
		endif;
	}
}
