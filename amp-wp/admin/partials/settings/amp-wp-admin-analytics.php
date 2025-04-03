<?php
/**
 * Provide a admin area view for the Analytics
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://pixelative.co
 * @since      1.0.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials/settings
 */
?>
<div id="settings-analytics" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Analytics', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<div id="section_analytics_type">
				<p><?php esc_html_e( 'When a field is enabled below, an <strong>amp-analytics</strong> tag will be added to all AMP pages using the respective parameters you set for it below.', 'amp-wp' ); ?></p>

				<table class="form-table amp-wp-form-table">
					<tbody>
						<!-- Google Analytics -->
						<tr>
							<th scope="row"><label for="amp_wp_ga_switch"><?php esc_html_e( 'Google Analytics', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $ga_switch ) && $ga_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_ga_switch"
											id="amp_wp_ga_switch"
											<?php echo ( isset( $ga_switch ) && $ga_switch == '1' ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $ga_switch ) && $ga_switch == '1' ) ? intval( $ga_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_ga">
										<label for="amp_wp_ga_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_ga"><?php esc_html_e( 'Enter Tracking ID', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder="e.g. UA-123456-1"
											name="amp_wp_ga"
											id="amp_wp_ga"
											value="<?php echo ( $ga_value ) ? esc_attr( $ga_value ) : ''; ?>">
											<!-- Description Text -->
											<div class="amp-wp-form-field-desc"><p><?php esc_html_e( 'Insert google analytics account number. It\'ll be in the format UA-XXXXXXXX-X or G-XXXXXXXX', 'amp-wp' ); ?></p></div>
											<!-- Description Text -->

											<!-- Error Messages - Add "error-field" class to .amp-wp-parent-child-field -->
											<!--<div class="amp-wp-field-error-msg">Please enter a valid value.</div>-->
											<!-- Error Messages - Add "error-field" class to .amp-wp-parent-child-field -->
									</div>
								</div>
							</td>
						</tr>
						<!-- /Google Analytics -->

						<!-- Facebook Pixel -->
						<tr>
							<th scope="row"><label for="amp_wp_fbp_switch"><?php esc_html_e( 'Facebook Pixel', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $fbp_switch ) && '1' == $fbp_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_fbp_switch"
											id="amp_wp_fbp_switch"
											<?php echo ( isset( $fbp_switch ) && '1' == $fbp_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $fbp_switch ) && '1' == $fbp_switch ) ? intval( $fbp_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_fbp">
										<label for="amp_wp_fbp_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_fbp"><?php esc_html_e( 'Enter Pixel ID', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder="e.g. 123456789123456"
											name="amp_wp_fbp"
											id="amp_wp_fbp"
											value = "<?php echo ( $fbp_value ) ? esc_attr( $fbp_value ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!-- /Facebook Pixel -->

						<!-- Segment Analytics -->
						<tr>
							<th scope="row"><label for="amp_wp_sa_switch"><?php esc_html_e( 'Segment Analytics', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $sa_switch ) && '1' == $sa_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_sa_switch"
											id="amp_wp_sa_switch"
											<?php echo ( isset( $sa_switch ) && '1' == $sa_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $sa_switch ) && '1' == $sa_switch ) ? intval( $sa_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_sa">
										<label for="amp_wp_sa_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_sa"><?php esc_html_e( 'Enter Segment Key', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_sa"
											id="amp_wp_sa"
											value = "<?php echo ( $sa_value ) ? esc_attr( $sa_value ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!--/Segment Analytics -->

						<!-- Quantcast Tracking -->
						<tr>
							<th scope="row"><label for="amp_wp_qc_switch"><?php esc_html_e( 'Quantcast Tracking', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $qc_switch ) && '1' == $qc_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_qc_switch"
											id="amp_wp_qc_switch"
											<?php echo ( isset( $qc_switch ) && '1' == $qc_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $qc_switch ) && '1' == $qc_switch ) ? intval( $qc_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_qc">
										<label for="amp_wp_qc_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_qc"><?php esc_html_e( 'Enter p-code', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_qc"
											id="amp_wp_qc"
											value = "<?php echo ( $qc_value ) ? esc_attr( $qc_value ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!--/Quantcast Tracking -->

						<!-- Alexa Metrics -->
						<tr>
							<th scope="row"><label for="amp_wp_acm_switch"><?php esc_html_e( 'Alexa Metrics', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $acm_switch ) && '1' == $acm_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_acm_switch"
											id="amp_wp_acm_switch"
											<?php echo ( isset( $acm_switch ) && '1' == $acm_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $acm_switch ) && '1' == $acm_switch ) ? intval( $acm_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_acm">
										<label for="amp_wp_acm_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_acm_account"><?php esc_html_e( 'Enter Alexa Metrics Account', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_acm_account"
											id="amp_wp_acm_account"
											value = "<?php echo ( $acm_account ) ? esc_attr( $acm_account ) : ''; ?>">

										<label for="amp_wp_acm_domain"><?php esc_html_e( 'Enter Alexa Metrics Domain', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_acm_domain"
											id="amp_wp_acm_domain"
											value = "<?php echo ( $acm_domain ) ? esc_attr( $acm_domain ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!--/Alexa Metrics -->

						<!-- Chartbeat Analytics -->
						<tr>
							<th scope="row"><label for="amp_wp_cb_switch"><?php esc_html_e( 'Chartbeat Analytics', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $cb_switch ) && '1' == $cb_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_cb_switch"
											id="amp_wp_cb_switch"
											<?php echo ( isset( $cb_switch ) && '1' == $cb_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $cb_switch ) && '1' == $cb_switch ) ? intval( $cb_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_cb">
										<label for="amp_wp_cb_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_cb_analytic"><?php esc_html_e( 'Enter Chartbeat Analytics ID', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_cb_analytic"
											id="amp_wp_cb_analytic"
											value = "<?php echo ( $cb_analytic ) ? esc_attr( $cb_analytic ) : ''; ?>">

										<label for="amp_wp_cb_domain"><?php esc_html_e( 'Enter Chartbeat Domain', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_cb_domain"
											id="amp_wp_cb_domain"
											value = "<?php echo ( $cb_domain ) ? esc_attr( $cb_domain ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!--/Chartbeat Analytics -->

						<!-- comScore -->
						<tr>
							<th scope="row"><label for="amp_wp_comscore_switch"><?php esc_html_e( 'comScore', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $comscore_switch ) && '1' == $comscore_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_comscore_switch"
											id="amp_wp_comscore_switch"
											<?php echo ( isset( $comscore_switch ) && '1' == $comscore_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $comscore_switch ) && '1' == $comscore_switch ) ? intval( $comscore_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_comscore">
										<label for="amp_wp_comscore_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_comscore_tracking_id"><?php esc_html_e( 'Enter C2', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_comscore_tracking_id"
											id="amp_wp_comscore_tracking_id"
											value = "<?php echo ( $comscore_tracking_id ) ? esc_attr( $comscore_tracking_id ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!--/comScore -->

						<!-- Yandex Metrica -->
						<tr>
							<th scope="row"><label for="amp_wp_yandex_metrica_switch"><?php esc_html_e( 'Yandex Metrica', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $yandex_metrica_switch ) && '1' == $yandex_metrica_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_yandex_metrica_switch"
											id="amp_wp_yandex_metrica_switch"
											<?php echo ( isset( $yandex_metrica_switch ) && '1' == $yandex_metrica_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $yandex_metrica_switch ) && '1' == $yandex_metrica_switch ) ? intval( $yandex_metrica_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_yandex_metrica">
										<label for="amp_wp_yandex_metrica_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_yandex_metrica_counter_id"><?php esc_html_e( 'Enter Counter ID ', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder=""
											name="amp_wp_yandex_metrica_counter_id"
											id="amp_wp_yandex_metrica_counter_id"
											value = "<?php echo ( $yandex_metrica_counter_id ) ? esc_attr( $yandex_metrica_counter_id ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!--/Yandex Metrica -->

						<!-- AFS Analytics -->
						<tr>
							<th scope="row"><label for="amp_wp_afs_switch"><?php esc_html_e( 'AFS Analytics', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $afs_switch ) && '1' == $afs_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_afs_switch"
											id="amp_wp_afs_switch"
											<?php echo ( isset( $afs_switch ) && '1' == $afs_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $afs_switch ) && '1' == $afs_switch ) ? intval( $afs_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_afs">
										<label for="amp_wp_afs_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_afs_website_id"><?php esc_html_e( 'Enter Website ID  ', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder="e.g. 00000003"
											name="amp_wp_afs_website_id"
											id="amp_wp_afs_website_id"
											value="<?php echo ( $afs_website_id ) ? esc_attr( $afs_website_id ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!-- /AFS Analytics -->

						<!-- Adobe -->
						<tr>
							<th scope="row"><label for="amp_wp_adobe_switch"><?php esc_html_e( 'Adobe Analytics', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $adobe_switch ) && '1' == $adobe_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox"
											name="amp_wp_adobe_switch"
											id="amp_wp_adobe_switch"
											<?php echo ( isset( $adobe_switch ) && '1' == $adobe_switch ) ? 'checked="checked"' : ''; ?>
											value="<?php echo ( isset( $adobe_switch ) && '1' == $adobe_switch ) ? intval( $adobe_switch ) : ''; ?>"
											class="analytic-switch"
											data-id="amp_wp_adobe">
										<label for="amp_wp_adobe_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="amp_wp_adobe_host_name"><?php esc_html_e( 'Enter Host Name', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder="e.g. metrics.example.com"
											name="amp_wp_adobe_host_name"
											id="amp_wp_adobe_host_name"
											value = "<?php echo ( $adobe_host_name ) ? esc_attr( $adobe_host_name ) : ''; ?>">

										<label for="amp_wp_adobe_report_suite_id"><?php esc_html_e( 'Enter ReportSuite ID', 'amp-wp' ); ?></label>
										<input type="text"
											size="10"
											maxlength="50"
											class="regular-text code"
											placeholder="e.g. 0000003"
											name="amp_wp_adobe_report_suite_id"
											id="amp_wp_adobe_report_suite_id"
											value = "<?php echo ( $adobe_report_suite_id ) ? esc_attr( $adobe_report_suite_id ) : ''; ?>">
									</div>
								</div>
							</td>
						</tr>
						<!-- /Adobe -->
					</tbody>
				</table>
			</div>

			<?php wp_nonce_field( 'amp_wp_analytics_setting', 'amp_wp_analytics_nonce' ); ?>
			<?php wp_original_referer_field( true, 'previous' ); ?>
			<input type="hidden" value="1" name="admin_notices">
		</div>
		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Analytics', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
	</form>
</div>
