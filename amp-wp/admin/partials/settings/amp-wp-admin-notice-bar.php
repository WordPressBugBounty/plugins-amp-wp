<?php
/**
 * Provide a admin area view for the Notice Bar
 *
 * @link       https://pixelative.co
 * @since      1.4.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials/settings
 */
?>
<div id="settings-notice-bar" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
        <div class="amp-wp-vtabs-header">
            <div class="amp-wp-vtabs-title">
                <h2><?php _e('Notice Bar', 'amp-wp'); ?></h2>
            </div>
            <div class="amp-wp-vtabs-btn-toolbar">
                <?php submit_button( esc_html__('Save Changes', 'amp-wp'), 'button-primary', 'save', false); ?>
            </div>
        </div>
		<div class="amp-wp-vtabs-body">
            <!-- Notice Bar - START -->
            <h3 class="amp-wp-form-section-title"><?php _e('Notice Bar', 'amp-wp'); ?></h3>
            <table class="form-table amp-wp-form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="noticebar_switch"><?php _e('Show Notice Bar', 'amp-wp'); ?></label></th>
                        <td>
                            <div class="amp-wp-parent-child-field <?php echo ( "1" == $noticebar_switch ) ? 'active' : ''; ?>">
                                <div class="switch">
                                    <input type="checkbox" name="amp_wp_noticebar_settings[noticebar_switch]" id="noticebar_switch" <?php echo ( isset( $noticebar_switch ) && "1" == $noticebar_switch ) ? 'checked="checked"' : ''; ?>>
                                    <label for="noticebar_switch"><?php esc_html_e('&nbsp;', 'amp-wp'); ?></label>
                                </div>
                                <div class="amp-wp-child-field">
                                    <label for="consent"><?php _e('Enter Notice Bar Text', 'amp-wp'); ?></label>
                                    <input type="text" name="amp_wp_noticebar_settings[consent]" id="consent" class="regular-text code" placeholder="<?php amp_wp_translation_echo( 'notice-bar-text' ); ?>" value="<?php echo ( $noticebar_consent ) ? esc_attr( $noticebar_consent ) : ''; ?>">

                                    <label for="accept_button_text"><?php _e('Enter Notice Bar Button Text', 'amp-wp'); ?></label>
                                    <input type="text" name="amp_wp_noticebar_settings[accept_button_text]" id="accept_button_text" class="regular-text code" placeholder="<?php amp_wp_translation_echo( 'notice-bar-button-text' ); ?>" value="<?php echo ( $noticebar_accept_button_text ) ? esc_attr( $noticebar_accept_button_text ) : ''; ?>">
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Notice Bar - END -->

			<?php wp_nonce_field('amp_wp_notice_bar_setting', 'amp_wp_notice_bar_setting'); ?>
			<input type="hidden" value="1" name="admin_notices">
		</div>
		<div class="amp-wp-vtabs-footer">
            <div class="amp-wp-vtabs-title">
                <h2><?php _e('Notice Bar', 'amp-wp'); ?></h2>
            </div>
            <div class="amp-wp-vtabs-btn-toolbar">
                <?php submit_button( esc_html__('Save Changes', 'amp-wp'), 'button-primary', 'save', false); ?>
            </div>
        </div>
	</form>
</div>