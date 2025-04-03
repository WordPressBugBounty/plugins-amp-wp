<?php
/**
 * AMP WP Template Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @category    Template
 * @package     Amp_WP/Functions
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018-2019, Pixelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.

// Add Ads into AMP WP Ads Manager panel if that was available.
if ( is_amp_wp_ads_manager_plugin_active() ) {
	amp_wp_template_part( 'amp-wp-ads-manager/ads' );
}

add_image_size( 'amp-wp-small', 100, 100, array( 'center', 'center' ) ); // Main Post Image In Small Width.
add_image_size( 'amp-wp-large', 738, 430, array( 'center', 'center' ) ); // Main Post Image In Full Width.
add_image_size( 'amp-wp-normal', 230, 160, array( 'center', 'center' ) ); // Main Post Image In Normal Width.

register_nav_menus( array( 'amp-wp-sidebar-nav' => __( 'AMP Sidebar', 'amp-wp' ) ) );
register_nav_menus( array( 'amp-wp-footer' => __( 'AMP Footer Menu', 'amp-wp' ) ) );

// Hook to enqueue style.
add_action( 'amp_wp_template_head', 'amp_wp_enqueue_styles', 0 );

if ( ! function_exists( 'amp_wp_language_attributes' ) ) :

	/**
	 * Get the Language Attributes for the HTML Tag.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_language_attributes() {
		$attributes = array();
		if ( function_exists( 'is_rtl' ) && is_rtl() ) {
			$attributes[] = 'dir="rtl"';
		}
		if ( $lang = get_bloginfo( 'language' ) ) {
			$attributes[] = "lang=\"$lang\"";
		}
		$output = implode( ' ', $attributes );
		echo $output;
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_styles' ) ) :

	/**
	 * Enqueue Static File for AMP Version
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_enqueue_styles() {
		amp_wp_enqueue_style( 'amp-wp-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		amp_wp_enqueue_style( 'amp-wp-google-fonts', 'https://fonts.googleapis.com/css?family=Karla|Noto+Sans:700|Overpass+Mono' );
		amp_wp_enqueue_block_style( 'global', AMP_WP_TEMPLATE_DIR_CSS . 'global/global' );
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_static' ) ) :

	/**
	 * Enqueue Static File for AMP Version
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_enqueue_static() {
		$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
		$is_show_sidebar        = ( isset( $amp_wp_layout_settings['is_show_sidebar'] ) && ! empty( $amp_wp_layout_settings['is_show_sidebar'] ) ) ? $amp_wp_layout_settings['is_show_sidebar'] : '';

		if ( 1 === $is_show_sidebar ) {
			amp_wp_enqueue_script( 'amp-sidebar', 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js' );
		}
	}
endif;

// Enqueue Static File Hook.
add_action( 'amp_wp_template_enqueue_scripts', 'amp_wp_enqueue_static' );

if ( ! function_exists( 'amp_wp_custom_styles' ) ) :

	/**
	 * Prints Custom Codes of AMP Theme After All Styles
	 *
	 * @version 1.0.0
	 * @since       1.0.0
	 */
	function amp_wp_custom_styles() {
		$header_text_color       = amp_wp_get_theme_mod( 'amp-wp-header-text-color', false );
		$header_background_color = amp_wp_get_theme_mod( 'amp-wp-header-background-color', false );
		$theme_color             = amp_wp_get_theme_mod( 'amp-wp-color-theme', false );
		$text_color              = amp_wp_get_theme_mod( 'amp-wp-color-text', false );
		ob_start();
		?>
		.site-header .logo a, .site-header .header-nav > li > a, .site-header .header-nav > li .navbar-toggle { color: <?php echo esc_attr( $header_text_color ); ?>; }
		.site-header { background: <?php echo esc_attr( $header_background_color ); ?>; }

		<?php // Theme Color. ?>
		.pagination .nav-links .page-numbers.prev,
		.pagination .nav-links .page-numbers.next,
		.listing-item a.post-read-more,
		.post-terms.cats .term-type,
		.post-terms a:hover,
		.search-form .search-submit,
		.amp-wp-main-link a,
		.post-categories li a,
		.amp-btn,.amp-btn:active,.amp-btn:focus,.amp-btn:hover,
		amp-web-push-widget button.subscribe:active, amp-web-push-widget button.subscribe:focus, amp-web-push-widget button.subscribe:hover,
		.archive-wrapper {
			background: <?php echo esc_attr( $theme_color ); ?>;
		}
		.entry-content ul.amp-wp-shortcode-list li:before, a {
			color: <?php echo esc_attr( $text_color ); ?>;
		}
		.amp-btn,.amp-btn:active,.amp-btn:focus,.amp-btn:hover, .post-terms.tags a:hover,.post-terms.tags a:focus,.post-terms.tags a:active,
		amp-web-push-widget button.subscribe:active, amp-web-push-widget button.subscribe:focus, amp-web-push-widget button.subscribe:hover {
			border-color: <?php echo esc_attr( $theme_color ); ?>;
		}

		<?php // Other Colors. ?>
		body.body {
			background:<?php echo amp_wp_get_theme_mod( 'amp-wp-color-bg', false ); ?>;
			color: <?php echo esc_attr( $text_color ); ?>;
		}
		.amp-wp-footer-nav {
			background:<?php echo amp_wp_get_theme_mod( 'amp-wp-color-footer-nav-bg', false ); ?>;
		}
		.amp-wp-copyright {
			background:<?php echo amp_wp_get_theme_mod( 'amp-wp-color-footer-bg', false ); ?>;
		}
		<?php
		amp_wp_add_inline_style( ob_get_clean(), 'theme_panel_color_fields' );
		amp_wp_add_inline_style( amp_wp_get_theme_mod( 'amp-wp-additional-css', false ), 'custom_codes_from_panel' );
	}
endif;

// AMP WP Custom Styles Hook.
add_action( 'amp_wp_template_enqueue_scripts', 'amp_wp_custom_styles', 100 );

if ( ! function_exists( 'amp_wp_default_theme_logo' ) ) :

	/**
	 * Get Theme Logo
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return object
	 */
	function amp_wp_default_theme_logo() {
		ob_start();
		$site_branding = amp_wp_get_branding_info();
		?>
		<a href="<?php echo esc_url( amp_wp_home_url() ); ?>" class="<?php echo ! empty( $site_branding['logo-tag'] ) ? 'image-logo' : 'text-logo'; ?> ">
		<?php echo ( ! empty( $site_branding['logo-tag'] ) ) ? $site_branding['logo-tag'] : esc_attr( $site_branding['name'] ); ?>
		</a>
		<?php
		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'amp_wp_default_theme_sidebar_logo' ) ) :

	/**
	 * Get Theme Sidebar Logo
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  object
	 */
	function amp_wp_default_theme_sidebar_logo() {
		ob_start();
		$site_branding = amp_wp_get_branding_info( 'sidebar' );
		?>
		<a
			href="<?php echo esc_url( amp_wp_home_url() ); ?>"
			class="branding <?php echo ! empty( $site_branding['logo-tag'] ) ? 'image-logo' : 'text-logo'; ?>"
		>
		<?php echo ( ! empty( $site_branding['logo-tag'] ) ) ? $site_branding['logo-tag'] : esc_attr( $site_branding['name'] ); ?>
		</a>
		<?php
		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'amp_wp_page_listing' ) ) :

	/**
	 * Detects and returns current page listing style
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @since   1.2.0 - Removed customizer settings
	 *
	 * @return  string
	 */
	function amp_wp_page_listing() {
		static $listing;

		if ( $listing ) {
			return $listing; }

		$listing = 'default';
		if ( is_home() ) {
			if ( get_option( 'amp_wp_layout_settings' ) ) {
				$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
				if ( isset( $amp_wp_layout_settings['home_page_layout'] ) ) {
					$listing = $amp_wp_layout_settings['home_page_layout'];
				}
			}
		}

		if ( empty( $listing ) || 'default' === $listing ) {
			if ( get_option( 'amp_wp_layout_settings' ) ) {
				$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
				if ( isset( $amp_wp_layout_settings['archive_page_layout'] ) ) {
					$listing = $amp_wp_layout_settings['archive_page_layout'];
				}
			}
		}

		return $listing;
	}

endif;

if ( ! function_exists( 'amp_wp_translation_stds' ) ) {

	/**
	 * Prepares translation default values
	 *
	 * @param array $std Default Labels Translations.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function amp_wp_translation_stds( $std = array() ) {
		$std['prev']                     = 'Previous';
		$std['next']                     = 'Next';
		$std['page']                     = 'Page';
		$std['page_of']                  = 'of %d';
		$std['by_on']                    = 'By %s1 on %s2';
		$std['browse_author_articles']   = 'Browse Author Articles';
		$std['add_comment']              = 'Add Comment';
		$std['share']                    = 'Share';
		$std['header']                   = 'Top Header';
		$std['side-header']              = 'Side Header';
		$std['tags']                     = 'Tags:';
		$std['404_message']              = 'Oops! That page cannot be found.';
		$std['view_desktop']             = 'View Desktop Version';
		$std['listing_2_date']           = 'M d, Y';
		$std['search_on_site']           = 'Search on site:';
		$std['search_input_placeholder'] = 'Search &hellip;';
		$std['search_button']            = 'Search';

		$std['browsing']                  = 'Browsing';
		$std['archive']                   = 'Archive';
		$std['browsing_category']         = 'Browsing category';
		$std['browsing_tag']              = 'Browsing tag';
		$std['browsing_author']           = 'Browsing author';
		$std['browsing_yearly']           = 'Browsing yearly archive';
		$std['browsing_monthly']          = 'Browsing monthly archive';
		$std['browsing_daily']            = 'Browsing daily archive';
		$std['browsing_product_category'] = 'Browsing shop category';
		$std['browsing_product_tag']      = 'Browsing shop tag';
		$std['related_posts']             = 'Related Posts';

		$std['asides']    = 'Asides';
		$std['galleries'] = 'Galleries';
		$std['images']    = 'Images';
		$std['videos']    = 'Videos';
		$std['quotes']    = 'Quotes';
		$std['links']     = 'Links';
		$std['statuses']  = 'Statuses';
		$std['audio']     = 'Audio';
		$std['chats']     = 'Chats';

		/**
		 * Comments Texts
		 */
		$std['comments']          = 'Comments';
		$std['add_comment']       = 'Add Comment';
		$std['comments_edit']     = 'Edit Comment';
		$std['comments_reply']    = 'Leave a Reply';
		$std['comments_reply_to'] = 'Reply To %s';

		$std['comment_previous']     = 'Previous';
		$std['comment_next']         = 'Next';
		$std['comment_page_numbers'] = 'Page %1$s of %2$s';

		/**
		 * Attachment Texts
		 */
		$std['attachment-return-to'] = 'Return to "%s"';
		// To-do change this id.
		$std['click-here']               = 'Click here';
		$std['attachment-play-video']    = '%s to play video';
		$std['attachment-play-audio']    = '%s to play audio';
		$std['attachment-download-file'] = '%s to Download File';
		$std['attachment-prev']          = 'Previous';
		$std['attachment-next']          = 'Next';

		/**
		 * WooCommerce Texts
		 */
		$std['product-shop']    = 'Shop';
		$std['product-desc']    = 'Description';
		$std['product-reviews'] = 'Reviews(%s)';
		$std['product-view']    = 'View';
		$std['product-sale']    = 'Sale!';

		/**
		 * Notice Bar & GDPR
		 */
		$std['notice-bar-text']        = __( 'This website uses cookies.', 'amp-wp' );
		$std['notice-bar-button-text'] = __( 'Accept', 'amp-wp' );

		$std['headline-text']                       = __( 'Headline', 'amp-wp' );
		$std['message-to-visitor']                  = __( 'This is GDPR Message.', 'amp-wp' );
		$std['message-to-visitor-description']      = __( 'This is the message that you want to share with the audience.', 'amp-wp' );
		$std['accept-button-text']                  = __( 'Accept', 'amp-wp' );
		$std['reject-button-text']                  = __( 'Reject', 'amp-wp' );
		$std['for-more-information']                = __( 'For More Information About Privacy', 'amp-wp' );
		$std['for-more-information-description']    = __( 'Text Before the Privacy Page Button.', 'amp-wp' );
		$std['select-the-privacy-page']             = __( '--Select--', 'amp-wp' );
		$std['select-the-privacy-page-description'] = __( 'Select the Privacy Page to Display.', 'amp-wp' );
		$std['privacy-page-button-text']            = __( 'Click Here', 'amp-wp' );

		/**
		 * OneSignal – Web Push Notifications
		 */
		$std['onesignal_subscribe']  = __( 'Subscribe to updates', 'amp-wp' );
		$std['onesignal_unsubsribe'] = __( 'Unsubscribe from updates', 'amp-wp' );

		return $std;
	}
}
add_filter( 'amp_wp_translation_std', 'amp_wp_translation_stds' );

if ( ! function_exists( 'amp_wp_auto_embed_content' ) ) :

	/**
	 * Filter Callback: Auto-embed using a link
	 *
	 * @param   string $content
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return string
	 */
	function amp_wp_auto_embed_content( $content ) {
		if ( ! is_string( $content ) ) {
			return array(
				'type'    => 'unknown',
				'content' => '',
			);
		}

		// Custom External Videos.
		preg_match( '#^(http|https)://.+\.(mp4|m4v|webm|ogv|wmv|flv)$#i', $content, $matches );
		if ( ! empty( $matches[0] ) ) {
			return array(
				'type'    => 'external-video',
				'content' => do_shortcode( '[video src="' . $matches[0] . '"]' ),
			);
		}

		// Custom External Audio.
		preg_match( '#^(http|https)://.+\.(mp3|m4a|ogg|wav|wma)$#i', $content, $matches );
		if ( ! empty( $matches[0] ) ) {
			return array(
				'type'    => 'external-audio',
				'content' => do_shortcode( '[audio src="' . $matches[0] . '"]' ),
			);
		}

		// Default Embeds and Other Registered.
		global $wp_embed;
		if ( ! is_object( $wp_embed ) ) {
			return array(
				'type'    => 'unknown',
				'content' => $content,
			);
		}

		$embed = $wp_embed->autoembed( $content );
		if ( $embed !== $content ) {
			return array(
				'type'    => 'embed',
				'content' => $embed,
			);
		}

		// No Embed Detected!
		return array(
			'type'    => 'unknown',
			'content' => $content,
		);
	}

endif;

if ( ! function_exists( 'amp_wp_set_show_on_front' ) ) :
	/**
	 * Setup show on front option value
	 *
	 * @since   1.0.0
	 * @return  bool|string
	 */
	function amp_wp_set_show_on_front() {
		return amp_wp_get_theme_mod( 'amp-wp-show-on-front' );
	}
endif;
add_filter( 'amp_wp_template_show_on_front', 'amp_wp_set_show_on_front' );

if ( ! function_exists( 'amp_wp_set_page_on_front' ) ) :

	/**
	 * Setup Page on Front Option Value
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  bool|string
	 */
	function amp_wp_set_page_on_front() {
		return amp_wp_get_theme_mod( 'amp-wp-page-on-front' );
	}
endif;
add_filter( 'amp_wp_template_page_on_front', 'amp_wp_set_page_on_front' );

if ( is_amp_wp() ) :

	$exclude_urls = '';
	if ( get_option( 'amp_wp_general_settings' ) ) {
		$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
		if ( isset( $amp_wp_general_settings['exclude_urls'] ) && ! empty( $amp_wp_general_settings['exclude_urls'] ) ) {
			$exclude_urls = $amp_wp_general_settings['exclude_urls'];
		}
	}
	if ( isset( $exclude_urls ) && ! empty( $exclude_urls ) ) :
		Amp_WP_Content_Sanitizer::set_non_amp_url( explode( "\n", trim( $exclude_urls ) ) );
	endif;
endif;

if ( ! function_exists( 'amp_wp_custom_code_head' ) ) :

	/**
	 * Prints Custom Codes Inside Head Tag
	 *
	 * @hooked amp_wp_template_head
	 */
	function amp_wp_custom_code_head() {
		echo amp_wp_get_option( 'amp-wp-code-head', false );
	}

endif;
add_action( 'amp_wp_template_head', 'amp_wp_custom_code_head' );

if ( ! function_exists( 'amp_wp_custom_code_body_start' ) ) :

	/**
	 * Prints Custom Codes Right After Body Tag Start
	 *
	 * @hooked amp_wp_template_body_start
	 */
	function amp_wp_custom_code_body_start() {
		echo amp_wp_get_option( 'amp-wp-code-body-start', false );
	}

endif;
add_action( 'amp_wp_template_body_start', 'amp_wp_custom_code_body_start' );

if ( ! function_exists( 'amp_wp_custom_code_body_stop' ) ) :

	/**
	 * Prints custom codes before body tag close
	 *
	 * @hooked amp_wp_template_footer
	 */
	function amp_wp_custom_code_body_stop() {
		echo amp_wp_get_option( 'amp-wp-code-body-stop', false );
	}

endif;
add_action( 'amp_wp_template_footer', 'amp_wp_custom_code_body_stop' );

if ( ! function_exists( 'amp_wp_auto_redirect_mobiles' ) ) :

	/**
	 * Trigger Auto Redirect Option
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  bool    true If Active
	 */
	function amp_wp_auto_redirect_mobiles() {
		$mobile_auto_redirect = '';
		if ( get_option( 'amp_wp_general_settings' ) ) {
			$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
			if ( isset( $amp_wp_general_settings['mobile_auto_redirect'] ) && ! empty( $amp_wp_general_settings['mobile_auto_redirect'] ) ) {
				$mobile_auto_redirect = $amp_wp_general_settings['mobile_auto_redirect'];
			}
		}
		return $mobile_auto_redirect;
	}
endif;
add_filter( 'amp_wp_template_auto_redirect', 'amp_wp_auto_redirect_mobiles' );

if ( ! function_exists( 'amp_wp_list_post_types' ) ) {

	/**
	 * List available and public post types.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function amp_wp_list_post_types() {

		$results = array();
		foreach ( get_post_types(
			array(
				'public'             => true,
				'publicly_queryable' => true,
			)
		) as $post_type => $_ ) {
			if ( ! $post_type_object = get_post_type_object( $post_type ) ) {
				continue;
			}
			$results[ $post_type ] = $post_type_object->label;
		}
		return $results;
	}
}

if ( ! function_exists( 'amp_wp_list_taxonomies' ) ) {

	/**
	 * List Available and Public Taxonomies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function amp_wp_list_taxonomies() {
		$results    = array();
		$taxonomies = get_taxonomies( array( 'public' => true ) );
		if ( $taxonomies ) {
			unset( $taxonomies['post_format'] );
			foreach ( $taxonomies as $id => $_ ) {
				if ( $object = get_taxonomy( $id ) ) {
					$results[ $id ] = $object->label;
				}
			}
		}
		return $results;
	}
}

if ( ! function_exists( 'amp_wp_filter_config' ) ) {

	/**
	 * @param array $filters
	 *
	 * @since       1.2.0
	 * @return  array
	 */
	function amp_wp_filter_config( $filters ) {
		$amp_on_home       = '';
		$amp_on_search     = '';
		$amp_on_post_types = array();
		$amp_on_taxonomies = array();
		if ( get_option( 'amp_wp_general_settings' ) ) {
			$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
			if ( isset( $amp_wp_general_settings['amp_on_home'] ) && ! empty( $amp_wp_general_settings['amp_on_home'] ) ) {
				$amp_on_home = $amp_wp_general_settings['amp_on_home'];
			}

			if ( isset( $amp_wp_general_settings['amp_on_search'] ) && ! empty( $amp_wp_general_settings['amp_on_search'] ) ) {
				$amp_on_search = $amp_wp_general_settings['amp_on_search'];
			}

			if ( isset( $amp_wp_general_settings['amp_on_post_types'] ) && ! empty( $amp_wp_general_settings['amp_on_post_types'] ) ) {
				$amp_on_post_types = (array) $amp_wp_general_settings['amp_on_post_types'];
			}

			if ( isset( $amp_wp_general_settings['amp_on_taxonomies'] ) && ! empty( $amp_wp_general_settings['amp_on_taxonomies'] ) ) {
				$amp_on_taxonomies = (array) $amp_wp_general_settings['amp_on_taxonomies'];
			}
		}

		$filters['disabled_homepage']   = ! $amp_on_home;
		$filters['disabled_search']     = ! $amp_on_search;
		$filters['disabled_post_types'] = $amp_on_post_types;
		$filters['disabled_taxonomies'] = $amp_on_taxonomies;

		return $filters;
	}
}
add_filter( 'amp_wp_filter_config_list', 'amp_wp_filter_config' );

if ( ! function_exists( 'amp_wp_set_url_format' ) ) {

	/**
	 * Set default AMP URL structure.
	 *
	 * @hooked  amp_wp_url_format_filter
	 *
	 * @param   string $default
	 * @since   1.0.4
	 *
	 * @return  string
	 */
	function amp_wp_set_url_format( $default ) {
		$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
		return ( isset( $amp_wp_general_settings['url_structure'] ) && ! empty( $amp_wp_general_settings['url_structure'] ) ) ? $amp_wp_general_settings['url_structure'] : 'start-point';
	}
}
add_filter( 'amp_wp_url_format_filter', 'amp_wp_set_url_format' );

if ( ! function_exists( 'amp_wp_analytics_ga_callback' ) ) :

	/**
	 * Prints Google Analytic Code
	 *
	 * @hooked amp_wp_analytics_ga
	 * @since 1.0.0
	 */
	function amp_wp_analytics_ga_callback() {
		$ga_switch = '';
		$ga_code   = '';
		if ( get_option( 'amp_wp_ga' ) ) {
			$amp_wp_ga = get_option( 'amp_wp_ga' );
			$ga_switch = $amp_wp_ga['ga_switch'];
			$ga_code   = $amp_wp_ga['ga'];
		}

		if ( $ga_switch && $ga_code ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="googleanalytics" id="googleanalytics">
				<script type="application/json">
				{
					"vars": {
						"account": "<?php echo esc_attr( $ga_code ); ?>"
					},
					"triggers": {
						"trackPageview": {
							"on": "visible",
							"request": "pageview"
						}
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_ga', 'amp_wp_analytics_ga_callback' );

if ( ! function_exists( 'amp_wp_analytics_fbp_callback' ) ) :

	/**
	 * Prints Facebook Pixel Code
	 *
	 * @hooked amp_wp_analytics_fbp
	 * @since 1.0.0
	 */
	function amp_wp_analytics_fbp_callback() {
		$fbp_switch = '';
		$fbp_code   = '';
		if ( get_option( 'amp_wp_fbp' ) ) {
			$amp_wp_fbp = get_option( 'amp_wp_fbp' );
			$fbp_switch = $amp_wp_fbp['fbp_switch'];
			$fbp_code   = $amp_wp_fbp['fbp'];
		}
		if ( $fbp_switch && $fbp_code ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="facebookpixel" id="facebook-pixel">
				<script type="application/json">
					{
						"vars": {
							"pixelId": "<?php echo esc_attr( $fbp_code ); ?>"
						},
						"triggers": {
							"trackPageview": {
								"on": "visible",
								"request": "pageview"
							}
						}
					}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_fbp', 'amp_wp_analytics_fbp_callback' );

if ( ! function_exists( 'amp_wp_analytics_sa_callback' ) ) :

	/**
	 * Prints Segment Analytics Code
	 *
	 * @hooked amp_wp_analytics_sa
	 * @since 1.0.0
	 */
	function amp_wp_analytics_sa_callback() {
		$sa_switch = '';
		$sa_code   = '';
		if ( get_option( 'amp_wp_sa' ) ) {
			$amp_wp_sa = get_option( 'amp_wp_sa' );
			$sa_switch = $amp_wp_sa['sa_switch'];
			$sa_code   = $amp_wp_sa['sa'];
		}

		if ( $sa_switch && $sa_code ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="segment" id="segment">
				<script type="application/json">
				{
					"vars": {
						"writeKey": "<?php echo esc_attr( $sa_code ); ?>",
						"name": "<?php the_title(); ?>"
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_sa', 'amp_wp_analytics_sa_callback' );

if ( ! function_exists( 'amp_wp_analytics_qc_callback' ) ) :

	/**
	 * Prints Quantcast pCode
	 *
	 * @hooked amp_wp_analytics_qc
	 * @since 1.0.0
	 */
	function amp_wp_analytics_qc_callback() {
		$qc_switch = '';
		$qc_code   = '';
		if ( get_option( 'amp_wp_qc' ) ) {
			$amp_wp_qc = get_option( 'amp_wp_qc' );
			$qc_switch = $amp_wp_qc['qc_switch'];
			$qc_code   = $amp_wp_qc['qc'];
		}
		if ( $qc_switch && $qc_code ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="quantcast" id="quantcast">
				<script type="application/json">
				{
					"vars": {
						"pcode": "<?php echo esc_attr( $qc_code ); ?>",
						"labels": [ "AMPProject" ]
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_qc', 'amp_wp_analytics_qc_callback' );

if ( ! function_exists( 'amp_wp_analytics_acm_callback' ) ) :

	/**
	 * Tracking - Alexa Certified Metrics
	 *
	 * @hooked amp_wp_analytics_acm
	 * @since 1.0.2
	 */
	function amp_wp_analytics_acm_callback() {
		$acm_switch  = '';
		$acm_account = '';
		$acm_domain  = '';
		if ( get_option( 'amp_wp_acm' ) ) {
			$amp_wp_acm  = get_option( 'amp_wp_acm' );
			$acm_switch  = $amp_wp_acm['acm_switch'];
			$acm_account = $amp_wp_acm['acm_account'];
			$acm_domain  = $amp_wp_acm['acm_domain'];
		}

		if ( $acm_switch && $acm_account && $acm_domain ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="alexametrics" id="alexametrics">
				<script type="application/json">
				{
					"vars": {
						"atrk_acct": "<?php echo esc_attr( $acm_account ); ?>",
						"domain": "<?php echo esc_url( $acm_domain ); ?>"
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_acm', 'amp_wp_analytics_acm_callback' );

if ( ! function_exists( 'amp_wp_analytics_cb_callback' ) ) :

	/**
	 * Tracking - Chartbeat Analytics
	 *
	 * @hooked amp_wp_analytics_cb
	 * @since 1.0.2
	 */
	function amp_wp_analytics_cb_callback() {
		$cb_switch   = '';
		$cb_analytic = '';
		$cb_domain   = '';
		if ( get_option( 'amp_wp_cb' ) ) {
			$amp_wp_cb   = get_option( 'amp_wp_cb' );
			$cb_switch   = $amp_wp_cb['cb_switch'];
			$cb_analytic = $amp_wp_cb['cb_analytic'];
			$cb_domain   = $amp_wp_cb['cb_domain'];
		}

		if ( $cb_switch && $cb_analytic && $cb_domain ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="chartbeat" id="chartbeat">
				<script type="application/json">
				{
					"vars": {
						"uid": "<?php echo esc_attr( $cb_analytic ); ?>",
						"domain": "<?php echo esc_url( $cb_domain ); ?>"
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_cb', 'amp_wp_analytics_cb_callback' );

if ( ! function_exists( 'amp_wp_analytics_comscore_callback' ) ) :

	/**
	 * Tracking - comScore UDM pageview
	 *
	 * @hooked amp_wp_analytics_comscore
	 * @since 1.0.2
	 */
	function amp_wp_analytics_comscore_callback() {
		$comscore_switch      = '';
		$comscore_tracking_id = '';
		if ( get_option( 'amp_wp_comscore' ) ) {
			$amp_wp_comscore      = get_option( 'amp_wp_comscore' );
			$comscore_switch      = $amp_wp_comscore['comscore_switch'];
			$comscore_tracking_id = $amp_wp_comscore['comscore_tracking_id'];
		}

		if ( $comscore_switch && $comscore_tracking_id ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="comscore" id="comscore">
				<script type="application/json">
				{
					"vars": {
						"c2": "<?php echo esc_attr( $comscore_tracking_id ); ?>"
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_comscore', 'amp_wp_analytics_comscore_callback' );

if ( ! function_exists( 'amp_wp_analytics_yandex_metrica_callback' ) ) :

	/**
	 * Tracking - Yandex Metrica
	 *
	 * @hooked amp_wp_analytics_yandex_metrica
	 * @since 1.0.4
	 */
	function amp_wp_analytics_yandex_metrica_callback() {

		$amp_wp_yandex_metrica_switch     = '';
		$amp_wp_yandex_metrica_counter_id = '';

		if ( get_option( 'amp_wp_yandex_metrica' ) ) {
			$amp_wp_yandex_metrica            = get_option( 'amp_wp_yandex_metrica' );
			$amp_wp_yandex_metrica_switch     = $amp_wp_yandex_metrica['yandex_metrica_switch'];
			$amp_wp_yandex_metrica_counter_id = $amp_wp_yandex_metrica['yandex_metrica_counter_id'];
		}

		if ( $amp_wp_yandex_metrica_switch && $amp_wp_yandex_metrica_counter_id ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="metrika" id="metrika">
				<script type="application/json">
				{
					"vars": {
						"counterId": "<?php echo esc_attr( $amp_wp_yandex_metrica_counter_id ); ?>"
					},
					"triggers": {
						"notBounce": {
							"on": "timer",
							"timerSpec": {
								"immediate": false,
								"interval": 15,
								"maxTimerLength": 16
							},
							"request": "notBounce"
						}
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_yandex_metrica', 'amp_wp_analytics_yandex_metrica_callback' );

if ( ! function_exists( 'amp_wp_analytics_afs_callback' ) ) :

	/**
	 * Tracking - AFS Analytics
	 *
	 * @hooked amp_wp_analytics_afs
	 * @since 1.0.4
	 */
	function amp_wp_analytics_afs_callback() {

		$afs_switch     = '';
		$afs_website_id = '';

		if ( get_option( 'amp_wp_afs' ) ) {
			$amp_wp_afs     = get_option( 'amp_wp_afs' );
			$afs_switch     = $amp_wp_afs['afs_switch'];
			$afs_website_id = $amp_wp_afs['afs_website_id'];

			$afs_server = 'www';
			if ( $afs_website_id > 99999 ) {
				$afs_server = 'www1';
			}
			if ( $afs_website_id > 199999 ) {
				$afs_server = 'www2';
			}
			if ( $afs_website_id > 299999 ) {
				$afs_server = 'www3';
			}
			if ( $afs_website_id > 399999 ) {
				$afs_server = 'www4';
			}
			if ( $afs_website_id > 499999 ) {
				$afs_server = 'www5';
			}
			if ( $afs_website_id > 599999 ) {
				$afs_server = 'www6';
			}
			if ( $afs_website_id > 699999 ) {
				$afs_server = 'www7';
			}
			if ( $afs_website_id > 799999 ) {
				$afs_server = 'www8';
			}
			if ( $afs_website_id > 899999 ) {
				$afs_server = 'www9';
			}
			if ( $afs_website_id > 999999 ) {
				$afs_server = 'www10';
			}
		}

		if ( $afs_switch && $afs_website_id ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="afsanalytics" id="afsanalytics">
				<script type="application/json">
				{
					"vars": {
						"server": "<?php echo esc_attr( $afs_server ); ?>",
						"websiteid": "<?php echo esc_attr( $afs_website_id ); ?>"
						"title": "<?php echo esc_attr( get_the_title() ); ?>"
						"url": "<?php echo esc_url( get_the_permalink() ); ?>"
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_afs', 'amp_wp_analytics_afs_callback' );

if ( ! function_exists( 'amp_wp_analytics_adobe_callback' ) ) :

	/**
	 * Tracking - Adobe Analytics
	 *
	 * @hooked amp_wp_analytics_adobe
	 * @since 1.0.4
	 */
	function amp_wp_analytics_adobe_callback() {

		$adobe_switch          = '';
		$adobe_host_name       = '';
		$adobe_report_suite_id = '';

		if ( get_option( 'amp_wp_adobe' ) ) {
			$amp_wp_adobe          = get_option( 'amp_wp_adobe' );
			$adobe_switch          = $amp_wp_adobe['adobe_switch'];
			$adobe_host_name       = $amp_wp_adobe['adobe_host_name'];
			$adobe_report_suite_id = $amp_wp_adobe['adobe_report_suite_id'];
		}

		if ( $adobe_switch && $adobe_host_name && $adobe_report_suite_id ) :
			amp_wp_enqueue_script( 'amp-analytics', 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js' );
			?>
			<amp-analytics type="adobeanalytics">
				<script type="application/json">
				{
					"vars": {
						"host": "<?php echo esc_attr( $adobe_host_name ); ?>",
						"reportSuites": "<?php echo esc_attr( $adobe_report_suite_id ); ?>",
					},
					"triggers": {
						"pageLoad": {
							"on": "visible",
							"request": "pageView"
						}
					}
				}
				</script>
			</amp-analytics>
			<?php
		endif;
	}
endif;
add_action( 'amp_wp_analytics_adobe', 'amp_wp_analytics_adobe_callback' );

if ( ! function_exists( 'amp_wp_notifications_bar_callback' ) ) :

	/**
	 * Prints Notice Bar
	 *
	 * @hooked  amp_wp_notifications_bar
	 * @since   1.0.0
	 */
	function amp_wp_notifications_bar_callback() {
		// Get Notice Bar Values.
		$noticebar_switch             = '';
		$noticebar_consent            = '';
		$noticebar_accept_button_text = '';

		if ( get_option( 'amp_wp_noticebar_settings' ) ) {
			$amp_wp_noticebar_settings    = get_option( 'amp_wp_noticebar_settings' );
			$noticebar_switch             = ( isset( $amp_wp_noticebar_settings['noticebar_switch'] ) && ! empty( $amp_wp_noticebar_settings['noticebar_switch'] ) ) ? $amp_wp_noticebar_settings['noticebar_switch'] : '';
			$noticebar_consent            = ( isset( $amp_wp_noticebar_settings['consent'] ) && ! empty( $amp_wp_noticebar_settings['consent'] ) ) ? $amp_wp_noticebar_settings['consent'] : __( 'This website uses cookies.', 'amp-wp' );
			$noticebar_accept_button_text = ( isset( $amp_wp_noticebar_settings['accept_button_text'] ) && ! empty( $amp_wp_noticebar_settings['accept_button_text'] ) ) ? $amp_wp_noticebar_settings['accept_button_text'] : __( 'Accept', 'amp-wp' );
		}

		if ( '1' == $noticebar_switch ) :
			amp_wp_enqueue_block_style( 'notification', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/notification/notification' );
			amp_wp_enqueue_script( 'amp-user-notification', 'https://cdn.ampproject.org/v0/amp-user-notification-0.1.js' );
			require_once AMP_WP_TEMPLATE_DIR . AMP_WP_THEME_NAME . '/components/notification/notification.php';
		endif;
	}
endif;
add_action( 'amp_wp_notifications_bar', 'amp_wp_notifications_bar_callback' );

if ( ! function_exists( 'amp_wp_gdpr_compliance_callback' ) ) :

	/**
	 * Prints GDPR Compliance
	 *
	 * @hooked  amp_wp_gdpr_compliance
	 * @since   1.0.0
	 */
	function amp_wp_gdpr_compliance_callback() {
		// Get GDPR Values.
		$gdpr_switch                   = '';
		$gdpr_headline_text            = '';
		$gdpr_message                  = '';
		$gdpr_accept_button_text       = '';
		$gdpr_reject_button_text       = '';
		$gdpr_for_more_privacy_info    = '';
		$gdpr_privacy_page             = 0;
		$gdpr_privacy_page_button_text = '';

		if ( get_option( 'amp_wp_gdpr_settings' ) ) {
			$amp_wp_gdpr_settings          = get_option( 'amp_wp_gdpr_settings' );
			$gdpr_switch                   = ( isset( $amp_wp_gdpr_settings['gdpr_switch'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_switch'] ) ) ? $amp_wp_gdpr_settings['gdpr_switch'] : '';
			$gdpr_headline_text            = ( isset( $amp_wp_gdpr_settings['headline_text'] ) && ! empty( $amp_wp_gdpr_settings['headline_text'] ) ) ? $amp_wp_gdpr_settings['headline_text'] : '';
			$gdpr_message                  = ( isset( $amp_wp_gdpr_settings['gdpr_message'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_message'] ) ) ? $amp_wp_gdpr_settings['gdpr_message'] : '';
			$gdpr_accept_button_text       = ( isset( $amp_wp_gdpr_settings['gdpr_accept_button_text'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_accept_button_text'] ) ) ? $amp_wp_gdpr_settings['gdpr_accept_button_text'] : __( 'Accept', 'amp-wp' );
			$gdpr_reject_button_text       = ( isset( $amp_wp_gdpr_settings['gdpr_reject_button_text'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_reject_button_text'] ) ) ? $amp_wp_gdpr_settings['gdpr_reject_button_text'] : __( 'Reject', 'amp-wp' );
			$gdpr_for_more_privacy_info    = ( isset( $amp_wp_gdpr_settings['gdpr_for_more_privacy_info'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_for_more_privacy_info'] ) ) ? $amp_wp_gdpr_settings['gdpr_for_more_privacy_info'] : '';
			$gdpr_privacy_page             = ( isset( $amp_wp_gdpr_settings['gdpr_privacy_page'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_privacy_page'] ) ) ? $amp_wp_gdpr_settings['gdpr_privacy_page'] : 0;
			$gdpr_privacy_page_button_text = ( isset( $amp_wp_gdpr_settings['gdpr_privacy_page_button_text'] ) && ! empty( $amp_wp_gdpr_settings['gdpr_privacy_page_button_text'] ) ) ? $amp_wp_gdpr_settings['gdpr_privacy_page_button_text'] : '';
		}

		if ( '1' == $gdpr_switch ) :

			amp_wp_enqueue_block_style( 'amp-gdpr', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/gdpr/gdpr' );
			amp_wp_enqueue_script( 'amp-consent', 'https://cdn.ampproject.org/v0/amp-consent-0.1.js' );
			amp_wp_enqueue_script( 'amp-geo', 'https://cdn.ampproject.org/v0/amp-geo-0.1.js' );

			$settings     = 'Privacy Settings';
			$privacy_page = '';
			if ( ! empty( $gdpr_privacy_page ) ) :
				$privacy_page = get_permalink( $gdpr_privacy_page );
			endif;

			$gdpr_countries = array( 'PK', 'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IS', 'IE', 'IT', 'LV', 'LI', 'LT', 'LU', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'GB', 'AX', 'IC', 'EA', 'GF', 'PF', 'TF', 'GI', 'GP', 'GG', 'JE', 'MQ', 'YT', 'NC', 'RE', 'BL', 'MF', 'PM', 'SJ', 'VA', 'WF', 'EZ', 'CH' );
			$gdpr_countries = apply_filters( 'amp_wp_gdpr_country_list', $gdpr_countries );
			$form_url       = admin_url( 'admin-ajax.php?action=amp_consent_submission' );

			require_once AMP_WP_TEMPLATE_DIR . AMP_WP_THEME_NAME . '/components/gdpr/gdpr.php';
		endif;
	}
endif;
add_action( 'amp_wp_gdpr_compliance', 'amp_wp_gdpr_compliance_callback' );

if ( ! function_exists( 'amp_wp_consent_submission' ) ) :

	/**
	 * AMP Consent Submission
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_consent_submission() {
		$current_url = '';
		$site_url    = '';
		$site_host   = '';
		$amp_site    = '';
		$current_url = wp_get_referer();
		$site_url    = amp_wp_parse_url( get_site_url() );
		$site_host   = $site_url['host'];
		$amp_site    = $site_url['scheme'] . '://' . $site_url['host'];
		header( "AMP-Access-Control-Allow-Source-Origin: $amp_site " );
		header( "AMP-Redirect-To: $current_url " );
		wp_die();
	}
endif;

// Consent Submission Hooks.
add_action( 'wp_ajax_amp_consent_submission', 'amp_wp_consent_submission' );
add_action( 'wp_ajax_nopriv_amp_consent_submission', 'amp_wp_consent_submission' );

if ( ! function_exists( 'amp_wp_set_excluded_url_format' ) ) :

	/**
	 * Set the URLs list which is not available in AMP version.
	 *
	 * @hooked amp_wp_url_excluded
	 *
	 * @param array $default
	 * @since  1.4.1
	 *
	 * @return array
	 */
	function amp_wp_set_excluded_url_format( $default ) {

		$excluded_urls = '';
		if ( get_option( 'amp_wp_general_settings' ) ) {
			$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
			if ( isset( $amp_wp_general_settings['excluded_urls'] ) && ! empty( $amp_wp_general_settings['excluded_urls'] ) ) {
				$excluded_urls = $amp_wp_general_settings['excluded_urls'];
				return explode( "\n", $excluded_urls );
			}
		}

		return $default;
	}
endif;
add_filter( 'amp_wp_url_excluded', 'amp_wp_set_excluded_url_format' );

if ( ! function_exists( 'amp_wp_do_block_styles' ) ) {

	/**
	 * Enqueue gutenberg block styles.
	 *
	 * @param string $content Content of the current post.
	 *
	 * @since 1.4.0
	 * @return string
	 */
	function amp_wp_do_block_styles( $content ) {

		global $wp_query;
		if ( ! is_amp_wp() || ! $wp_query || ! $wp_query->is_main_query() ) {
			return $content;
		}

		$blocks_list = array(
			'button',
			'columns',
			'cover',
			'file',
			'gallery',
			'image',
			'latest-comments',
			'list',
			'quote',
			'separator',
			'table',
			'verse',
		);

		if ( preg_match_all(
			'/<!--\s+(?<closer>\/)?wp:(?:<namespace>[a-z][a-z0-9_-]*\/)?(?<name>[a-z][a-z0-9_-]*)\s+(?:<attrs>{(?:(?:[^}]+|}+(?=})|(?!}\s+\/?-->).)*+)?}\s+)?(?<void>\/)?-->/s',
			$content,
			$matches
		) ) {
			foreach ( array_unique( $matches[2] ) as $block ) {
				if ( in_array( $block, $blocks_list ) ) {
					amp_wp_enqueue_block_style( 'block-' . $block, AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/gutenberg/' . $block, false );
				}
			}
		}
		return $content;
	}
}
add_filter( 'the_content', 'amp_wp_do_block_styles', 2 );
