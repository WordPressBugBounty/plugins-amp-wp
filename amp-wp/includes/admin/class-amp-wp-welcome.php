<?php
/**
 * Class Amp_WP_Welcome
 *
 * This file defines the Amp_WP_Welcome class, which is used to display AMP WP welcome page.
 *
 * @since       1.0.0
 *
 * @package     Amp_WP_Welcome
 * @subpackage  Amp_WP_Welcome/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Amp_WP_Welcome Class
 *
 * This class is used to define the AMP WP welcome Page.
 *
 * @link        https://pixelative.co
 * @since 1.0.0
 *
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Welcome {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Action - Add Welcome Menu.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 10 );

		/**
		 * Classes responsible for defining welcome section.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/welcome/class-amp-wp-getting-started.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/welcome/class-amp-wp-features.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/welcome/class-amp-wp-credits.php';
	}

	/**
	 * Add Welcome Page Under AMP WP Admin Menu.
	 *
	 * @since   1.0.0
	 */
	public function admin_menu() {

		add_menu_page(
			'AMP WP', // string $page_title.
			'AMP WP', // string $menu_title.
			'manage_options', // string $capability.
			'amp-wp-welcome', // string $menu_slug.
			array( $this, 'amp_wp_welcome_tab_menu' ),
			plugins_url( 'amp-wp/admin/images/amp-wp-icon.svg' ), // string $icon_url.
			25 // int $position.
		);
		add_submenu_page(
			'amp-wp-welcome', // string $parent_slug.
			'Welcome', // string $page_title.
			'Welcome', // string $menu_title.
			'manage_options', // string $capability.
			'amp-wp-welcome' // string $menu_slug.
		);
	}

	/**
	 * Add Welcome Tab Menu.
	 *
	 * @Since   1.4.0
	 */
	public function amp_wp_welcome_tab_menu() {

		$page = filter_input( INPUT_GET, 'page' );
		?>
		<div class="amp-wp-adb">
			<?php require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-header.php'; ?>

			<div class="amp-wp-box alert-box">
				<h3><?php esc_html_e( 'Please Note: ', 'amp-wp' ); ?></h3>
				<p>
					<?php
						echo wp_kses_post(
							__(
								'If you face any layout issues or your images appear to be smashed after installing/updating the plugin, then please install and activate <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> plugin. After activating the plugin, go to <strong>Tools</strong> > <strong>Regenerate Thumbnails</strong> from the WP Admin sidebar and choose "<strong>Regenerate Thumbnails For All Attachments</strong>". This will re-generate all the theme generated sizes of all your images.',
								'amp-wp'
							)
						);
					?>
				</p>
			</div>
			<div class="amp-wp-vtabs">
				<div class="amp-wp-vtabs-sidebar">
					<div class="amp-wp-vtabs-menu">
					<?php
					/**
					 * Filter the Welcome Tab Menus.
					 *
					 * @since 1.4.0
					 *
					 * @param array (){
					 *     @type array Tab Id => Welcome Tab Name
					 * }
					 */
					$welcome_tabs = apply_filters( 'amp_wp_welcome_tab_menus', array() );

					$count = 1;
					if ( $welcome_tabs ) {
						foreach ( $welcome_tabs as $key => $tab_name ) {
							$active_tab = ( 1 === $count ) ? 'active' : '';
							echo '<a href="#welcome-' . sanitize_key( $key ) . '" class="' . sanitize_html_class( $active_tab ) . ' ">' . wp_kses_post( $tab_name ) . '</a>';
							$count++;
						}
					}
					?>
					</div>
				</div>
				<div class="amp-wp-vtabs-content-wrap">
				<?php
				/**
				 * Action -> Display Welcome Sections.
				 *
				 * @since 1.4.0
				 */
				do_action( 'amp_wp_welcome_tab_section' );
				?>
				</div>
			</div>
				<?php require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-rating-box.php'; ?>
		</div>
			<?php

	}
}
new Amp_WP_Welcome();
