<?php
/**
 * Amp_WP_Layout Class
 *
 * This is used to define AMP WP Layout Setting.
 *
 * @link        https://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP_Layout
 * @subpackage  Amp_WP_Layout/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Amp_WP_Layout {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {

		// Filter -> Add Layout Settings Tab.
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_layout_tab' ) );

		// Action -> Display Layout Settings.
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_layout_settings' ) );

		// Action -> Save Layout Settings.
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_layout_settings' ) );
	}

	/**
	 * Add Layout Settings Tab.
	 *
	 * @since    1.4.0
	 *
	 * @param    array $tabs  Settings Tab.
	 * @return   array  $tabs  Merge array of Settings Tab with Layout Tab.
	 */
	public function amp_wp_add_layout_tab( $tabs ) {

		$tabs['layout'] = __( '<i class="amp-wp-admin-icon-compose"></i><span>Layout</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Layout Settings.
	 *
	 * This function is used to display stored Layout settings.
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_add_layout_settings() {

		$active_sites = array(
			'email'       => 'Email',
			'facebook'    => 'Facebook',
			'linkedin'    => 'LinkedIn',
			'pinterest'   => 'Pinterest',
			'tumblr'      => 'Tumblr',
			'twitter'     => 'Twitter',
			'whatsapp'    => 'WhatsApp',
			'line'        => 'LINE',
			'stumbleupon' => 'StumbleUpon',
			'telegram'    => 'Telegram',
			'digg'        => 'Digg',
			'reddit'      => 'Reddit',
			'vk'          => 'VK',
		);

		// Header Settings - Start.
		$is_show_search         = '';
		$is_sticky_header       = '';
		$is_show_sidebar        = '';
		$sidebar_copyright_text = '';
		// Header Settings - End.
		// Footer Settings - Start.
		$footer_copyright_text = '';
		// Footer Settings - End
		// Layout Settings - Home Page - Start.
		$home_page_layout           = '';
		$slider_on_home             = '';
		$slider_on_home_count       = '';
		$slider_on_home_post_date   = '';
		$slider_on_home_post_author = '';
		// Layout Settings - Home Page - End
		// Layout Settings - Archive Page - Start.
		$archive_page_layout    = '';
		$show_author_in_archive = '';
		$show_date_in_archive   = '';
		// Layout Settings - Archive Page - End
		// Layout Settings - Single Post Page - Start.
		$show_thumbnail = '';

		$show_author_in_single = '';

		$show_date_in_single              = '';
		$show_tags                        = '';
		$social_share_on_post             = '';
		$social_share_on_post_count       = '';
		$social_share_on_post_link_format = '';
		$social_share_links               = array();
		$facebook_app_id                  = '';
		$show_related_posts               = '';
		$show_related_post_count          = '';
		$show_related_post_algorithm      = '';
		$show_related_post_thumbnail      = '';
		$show_related_post_date           = '';
		$show_related_post_author         = '';
		$show_comments                    = '';
		$featured_va_meta_key             = '';
		// Layout Settings - Single Post Page - End

		// Layout Settings - Default Page - Start.
		$show_page_thumbnail  = '';
		$social_share_on_page = '';

		// Layout Settings - Default Page - End.
		if ( get_option( 'amp_wp_layout_settings' ) ) {
			$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );

			// Header Settings - Start.
			$is_show_search         = ( isset( $amp_wp_layout_settings['is_show_search'] ) && ! empty( $amp_wp_layout_settings['is_show_search'] ) ) ? $amp_wp_layout_settings['is_show_search'] : '';
			$is_sticky_header       = ( isset( $amp_wp_layout_settings['is_sticky_header'] ) && ! empty( $amp_wp_layout_settings['is_sticky_header'] ) ) ? $amp_wp_layout_settings['is_sticky_header'] : '';
			$is_show_sidebar        = ( isset( $amp_wp_layout_settings['is_show_sidebar'] ) && ! empty( $amp_wp_layout_settings['is_show_sidebar'] ) ) ? $amp_wp_layout_settings['is_show_sidebar'] : '';
			$sidebar_copyright_text = ( isset( $amp_wp_layout_settings['sidebar_copyright_text'] ) && ! empty( $amp_wp_layout_settings['sidebar_copyright_text'] ) ) ? $amp_wp_layout_settings['sidebar_copyright_text'] : '';
			// Header Settings - End

			// Footer Settings - Start.
			$footer_copyright_text = ( isset( $amp_wp_layout_settings['footer_copyright_text'] ) && ! empty( $amp_wp_layout_settings['footer_copyright_text'] ) ) ? $amp_wp_layout_settings['footer_copyright_text'] : '';
			$non_amp_version       = ( isset( $amp_wp_layout_settings['non_amp_version'] ) && ! empty( $amp_wp_layout_settings['non_amp_version'] ) ) ? $amp_wp_layout_settings['non_amp_version'] : '';
			// Footer Settings - End

			// Layout Settings - Home Page - Start.
			$home_page_layout           = ( isset( $amp_wp_layout_settings['home_page_layout'] ) && ! empty( $amp_wp_layout_settings['home_page_layout'] ) ) ? $amp_wp_layout_settings['home_page_layout'] : '';
			$slider_on_home             = ( isset( $amp_wp_layout_settings['slider_on_home'] ) && ! empty( $amp_wp_layout_settings['slider_on_home'] ) ) ? $amp_wp_layout_settings['slider_on_home'] : '';
			$slider_on_home_count       = ( isset( $amp_wp_layout_settings['slider_on_home_count'] ) && ! empty( $amp_wp_layout_settings['slider_on_home_count'] ) ) ? $amp_wp_layout_settings['slider_on_home_count'] : '';
			$slider_on_home_post_date   = ( isset( $amp_wp_layout_settings['slider_on_home_post_date'] ) && ! empty( $amp_wp_layout_settings['slider_on_home_post_date'] ) ) ? $amp_wp_layout_settings['slider_on_home_post_date'] : '';
			$slider_on_home_post_author = ( isset( $amp_wp_layout_settings['slider_on_home_post_author'] ) && ! empty( $amp_wp_layout_settings['slider_on_home_post_author'] ) ) ? $amp_wp_layout_settings['slider_on_home_post_author'] : '';
			// Layout Settings - Home Page - End

			// Layout Settings - Archive Page - Start.
			$archive_page_layout    = ( isset( $amp_wp_layout_settings['archive_page_layout'] ) && ! empty( $amp_wp_layout_settings['archive_page_layout'] ) ) ? $amp_wp_layout_settings['archive_page_layout'] : '';
			$show_author_in_archive = ( isset( $amp_wp_layout_settings['show_author_in_archive'] ) && ! empty( $amp_wp_layout_settings['show_author_in_archive'] ) ) ? $amp_wp_layout_settings['show_author_in_archive'] : '';
			$show_date_in_archive   = ( isset( $amp_wp_layout_settings['show_date_in_archive'] ) && ! empty( $amp_wp_layout_settings['show_date_in_archive'] ) ) ? $amp_wp_layout_settings['show_date_in_archive'] : '';
			// Layout Settings - Archive Page - End.

			// Layout Settings - Single Post Page - Start.
			$show_thumbnail = ( isset( $amp_wp_layout_settings['show_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_thumbnail'] ) ) ? $amp_wp_layout_settings['show_thumbnail'] : '';

			$show_author_in_single = ( isset( $amp_wp_layout_settings['show_author_in_single'] ) && ! empty( $amp_wp_layout_settings['show_author_in_single'] ) ) ? $amp_wp_layout_settings['show_author_in_single'] : '';

			$show_date_in_single              = ( isset( $amp_wp_layout_settings['show_date_in_single'] ) && ! empty( $amp_wp_layout_settings['show_date_in_single'] ) ) ? $amp_wp_layout_settings['show_date_in_single'] : '';
			$show_tags                        = ( isset( $amp_wp_layout_settings['show_tags'] ) && ! empty( $amp_wp_layout_settings['show_tags'] ) ) ? $amp_wp_layout_settings['show_tags'] : '';
			$social_share_on_post             = ( isset( $amp_wp_layout_settings['social_share_on_post'] ) && ! empty( $amp_wp_layout_settings['social_share_on_post'] ) ) ? $amp_wp_layout_settings['social_share_on_post'] : '';
			$social_share_on_post_count       = ( isset( $amp_wp_layout_settings['social_share_on_post_count'] ) && ! empty( $amp_wp_layout_settings['social_share_on_post_count'] ) ) ? $amp_wp_layout_settings['social_share_on_post_count'] : '';
			$social_share_on_post_link_format = ( isset( $amp_wp_layout_settings['social_share_on_post_link_format'] ) && ! empty( $amp_wp_layout_settings['social_share_on_post_link_format'] ) ) ? $amp_wp_layout_settings['social_share_on_post_link_format'] : '';
			$social_share_links               = ( isset( $amp_wp_layout_settings['social_share_links'] ) && ! empty( $amp_wp_layout_settings['social_share_links'] ) ) ? $amp_wp_layout_settings['social_share_links'] : array();
			$facebook_app_id                  = ( isset( $amp_wp_layout_settings['facebook_app_id'] ) && ! empty( $amp_wp_layout_settings['facebook_app_id'] ) ) ? $amp_wp_layout_settings['facebook_app_id'] : '';
			$show_related_posts               = ( isset( $amp_wp_layout_settings['show_related_posts'] ) && ! empty( $amp_wp_layout_settings['show_related_posts'] ) ) ? $amp_wp_layout_settings['show_related_posts'] : '';
			$show_related_post_count          = ( isset( $amp_wp_layout_settings['show_related_post_count'] ) && ! empty( $amp_wp_layout_settings['show_related_post_count'] ) ) ? $amp_wp_layout_settings['show_related_post_count'] : '';
			$show_related_post_algorithm      = ( isset( $amp_wp_layout_settings['show_related_post_algorithm'] ) && ! empty( $amp_wp_layout_settings['show_related_post_algorithm'] ) ) ? $amp_wp_layout_settings['show_related_post_algorithm'] : '';
			$show_related_post_thumbnail      = ( isset( $amp_wp_layout_settings['show_related_post_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_related_post_thumbnail'] ) ) ? $amp_wp_layout_settings['show_related_post_thumbnail'] : '';
			$show_related_post_date           = ( isset( $amp_wp_layout_settings['show_related_post_date'] ) && ! empty( $amp_wp_layout_settings['show_related_post_date'] ) ) ? $amp_wp_layout_settings['show_related_post_date'] : '';
			$show_related_post_author         = ( isset( $amp_wp_layout_settings['show_related_post_author'] ) && ! empty( $amp_wp_layout_settings['show_related_post_author'] ) ) ? $amp_wp_layout_settings['show_related_post_author'] : '';
			$show_comments                    = ( isset( $amp_wp_layout_settings['show_comments'] ) && ! empty( $amp_wp_layout_settings['show_comments'] ) ) ? $amp_wp_layout_settings['show_comments'] : '';
			$featured_va_meta_key             = ( isset( $amp_wp_layout_settings['featured_va_meta_key'] ) && ! empty( $amp_wp_layout_settings['featured_va_meta_key'] ) ) ? $amp_wp_layout_settings['featured_va_meta_key'] : '';
			// Layout Settings - Single Post Page - End.
			// Layout Settings - Default Page - Start.
			$show_page_thumbnail  = ( isset( $amp_wp_layout_settings['show_page_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_page_thumbnail'] ) ) ? $amp_wp_layout_settings['show_page_thumbnail'] : '';
			$social_share_on_page = ( isset( $amp_wp_layout_settings['social_share_on_page'] ) && ! empty( $amp_wp_layout_settings['social_share_on_page'] ) ) ? $amp_wp_layout_settings['social_share_on_page'] : '';
			// Layout Settings - Default Page - End.
		}

		// Load View.
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-layout.php';
	}

	/**
	 * Save Layout Settings.
	 *
	 * @since       1.4.0
	 */
	public function amp_wp_save_layout_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		$amp_wp_layout_settings = filter_input_array( INPUT_POST );
		if ( $amp_wp_layout_settings ) :
			foreach ( $amp_wp_layout_settings as $key => $value ) {
				if ( strstr( $key, 'layout_settings' ) ) {

					if ( isset( $value['is_show_search'] ) ) {
						$value['is_show_search'] = 1;
					}

					if ( isset( $value['is_sticky_header'] ) ) {
						$value['is_sticky_header'] = 1;
					}

					if ( isset( $value['is_show_sidebar'] ) ) {
						$value['is_show_sidebar'] = 1;
					}

					if ( isset( $value['non_amp_version'] ) ) {
						$value['non_amp_version'] = 1;
					}

					if ( isset( $value['show_thumbnail'] ) ) {
						$value['show_thumbnail'] = 1;
					}

					if ( isset( $value['show_author_in_archive'] ) ) {
						$value['show_author_in_archive'] = 1;
					}

					if ( isset( $value['show_author_in_single'] ) ) {
						$value['show_author_in_single'] = 1;
					}

					if ( isset( $value['show_date_in_archive'] ) ) {
						$value['show_date_in_archive'] = 1;
					}

					if ( isset( $value['show_date_in_single'] ) ) {
						$value['show_date_in_single'] = 1;
					}

					if ( isset( $value['social_share_on_post'] ) ) {
						$value['social_share_on_post'] = 1;
					}

					if ( isset( $value['show_tags'] ) ) {
						$value['show_tags'] = 1;
					}

					if ( isset( $value['show_related_posts'] ) ) {
						$value['show_related_posts'] = 1;
					}
					if ( isset( $value['show_related_post_thumbnail'] ) ) {
						$value['show_related_post_thumbnail'] = 1;
					}

					if ( isset( $value['show_related_post_date'] ) ) {
						$value['show_related_post_date'] = 1;
					}

					if ( isset( $value['show_related_post_author'] ) ) {
						$value['show_related_post_author'] = 1;
					}

					if ( isset( $value['show_comments'] ) ) {
						$value['show_comments'] = 1;
					}

					if ( isset( $value['slider_on_home'] ) ) {
						$value['slider_on_home'] = 1;
					}

					if ( isset( $value['slider_on_home_post_date'] ) ) {
						$value['slider_on_home_post_date'] = 1;
					}

					if ( isset( $value['slider_on_home_post_author'] ) ) {
						$value['slider_on_home_post_author'] = 1;
					}

					if ( isset( $value['show_page_thumbnail'] ) ) {
						$value['show_page_thumbnail'] = 1;
					}

					if ( isset( $value['social_share_on_page'] ) ) {
						$value['social_share_on_page'] = 1;
					}
					update_option( sanitize_key( $key ), $value );
				}
			}

			// Remove Layout Options.
			remove_theme_mod( 'amp-wp-post-show-thumbnail' );
			remove_theme_mod( 'amp-wp-post-show-comment' );
			remove_theme_mod( 'amp-wp-post-show-related' );
			remove_theme_mod( 'amp-wp-post-related-count' );
			remove_theme_mod( 'amp-wp-post-related-algorithm' );
			remove_theme_mod( 'amp-wp-post-social-share-show' );
			remove_theme_mod( 'amp-wp-post-social-share-count' );
			remove_theme_mod( 'amp-wp-post-social-share-link-format' );
			remove_theme_mod( 'amp-wp-featured-va-key' );

			// Remove Page Options.
			remove_theme_mod( 'amp-wp-on-home' );
			remove_theme_mod( 'amp-wp-home-show-slide' );
			remove_theme_mod( 'amp-wp-home-listing' );
			remove_theme_mod( 'amp-wp-on-search' );
			remove_theme_mod( 'amp-wp-filter-post-types' );
			remove_theme_mod( 'amp-wp-filter-taxonomies' );
			remove_theme_mod( 'amp-wp-page-social-share-show' );
		endif;
	}
}
new Amp_WP_Layout();
