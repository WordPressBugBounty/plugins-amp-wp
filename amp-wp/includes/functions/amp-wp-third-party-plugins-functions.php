<?php
/**
 * AMP WP Third Party Functions
 *
 * @category    Third_Party
 * @package     Amp_WP/Functions
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2019, Pixelative
 */

/**
 * Adds OneSignal notifications for AMP.
 *
 * This function checks if the `amp_wp_onesignal_notifications` function exists and if the OneSignal switch is enabled
 * in the plugin settings. If the conditions are met, it enqueues the necessary scripts and generates the HTML markup
 * for the AMP web push notification component with the appropriate URLs.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'amp_wp_onesignal_notifications' ) ) {
	/**
	 * Render the OneSignal notifications for AMP.
	 */
	function amp_wp_onesignal_notifications() {
		$amp_wp_third_party_plugins_support_settings = get_option( 'amp_wp_third_party_plugins_support_settings' );

		if ( empty( $amp_wp_third_party_plugins_support_settings['onesignal_switch'] ) ) {
			return;
		}

		// Enqueue necessary scripts.
		amp_wp_enqueue_script( 'amp-web-push', 'https://cdn.ampproject.org/v0/amp-web-push-0.1.js' );
		amp_wp_enqueue_block_style( 'onesignal-free-web-push-notifications', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/plugins/onesignal-free-web-push-notifications/onesignal-free-web-push-notifications' );

		$onesignal_app_id = $amp_wp_third_party_plugins_support_settings['onesignal_app_id'];

		// HTTPS sites.
		$helper_iframe_url     = AMP_WP_DIR_URL . 'includes/onesignal-integration/amp-helper-frame.html?appId=' . $onesignal_app_id;
		$permission_dialog_url = AMP_WP_DIR_URL . 'includes/onesignal-integration/amp-permission-dialog.html?appId=' . $onesignal_app_id;
		$service_worker_url    = plugins_url( 'onesignal-free-web-push-notifications/sdk_files/OneSignalSDKWorker.js.php?appId=' . $onesignal_app_id );

		// HTTP sites.
		if ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_switch_http_site'] ) && '1' == $amp_wp_third_party_plugins_support_settings['onesignal_switch_http_site'] ) {
			$onesignal_subdomain = $amp_wp_third_party_plugins_support_settings['onesignal_http_site_subdomain'];
			if ( $onesignal_subdomain ) {
				$onesignal_subdomain = $onesignal_subdomain . '.';
			}
			$helper_iframe_url     = 'https://' . $onesignal_subdomain . 'os.tc/amp/helper_frame?appId=' . $onesignal_app_id . '';
			$permission_dialog_url = 'https://' . $onesignal_subdomain . 'os.tc/amp/permission_dialog?appId=' . $onesignal_app_id . '';
			$service_worker_url    = 'https://' . $onesignal_subdomain . 'os.tc/OneSignalSDKWorker.js?appId=' . $onesignal_app_id . '';
		}
		?>
		<amp-web-push
			layout="nodisplay"
			helper-iframe-url="<?php echo esc_url( $helper_iframe_url ); ?>"
			permission-dialog-url="<?php echo esc_url( $permission_dialog_url ); ?>"
			service-worker-url="<?php echo esc_url( $service_worker_url ); ?>">
		</amp-web-push>
		<?php
	}
}

// Check if the function exists and add the action to execute it at the beginning of the AMP body.
if ( ! function_exists( 'amp_wp_onesignal_notifications' ) ) {
	add_action( 'amp_wp_body_beginning', 'amp_wp_onesignal_notifications', 11 );
}

/**
 * Adds the OneSignal notifications widget for AMP.
 *
 * This function checks if the amp_wp_onesignal_notifications_widget function exists
 * and if the OneSignal switch is enabled in the plugin settings. If the conditions are met,
 * it generates the HTML markup for the push notification widget and adds it to the appropriate
 * position in the AMP content.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'amp_wp_onesignal_notifications_widget' ) ) {
	/**
	 * Render the OneSignal notifications widget.
	 */
	function amp_wp_onesignal_notifications_widget() {
		$amp_wp_third_party_plugins_support_settings = get_option( 'amp_wp_third_party_plugins_support_settings' );
		if ( isset( $amp_wp_third_party_plugins_support_settings['onesignal_switch'] ) && ! empty( $amp_wp_third_party_plugins_support_settings['onesignal_switch'] ) ) {
			?>
		<!-- Push Notification Widget -->
		<div class="amp-web-push-container">
			<!-- A subscription widget -->
			<amp-web-push-widget visibility="unsubscribed" layout="fixed" width="245" height="45">
				<button class="subscribe" on="tap:amp-web-push.subscribe">
					<i class="fa fa-bell" aria-hidden="true"></i>
					<?php echo amp_wp_translation_get( 'onesignal_subscribe' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</amp-web-push-widget>

			<!-- An unsubscription widget -->
			<amp-web-push-widget visibility="subscribed" layout="fixed" width="230" height="45">
				<button class="unsubscribe" on="tap:amp-web-push.unsubscribe"><?php echo amp_wp_translation_get( 'onesignal_unsubsribe' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
			</amp-web-push-widget>
		</div>
			<?php
		}
	}
}

// Retrieve the plugin settings.
$amp_wp_third_party_plugins_support_settings = get_option( 'amp_wp_third_party_plugins_support_settings' );

// Determine the position of the OneSignal notifications widget.
$onesignal_position = isset( $amp_wp_third_party_plugins_support_settings['onesignal_position'] ) ? $amp_wp_third_party_plugins_support_settings['onesignal_position'] : '';

// Add the OneSignal notifications widget to the appropriate position in the AMP content.
if ( 'below_the_content' === $onesignal_position ) {
	add_action( 'amp_wp_post_content_below', 'amp_wp_onesignal_notifications_widget' );
} elseif ( 'above_the_content' === $onesignal_position ) {
	add_action( 'amp_wp_post_content_before', 'amp_wp_onesignal_notifications_widget' );
}
