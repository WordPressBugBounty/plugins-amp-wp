<?php
/**
 * Provide a admin area view for the general settings
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
<div id="settings-general" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<input type="hidden" value="1" name="admin_notices">
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'General Settings', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
				<!-- <button class="button">< ?php esc_html_e( 'Reset', 'amp-wp' ); ?></button> -->
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<!-- Enable/Disable AMP - START -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Enable/Disable AMP', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="amp_on_home"><?php esc_html_e( 'Enable AMP on Home Page', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_general_settings[amp_on_home]" id="amp_on_home" <?php echo ( isset( $amp_on_home ) && ! empty( $amp_on_home ) ) ? 'checked="checked"' : ''; ?> />
								<label for="amp_on_home">&nbsp;</label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="amp_on_search"><?php esc_html_e( 'Enable AMP on Search Page', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_general_settings[amp_on_search]" id="amp_on_search" <?php echo ( isset( $amp_on_search ) && ! empty( $amp_on_search ) ) ? 'checked="checked"' : ''; ?> />
								<label for="amp_on_search">&nbsp;</label>
							</div>
						</td>
					</tr>
					<?php
					$post_types = amp_wp_list_post_types();
					if ( $post_types ) :
						?>
					<tr>
						<th scope="row"><label for="amp_on_post_types"><?php esc_html_e( 'Disable AMP on Post Types', 'amp-wp' ); ?></label></th>
						<td>
							<select name="amp_wp_general_settings[amp_on_post_types][]" id="amp_on_post_types" multiple="multiple" class="amp-wp-select" data-placeholder="Select Post Types">
							<?php
							foreach ( $post_types as $key => $value ) :
								$selected = in_array( $key, $amp_on_post_types ) ? ' selected="selected" ' : '';
								echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_attr( $value ) . '</option>';
							endforeach;
							?>
							</select>
						</td>
					</tr>
					<?php endif; ?>
					<?php
					$get_taxonomies = amp_wp_list_taxonomies();
					if ( $get_taxonomies ) :
						?>
					<tr>
						<th scope="row"><label for="amp_on_taxonomies"><?php esc_html_e( 'Disable AMP on Taxonomies', 'amp-wp' ); ?></label></th>
						<td>
							<select name="amp_wp_general_settings[amp_on_taxonomies][]" id="amp_on_taxonomies" multiple="multiple" class="amp-wp-select" data-placeholder="Select Taxonomies">
							<?php
							foreach ( $get_taxonomies as $key => $value ) :
								$selected = in_array( $key, $amp_on_taxonomies ) ? ' selected="selected" ' : '';
								echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_attr( $value ) . '</option>';
							endforeach;
							?>
							</select>
						</td>
					</tr>
					<?php endif; ?>
					<tr>
						<th scope="row"><label for="exclude_urls"><?php esc_html_e( 'Exclude URLs From Auto Converting:', 'amp-wp' ); ?></label></th>
						<td>
							<textarea id="exclude_urls" name="amp_wp_general_settings[exclude_urls]" rows="5" class="large-text code"><?php echo wp_kses_post( $exclude_urls ); ?></textarea>
							<div class="description">
								<p><?php esc_html_e( 'You can exclude URLs of your site to prevent converting them into AMP URL inside your site.', 'amp-wp' ); ?></p>
								<p><?php esc_html_e( 'You can use <strong>*</strong> in the end of URL to exclude all URLs that start with it. e.g. <span class="pre">//yoursite.com/test/*</span>', 'amp-wp' ); ?></p>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="excluded_urls"><?php esc_html_e( 'Exclude AMP by URL:', 'amp-wp' ); ?></label></th>
						<td>
							<textarea id="excluded_urls" name="amp_wp_general_settings[excluded_urls]" rows="5" class="large-text code"><?php echo wp_kses_post( $excluded_urls ); ?></textarea>
							<div class="description">
								<p><?php esc_html_e( 'You can disable AMP version of the page. e.g. /product/* will disable all amp pages starting with product in the URL.', 'amp-wp' ); ?></p>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Enable/Disable AMP - END -->

			<!-- AMP Permalink- START -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'AMP Permalink', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="url_structure"><?php esc_html_e( 'AMP URL Format', 'amp-wp' ); ?></label></th>
						<td>
							<select name="amp_wp_general_settings[url_structure]" id="url_structure" class="amp-wp-select">
								<option value="start-point"<?php echo ( 'start-point' == $url_structure ) ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Start Point - At the beginning of the URL', 'amp-wp' ); ?></option>
								<option value="end-point"<?php echo ( 'end-point' == $url_structure ) ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'End Point - At the end of the URL', 'amp-wp' ); ?></option>
							</select>
							<div class="description">
								<p><strong><?php esc_html_e( 'Start Point:', 'amp-wp' ); ?></strong> <span class="pre">//yoursite.com/<strong>amp</strong>/post/</span></p>
								<p><strong><?php esc_html_e( 'End Point:', 'amp-wp' ); ?></strong> <span class="pre">//yoursite.com/post/<strong>amp</strong>/</span></p>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- AMP Permalink - END -->

			<!-- Mobile Redirect - START -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Mobile Redirect', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="mobile_auto_redirect"><?php esc_html_e( 'Automatically Redirect Users to AMP Version:', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_general_settings[mobile_auto_redirect]" id="mobile_auto_redirect" <?php echo ( isset( $mobile_auto_redirect ) && ! empty( $mobile_auto_redirect ) ) ? 'checked="checked"' : ''; ?> />
								<label for="mobile_auto_redirect">&nbsp;</label>
							</div>
							<p class="description"><?php esc_html_e( 'This will automatically redirect all mobile users to the AMP version of the site.', 'amp-wp' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Mobile Redirect - END -->

			<!-- Theme Settings - START -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Theme Settings', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="theme_name"><?php echo esc_attr( $this->amp_wp_theme['title'] ); ?></label></th>
						<td>
							<select name="amp_wp_general_settings[theme_name]" id="theme_name" class="amp-wp-select">
								<?php
								$select_title_dom = '';
								foreach ( $this->amp_wp_theme['content']['options'] as $key => $value ) {
									$selected = '';
									if ( $theme_name == $value ) {
										$selected = 'selected="selected"';
									}
									$select_title_dom .= '<option value="' . $value . '" ' . $selected . ' >' . $key . '</option>';
								}
								echo $select_title_dom;
								?>
							</select>
							<p class="description"><?php esc_html_e( 'More themes coming soon.', 'amp-wp' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Theme Settings - END -->
		</div>

		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'General Settings', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
				<!-- <button class="button">< ?php esc_html_e( 'Reset', 'amp-wp' ); ?></button> -->
			</div>
		</div>
	</form>
</div>
