<?php
if( class_exists( 'WP_Customize_Control' ) ) {
    
	/**
	 * Heading Custom Control
	 *
	 * @author Mohsin Rafique <http://pixelative.co>
	 */
    class Amp_WP_Customize_Heading_Control extends WP_Customize_Control {
		
		/**
		 * Enqueue scripts/styles for the AMP WP custom switch
		 */
        public function enqueue() {
            wp_enqueue_style( 'amp-wp-heading', amp_wp_plugin_url( 'admin/css/amp-wp-heading.css' ), array(), '1.0', 'all' );
        }
		
        public function render_content() {
		?>
		<h3 class="heading-divider"><?php echo wp_kses_post( $this->description ); ?></h3>
        <?php
        }
    }
}