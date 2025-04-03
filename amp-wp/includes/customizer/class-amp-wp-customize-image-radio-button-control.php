<?php
if( class_exists( 'WP_Customize_Control' ) ) {
    
	/**
	 * Custom Switch Control
	 *
	 * @author Mohsin Rafique <http://pixelative.co>
	 */
    class Amp_WP_Image_Radio_Button_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
        public $type = 'image_radio_button';
                
		/**
		 * Enqueue scripts/styles for the AMP WP custom switch
		 */
        public function enqueue() {
            wp_enqueue_style( 'amp-wp-image-radio-button', amp_wp_plugin_url( 'admin/css/amp-wp-image-radio-button.css' ), array(), '1.0', 'all' );
        }

        protected function render_content() {
            $val = $this->value();
        ?>
            <div class="image_radio_button_control">
                <?php if( !empty( $this->label ) ) { ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php } ?>
                <?php if( !empty( $this->description ) ) { ?>
                    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php } ?>

                <?php foreach ( $this->choices as $key => $value ) { ?>
                    <label class="radio-button-label">
                        <input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                        <img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
                    </label>
                <?php } ?>
            </div>
        <?php
        }
    }
}