<?php
if( class_exists( 'WP_Customize_Control' ) ) {
	
	/**
	 * Slider Custom Control
	 *
	 * @author Mohsin Rafique <http://pixelative.co>
	 */
	class Amp_WP_Customize_Slider_Control extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'min' => 52,
                'max' => 200,
                'step' => 1
            );
            $args = wp_parse_args( $args, $defaults );

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
        }
		
		/**
		 * Enqueue scripts/styles for the AMP WP custom switch
		 */
        public function enqueue() {
            wp_enqueue_style( 'amp-wp-slider', amp_wp_plugin_url( 'admin/css/amp-wp-slider.css' ), array(), '1.0', 'all' );
			wp_enqueue_script( 'amp-wp-slider-js', amp_wp_plugin_url( 'admin/js/amp-wp-slider.js' ), array( 'jquery' ), '1.0', true );
        }

		public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="wrapper">
				<input type="range" class="range-slider" min="<?php echo $this->min ?>" max="<?php echo $this->max; ?>" step="<?php echo $this->step; ?>" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() ); " />
				<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_attr_e( 'Reset', 'amp-wp' ); ?></span></span>
				<span class="value">
					<input type="text" onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() )" value='<?php echo esc_attr( $this->value() ); ?>'>
				</span>
			</div>
		</label>
		<?php
		}
	}
}