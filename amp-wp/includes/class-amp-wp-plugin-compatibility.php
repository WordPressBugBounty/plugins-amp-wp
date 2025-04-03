<?php

/**
 * Third Party Plugins Compatibility
 *
 * @since 1.0.0
 */
class Amp_WP_Plugin_Compatibility {

	/**
	 * List of all plugins
	 *
	 * @var array
	 */
	public static $plugins = array();

	/**
	 * Initialization
	 */
	public static function init() {

		if ( ! is_amp_wp() ) {
			return;
		}

		/**
		 * WPML - The WordPress Multilingual Plugin Compatibility
		 * - Template Hooks
		 *
		 * @link    https://wpml.org
		 *
		 * @since   1.0.0
		 */
		add_action( 'init', array( __CLASS__, 'wpml_template_hooks' ) );
		add_action( 'template_redirect', array( __CLASS__, 'wpml_template_hooks' ) );

		add_action( 'init', array( __CLASS__, 'wp_init' ) );

		self::$plugins = array_flip( wp_get_active_and_valid_plugins() );

		/**
		 * WP Fastest Cache Compatibility
		 *
		 * @link    https://wordpress.org/plugins/wp-fastest-cache/
		 *
		 * @since   1.0.0
		 */
		if ( isset( self::$plugins[ WP_PLUGIN_DIR . '/wp-fastest-cache/wpFastestCache.php' ] ) && ! isset( $GLOBALS['wp_fastest_cache_options'] ) ) {
			self::wpfc_fix_options();
		}

		/**
		 * Convert Plug Compatibility
		 *
		 * @link    http://convertplug.com
		 *
		 * @since   1.0.0
		 */
		if ( class_exists( 'Convert_Plug' ) ) {
			add_action( 'after_setup_theme', 'Amp_WP_Plugin_Compatibility::convert_plug' );
		}

		/**
		 * Above The Fold Plugin Compatibility
		 *
		 * @since   1.0.0
		 */
		if ( class_exists( 'Abovethefold' ) ) {
			if ( ! defined( 'DONOTABTF' ) ) {
				define( 'DONOTABTF', true );
			}
			$GLOBALS['Abovethefold']->disable = true;

			amp_wp_remove_class_action( 'init', 'Abovethefold_Optimization', 'html_output_hook', 99999 );
			amp_wp_remove_class_action( 'wp_head', 'Abovethefold_Optimization', 'header', 1 );
			amp_wp_remove_class_action( 'wp_print_footer_scripts', 'Abovethefold_Optimization', 'footer', 99999 );
		}

		/**
		 * WP-Optimize Compatibility
		 *
		 * @link    https://wordpress.org/plugins/wp-optimize
		 *
		 * @since   1.0.0
		 */
		if ( class_exists( 'WP_Optimize' ) ) {
			amp_wp_remove_class_action( 'plugins_loaded', 'WP_Optimize', 'plugins_loaded', 1 );
		}

		/**
		 * WP Speed Grades Lite Compatibility
		 *
		 * @link    http://www.wp-speed.com
		 *
		 * @since   1.0.0
		 */
		if ( defined( 'WP_SPEED_GRADES_VERSION' ) ) {
			add_action( 'init', array( 'Amp_WP_Plugin_Compatibility', 'pre_init' ), 0 );
		}

		self::$plugins = null; // Clear memory.
		add_action( 'plugins_loaded', 'Amp_WP_Plugin_Compatibility::plugins_loaded' );

		/**
		 * Pretty Links Compatibility
		 *
		 * @link    https://wordpress.org/plugins/pretty-link/
		 *
		 * @since   1.0.0
		 */
		add_filter( 'prli-check-if-slug', 'Amp_WP_Plugin_Compatibility::pretty_links_compatibility', 2, 2 );

		/**
		 * Polylang Compatibility
		 *
		 * @link    https://wordpress.org/plugins/polylang/
		 *
		 * @since   1.0.0
		 */
		add_filter( 'pll_check_canonical_url', '__return_false' );

		/**
		 * New Relic Compatibility
		 * Disable the New Relic Browser agent on AMP responses.
		 * This prevents the New Relic from causing invalid AMP responses due the NREUM script it injects after the meta charset:
		 *
		 * @link    https://docs.newrelic.com/docs/browser/new-relic-browser/troubleshooting/google-amp-validator-fails-due-3rd-party-script
		 * Sites with New Relic will need to specially configure New Relic for AMP:
		 * @link    https://docs.newrelic.com/docs/browser/new-relic-browser/installation/monitor-amp-pages-new-relic-browser
		 *
		 * @since   1.0.0
		 */
		if ( extension_loaded( 'newrelic' ) && function_exists( 'newrelic_disable_autorum' ) ) {
			newrelic_disable_autorum();
		}

		/**
		 * Plugins Compatibility on 'template_redirect' Hook
		 *
		 * - Yoast SEO
		 * - W3 Total Cache
		 * - WP Rocket
		 * - WP Speed of Light
		 * - Lazy Load
		 * - Lazy Load XT
		 * - Facebook Comments
		 * - Ultimate Tweaker
		 * - WPO Tweaks
		 * - Squirrly SEO
		 *
		 * @since   1.0.0
		 * @since   1.0.4   Added compatibility for Squirrly SEO Plugin
		 */
		add_action( 'template_redirect', array( __CLASS__, 'fix_third_party_plugin_compatibilities' ) );

		/**
		 * Jetpack
		 *
		 * @since   1.4.3.1 Added compatibility for Jetpack plugin
		 */
		add_action( 'template_redirect', array( __CLASS__, 'amp_wp_jetpack_compatibility' ), 9 );

		/**
		 * Disable Multi Rating Plugin
		 *
		 * @link    https://wordpress.org/plugins/multi-rating/
		 *
		 * @since   1.4.3.1
		 */
		add_action( 'after_setup_theme', 'Amp_WP_Plugin_Compatibility::multi_rating' );

		/**
		 * Snip - The Rich Snippets & Structured Data Plugin
		 *
		 * @param Frontend_Controller $instance
		 *
		 * @since 1.5.8
		 */
		add_action( 'wpbuddy/rich_snippets/frontend/init', array( __CLASS__, 'rich_snippets' ) );

		/**
		 * WPForms Lite Plugin Compatibility
		 *
		 * @link    https://wordpress.org/plugins/polylang/
		 *
		 * @since   1.5.11
		 */
		add_filter( 'wpforms_frontend_shortcode_amp_text', 'Amp_WP_Plugin_Compatibility::wpforms_compatibility' );

		/**
		 * SG Optimizer Plugin Compatibility.
		 *
		 * @link https://wordpress.org/plugins/sg-cachepress/
		 *
		 * @since 1.5.12
		 */
		add_filter( 'pre_option_siteground_optimizer_combine_google_fonts', '__return_zero' );

	}

	/**
	 * WPML - The WordPress Multilingual Plugin Compatibility
	 * - Template Hooks
	 *
	 * @link    https://wpml.org
	 * @since   1.0.0
	 */
	public static function wpml_template_hooks() {

		global $wpml_language_resolution;

		/**
		 * @var SitePress $sitepress
		 */
		$sitepress = isset( $GLOBALS['sitepress'] ) ? $GLOBALS['sitepress'] : '';
		$callback  = array( $sitepress, 'display_wpml_footer' );

		if ( ! $sitepress || ! $sitepress instanceof SitePress ) {
			return;
		}

		if ( has_action( 'wp_footer', $callback ) ) {
			add_action( 'amp_wp_template_footer', $callback );
		}

		if ( $sitepress->get_setting( 'language_negotiation_type' ) == '1' ) {
			add_filter(
				'amp_wp_transformer_exclude_subdir',
				array(
					$wpml_language_resolution,
					'get_active_language_codes',
				)
			);
		}
	}

	/**
	 * Pre init action
	 */
	public static function pre_init() {
		remove_action( 'init', 'wpspgrpro_init_minify_html', 1 );
	}

	public static function wp_init() {

		if ( class_exists( 'wpForo' ) ) {
			add_filter( 'amp_wp_amp_version_exists', array( __CLASS__, 'wpforo_amp_exists' ) );
		}
	}

	/**
	 * wpForo plugin compatibility.
	 *
	 * @link https://wordpress.org/plugins/wpforo/
	 *
	 * @param bool $exists
	 *
	 * @return bool
	 */
	public static function wpforo_amp_exists( $exists ) {

		if ( ! $exists || is_wpforo_page() ) {
			return false;
		}

		return $exists;
	}

	/**
	 * Convert Plug plugin
	 *
	 * @link    http://convertplug.com/
	 */
	public static function convert_plug() {
		amp_wp_remove_class_filter( 'the_content', 'Convert_Plug', 'cp_add_content', 10 );
	}

	/**
	 * WordPress Fastest Cache Plugins Fixes
	 *
	 * Disables minify features if WPFC plugin in AMP
	 */
	public static function wpfc_fix_options() {
		if ( $wp_fastest_cache_options = get_option( 'WpFastestCache' ) ) {
			$GLOBALS['wp_fastest_cache_options'] = json_decode( $wp_fastest_cache_options );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheRenderBlocking );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheCombineJsPowerFul );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheMinifyJs );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheCombineJs );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheCombineCss );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheLazyLoad );
			unset( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheGoogleFonts );
		} else {
			$GLOBALS['wp_fastest_cache_options'] = array();
		}
	}

	/**
	 * Plugin loaded hook
	 */
	public static function plugins_loaded() {
		/**
		 * Initialize Custom Permalinks Support
		 */
		if ( function_exists( 'custom_permalinks_request' ) ) { // Guess is custom permalinks installed and active
			add_filter( 'request', 'Amp_WP_Plugin_Compatibility::amp_wp_custom_permalinks', 15 );
		}

		/**
		 * NextGEN Gallery Compatibility
		 */
		add_filter( 'run_ngg_resource_manager', '__return_false', 999 );

		/**
		 * WPML Compatibility
		 */
		if ( defined( 'WPML_PLUGIN_BASENAME' ) && WPML_PLUGIN_BASENAME ) {
			add_action( 'wpml_is_redirected', '__return_false' );
		}
	}

	/**
	 * Add Custom Permalinks Compatibility
	 *
	 * @param   array $query_vars
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  array
	 */
	public static function amp_wp_custom_permalinks( $query_vars ) {

		$amp_qv = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : 'amp';
		$path   = amp_wp_get_wp_installation_slug();
		if ( ! (
			preg_match( "#^$path/*$amp_qv/(.*?)/*$#", $_SERVER['REQUEST_URI'], $matched ) ||
			preg_match( "#^$path/*(.*?)/$amp_qv/*$#", $_SERVER['REQUEST_URI'], $matched )
		) ) {
			return $query_vars;
		}

		if ( empty( $matched[1] ) ) {
			return $query_vars;
		}

		remove_filter( 'request', 'Amp_WP_Plugin_Compatibility::amp_wp_custom_permalinks', 15 );

		$_SERVER['REQUEST_URI'] = '/' . $matched[1] . '/';
		$query_vars ['amp']     = '1';
		$_REQUEST['amp']        = '1';

		if ( $new_qv = custom_permalinks_request( $query_vars ) ) {
			$new_qv['amp'] = '1';

			// Prevent Redirect amp Post to non-amp Version
			remove_filter( 'template_redirect', 'custom_permalinks_redirect', 5 );
			return $new_qv;
		}

		return $query_vars;
	}

	/**
	 * Drop amp start-point from pretty link slug
	 *
	 * @param bool|object $is_pretty_link
	 * @param string      $slug
	 *
	 * @since 1.0.0
	 * @return bool|object
	 */
	public static function pretty_links_compatibility( $is_pretty_link, $slug ) {
		if ( isset( $GLOBALS['prli_link'] ) && $GLOBALS['prli_link'] instanceof PrliLink ) {
			if ( preg_match( '#^/*' . Amp_WP_Public::AMP_WP_STARTPOINT . '/+(.+)$#i', $slug, $match ) ) {
				/**
				 * @var PrliLink $instance
				 */
				$instance = $GLOBALS['prli_link'];
				$callback = array( $instance, 'getOneFromSlug' );

				if ( is_callable( $callback ) ) {
					return call_user_func( $callback, $match[1] );
				}
			}
		}
		return $is_pretty_link;
	}

	/**
	 * Plugins Compatibility on 'template_redirect' Hook
	 *
	 * - Yoast SEO
	 * - All In One SEO Pack
	 * - W3 Total Cache
	 * - WP Rocket
	 * - WP Speed of Light
	 * - Lazy Load
	 * - Lazy Load XT
	 * - Facebook Comments
	 * - Ultimate Tweaker
	 * - WPO Tweaks
	 * - Squirrly SEO
	 *
	 * @since   1.0.0
	 * @since   1.0.4   Added compatibility for Squirrly SEO Plugin
	 */
	public static function fix_third_party_plugin_compatibilities() {

		/**
		 * Yoast SEO
		 *
		 * @link    https://wordpress.org/plugins/wordpress-seo/
		 *
		 * @since   1.0.0
		 */
		if ( defined( 'WPSEO_VERSION' ) ) {

			/**
			 * Yoast SEO Meta Tags
			 *
			 * - Print Meta Description
			 * - Print Twitter Card
			 * - Print Meta Tags Using Yoast SEO Open Graph.
			 *
			 * @since   1.0.0
			 */
			if ( class_exists( 'WPSEO_OpenGraph' ) ) {
				add_action( 'amp_wp_template_head', array( __CLASS__, 'yoast_seo_metatags' ) );
			}

			/**
			 * Sync non-AMP Homepage Title With AMP Version
			 *
			 * @since   1.0.0
			 */
			if ( is_home() && ! amp_wp_is_static_home_page() && Amp_WP_Public::amp_wp_get_option( 'show_on_front' ) === 'page' ) {
				add_filter( 'pre_get_document_title', 'Amp_WP_Plugin_Compatibility::yoast_seo_homepage_title', 99 );
			}

			/**
			 * Sync JSON-ID Data With Yoast SEO
			 *
			 * @since 1.0.0
			 */
			if ( is_home() ) {
				add_filter( 'amp_wp_json_ld_website', 'Amp_WP_Plugin_Compatibility::yoast_seo_homepage_json_ld' );
			}
		}

		/**
		 * All In One SEO Pack
		 *
		 * - Print Meta Description
		 * - Print Twitter Card
		 * - Print Meta Tags Using Yoast SEO Open Graph.
		 *
		 * @since   1.4.3.1
		 */
		if ( class_exists( 'All_in_One_SEO_Pack' ) ) {

			/**
			 * All In One SEO Pack Meta Tags
			 *
			 * @since   1.4.3.1
			 */
			add_action( 'amp_wp_template_head', array( __CLASS__, 'aioseop_metatags' ) );

			/**
			 * Sync non-AMP Homepage Title With AMP Version
			 *
			 * @since   1.4.3.1
			 */
			if ( is_home() && ! amp_wp_is_static_home_page() && Amp_WP_Public::amp_wp_get_option( 'show_on_front' ) === 'page' ) {
				// add_filter( 'pre_get_document_title', 'Amp_WP_Plugin_Compatibility::aioseop_homepage_title', 99);
			}
		}

		/**
		 * W3 Total Cache
		 *
		 * @link    https://wordpress.org/plugins/w3-total-cache/
		 *
		 * @since   1.0.0
		 * @since   1.5.5   Disabled filter 'w3tc_minify_html_enable'
		 */
		add_filter( 'w3tc_minify_js_enable', '__return_false' );
		add_filter( 'w3tc_minify_css_enable', '__return_false' );
		add_filter( 'w3tc_minify_html_enable', '__return_false' );

		/**
		 * WP Rocket
		 *
		 * @link    https://wp-rocket.me/
		 *
		 * @since   1.0.0
		 */
		if ( defined( 'WP_ROCKET_VERSION' ) ) {

			if ( ! defined( 'DONOTMINIFYCSS' ) ) {
				define( 'DONOTMINIFYCSS', true ); }
			if ( ! defined( 'DONOTMINIFYJS' ) ) {
				define( 'DONOTMINIFYJS', true ); }

			// Disable Lazy Load
			add_filter( 'do_rocket_lazyload', '__return_false', PHP_INT_MAX );
			add_filter( 'do_rocket_lazyload_iframes', '__return_false', PHP_INT_MAX );

			// Disable HTTP Protocol Removing on script, link, img, srcset and form tags.
			remove_filter( 'rocket_buffer', '__rocket_protocol_rewrite', PHP_INT_MAX );
			remove_filter( 'wp_calculate_image_srcset', '__rocket_protocol_rewrite_srcset', PHP_INT_MAX );

			// Disable Concatenate Google Fonts
			add_filter( 'get_rocket_option_minify_google_fonts', '__return_false', PHP_INT_MAX );

			// Disable CSS & JS minification
			add_filter( 'get_rocket_option_minify_js', '__return_false', PHP_INT_MAX );
			add_filter( 'get_rocket_option_minify_css', '__return_false', PHP_INT_MAX );
		}

		/**
		 * WP Speed of Light
		 *
		 * @link    https://wordpress.org/plugins-wp/wp-speed-of-light/
		 *
		 * @since   1.0.0
		 */
		if ( defined( 'WPSOL_VERSION' ) ) {
			add_filter( 'wpsol_filter_js_noptimize', '__return_true', PHP_INT_MAX );
			add_filter( 'wpsol_filter_css_noptimize', '__return_true', PHP_INT_MAX );
		}

		/**
		 * Lazy Load
		 *
		 * @link    https://wordpress.org/plugins/lazy-load/
		 *
		 * @since   1.0.0
		 */
		if ( class_exists( 'LazyLoad_Images' ) ) {
			add_filter( 'lazyload_is_enabled', '__return_false', PHP_INT_MAX );
		}

		/**
		 * Lazy Load XT
		 *
		 * @link    https://wordpress.org/plugins/lazy-load-xt/
		 *
		 * @since   1.0.0
		 */
		if ( class_exists( 'Image_Lazy_Load' ) ) {

			global $lazyloadxt;
			if ( is_object( $lazyloadxt ) ) {
				remove_filter( 'the_content', array( $lazyloadxt, 'filter_html' ) );
				remove_filter( 'widget_text', array( $lazyloadxt, 'filter_html' ) );
				remove_filter( 'post_thumbnail_html', array( $lazyloadxt, 'filter_html' ) );
				remove_filter( 'get_avatar', array( $lazyloadxt, 'filter_html' ) );
			}
		}

		/**
		 * Facebook Comments
		 *
		 * @link    https://wordpress.org/plugins/facebook-comments-plugin/
		 *
		 * @since   1.0.0
		 */
		if ( function_exists( 'fbcommentshortcode' ) ) {
			remove_action( 'wp_footer', 'fbmlsetup', 100 );
			remove_filter( 'the_content', 'fbcommentbox', 100 );
			remove_filter( 'widget_text', 'do_shortcode' );
		}

		/**
		 * Ultimate Tweaker
		 *
		 * @link    https://ultimate-tweaker.com/
		 *
		 * @since   1.0.0
		 */
		if ( class_exists( 'ultimate_tweaker_Plugin_File' ) && defined( 'UT_VERSION' ) ) {
			amp_wp_remove_class_filter( 'post_thumbnail_html', 'OT_media_image_no_width_height_Tweak', '_do', 10 );
			amp_wp_remove_class_filter( 'image_send_to_editor', 'OT_media_image_no_width_height_Tweak', '_do', 10 );
		}

		/**
		 * WPO Tweaks
		 *
		 * @link    https://servicios.ayudawp.com/
		 *
		 * @since   1.0.0
		 */
		if ( function_exists( 'wpo_tweaks_init' ) ) {
			remove_filter( 'script_loader_tag', 'wpo_defer_parsing_of_js' );
		}

		/**
		 * Squirrly SEO
		 *
		 * @link    https://wordpress.org/plugins/squirrly-seo/
		 *
		 * @since   1.0.4
		 */
		if ( ! is_callable( 'SQ_Classes_ObjController::getClass' ) ) {
			return;
		}
		$object = SQ_Classes_ObjController::getClass( 'SQ_Models_Services_Canonical' );
		remove_filter( 'sq_canonical', array( $object, 'packCanonical' ), 99 );
		add_action( 'sq_canonical', array( __class__, 'return_rel_canonical' ), 99 );
	}

	/**
	 * Jetpack
	 * Add/Disable Jetpack features that are not compatible with AMP.
	 *
	 * @link    https://wordpress.org/plugins/jetpack/
	 *
	 * @since 1.4.3.1
	 */
	public static function amp_wp_jetpack_compatibility() {
		if ( class_exists( 'Jetpack' ) && ! ( defined( 'IS_WPCOM' ) && IS_WPCOM ) && version_compare( JETPACK__VERSION, '6.2-alpha', '<' ) ) {
			if ( Jetpack::is_module_active( 'stats' ) ) {

				// Add Jetpack stats pixel.
				add_action( 'amp_wp_template_footer', array( __class__, 'jetpack_amp_add_stats_pixel' ) );
			}

			// Disable Jetpack sharing.
			add_filter( 'sharing_show', '__return_false', 100 );

			/**
			 * Remove the Related Posts placeholder and headline that gets hooked into the_content
			 * That placeholder is useless since we can't ouput, and don't want to output Related Posts in AMP.
			 */
			if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
				$jprp = Jetpack_RelatedPosts::init();
				remove_filter( 'the_content', array( $jprp, 'filter_add_target_to_dom' ), 40 );
			}

			// Force videopress to use html5 player
			add_filter( 'videopress_shortcode_options', array( __class__, 'amp_wp_videopress_enable_freedom_mode' ) );
		}
	}

	/**
	 * Yoast SEO Meta Tags
	 *
	 * - Print Meta Description
	 * - Print Twitter Card
	 * - Print Meta Tags Using Yoast SEO Open Graph.
	 *
	 * @since   1.0.0
	 */
	public static function yoast_seo_metatags() {

		// Remove Canonical URL from Yoast to generate correct canonical.
		amp_wp_remove_class_action( 'wpseo_head', 'WPSEO_Frontend', 'canonical', 20 );
		add_filter( 'wpseo_frontend_presenter_classes', array( __CLASS__, 'yoast_seo_remove_canonical_presenter_class' ), 120 );

		$wp_seo = WPSEO_Frontend::get_instance();
		$desc   = $wp_seo->metadesc( false );
		echo '<meta name="description" content="', esc_attr( wp_strip_all_tags( stripslashes( $desc ) ) ), '"/>', "\n";

		$options = WPSEO_Options::get_option( 'wpseo_social' );
		if ( $options['twitter'] === true ) {
			WPSEO_Twitter::get_instance();
		}

		// Yoast SEO Meta.
		do_action( 'wpseo_opengraph' );
	}



	/**
	 * Remove canonical to prevent duplicate canonical tag on the page.
	 *
	 * @param array $presenters The current array of presenters.
	 *
	 * @return array
	 */
	public static function yoast_seo_remove_canonical_presenter_class( $presenters ) {

		$index = array_search( 'Yoast\WP\SEO\Presenters\Canonical_Presenter', $presenters );

		if ( false !== $index ) {
			unset( $presenters[ $index ] );
		}

		return $presenters;
	}

	/**
	 * Sync non-AMP Homepage Title With AMP Version
	 *
	 * @param string $title The document title.
	 *
	 * @access public
	 * @version 1.0.0
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function yoast_seo_homepage_title( $title ) {
		if ( ( $post_id = Amp_WP_Public::amp_wp_get_option( 'page_on_front' ) ) && is_callable( 'WPSEO_Frontend::get_instance' ) ) {
			$post = get_post( $post_id );
			if ( $post instanceof WP_Post ) {
				$wp_seo = WPSEO_Frontend::get_instance();
				if ( $new_title = $wp_seo->get_content_title( $post ) ) {
					return $new_title;
				}
			}
		}
		return $title;
	}

	/**
	 * Sync JSON-ID Data With Yoast SEO
	 *
	 * @param array $data
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @return array
	 */
	public static function yoast_seo_homepage_json_ld( $data ) {

		if ( is_callable( 'WPSEO_Options::get_options' ) ) {
			$options = WPSEO_Options::get_options( array( 'wpseo', 'wpseo_social' ) );

			if ( ! empty( $options['website_name'] ) ) {
				$data['name'] = $options['website_name'];
			}

			if ( ! empty( $options['alternate_website_name'] ) ) {
				$data['alternateName'] = $options['alternate_website_name'];
				unset( $data['description'] );
			}
		}
		return $data;
	}

	/**
	 * Return Squirrly SEO Canonical URL
	 *
	 * @since   1.0.4
	 * @return  string
	 */
	public static function return_rel_canonical() {
		if ( $canonical = amp_wp_rel_canonical_url() ) {
			return '<link rel="canonical" href="' . $canonical . '"/>';
		}
	}

	/**
	 * All In One SEO Pack Meta Tags
	 *
	 * @since   1.4.3.1
	 */
	public static function aioseop_metatags() {

		// Remove Canonical URL
		add_filter( 'aioseop_canonical_url', '__return_false', 10 );

		$aioseop_obj = new All_in_One_SEO_Pack();
		$info        = $aioseop_obj->get_page_snippet_info();
		$desc        = $info['description'];

		if ( $desc ) :
			echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( stripslashes( $desc ) ) ) . '"/>' . "\n";
		endif;

		// All In One SEO Pack Meta
		do_action( 'aioseop_modules_wp_head' );
	}

	/**
	 * Sync non-AMP Homepage Title With AMP Version - In Dev mode
	 *
	 * @param   string $title
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.4.3.1
	 *
	 * @return string
	 */
	public static function aioseop_homepage_title( $title ) {
		if ( ( $post_id = Amp_WP_Public::amp_wp_get_option( 'page_on_front' ) ) ) {
			$post = get_post( $post_id );
			if ( $post instanceof WP_Post ) {

				$aioseop_obj = new All_in_One_SEO_Pack();
				$info        = $aioseop_obj->get_page_snippet_info();
				$new_title   = $info['title'];

				if ( $new_title ) {
					return $new_title;
				}
			}
		}
		return $title;
	}

	/**
	 * Multi Rating plugin
	 * https://wordpress.org/plugins/multi-rating/
	 *
	 * @since 1.4.3.1
	 */
	public static function multi_rating() {
		remove_filter( 'the_content', 'mr_filter_the_content', 10 );
		remove_filter( 'the_title', 'mr_filter_the_title', 10 );
		add_filter( 'mr_can_do_shortcode', '__return_false', 10 );
	}

	/**
	 * Add Jetpack stats pixel.
	 *
	 * @since 1.4.3.1
	 */
	public static function jetpack_amp_add_stats_pixel() {
		if ( ! has_action( 'wp_footer', 'stats_footer' ) ) {
			return;
		}
		$f = new self();
		?>
		<amp-pixel src="<?php echo esc_url( $f->jetpack_amp_build_stats_pixel_url() ); ?>"></amp-pixel>
		<?php
	}

	/**
	 * Generate the stats pixel.
	 *
	 * @link    https://pixel.wp.com/g.gif?v=ext&j=1%3A3.9.1&blog=1234&post=5678&tz=-4&srv=example.com&host=example.com&ref=&rand=0.4107963021218808
	 *
	 * @since   1.4.3.1
	 */
	public function jetpack_amp_build_stats_pixel_url() {
		global $wp_the_query;
		if ( function_exists( 'stats_build_view_data' ) ) { // Added in <https://github.com/Automattic/jetpack/pull/3445>.
			$data = stats_build_view_data();
		} else {
			$blog     = Jetpack_Options::get_option( 'id' );
			$tz       = get_option( 'gmt_offset' );
			$v        = 'ext';
			$blog_url = amp_wp_parse_url( site_url() );
			$srv      = $blog_url['host'];
			$j        = sprintf( '%s:%s', JETPACK__API_VERSION, JETPACK__VERSION );
			$post     = $wp_the_query->get_queried_object_id();
			$data     = compact( 'v', 'j', 'blog', 'post', 'tz', 'srv' );
		}

		$data['host'] = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : ''; // input var ok.
		$data['rand'] = 'RANDOM'; // AMP placeholder.
		$data['ref']  = 'DOCUMENT_REFERRER'; // AMP placeholder.
		$data         = array_map( 'rawurlencode', $data );
		return add_query_arg( $data, 'https://pixel.wp.com/g.gif' );
	}

	/**
	 * Force videopress to use html5 player that would generate <video /> tag
	 * that will be later converted to <amp-video />
	 *
	 * @since 1.4.3.1
	 *
	 * @param array $options videopress shortcode options.
	 * @return array videopress shortcode options with `freedom` set to true
	 */
	public static function amp_wp_videopress_enable_freedom_mode( $options ) {

		$options['freedom'] = true;
		return $options;
	}

	/**
	 * Snip - The Rich Snippets & Structured Data Plugin
	 *
	 * @param Frontend_Controller $instance
	 *
	 * @since 1.5.8
	 */
	public static function rich_snippets( $instance ) {
		if ( get_option( 'wpb_rs/settings/snippets_in_footer', true ) ) {
			add_action( 'amp_wp_template_footer', array( $instance, 'print_snippets' ) );
		} else {
			add_action( 'amp_wp_template_head', array( $instance, 'print_snippets' ) );
		}
	}

	/**
	 * WPForms Lite Plugin Compatibility
	 *
	 * @since 1.5.11
	 * @return bool|object
	 */
	public static function wpforms_compatibility( $url ) {
		$args = array();

		preg_match_all( '/href="(.*?)"/s', $url, $matches );
		$count = count( $matches[1] );
		for ( $row = 0; $row < $count; $row++ ) {
			$new_skip_url_array = amp_wp_parse_url( $matches[1][ "$row" ] );
			$args['query-args'] = array( array( 'amp-wp-skip-redirect', true ) );
		}

		$new_url = sprintf(
			wp_kses(
				/* translators: %s - URL to a non-amp version of a page with the form. */
				__( '<a href="%s">Go to the full page</a> to view and submit the form.', 'wpforms-lite' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			),
			esc_url( amp_wp_guess_non_amp_url( $args ) . '#' . esc_attr( $new_skip_url_array['fragment'] ) )
		);

		return $new_url;
	}
}

Amp_WP_Plugin_Compatibility::init();

/**
 * Speed Booster Pack
 * https://wordpress.org/plugins/speed-booster-pack/
 */
if ( is_amp_wp() && ! class_exists( 'Speed_Booster_Pack_Core' ) ) {
	/**
	 * Disables plugin functionality by overriding "Speed_Booster_Pack_Core" class
	 */
	class Speed_Booster_Pack_Core{}
}
