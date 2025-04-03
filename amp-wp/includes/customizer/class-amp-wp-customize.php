<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Amp_WP_Customize Class
 * 
 * This is used to define For AMP WP Customizer.
 * 
 * @link		http://pixelative.co
 * @since		1.1.0
 *
 * @package		Amp_WP_Customize
 * @subpackage	Amp_WP_Customize/includes
 * @author		Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Customize {
    
    /**
         * Initialize the class and set its properties.
	 *
         * @since    1.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
         */
    public function __construct() {
		
		// Action - Add Settings Menu
        add_action( 'admin_menu', array($this, 'admin_menu'), 30 );
    }

	/**
	 * Add Add-ons Page Under AMP WP Admin Menu.
	 * 
	 * @since   1.1.0
	 */
    public function admin_menu() {
		$customize_url = add_query_arg( array(
            'return' => urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
            'url' => urlencode( amp_wp_site_url() ),
            'autofocus' => array( 'panel' => 'amp-wp-panel' )
        ), 'customize.php' );
        add_submenu_page(
            'amp-wp-welcome',
            _x( 'Customize AMP Theme', 'amp-wp' ),
            _x( 'Customize AMP Theme', 'amp-wp' ),
            'manage_options',
            $customize_url
        );
    }
}
new Amp_WP_Customize();