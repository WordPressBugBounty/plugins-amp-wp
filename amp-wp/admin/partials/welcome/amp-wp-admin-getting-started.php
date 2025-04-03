<?php
/**
 * Getting Started Admin View
 *
 * @link        https://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP
 * @subpackage  Amp_WP/admin/partials/welcome
 */
?>
<div id="welcome-getting-started" class="amp-wp-vtabs-content">
    <div class="amp-wp-vtabs-header">
        <div class="amp-wp-vtabs-title">
            <h2><?php _e('Getting Started', 'amp-wp'); ?></h2>
        </div>
    </div>
    <div class="amp-wp-vtabs-body">
        <h3><?php _e('Thank you for installing our plugin.', 'amp-wp'); ?></h3>
		<p class="mb-20"><?php _e('Please complete the following steps to configure the plugin:', 'amp-wp'); ?></p>

        <hr class="amp-wp-section-sep">
            
        <div class="amp-wp-welcome">
            <div class="amp-wp-boxes amp-wp-boxes-3-col">
                <?php $i=1; foreach( $getting_started as $value ): ?>
				<div class="amp-wp-box amp-wp-box-num-icon">
                    <div class="amp-wp-num-icon-title">
                        <div class="amp-wp-num"><?php echo intval( $i ); ?></div>
                        <div class="amp-wp-icon-title">
                            <img src="<?php echo esc_attr( $value['box-image'] ); ?>" alt="<?php echo esc_attr( $value['box-title'] ); ?>" />
                            <h2><?php echo esc_attr( $value['box-title'] ); ?></h2>
                        </div>
                    </div>
                    <p><?php echo wp_kses_post( $value['box-description'] ); ?></p>
                    <div class="amp-wp-action-buttons">
                        <a href="<?php echo esc_url( $value['box-cta-url'] ); ?>" class="button-primary"><?php echo esc_attr( $value['box-cta-title'] ); ?></a>
                    </div>
                </div>
				<?php $i++; endforeach; ?>
            </div>
        </div>
        
        <hr class="amp-wp-section-sep">
    </div>
    <div class="amp-wp-vtabs-footer">
        <div class="amp-wp-vtabs-title">
            <h2><?php _e('Getting Started', 'amp-wp'); ?></h2>
        </div>
    </div>
</div>