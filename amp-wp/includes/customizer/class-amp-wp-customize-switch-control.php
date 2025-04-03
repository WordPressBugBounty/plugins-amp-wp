<?php
if( class_exists( 'WP_Customize_Control' ) ) {
    
    /**
     * Custom Switch Control
     *
     * @author  Mohsin Rafique  <mohsin.rafique@gmail.com>
     */
    class Amp_WP_Customize_Switch_Control extends WP_Customize_Control {
        
        /**
         * Enqueue scripts/styles for the AMP WP custom switch
         * 
         * @since   1.0.0
         */
        public function enqueue() {
            wp_enqueue_script( 'amp-wp-switch', amp_wp_plugin_url( 'admin/js/amp-wp-switch.js' ), array( 'jquery' ), rand(), true );
            wp_enqueue_style( 'amp-wp-switch', amp_wp_plugin_url( 'admin/css/amp-wp-switch.css'), array(), rand() );
        }
        
        /**
         * Render the control's content.
         * 
         * @author      Mohsin Rafique <mohsin.rafique@gmail.com>
         * @version     1.0.0
         */
        protected function render_content() {
            $val = $this->value();
        ?>
            <label>
                <div class="amp-wp-switch-new">
                    <span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle;"><?php echo esc_html( $this->label ); ?></span>
                    <input type="checkbox" id="cb<?php echo $this->instance_number; ?>" class="tgl tgl-light" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
                    <label for="cb<?php echo $this->instance_number; ?>" class="tgl-btn"></label>
                </div>
                <?php if( !empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
            </label>
        <?php
        }
    }
}