<?php
if( class_exists( 'WP_Customize_Control' ) ) {
    
	/**
	 * Accordion Custom Control
	 *
	 * @author Mohsin Rafique <http://pixelative.co>
	 */
    class Amp_WP_Customize_Accordion_Control extends WP_Customize_Control {
		
		/**
		 * Enqueue scripts/styles for the AMP WP custom switch
		 */
        public function enqueue() {
            wp_enqueue_style( 'amp-wp-accordion', amp_wp_plugin_url( 'admin/css/amp-wp-accordion.css' ), array(), '1.0', 'all' );
			wp_enqueue_script( 'amp-wp-accordion-js', amp_wp_plugin_url( 'admin/js/amp-wp-accordion.js' ), array( 'jquery' ), '1.0', true );
        }
		
        public function render_content() {
			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'class' => array(),
					'target' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'i' => array(
					'class' => array()
				),
			);
    ?>
			<div class="single-accordion-custom-control">
				<div class="single-accordion-toggle"><?php echo esc_html( $this->label ); ?><span class="accordion-icon-toggle dashicons dashicons-plus"></span></div>
				<div class="single-accordion customize-control-description">
				<?php
					if ( is_array( $this->description ) ) {
						echo '<ul class="single-accordion-description">';
						foreach ( $this->description as $key => $value ) {
							echo '<li>' . $key . wp_kses( $value, $allowed_html ) . '</li>';
						}
						echo '</ul>';
					}
					else {
						echo wp_kses( $this->description, $allowed_html );
					}
				  ?>
				</div>
			</div>
        <?php
        }
    }
}