<?php
/**
 * Credits Admin View
 *
 * @link        https://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP
 * @subpackage  Amp_WP/admin/partials/welcome
 */
?>
<div id="welcome-credits" class="amp-wp-vtabs-content">
    <div class="amp-wp-vtabs-header">
        <div class="amp-wp-vtabs-title">
            <h2><?php _e('Credits', 'amp-wp'); ?></h2>
        </div>
    </div>
    <div class="amp-wp-vtabs-body">
        <p class="mb-20"><?php _e('AMP WP was developed with <span style="color: #d70000;">&#10084;</span> by <a style="color: #d70000;" href="#">Pixelative</a>.', 'amp-wp'); ?></p>

        <hr class="amp-wp-section-sep">
        <h3><?php _e('Project Leaders:', 'amp-wp'); ?></h3>
        <hr class="amp-wp-section-sep">

        <div class="amp-wp-team">
            <?php
            if( $credit_leader ) :
            foreach( $credit_leader as $leader ) :
            ?>
            <a href="<?php echo esc_url($leader['url']); ?>" target="_blank" class="amp-wp-team-member">
                <?php echo get_avatar( sanitize_email( $leader['email'] ) ); ?>
                <div class="amp-wp-member-info">
                    <h4><?php echo esc_attr($leader['name']); ?></h4>
                    <p><?php echo esc_attr( $leader['role'] ); ?></p>
                </div>
            </a>
            <?php
            endforeach;
            endif;
            ?>
        </div>

        <hr class="amp-wp-section-sep">
        <h3><?php _e('Team:', 'amp-wp'); ?></h3>
        <hr class="amp-wp-section-sep">

        <div class="amp-wp-team">
            <?php
            if( $credit_team ) :
            foreach( $credit_team as $team ) :
            ?>
            <a href="<?php echo esc_url( $team['url'] ); ?>" target="_blank" class="amp-wp-team-member">
                <?php echo get_avatar( sanitize_email( $team['email'] ) ); ?>
                <div class="amp-wp-member-info">
                    <h4><?php echo esc_attr( $team['name'] ); ?></h4>
                    <p><?php echo esc_attr( $team['role'] ); ?></p>
                </div>
            </a>
            <?php
            endforeach;
            endif;
            ?>
        </div>
    </div>
    <div class="amp-wp-vtabs-footer">
        <div class="amp-wp-vtabs-title">
            <h2><?php _e('Credits', 'amp-wp'); ?></h2>
        </div>
    </div>
</div>