<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link                https://pixelative.co
 * @since               1.0.0
 * @package             Amp_WP
 *
 * @wordpress-plugin
 * Plugin Name:         AMP WP
 * Plugin URI:          https://wordpress.org/plugins/amp-wp
 * Description:         Automagically add Google AMP functionality to your site. Tons of Premium Features for FREE. Enable/Disable Post Types, Categories, and Tags.
 * Version:             1.5.17
 * Author:              Pixelative, Mohsin Rafique
 * Author URI:          https://pixelative.co
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         amp-wp
 * Domain Path:         /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'AMP_WP_DEV_MODE', false );
define( 'AMP_WP_TEMPLATE_DIR', plugin_dir_path( __FILE__ ) . 'public/partials/' );
define( 'AMP_WP_TEMPLATE_DIR_CSS', '../../css/' );
define( 'AMP_WP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AMP_WP_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AMP_WP_AJAX_URL', esc_js( admin_url( 'admin-ajax.php' ) ) );

define( 'AMP_WP_OVERRIDE_TPL_DIR', 'amp-wp' );
define( 'AMP_WP_SLOGAN', __( 'Google AMP For WordPress', 'amp-wp' ) );

$amp_wp_general_settings = get_option( 'amp_wp_general_settings', array() );
$theme_name              = ( isset( $amp_wp_general_settings['theme_name'] ) && ! empty( $amp_wp_general_settings['theme_name'] ) ) ? esc_attr( $amp_wp_general_settings['theme_name'] ) : 'tez';

if ( $theme_name ) {
	define( 'AMP_WP_THEME_NAME', $theme_name );
} else {
	define( 'AMP_WP_THEME_NAME', 'tez' );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AMP_WP_VERSION', '1.5.17' );

/**
 * Display Plugin Upgrade Notice to Users
 *
 * @since   1.0.3
 * @param   array $data An array of plugin metadata.
 * @param   array $response An array of metadata about the available plugin update.
 */
function amp_wp_plugin_update_message( $data, $response ) {
	if ( isset( $data['upgrade_notice'] ) && strlen( trim( $data['upgrade_notice'] ) ) > 0 ) {
		printf( '<div class="amp-wp-update-message">%s</div>', wp_kses_post( wpautop( $data['upgrade_notice'] ) ) );
	}
}

// Hook to display a message in the plugins list.
add_action( 'in_plugin_update_message-amp-wp/amp-wp.php', 'amp_wp_plugin_update_message', 10, 2 );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-amp-wp-activator.php
 */
function activate_amp_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amp-wp-activator.php';
	Amp_WP_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-amp-wp-deactivator.php
 */
function deactivate_amp_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amp-wp-deactivator.php';
	Amp_WP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_amp_wp' );
register_deactivation_hook( __FILE__, 'deactivate_amp_wp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-amp-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_amp_wp() {
	$plugin = new Amp_WP();
	$plugin->run();
}
run_amp_wp();
