<?php
/**
 * Fired during plugin activation
 *
 * @link       http://pixelative.co
 * @since      1.0.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Amp_WP
 * @subpackage Amp_WP/includes
 * @author     Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.2.1
	 */
	public static function activate() {
		do_action( 'amp_wp_default_configurations' );
	}
}
