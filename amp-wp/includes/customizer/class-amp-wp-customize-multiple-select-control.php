<?php
if( class_exists( 'WP_Customize_Control' ) ) {
    
    /**
     * Divider Custom Control
     *
     * @author Mohsin Rafique <http://pixelative.co>
     */
    class Amp_WP_Customize_Multiple_Select_Control extends WP_Customize_Control {
        
        public $deferred_choices;
        
        /**
         * Render the control's content.
         */
        protected function render_content() {
            if( 'select' !== $this->type ) {
                parent::render_content();
                return;
            }

            if( $this->deferred_choices && is_callable( $this->deferred_choices ) ) {
                $this->choices = call_user_func( $this->deferred_choices );
            }
            ob_start();

            parent::render_content();
            echo str_replace( '<select ', '<select multiple ', ob_get_clean() );
        }
    }
}