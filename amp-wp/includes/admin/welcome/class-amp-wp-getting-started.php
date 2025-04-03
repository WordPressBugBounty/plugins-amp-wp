<?php
/**
 * Amp_WP_Getting_Started Class
 *
 * This is used to define AMP WP Welcome Section.
 *
 * @link            https://pixelative.co
 * @since           1.4.0
 *
 * @package         Amp_WP_Getting_Started
 * @subpackage      Amp_WP_Getting_Started/includes
 * @author          Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class Amp_WP_Getting_Started {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.4.0
	 */
	public function __construct() {

		// Filter -> Add Getting Started Tab.
		add_filter( 'amp_wp_welcome_tab_menus', array( $this, 'amp_wp_add_getting_started_tab' ) );

		// Action -> Display Getting Started.
		add_action( 'amp_wp_welcome_tab_section', array( $this, 'amp_wp_add_getting_started_settings' ) );
	}

	/**
	 * Add Getting Started Tab
	 *
	 * @since       1.4.0
	 *
	 * @param       array $tabs  Getting Started Tab.
	 * @return      array  $tabs  Merge array of Welcome Tab with Getting Started Tab.
	 */
	public function amp_wp_add_getting_started_tab( $tabs ) {

		$tabs['getting-started'] = __( '<i class="amp-wp-admin-icon-settings-1"></i><span>Getting Started</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Getting Started
	 *
	 * This function is used to display Getting Started section.
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_add_getting_started_settings() {

		$getting_started = array(
			array(
				'box-title'       => __( 'Configure General Settings', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/set-global.png',
				'box-description' => __( 'To configure basic settings of the plugin, please click below to go to General settings panel. You can also set which pages you want to enable/disable the AMP version for e.g. <strong>Home Page</strong>, <strong>Search Page</strong>, <strong>Post Types</strong>, <strong>Taxonomies</strong>, or <strong>Custom URLs</strong> from this panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
				'box-cta-title'   => __( 'General Settings', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Configure Layout Settings', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/configure-layout.png',
				'box-description' => __( 'To show/hide different layout components, e.g. <strong>Slider</strong>, <strong>Share Box</strong>, <strong>Comments</strong>, <strong>Authors</strong>, <strong>Dates</strong>, and <strong>Tags</strong> etc., please click below to go to the Layout settings panel. You can also choose the <strong>Post Listing Layout</strong> from this panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-layout' ), 'admin.php' ),
				'box-cta-title'   => __( 'Layout Settings', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Configure Social Links', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/configure-social-links.png',
				'box-description' => __( 'To configure Social Links in Side Navigation, please click below to go to Social Links settings panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-social-links' ), 'admin.php' ),
				'box-cta-title'   => __( 'Social Links', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Customize AMP Theme', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/customize.png',
				'box-description' => __( 'To brand your AMP theme, such as, <strong>logo</strong>, <strong>color scheme</strong> and <strong>typography</strong>, please click below to go to the Customize AMP Theme page. You can also set the <strong>Default Front Page</strong> for the AMP version and add <strong>Custom HTML/CSS</strong> from the customizer.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg(
					array(
						'return'    => rawurlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
						'url'       => rawurlencode( amp_wp_site_url() ),
						'autofocus' => array( 'panel' => 'amp-wp-panel' ),
					),
					'customize.php'
				),
				'box-cta-title'   => __( 'Customize AMP Theme', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Install Analytics', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/analytics.png',
				'box-description' => __( 'To install analytics code e.g. <strong>Google Analytics</strong>, <strong>Facebook Pixel</strong>, <strong>Segment Analytics</strong>, <strong>Alexa Metrics</strong>, <strong>Yandex Metrica</strong>, etc. please click below to go to Analytics settings panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-analytics' ), 'admin.php' ),
				'box-cta-title'   => __( 'Analytics', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Set Translations', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/translations.png',
				'box-description' => __( 'To set global <strong>Translations</strong> and <strong>Labels</strong> for your theme, please click below to go to Translations settings panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-translation' ), 'admin.php' ),
				'box-cta-title'   => __( 'Translations', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Configure Notice Bar', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/configure-notice-bar.png',
				'box-description' => __( 'To configure a site-wide <strong>notice bar</strong>, please click below to go to Notice Bar settings panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-notice-bar' ), 'admin.php' ),
				'box-cta-title'   => __( 'Notice Bar', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Configure GDPR', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/gdpr.png',
				'box-description' => __( 'To ensure you comply with the <strong>GDPR</strong> policies for EU users, please click below to go to GDPR settings panel.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-gdpr' ), 'admin.php' ),
				'box-cta-title'   => __( 'GDPR', 'amp-wp' ),
			),
			array(
				'box-title'       => __( 'Configure Structured Data', 'amp-wp' ),
				'box-image'       => AMP_WP_DIR_URL . 'admin/images/welcome/configure-structured-data.png',
				'box-description' => __( 'Add Google Rich Snippets markup according to Schema.org guidelines to structure your AMP site for SEO.', 'amp-wp' ),
				'box-cta-url'     => add_query_arg( array( 'page' => 'amp-wp-settings#settings-structured-data' ), 'admin.php' ),
				'box-cta-title'   => __( 'Structured Data', 'amp-wp' ),
			),
		);

		$sub_menu = array(
			'social_links_url' => add_query_arg( array( 'page' => 'amp-wp-settings#settings-social-links' ), 'admin.php' ),
			'gdpr_url'         => add_query_arg( array( 'page' => 'amp-wp-settings#settings-gdpr' ), 'admin.php' ),
		);

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/welcome/amp-wp-admin-getting-started.php';
	}
}
new Amp_WP_Getting_Started();
