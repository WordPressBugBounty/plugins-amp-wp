<?php
/**
 * Provide a admin area view for the Social Links
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
<div id="settings-social-links" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<input type="hidden" value="1" name="admin_notices">
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Social Links', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<div id="section_analytics_type">
				<p><?php esc_html_e( 'When a field is enabled below, a <strong>Social Link</strong> will be added to Side Navigation using the respective parameters you set for it below.', 'amp-wp' ); ?></p>

				<table class="form-table amp-wp-form-table">
					<tbody>
						<!-- Facebook Link -->
						<tr>
							<th scope="row"><label for="facebook_switch"><?php esc_html_e( 'Facebook', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $facebook_switch ) && $facebook_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[facebook_switch]" id="facebook_switch" <?php echo ( isset( $facebook_switch ) && ! empty( $facebook_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="facebook_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="facebook"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[facebook]" id="facebook" placeholder="e.g. https://facebook.com/" value="<?php echo ( isset( $facebook ) && ! empty( $facebook ) ) ? esc_url( $facebook ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- /Facebook Link -->

						<!-- Twitter Link -->
						<tr>
							<th scope="row"><label for="twitter_switch"><?php esc_html_e( 'Twitter', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $twitter_switch ) && $twitter_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[twitter_switch]" id="twitter_switch" <?php echo ( isset( $twitter_switch ) && ! empty( $twitter_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="twitter_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="twitter"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[twitter]" id="twitter" placeholder="e.g. https://twitter.com/" value="<?php echo ( isset( $twitter ) && ! empty( $twitter ) ) ? esc_url( $twitter ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- /Twitter Link -->

						<!-- Pinterest Link -->
						<tr>
							<th scope="row"><label for="pinterest_switch"><?php esc_html_e( 'Pinterest', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $pinterest_switch ) && $pinterest_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[pinterest_switch]" id="pinterest_switch" <?php echo ( isset( $pinterest_switch ) && ! empty( $pinterest_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="pinterest_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="pinterest"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[pinterest]" id="pinterest" placeholder="e.g. https://www.pinterest.com/CompanyName/" value="<?php echo ( isset( $pinterest ) && ! empty( $pinterest ) ) ? esc_url( $pinterest ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- / Pinterest Link -->

						<!-- Instagram Link -->
						<tr>
							<th scope="row"><label for="instagram_switch"><?php esc_html_e( 'Instagram', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $instagram_switch ) && $instagram_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[instagram_switch]" id="instagram_switch" <?php echo ( isset( $instagram_switch ) && ! empty( $instagram_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="instagram_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="instagram"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[instagram]" id="instagram" placeholder="e.g. https://www.instagram.com/CompanyName/" value="<?php echo ( isset( $instagram ) && ! empty( $instagram ) ) ? esc_url( $instagram ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- / Instagram Link -->

						<!-- LinkedIn Link -->
						<tr>
							<th scope="row"><label for="linkedin_switch"><?php esc_html_e( 'LinkedIn', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $linkedin_switch ) && $linkedin_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[linkedin_switch]" id="linkedin_switch" <?php echo ( isset( $linkedin_switch ) && ! empty( $linkedin_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="linkedin_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="linkedin"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[linkedin]" id="linkedin" placeholder="e.g. https://www.linkedin.com/CompanyName/" value="<?php echo ( isset( $linkedin ) && ! empty( $linkedin ) ) ? esc_url( $linkedin ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- / LinkedIn Link -->

						<!-- YouTube Link -->
						<tr>
							<th scope="row"><label for="youtube_switch"><?php esc_html_e( 'YouTube', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $youtube_switch ) && $youtube_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[youtube_switch]" id="youtube_switch" <?php echo ( isset( $youtube_switch ) && ! empty( $youtube_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="youtube_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="youtube"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[youtube]" id="youtube" placeholder="e.g. https://www.youtube.com/channel/channel_id" value="<?php echo ( isset( $youtube ) && ! empty( $youtube ) ) ? esc_url( $youtube ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- /YouTube Link -->

						<!-- Email -->
						<tr>
							<th scope="row"><label for="email_switch"><?php esc_html_e( 'Email', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( isset( $email_switch ) && $email_switch == '1' ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_social_links_settings[email_switch]" id="email_switch" <?php echo ( isset( $email_switch ) && ! empty( $email_switch ) ) ? 'checked="checked"' : ''; ?>>
										<label for="email_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="email"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
										<input type="text" name="amp_wp_social_links_settings[email]" id="email" placeholder="e.g. email@yourcompany.com" value="<?php echo ( isset( $email ) && ! empty( $email ) ) ? antispambot( $email ) : ''; ?>" class="regular-text code">
									</div>
								</div>
							</td>
						</tr>
						<!-- /Email -->
					</tbody>
				</table>
			</div>

			<?php wp_nonce_field( 'amp_wp_analytics_setting', 'amp_wp_analytics_nonce' ); ?>
			<?php wp_original_referer_field( true, 'previous' ); ?>
			<input type="hidden" value="1" name="admin_notices">
		</div>
		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Social Links', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
	</form>
</div>
