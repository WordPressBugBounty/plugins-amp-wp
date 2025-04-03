<?php
if( class_exists( 'WP_Customize_Control' ) ) {
    
    /**
     * Divider Custom Control
     *
     * @author Mohsin Rafique <http://pixelative.co>
     */
    class Amp_WP_Customize_Divider_Control extends WP_Customize_Control {
		protected function render_content() {
    ?>
        <hr>
        <?php
        }
    }
}