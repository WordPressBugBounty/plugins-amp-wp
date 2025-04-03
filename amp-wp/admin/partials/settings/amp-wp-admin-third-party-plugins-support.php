<?php
/**
 * Provide a admin area view for the Third Party Plugins Support
 *
 * @link       https://pixelative.co
 * @since      1.5.11
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials/settings
 */
?>
<div id="settings-third-party-plugins-support" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<input type="hidden" value="1" name="admin_notices">
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Third party Plugins Support', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<!-- OneSignal – Web Push Notifications - START -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'OneSignal – Web Push Notifications', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="onesignal_switch"><?php esc_html_e( 'Enable OneSignal on Site', 'amp-wp' ); ?></label></th>
						<td>
							<div class="amp-wp-parent-child-field <?php echo ( '1' == $onesignal_switch ) ? 'active' : ''; ?>">
								<div class="switch">
									<input type="checkbox" name="amp_wp_third_party_plugins_support_settings[onesignal_switch]" id="onesignal_switch" <?php echo ( isset( $onesignal_switch ) && ! empty( $onesignal_switch ) ) ? 'checked="checked"' : ''; ?> />
									<label for="onesignal_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
								</div>
								<div class="amp-wp-child-field">
									<label for="onesignal_app_id"><?php esc_html_e( 'App ID', 'amp-wp' ); ?></label>
									<input type="text" name="amp_wp_third_party_plugins_support_settings[onesignal_app_id]" id="onesignal_app_id" value="<?php echo ( isset( $onesignal_app_id ) && ! empty( $onesignal_app_id ) ) ? esc_html( $onesignal_app_id ) : ''; ?>" />

									<label for="onesignal_position"><?php esc_html_e( 'Position', 'amp-wp' ); ?></label>
									<select name="amp_wp_third_party_plugins_support_settings[onesignal_position]" id="onesignal_position" class="amp-wp-select">
										<?php foreach ( $positions as $key => $value ) : ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php echo ( $key == $onesignal_position ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr( $value ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="onesignal_http_site_switch"><?php esc_html_e( 'HTTP Site', 'amp-wp' ); ?></label></th>
						<td>
							<div class="amp-wp-parent-child-field <?php echo ( '1' == $onesignal_http_site_switch ) ? 'active' : ''; ?>">
								<div class="switch">
									<input type="checkbox" name="amp_wp_third_party_plugins_support_settings[onesignal_http_site_switch]" id="onesignal_http_site_switch" <?php echo ( isset( $onesignal_http_site_switch ) && ! empty( $onesignal_http_site_switch ) ) ? 'checked="checked"' : ''; ?> />
									<label for="onesignal_http_site_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
								</div>
								<div class="amp-wp-child-field">
									<label for="onesignal_http_site_subdomain"><?php esc_html_e( 'Subdomain', 'amp-wp' ); ?></label>
									<input type="text" name="amp_wp_third_party_plugins_support_settings[onesignal_http_site_subdomain]" id="onesignal_http_site_subdomain" value="<?php echo ( isset( $onesignal_http_site_subdomain ) && ! empty( $onesignal_http_site_subdomain ) ) ? esc_url( $onesignal_http_site_subdomain ) : ''; ?>" />
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- OneSignal – Web Push Notifications - END -->
		</div>
		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Third party Plugins Support', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
	</form>
</div>
