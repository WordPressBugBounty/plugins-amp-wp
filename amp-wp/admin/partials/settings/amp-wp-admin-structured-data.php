<?php
/**
 * Provide a admin area view for the Structured Data
 *
 * @link       https://pixelative.co
 * @since      1.4.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials/settings
 */
?>
<div id="settings-structured-data" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<input type="hidden" value="1" name="amp_wp_structured_data_settings[disable_data]">
		<input type="hidden" value="1" name="admin_notices">
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Structured Data', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<div id="section_analytics_type">
				<table class="form-table amp-wp-form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="structured_data_switch"><?php esc_html_e( 'Enable Structured Data on Site', 'amp-wp' ); ?></label></th>
							<td>
								<div class="amp-wp-parent-child-field <?php echo ( '1' == $structured_data_switch ) ? 'active' : ''; ?>">
									<div class="switch">
										<input type="checkbox" name="amp_wp_structured_data_settings[structured_data_switch]" id="structured_data_switch" <?php echo ( isset( $structured_data_switch ) && ! empty( $structured_data_switch ) ) ? 'checked="checked"' : ''; ?> />
										<label for="structured_data_switch"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
									<div class="amp-wp-child-field">
										<label for="schema_type_for_post"><?php esc_html_e( 'Schema Type for Post', 'amp-wp' ); ?></label>

										<select name="amp_wp_structured_data_settings[schema_type_for_post]" id="schema_type_for_post" class="amp-wp-select">
											<?php foreach ( $schema_type as $key => $value ) : ?>
											<option value="<?php echo esc_attr( $key ); ?>" <?php echo ( $key == $schema_type_for_post ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr( $value ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Structured Data', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
	</form>
</div>
