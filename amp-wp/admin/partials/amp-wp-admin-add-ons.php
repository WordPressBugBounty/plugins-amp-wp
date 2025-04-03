<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link        https://pixelative.co
 * @since       1.0.0
 *
 * @package     Amp_WP
 * @subpackage  Amp_WP/admin/partials
 */

?>
<div class="amp-wp-adb">
	<?php require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-header.php'; ?>

	<div class="amp-wp-content-wrap">
		<div class="amp-wp-content-header">
			<h2 class="amp-wp-content-title"><?php esc_html_e( 'New Premium Add-Ons', 'amp-wp' ); ?></h2>
		</div>

		<div class="amp-wp-content-body">
			<div class="amp-wp-boxes amp-wp-boxes-3-col">
				<?php $i = 1; foreach ( $add_ons as $value ) : ?>
				<div class="amp-wp-box amp-wp-box-w-img gray-scale">

					<div class="amp-wp-box-header">
						<h3><?php echo esc_attr( $value['box-title'] ); ?></h3>
					</div>
					<img src="<?php echo esc_attr( $value['box-image'] ); ?>" alt="<?php echo esc_attr( $value['box-title'] ); ?>" />
					<div class="amp-wp-box-body">
						<p><?php echo wp_kses_post( $value['box-description'] ); ?></p>
						<p>&nbsp;</p>
						<div class="amp-wp-action-buttons">
							<a href="<?php echo esc_url( $value['box-cta-url'] ); ?>" class="button-primary" target="_blank"><?php echo esc_attr( $value['box-cta-title'] ); ?></a>
						</div>
					</div>
				</div>
					<?php
					$i++;
				endforeach;
				?>
			</div>
		</div>
	</div>
</div>
