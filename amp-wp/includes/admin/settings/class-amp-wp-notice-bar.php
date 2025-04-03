<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Amp_WP_Notice_Bar Class
 * 
 * This is used to define AMP WP Notice Bar setting.
 * 
 * @link		http://pixelative.co
 * @since		1.4.0
 *
 * @package		Amp_WP_Notice_Bar
 * @subpackage	Amp_WP_Notice_Bar/includes/admin
 * @author		Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Notice_Bar {
    
    /**
	 * Initialize the class and set its properties.
	 *
     * @since	1.4.0
     */
    public function __construct() {
		
		// Filter -> Add Notice Bar Settings Tab
        add_filter('amp_wp_settings_tab_menus', array($this, 'amp_wp_add_notice_bar_tab') );
		
		// Action -> Display Notice Bar Settings
		add_action('amp_wp_settings_tab_section', array($this, 'amp_wp_add_notice_bar_settings') );
		
		// Action -> Save Notice Bar Settings
		add_action('amp_wp_save_setting_sections', array($this, 'amp_wp_save_notice_bar_settings') );
    }
	
	/**
	 * Add Notice Bar Settings Tab
	 *
	 * @since	1.4.0
	 * 
	 * @param	array  $tabs  Settings Tab
	 * @return	array  $tabs  Merge array of Settings Tab with Notice Bar & GDPR Tab.
	 */
	public function amp_wp_add_notice_bar_tab($tabs) {
		
		$tabs['notice-bar'] = __('<i class="amp-wp-admin-icon-notification"></i><span>Notice Bar</span>', 'amp-wp');
		return $tabs;
	}
	
	/**
	 * Display Notice Bar Settings
	 *
	 * This function is used to display stored Notice Bar settings.
	 *  
	 * @since		1.4.0
	 */
	public function amp_wp_add_notice_bar_settings() {
		
		// Get Notice Bar Values
		$noticebar_switch = '';
		$noticebar_consent = '';
		$noticebar_accept_button_text = '';
        
		if( get_option('amp_wp_noticebar_settings') ) {
            $amp_wp_noticebar_settings = get_option('amp_wp_noticebar_settings');
			$noticebar_switch = ( isset( $amp_wp_noticebar_settings['noticebar_switch'] ) && !empty( $amp_wp_noticebar_settings['noticebar_switch'] ) ) ? $amp_wp_noticebar_settings['noticebar_switch'] : '';
            $noticebar_consent = ( isset( $amp_wp_noticebar_settings['consent'] ) && !empty( $amp_wp_noticebar_settings['consent'] ) ) ? $amp_wp_noticebar_settings['consent'] : '';
            $noticebar_accept_button_text = ( isset( $amp_wp_noticebar_settings['accept_button_text'] ) && !empty( $amp_wp_noticebar_settings['accept_button_text'] ) ) ? $amp_wp_noticebar_settings['accept_button_text'] : array();
        }
		
		// Load View
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-notice-bar.php';
	}
	
	/**
	 * Save Notice Bar Settings
	 * 
	 * @since	1.4.0
	 */
	public function amp_wp_save_notice_bar_settings() {
		
		$amp_wp_noticebar_settings = filter_input_array( INPUT_POST );
		
		if( $amp_wp_noticebar_settings ) :
			foreach( $amp_wp_noticebar_settings as $key => $value ) {
				if( strstr( $key, 'noticebar_settings' ) ) {
					if( isset( $value['noticebar_switch'] ) ) {
						$value['noticebar_switch'] = 1;
					}
					update_option( sanitize_key( $key ), $value );
				}
			}
		endif;
		
		remove_theme_mod( 'amp-wp-notifications' );
		remove_theme_mod( 'amp-wp-notifications-text' );
		remove_theme_mod( 'amp-wp-notifications-accept-button-text' );
	}
}
new Amp_WP_Notice_Bar();