<?php
/**
 * AMP WP Theme functions
 *
 * @package    Amp_WP/Functions
 * @version    1.0.0
 * @author     Pixelative <mohsin@pixelative.co>
 * @copyright  Copyright (c) 2018, Pixelative
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'amp_wp_locate_template' ) ) :

	/**
	 * Retrieve the Name of the Highest Priority Amp Template File That Exists.
	 *
	 * @see   locate_template for more doc
	 *
	 * @param string|array $template_names Template file(s) to search for, in order.
	 * @param bool         $load           If true the Template File Will Be Loaded If It Is Found.
	 * @param bool         $require_once   Whether to Require_once or Require. Default true. Has No Effect If $load Is false.
	 *
	 * @since 1.0.0
	 *
	 * @return string The template filename if one is located.
	 */
	function amp_wp_locate_template( $template_names, $load = false, $require_once = true ) {

		add_theme_support( 'amp-wp-template' );
		$wp_theme_can_override = current_theme_supports( 'amp-wp-template' );

		// Get Default Theme Path.
		$default_path = amp_wp_get_template_directory();

		/**
		 * Scan WordPress theme directory at first, if override feature was enabled
		 */
		$scan_directories = array(
			STYLESHEETPATH . '/' . AMP_WP_OVERRIDE_TPL_DIR . '/',
			TEMPLATEPATH . '/' . AMP_WP_OVERRIDE_TPL_DIR . '/',
			$default_path,
		);

		$scan_directories = array_unique( array_filter( $scan_directories ) );

		foreach ( $scan_directories as $theme_directory ) {
			if ( $theme_file_path = amp_wp_load_template( $template_names, $theme_directory, $load, $require_once ) ) {
				return $theme_file_path;
			}
		}
	}
endif;

if ( ! function_exists( 'amp_wp_load_template' ) ) :

	/**
	 * Require the Template File
	 *
	 * @param string|array $templates
	 * @param string       $theme_directory base directory. scan $templates files into this directory
	 * @param bool         $load
	 * @param bool         $require_once
	 *
	 * @see amp_wp_locate_template for parameters documentation
	 *
	 * @since               1.0.0
	 *
	 * @return              bool|string
	 */
	function amp_wp_load_template( $templates, $theme_directory, $load = false, $require_once = true ) {
		foreach ( (array) $templates as $theme_file ) {
			$theme_file      = ltrim( $theme_file, '/' );
			$theme_directory = trailingslashit( $theme_directory );
			if ( file_exists( $theme_directory . $theme_file ) ) {
				if ( $load ) {
					if ( $require_once ) {
						require_once $theme_directory . $theme_file;
					} else {
						require $theme_directory . $theme_file;
					}
				}
				return $theme_directory . $theme_file;
			}
		}
		return false;
	}
endif;

// Start Template Hierarchy Related Functions.
if ( ! function_exists( 'amp_wp_head' ) ) :

	/**
	 * Fire the amp_wp_head action.
	 *
	 * @since 1.0.0
	 */
	function amp_wp_head() {
		do_action( 'amp_wp_template_head' );
	}
endif;

if ( ! function_exists( 'amp_wp_footer' ) ) :

	/**
	 * Fire the amp_wp_footer action.
	 *
	 * @since 1.0.0
	 */
	function amp_wp_footer() {
		do_action( 'amp_wp_template_footer' );
	}
endif;

if ( ! function_exists( 'amp_wp_body_class' ) ) :

	/**
	 * Display the classes for the body element.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_body_class( $class = '' ) {
		echo 'class="' . esc_attr( join( ' ', get_body_class( $class ) ) ) . '"';
	}
endif;

if ( ! function_exists( 'amp_wp_get_header' ) ) :

	/**
	 * Load footer template.
	 *
	 * @param string $name The name of the specialised header.
	 *
	 * @since 1.0.0
	 */
	function amp_wp_get_header( $name = null ) {
		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "header-{$name}.php";
		}
		$templates[] = 'header.php';
		amp_wp_locate_template( $templates, true );
	}
endif;

if ( ! function_exists( 'amp_wp_get_footer' ) ) :

	/**
	 * Load footer template.
	 *
	 * @param string $name Name of the specific footer file to use.
	 *
	 * @since 1.0.0
	 */
	function amp_wp_get_footer( $name = null ) {
		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "footer-{$name}.php";
		}
		$templates[] = 'footer.php';
		amp_wp_locate_template( $templates, true );
	}
endif;

if ( ! function_exists( 'amp_wp_get_sidebar' ) ) :

	/**
	 * Load sidebar template.
	 *
	 * @param string $name The name of the specialised sidebar.
	 *
	 * @since 1.0.0
	 */
	function amp_wp_get_sidebar( $name = null ) {
		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "sidebar-{$name}.php";
		}
		$templates[] = 'sidebar.php';
		amp_wp_locate_template( $templates, true );
	}
endif;

if ( ! function_exists( 'amp_wp_get_search_form' ) ) :

	/**
	 * Retrieve path of search form in current or parent template.
	 *
	 * @since 1.0.0
	 *
	 * @return string Full path to index template file.
	 */
	function amp_wp_get_search_form() {
		add_theme_support( 'amp-wp-form' );
		return amp_wp_locate_template( 'searchform.php', true );
	}
endif;

if ( ! function_exists( 'amp_wp_get_template_info' ) ) :

	/**
	 * Get active amp theme information
	 *
	 * Array {
	 *
	 * @type string     $Version      Template Semantic Version Number {@link http://semver.org/}
	 * @type string     $ScreenShot   -optional:screenshot.png- Relative Path to ScreenShot.
	 * @type int|string $MaxWidth     -optional:780- Maximum Template Container Width.
	 * @type string     $TemplateRoot Absolute Path to Template Directory
	 * @type string     $Description  Template Description
	 * @type string     $AuthorURI    Template Author URL
	 * @type string     $Author       Template Author
	 * @type string     $Name         Template name
	 * @type string     $ThemeURI     Template URL
	 * }
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function amp_wp_get_template_info() {

		return wp_parse_args(
			apply_filters( 'amp_wp_template_active_template', array() ),
			array(
				'Name'         => __( 'Default Template', 'amp-wp' ),
				'ThemeURI'     => 'https://ampwp.io',
				'Description'  => 'AMP WP Default Template',
				'Author'       => 'Pixelative',
				'AuthorURI'    => 'https://pixelative.co',
				'Version'      => '1.0.0',
				'ScreenShot'   => 'screenshot.png',
				'TemplateRoot' => AMP_WP_TEMPLATE_DIR . AMP_WP_THEME_NAME,
				'MaxWidth'     => 768,
				'view'         => 'general',
			)
		);
	}
endif;

if ( ! function_exists( 'amp_wp_get_template_directory' ) ) :

	/**
	 * Get Absolute Path to Active Amp-Wp Theme Directory
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_get_template_directory() {
		if ( $theme_info = amp_wp_get_template_info() ) {
			return $theme_info['TemplateRoot'];
		}
		return '';
	}
endif;

if ( ! function_exists( 'amp_wp_get_container_width' ) ) :

	/**
	 * Get Maximum Container Width
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  int
	 */
	function amp_wp_get_container_width() {
		$info = amp_wp_get_template_info();
		return (int) $info['MaxWidth'];
	}
endif;

if ( ! function_exists( 'amp_wp_guess_height' ) ) :

	/**
	 * Calculate height fits to width
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  int
	 */
	function amp_wp_guess_height() {
		return amp_wp_get_container_width() * 0.75;
	}
endif;

if ( ! function_exists( 'amp_wp_get_hw_attr' ) ) :

	/**
	 * Get Width & Height Attribute
	 *
	 * @param   string $width  Custom width.
	 * @param   string $height Custom height.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_get_hw_attr( $width = '', $height = '' ) {
		$attr = '';
		if ( empty( $width ) ) {
			$width = amp_wp_get_container_width();
		}
		if ( $width ) {
			$attr .= 'width="' . intval( $width ) . '" ';
		}
		if ( empty( $height ) ) {
			$height = amp_wp_guess_height();
		}
		if ( $height ) {
			$attr .= 'height="' . intval( $height ) . '" ';
		}
		return $attr;
	}
endif;

if ( ! function_exists( 'amp_wp_hw_attr' ) ) :

	/**
	 * Get Width & Height Attribute
	 *
	 * @param string $width
	 * @param string $height
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function amp_wp_hw_attr( $width = '', $height = '' ) {
		echo amp_wp_get_hw_attr( $width, $height );
	}
endif;

if ( ! function_exists( 'amp_wp_print_rel_canonical' ) ) :

	/**
	 * Print rel="canonical" Tag in AMP Version
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_print_rel_canonical() {

		if ( $canonical = amp_wp_rel_canonical_url() ) {
			?>
		<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>"/>
			<?php
		}
	}
endif;

if ( ! function_exists( 'amp_wp_rel_canonical_url' ) ) :

	/**
	 * Get rel="canonical" tag URL.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function amp_wp_rel_canonical_url() {

		$canonical_url = amp_wp_get_canonical_url();

		if ( ! $canonical_url ) {
			$canonical_url = amp_wp_site_url();
		}

		return Amp_WP_Content_Sanitizer::transform_to_non_amp_url( $canonical_url );
	}
endif;

if ( ! function_exists( 'amp_wp_get_canonical_url' ) ) :

	/**
	 * Get the Active Page URL
	 *
	 * @copyright we used WPSEO_Frontend::generate_canonical codes
	 *
	 * @since   1.0.0
	 * @since   1.4.0 Function Refactored to get Canonical URLs
	 *
	 * @return  string  URL of the page on success or empty string otherwise.
	 */
	function amp_wp_get_canonical_url() {
		$parse         = amp_wp_parse_url( home_url() );
		list( $url )   = explode( '?', $_SERVER['REQUEST_URI'] );
		$valid_queries = array_intersect_key(
			$_GET,
			array(
				Amp_WP_Public::AMP_WP_STARTPOINT => '',
				'amp-wp-skip-redirect'           => '',
			)
		);
		return sprintf( '%s://%s%s', $parse['scheme'], $parse['host'], add_query_arg( $valid_queries, $url ) );
	}
endif;

if ( ! function_exists( 'amp_wp_print_rel_amphtml' ) ) :

	/**
	 * Print rel=amphtml tag
	 *
	 * @since 1.0.0
	 */
	function amp_wp_print_rel_amphtml() {
		if ( ! Amp_WP_Public::amp_version_exists() ) {
			return;
		}

		$canonical = Amp_WP_Content_Sanitizer::transform_to_amp_url( amp_wp_get_canonical_url() );
		if ( $canonical ) {
			?>
		<link rel="amphtml" href="<?php echo esc_attr( $canonical ); ?>" />
			<?php
		}
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_boilerplate_style' ) ) :

	/**
	 * Print required amp style to head
	 *
	 * @link  https://github.com/ampproject/amphtml/blob/master/spec/amp-boilerplate.md
	 *
	 * @since 1.0.0
	 */
	function amp_wp_enqueue_boilerplate_style() {
		echo <<<AMP_Boilerplate
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
AMP_Boilerplate;
	}
endif;

if ( ! function_exists( 'amp_wp_template_part' ) ) :

	/**
	 * Load a Template Part Into a Template
	 *
	 * @see   get_template_part for more documentation
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 *
	 * @since 1.0.0
	 */
	function amp_wp_template_part( $slug, $name = null ) {
		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "{$slug}-{$name}.php";
		}
		$templates[] = "{$slug}.php";
		amp_wp_locate_template( $templates, true, false );
	}
endif;

if ( ! function_exists( 'amp_wp_get_search_page_url' ) ) :

	/**
	 * Get Search Page URL
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_get_search_page_url() {
		/**
		 * The s query var must always add to AMP front-page url. for more information see the following function.
		 *
		 * @see amp_wp_site_url
		 */
		return esc_url( add_query_arg( 's', '', amp_wp_site_url( '', '', true ) ) );
	}
endif;

if ( ! function_exists( 'amp_wp_get_thumbnail' ) ) :

	/**
	 * Used to get thumbnail image for posts with support of default thumbnail image
	 *
	 * @param   string $thumbnail_size
	 * @param   null   $post_id
	 *
	 * @since       1.0.0
	 * @since       1.2.0       Added srcset & alt text
	 *
	 * @return string
	 */
	function amp_wp_get_thumbnail( $thumbnail_size = 'thumbnail', $post_id = null ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$thumbnail_id = get_post_thumbnail_id( $post_id );
		$img          = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );
		$img_alt      = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
		$srcset       = wp_get_attachment_image_srcset( $thumbnail_id, $thumbnail_size );
		if ( $img ) {
			return array(
				'src'    => $img[0],
				'width'  => $img[1],
				'height' => $img[2],
				'alt'    => $img_alt,
				'srcset' => $srcset,
			);
		}

		$img = array(
			'src'    => '',
			'width'  => '',
			'height' => '',
			'alt'    => '',
			'srcset' => '',
		);

		// todo add default thumbnail functionality or extension here
		return $img;
	}
endif;

if ( ! function_exists( 'amp_wp_element_unique_id' ) ) :

	/**
	 * Create Unique Id for Element
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_element_unique_id() {
		return uniqid( 'element-' . rand() . '-' );
	}
endif;

if ( ! function_exists( 'amp_wp_theme_set_menu_walker' ) ) :

	/**
	 * Change Menu Walker Only for Main Amp Site Navigation
	 *
	 * Walker of navigation menu with 'amp-wp-sidebar-nav' theme_location going to change' Amp_WP_Menu_Walker'.
	 *
	 * @param array $args Array of wp_nav_menu() arguments.
	 *
	 * @see    Amp_WP_Menu_Walker
	 * @see    default-filters.php file
	 *
	 * @since  1.0.0
	 * @return array modified $args
	 */
	function amp_wp_theme_set_menu_walker( $args ) {
		if ( ! is_amp_wp() | ! has_nav_menu( $args['theme_location'] ) ) {
			return $args;
		}
		if ( apply_filters( 'amp_wp_template_set_menu_walker', $args['theme_location'] === 'amp-wp-sidebar-nav', $args ) ) {
			add_theme_support( 'amp-wp-navigation' );
			$args['walker'] = new Amp_WP_Menu_Walker();
		}
		return $args;
	}
endif;

if ( ! function_exists( 'amp_wp_direction' ) ) :

	/**
	 * Handy Function to Print ‘Right’ String on RTL Mode and ‘Left’ Otherwise!
	 *
	 * @param   bool $reverse
	 *
	 * @version 1.0.0.
	 * @since   1.0.0
	 * @return  void
	 */
	function amp_wp_direction( $reverse = false ) {
		$header_layout = ( ! empty( amp_wp_get_option( 'amp-wp-header-preset-options' ) ) ) ? amp_wp_get_option( 'amp-wp-header-preset-options' ) : 'logo-left-simple';

		if ( 'logo-left-simple' != $header_layout ) :
			$reverse = true;
		endif;

		if ( $reverse ) {
			echo is_rtl() ? 'right' : 'left';
		} else {
			echo is_rtl() ? 'left' : 'right';
		}
	}
endif;

if ( ! function_exists( 'amp_wp_fix_customizer_statics' ) ) :

	/**
	 * Fix for Loading JS/CSS Static Files in customize.php Page
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_fix_customizer_statics() {
		if ( is_customize_preview() ) {
			add_action( 'amp_wp_template_head', 'wp_head', 1, 1 );
			add_action( 'amp_wp_template_footer', 'wp_footer', 1, 1 );
		}
	}
endif;

if ( ! function_exists( 'amp_wp_site_url' ) ) :

	/**
	 * Get AMP Index Page URL
	 *
	 * @param   string $path Optional. Path relative to the site URL. Default empty.
	 * @param   string $before_sp Custom string to append before amp start point. Default empty.
	 * @param   bool   $front_page_url  Optional. see the following comment.
	 *
	 * @global  array $amp_wp_post_type_slugs list of custom post type rewrite slug @see amp_wp_collect_post_type_slugs
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	function amp_wp_site_url( $path = '', $before_sp = '', $front_page_url = null ) {

		if ( $structure = amp_wp_get_permalink_structure() ) {

			/**
			 * Do not append permalink structure prefix on custom post type urls because The prefix
			 * is just for default WordPress post type (post) and it can not stay before custom post type urls.
			 *
			 * @since 1.5.5
			 */
			if ( $url_prefix = amp_wp_permalink_prefix() ) {
				global $amp_wp_post_type_slugs;

				// Grab all characters until first slash
				$maybe_post_slug_slug = substr( $path, 0, strpos( $path, '/' ) );
				if ( $amp_wp_post_type_slugs && in_array( $maybe_post_slug_slug, $amp_wp_post_type_slugs ) ) { // Is it a custom post type single permalink?
					$url_prefix = '';
				}
			}

			if ( ! isset( $front_page_url ) ) {
				$front_page_url = $path === '';
			}

			if ( ! empty( $path ) && $url_prefix && preg_match( '#^' . preg_quote( $url_prefix, '#' ) . '(.+)$#i', $path, $match ) ) {
				$path      = $match[1];
				$before_sp = str_replace( $match[1], '', $match[0] ) . $before_sp;
			}

			/**
			 * Prepend permalink structure prefix before amp cause 404 error in search page
			 * So we added $front_page_url parameter to bypass this functionality.
			 *
			 * @see     better_amp_permalink_prefix
			 * @see     better_amp_get_search_page_url
			 *
			 * @example when structure is /topics/%post_id%/%postname%/ and $front_page_url = false
			 * Then the search page will be /topics/amp/?s which cause 404 error
			 */
			$url  = trailingslashit( home_url( $front_page_url ? '' : $url_prefix ) );
			$url .= $before_sp ? trailingslashit( $before_sp ) : '';
			$url .= Amp_WP_Public::AMP_WP_STARTPOINT;

			if ( $path ) {
				$url .= '/' . ltrim( $path, '/' );
			}
		} else {
			$url = add_query_arg( Amp_WP_Public::AMP_WP_STARTPOINT, true, home_url( $path ) );
		}

		return $url;
	}
endif;

if ( ! function_exists( 'amp_wp_home_url' ) ) :

	/**
	 * Get AMP Home Page URL
	 *
	 * @since   1.4.2
	 * @return  string
	 */
	function amp_wp_home_url() {
		return esc_url( amp_wp_site_url() );
	}
endif;

if ( ! function_exists( 'amp_wp_url_trim_end_slash' ) ) :

	/**
	 * Trim extra slashes from the end ( Not in used )
	 *
	 * @param   string $url
	 *
	 * @since   1.4.2
	 * @return  string
	 */
	function amp_wp_url_trim_end_slash( $url ) {
		return preg_replace( '#/+#', '/', $url );
	}
endif;

if ( ! function_exists( 'amp_wp_do_shortcode' ) ) :

	/**
	 * Do component shortcodes like WordPress: do_shortcode function
	 *
	 * @since 1.0.5
	 *
	 * @return string Content with shortcodes filtered out
	 */
	function amp_wp_do_shortcode() {
		static $registered;
		$args = func_get_args();
		if ( ! $registered ) {
			Amp_WP_Public::get_instance()->call_components_method( 'register_shortcodes' );
			$registered = true;
		}
		return call_user_func_array( 'do_shortcode', $args );
	}
endif;

if ( ! function_exists( 'amp_wp_get_branding_info' ) ) :

	/**
	 * Returns Site Branding Info
	 *
	 * @param   string $position
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  array
	 */
	function amp_wp_get_branding_info( $position = 'header' ) {
		if ( $info = amp_wp_get_global( $position . '-site-info', false ) ) {
			return $info;
		} else {
			$info = array(
				'logo'        => '',
				'logo-tag'    => '',
				'name'        => get_bloginfo( 'name', 'display' ),
				'description' => get_bloginfo( 'description', 'display' ),
			);
		}

		if ( $name = amp_wp_get_option( 'amp-wp-' . $position . '-logo-text', false ) ) {
			$info['name'] = $name;
		}
		if ( $logo = amp_wp_get_option( 'amp-wp-' . $position . '-logo-img' ) ) {
			$logo = wp_get_attachment_image_src( $logo, 'full' );

			if ( $logo ) {
				$logo = array(
					'src'    => $logo[0],
					'width'  => $logo[1],
					'height' => $logo[2],
				);
			}
			if ( ! empty( $logo['src'] ) ) {
				$info['logo']        = $logo;
				$info['logo']['alt'] = $info['name'] . ' - ' . $info['description'];
				$info['logo-tag']    = amp_wp_create_image( $info['logo'], false );
			}
		}
		amp_wp_set_global( $position . '-site-info', $info );
		return $info;
	}
endif;

if ( ! function_exists( 'amp_wp_get_theme_mod' ) ) :

	/**
	 * Returns saved value of option or default from config
	 *
	 * @param   $name
	 * @param   bool $check_customize_preview
	 *
	 * @todo    remove this function and use amp_wp_get_option instead
	 * @since   1.0.0
	 *
	 * @return  bool|string
	 */
	function amp_wp_get_theme_mod( $name, $check_customize_preview = true ) {
		$result = get_theme_mod( $name, amp_wp_get_default_theme_setting( $name ) );
		if ( ! $result && $check_customize_preview ) {
			$result = amp_wp_is_customize_preview();
		}
		return $result;
	}
endif;
// End Template Hierarchy Related Functions.

// Start Template Hierarchy.
if ( ! function_exists( 'amp_wp_embed_template' ) ) :
	/**
	 * Retrieves an embed template path in the current or parent template.
	 *
	 * The hierarchy for this template looks like:
	 *
	 * 1. embed-{post_type}-{post_format}.php
	 * 2. embed-{post_type}.php
	 * 3. embed.php
	 *
	 * An example of this is:
	 *
	 * 1. embed-post-audio.php
	 * 2. embed-post.php
	 * 3. embed.php
	 *
	 * The template hierarchy and template path are filterable via the {@see '$type_template_hierarchy'}
	 * and {@see '$type_template'} dynamic hooks, where `$type` is 'embed'.
	 *
	 * @since 1.0.0
	 *
	 * @see get_query_template()
	 *
	 * @return string Full path to embed template file.
	 */
	function amp_wp_embed_template() {
		$object    = get_queried_object();
		$templates = array();
		if ( ! empty( $object->post_type ) ) {
			$post_format = get_post_format( $object );
			if ( $post_format ) {
				$templates[] = "embed-{$object->post_type}-{$post_format}.php";
			}
			$templates[] = "embed-{$object->post_type}.php";
		}
		$templates[] = 'embed.php';

		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_404_template' ) ) :

	/**
	 * Retrieve path of 404 template in current or parent template.
	 *
	 * @see     get_404_template()
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to 404 template file.
	 */
	function amp_wp_404_template() {
		return amp_wp_locate_template( '404.php' );
	}
endif;

if ( ! function_exists( 'amp_wp_search_template' ) ) :

	/**
	 * Retrieve path of search template in current or parent template.
	 *
	 * @see     get_search_template()
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to search template file.
	 */
	function amp_wp_search_template() {
		return amp_wp_locate_template( 'search.php' );
	}
endif;

if ( ! function_exists( 'amp_wp_is_static_home_page' ) ) :

	/**
	 * Is current page static home page
	 *
	 * @return  bool true on success or false on failure
	 * @since   1.0.0
	 */
	function amp_wp_is_static_home_page() {
		return is_home() && apply_filters( 'amp_wp_template_show_on_front', 'posts' ) === 'page';
	}
endif;

if ( ! function_exists( 'amp_wp_static_home_page_template' ) ) :

	/**
	 * Retrieve Path of Static Homepage Template in Current or Parent Template.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string  Full Path to Static Home Page Template File.
	 */
	function amp_wp_static_home_page_template() {

		if ( $template = amp_wp_front_page_template() ) :
		elseif ( $template = amp_wp_page_template() ) :
		elseif ( $template = amp_wp_singular_template() ) :
		endif;

		return $template;
	}
endif;

if ( ! function_exists( 'amp_wp_front_page_template' ) ) :
	/**
	 * Retrieve path of front-page template in current or parent template.
	 *
	 * @see   get_front_page_template()
	 *
	 * @since 1.0.0
	 *
	 * @return string Full path to front page template file.
	 */
	function amp_wp_front_page_template() {
		return amp_wp_locate_template( 'front-page.php' );
	}
endif;

if ( ! function_exists( 'amp_wp_home_template' ) ) :

	/**
	 * Retrieve path of home template in current or parent template.
	 *
	 * @see     get_home_template()
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to home template file.
	 */
	function amp_wp_home_template() {
		$templates = array( 'home.php', 'index.php' );
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_post_type_archive_template' ) ) :

	/**
	 * Retrieve path of post type archive template in current or parent template.
	 *
	 * @see   amp_wp_archive_template()
	 * @see   get_post_type_archive_template()
	 *
	 * @since 1.0.0
	 *
	 * @return string Full path to archive template file.
	 */
	function amp_wp_post_type_archive_template() {
		$post_type = get_query_var( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}

		$obj = get_post_type_object( $post_type );
		if ( ! $obj->has_archive ) {
			return '';
		}
		return amp_wp_archive_template();
	}
endif;

if ( ! function_exists( 'amp_wp_taxonomy_template' ) ) :
	/**
	 * Retrieve path of taxonomy template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string  Full path to taxonomy template file.
	 */
	function amp_wp_taxonomy_template() {
		$term      = get_queried_object();
		$templates = array();
		if ( ! empty( $term->slug ) ) {
			$taxonomy    = $term->taxonomy;
			$templates[] = "taxonomy-$taxonomy-{$term->slug}.php";
			$templates[] = "taxonomy-$taxonomy.php";
		}
		$templates[] = 'taxonomy.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_attachment_template' ) ) :

	/**
	 * Retrieve Path of Attachment Template in Current or Parent Template.
	 *
	 * @global  array $posts
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to attachment template file.
	 */
	function amp_wp_attachment_template() {
		$attachment = get_queried_object();
		$templates  = array();
		if ( $attachment ) {
			if ( false !== strpos( $attachment->post_mime_type, '/' ) ) {
				list( $type, $subtype ) = explode( '/', $attachment->post_mime_type );
			} else {
				list( $type, $subtype ) = array( $attachment->post_mime_type, '' );
			}

			if ( ! empty( $subtype ) ) {
				$templates[] = "{$type}-{$subtype}.php";
				$templates[] = "{$subtype}.php";
			}
			$templates[] = "{$type}.php";
		}

		$templates[] = 'attachment.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_single_template' ) ) :

	/**
	 * Retrieve path of single template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to single template file.
	 */
	function amp_wp_single_template() {
		$object    = get_queried_object();
		$templates = array();
		if ( ! empty( $object->post_type ) ) {
			$templates[] = "single-{$object->post_type}-{$object->post_name}.php";
			$templates[] = "single-{$object->post_type}.php";
		}
		$templates[] = 'single.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_page_template' ) ) :

	/**
	 * Retrieve path of page template in current or parent template.
	 *
	 * @see     get_page_template()
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to page template file.
	 */
	function amp_wp_page_template() {
		$id       = get_queried_object_id();
		$template = get_page_template_slug();
		$pagename = get_query_var( 'pagename' );

		if ( ! $pagename && $id ) {
			// If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
			$post = get_queried_object();
			if ( $post ) {
				$pagename = $post->post_name;
			}
		}

		$templates = array();
		if ( $template && 0 === validate_file( $template ) ) {
			$templates[] = $template;
		}
		if ( $pagename ) {
			$templates[] = "page-$pagename.php";
		}
		if ( $id ) {
			$templates[] = "page-$id.php";
		}

		$templates[] = 'page.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_singular_template' ) ) :
	/**
	 * Retrieves the path of the singular template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string  Full path to singular template file
	 */
	function amp_wp_singular_template() {
		return amp_wp_locate_template( 'singular.php' );
	}
endif;

if ( ! function_exists( 'amp_wp_category_template' ) ) :
	/**
	 * Retrieve path of category template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to category template file.
	 */
	function amp_wp_category_template() {
		$category  = get_queried_object();
		$templates = array();
		if ( ! empty( $category->slug ) ) {
			$templates[] = "category-{$category->slug}.php";
			$templates[] = "category-{$category->term_id}.php";
		}
		$templates[] = 'category.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_tag_template' ) ) :
	/**
	 * Retrieve path of tag template in current or parent template.
	 *
	 * @see     get_query_template()
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to tag template file.
	 */
	function amp_wp_tag_template() {
		$tag       = get_queried_object();
		$templates = array();
		if ( ! empty( $tag->slug ) ) {
			$templates[] = "tag-{$tag->slug}.php";
			$templates[] = "tag-{$tag->term_id}.php";
		}
		$templates[] = 'tag.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_author_template' ) ) :

	/**
	 * Retrieve path of author template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to author template file.
	 */
	function amp_wp_author_template() {
		$author    = get_queried_object();
		$templates = array();
		if ( $author instanceof WP_User ) {
			$templates[] = "author-{$author->user_nicename}.php";
			$templates[] = "author-{$author->ID}.php";
		}
		$templates[] = 'author.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_date_template' ) ) :
	/**
	 * Retrieve path of date template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to date template file.
	 */
	function amp_wp_date_template() {
		return amp_wp_locate_template( 'date.php' );
	}
endif;

if ( ! function_exists( 'amp_wp_archive_template' ) ) :

	/**
	 * Retrieve path of archive template in current or parent template.
	 *
	 * @see     get_archive_template()
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to archive template file.
	 */
	function amp_wp_archive_template() {
		$post_types = array_filter( (array) get_query_var( 'post_type' ) );
		$templates  = array();

		if ( count( $post_types ) == 1 ) {
			$post_type   = reset( $post_types );
			$templates[] = "archive-{$post_type}.php";
		}
		$templates[] = 'archive.php';
		return amp_wp_locate_template( $templates );
	}
endif;

if ( ! function_exists( 'amp_wp_paged_template' ) ) :
	/**
	 * Retrieve path of paged template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to paged template file.
	 */
	function amp_wp_paged_template() {
		return amp_wp_locate_template( 'paged.php' );
	}
endif;

if ( ! function_exists( 'amp_wp_index_template' ) ) :

	/**
	 * Retrieve path of index template in current or parent template.
	 *
	 * @since   1.0.0
	 *
	 * @return  string Full path to index template file.
	 */
	function amp_wp_index_template() {
		return amp_wp_locate_template( 'index.php' );
	}
endif;
// End Template Hierarchy
// Start Global Variables
if ( ! function_exists( 'amp_wp_set_global' ) ) :

	/**
	 * Used to set a global variable.
	 *
	 * @param   string $id
	 * @param   mixed  $value
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_set_global( $id, $value ) {
		global $amp_wp_theme_core_globals_cache;
		$amp_wp_theme_core_globals_cache[ $id ] = $value;
	}
endif;

if ( ! function_exists( 'amp_wp_unset_global' ) ) :

	/**
	 * Used to Remove a Global Variable.
	 *
	 * @param   string $id
	 *
	 * @since   1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_unset_global( $id ) {
		global $amp_wp_theme_core_globals_cache;
		unset( $amp_wp_theme_core_globals_cache[ $id ] );
	}
endif;

if ( ! function_exists( 'amp_wp_get_global' ) ) :

	/**
	 * Used to get a global value.
	 *
	 * @param   string $id
	 * @param   mixed  $default
	 *
	 * @since   1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_get_global( $id, $default = null ) {
		global $amp_wp_theme_core_globals_cache;
		if ( isset( $amp_wp_theme_core_globals_cache[ $id ] ) ) {
			return $amp_wp_theme_core_globals_cache[ $id ];
		} else {
			return $default;
		}
	}
endif;

if ( ! function_exists( 'amp_wp_echo_global' ) ) :

	/**
	 * Used to Print a Global Value.
	 *
	 * @param   string $id
	 * @param   mixed  $default
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_echo_global( $id, $default = null ) {
		global $amp_wp_theme_core_globals_cache;
		if ( isset( $amp_wp_theme_core_globals_cache[ $id ] ) ) {
			echo $amp_wp_theme_core_globals_cache[ $id ]; // escaped before
		} else {
			echo $default; // escaped before
		}
	}
endif;

if ( ! function_exists( 'amp_wp_clear_globals' ) ) :

	/**
	 * Used to clear all properties.
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	function amp_wp_clear_globals() {
		global $amp_wp_theme_core_globals_cache;
		$amp_wp_theme_core_globals_cache = array();
	}
endif;
// End Global Variables
// Start Blocks Properties
if ( ! function_exists( 'amp_wp_get_prop' ) ) :

	/**
	 * Used to get a property value.
	 *
	 * @param   string $id
	 * @param   mixed  $default
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_get_prop( $id, $default = null ) {
		global $amp_wp_theme_core_props_cache;
		if ( isset( $amp_wp_theme_core_props_cache[ $id ] ) ) {
			return $amp_wp_theme_core_props_cache[ $id ];
		} else {
			return $default;
		}
	}
endif;

if ( ! function_exists( 'amp_wp_echo_prop' ) ) :

	/**
	 * Used to print a property value.
	 *
	 * @param   string $id
	 * @param   mixed  $default
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_echo_prop( $id, $default = null ) {
		global $amp_wp_theme_core_props_cache;

		if ( isset( $amp_wp_theme_core_props_cache[ $id ] ) ) {
			echo $amp_wp_theme_core_props_cache[ $id ]; // escaped before
		} else {
			echo $default; // escaped before
		}
	}
endif;

if ( ! function_exists( 'amp_wp_get_prop_class' ) ) :

	/**
	 * Used to get block class property.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function amp_wp_get_prop_class() {
		global $amp_wp_theme_core_props_cache;

		if ( isset( $amp_wp_theme_core_props_cache['class'] ) ) {
			return $amp_wp_theme_core_props_cache['class'];
		} else {
			return '';
		}
	}
endif;

if ( ! function_exists( 'amp_wp_get_prop_thumbnail_size' ) ) :

	/**
	 * Used to get block thumbnail size property.
	 *
	 * @param   string $default
	 *
	 * @since 1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_get_prop_thumbnail_size( $default = 'thumbnail' ) {
		global $amp_wp_theme_core_props_cache;

		if ( isset( $amp_wp_theme_core_props_cache['thumbnail-size'] ) ) {
			return $amp_wp_theme_core_props_cache['thumbnail-size'];
		} else {
			return $default;
		}
	}
endif;

if ( ! function_exists( 'amp_wp_set_prop' ) ) :

	/**
	 * Used to set a block property value.
	 *
	 * @param   string $id
	 * @param   mixed  $value
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_set_prop( $id, $value ) {
		global $amp_wp_theme_core_props_cache;

		$amp_wp_theme_core_props_cache[ $id ] = $value;
	}
endif;

if ( ! function_exists( 'amp_wp_set_prop_class' ) ) :

	/**
	 * Used to set a block class property value.
	 *
	 * @param   mixed $value
	 * @param   bool  $clean
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_set_prop_class( $value, $clean = false ) {
		global $amp_wp_theme_core_props_cache;

		if ( $clean ) {
			$amp_wp_theme_core_props_cache['class'] = $value;
		} else {
			$amp_wp_theme_core_props_cache['class'] = $value . ' ' . amp_wp_get_prop_class();
		}
	}
endif;

if ( ! function_exists( 'amp_wp_set_prop_thumbnail_size' ) ) :

	/**
	 * Used to set a block property value.
	 *
	 * @param   mixed $value
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_set_prop_thumbnail_size( $value = 'thumbnail' ) {
		global $amp_wp_theme_core_props_cache;

		$amp_wp_theme_core_props_cache['thumbnail-size'] = $value;
	}
endif;

if ( ! function_exists( 'amp_wp_unset_prop' ) ) :

	/**
	 * Used to remove a property from block property list.
	 *
	 * @param   string $id
	 *
	 * @since 1.0.0
	 *
	 * @return  mixed
	 */
	function amp_wp_unset_prop( $id ) {
		global $amp_wp_theme_core_props_cache;

		unset( $amp_wp_theme_core_props_cache[ $id ] );
	}
endif;

if ( ! function_exists( 'amp_wp_clear_props' ) ) :

	/**
	 * Used to clear all properties.
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	function amp_wp_clear_props() {
		global $amp_wp_theme_core_props_cache;

		$amp_wp_theme_core_props_cache = array();
	}
endif;
// End Blocks Properties
if ( ! function_exists( 'amp_wp_get_option' ) ) :

	/**
	 * Returns option value
	 *
	 * @param string $option_key
	 * @param string $default_value
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function amp_wp_get_option( $option_key = '', $default_value = null ) {
		if ( empty( $option_key ) ) {
			return $default_value;
		}
		if ( is_null( $default_value ) ) {
			$default_value = apply_filters( 'amp-wp-template-default-theme-mod', $default_value, $option_key );
		}
		return get_theme_mod( $option_key, $default_value );
	}
endif;

if ( ! function_exists( 'amp_wp_get_server_ip_address' ) ) :

	/**
	 * Handy Function for Get Server IP
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string|null IP address on success or null on failure.
	 */
	function amp_wp_get_server_ip_address() {
		global $is_IIS;

		$ip = ( $is_IIS && isset( $_SERVER['LOCAL_ADDR'] ) ) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR'];

		if ( $ip === '::1' || filter_var( $ip, FILTER_VALIDATE_IP ) !== false ) {
			return $ip;
		}
	}
endif;

if ( ! function_exists( 'amp_wp_is_localhost' ) ) :

	/**
	 * Utility function to detect is site currently running on localhost?
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	function amp_wp_is_localhost() {
		$server_ip      = amp_wp_get_server_ip_address();
		$server_ip_long = ip2long( $server_ip );
		return $server_ip === '::1' || ( $server_ip_long >= 2130706433 && $server_ip_long <= 2147483646 );
	}
endif;

// Start Queries
if ( ! function_exists( 'amp_wp_get_query' ) ) :

	/**
	 * Used to get current query.
	 *
	 * @since 1.0.0
	 *
	 * @return  WP_Query|null
	 */
	function amp_wp_get_query() {
		global $amp_wp_theme_core_query;

		// Add default query to ThemeName query if its not added or default query is used.
		if ( ! is_a( $amp_wp_theme_core_query, 'WP_Query' ) ) {
			global $wp_query;
			$amp_wp_theme_core_query = &$wp_query;
		}
		return $amp_wp_theme_core_query;
	}
endif;

if ( ! function_exists( 'amp_wp_set_query' ) ) :

	/**
	 * Used to get current query.
	 *
	 * @param   WP_Query $query
	 *
	 * @since 1.0.0
	 */
	function amp_wp_set_query( &$query ) {
		global $amp_wp_theme_core_query;
		$amp_wp_theme_core_query = $query;
	}

endif;

if ( ! function_exists( 'amp_wp_clear_query' ) ) :

	/**
	 * Used to get current query.
	 *
	 * @param   bool $reset_query
	 *
	 * @since   1.0.0
	 */
	function amp_wp_clear_query( $reset_query = true ) {
		global $amp_wp_theme_core_query;
		$amp_wp_theme_core_query = null;

		// This will remove obscure bugs that occur when the previous wp_query object is not destroyed properly before another is set up.
		if ( $reset_query ) {
			wp_reset_query();
		}
	}
endif;
// End Queries
// Start Post Related Functions
if ( ! function_exists( 'amp_wp_have_posts' ) ) :

	/**
	 * Used for checking have posts in advanced way!
	 *
	 * @since 1.0.0
	 */
	function amp_wp_have_posts() {
		// Add default query to amp_wp_template query if its not added or default query is used.
		if ( ! amp_wp_get_query() instanceof WP_Query ) {
			global $wp_query;
			amp_wp_set_query( $wp_query );
		}

		// If Count Customized
		if ( amp_wp_get_prop( 'posts-count', null ) != null ) {
			if ( amp_wp_get_prop( 'posts-counter', 1 ) > amp_wp_get_prop( 'posts-count' ) ) {
				return false;
			} else {
				if ( amp_wp_get_query()->current_post + 1 < amp_wp_get_query()->post_count ) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return amp_wp_get_query()->current_post + 1 < amp_wp_get_query()->post_count;
		}
	}
endif;

if ( ! function_exists( 'amp_wp_the_post' ) ) :

	/**
	 * Custom the_post for custom counter functionality
	 *
	 * @since 1.0.0
	 */
	function amp_wp_the_post() {
		// If count customized
		if ( amp_wp_get_prop( 'posts-count', null ) != null ) {
			amp_wp_set_prop( 'posts-counter', absint( amp_wp_get_prop( 'posts-counter', 1 ) ) + 1 );
		}

		// Do default the_post
		amp_wp_get_query()->the_post();
	}
endif;

if ( ! function_exists( 'amp_wp_the_post_thumbnail' ) ) :

	/**
	 * Display the post thumbnail.
	 *
	 * @since 1.0.0
	 *
	 * @param string $size
	 * @param string $attr
	 */
	function amp_wp_the_post_thumbnail( $size = 'post-thumbnail', $attr = '' ) {
		if ( empty( $attr ) ) {
			$attr = array(
				'alt'    => the_title_attribute( array( 'echo' => false ) ),
				'layout' => 'responsive',
			);
		}
		the_post_thumbnail( $size, $attr );
	}
endif;

if ( ! function_exists( 'amp_wp_human_number_format' ) ) :

	/**
	 * Format number to human friendly style
	 *
	 * @param $number
	 *
	 * @return string
	 */
	function amp_wp_human_number_format( $number ) {
		if ( ! is_numeric( $number ) ) {
			return $number;
		}
		if ( $number >= 1000000 ) {
			return round( ( $number / 1000 ) / 1000, 1 ) . 'M';
		} elseif ( $number >= 100000 ) {
			return round( $number / 1000, 0 ) . 'k';
		} else {
			return @number_format( $number );
		}
	}
endif;

if ( ! function_exists( 'amp_wp_get_archive_title_fields' ) ) :

	/**
	 * Handy function used to get archive pages title fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function amp_wp_get_archive_title_fields() {
		$icon        = '';
		$pre_title   = '';
		$title       = '';
		$description = '';

		if ( is_category() ) {
			$icon        = '<i class="fa fa-folder"></i>';
			$pre_title   = amp_wp_translation_get( 'browsing_category' );
			$title       = single_cat_title( '', false );
			$description = category_description();

		} elseif ( is_tag() ) {
			$icon        = '<i class="fa fa-tag"></i>';
			$pre_title   = amp_wp_translation_get( 'browsing_tag' );
			$title       = single_tag_title( '', false );
			$description = tag_description();
		} elseif ( is_author() ) {
			$icon        = '<i class="fa fa-user-circle"></i>';
			$pre_title   = amp_wp_translation_get( 'browsing_author' );
			$title       = '<span class="vcard">' . get_the_author() . '</span>';
			$description = get_the_author_meta( 'description' );
		} elseif ( is_year() ) {
			$icon      = '<i class="fa fa-calendar"></i>';
			$pre_title = amp_wp_translation_get( 'browsing_yearly' );
			$title     = get_the_date( _x( 'Y', 'yearly archives date format', 'amp-wp' ) );
		} elseif ( is_month() ) {
			$icon      = '<i class="fa fa-calendar"></i>';
			$pre_title = amp_wp_translation_get( 'browsing_monthly' );
			$title     = get_the_date( _x( 'F Y', 'monthly archives date format', 'amp-wp' ) );
		} elseif ( is_day() ) {
			$icon      = '<i class="fa fa-calendar"></i>';
			$pre_title = amp_wp_translation_get( 'browsing_daily' );
			$title     = get_the_date( _x( 'F j, Y', 'daily archives date format', 'amp-wp' ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$icon      = '<i class="fa fa-pencil"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'asides' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$icon      = '<i class="fa fa-camera"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'galleries' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$icon      = '<i class="fa fa-camera"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'images' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$icon      = '<i class="fa fa-video-camera"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'videos' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$icon      = '<i class="fa fa-quote-' . amp_wp_direction() . '"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'quotes' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$icon      = '<i class="fa fa-link"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'links' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$icon      = '<i class="fa fa-refresh"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'statuses' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$icon      = '<i class="fa fa-music"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'audio' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$icon      = '<i class="fa fa-coffee"></i>';
				$pre_title = amp_wp_translation_get( 'browsing_archive' );
				$title     = amp_wp_translation_get( 'chats' );
			}
		} elseif ( is_post_type_archive() ) {
			$icon        = '<i class="fa fa-archive"></i>';
			$pre_title   = amp_wp_translation_get( 'browsing_archive' );
			$title       = post_type_archive_title( '', false );
			$description = function_exists( 'get_the_post_type_description' ) ? get_the_post_type_description() : '';
		} elseif ( is_tax() ) {
			$tax         = get_taxonomy( get_queried_object()->taxonomy );
			$icon        = '<i class="fa fa-archive"></i>';
			$pre_title   = amp_wp_translation_get( 'browsing_archive' );
			$title       = sprintf( __( '%1$s: %2$s', 'beetter-amp' ), $tax->labels->singular_name, single_term_title( '', false ) );
			$description = term_description();
		} else {
			$icon      = '<i class="fa fa-archive"></i>';
			$pre_title = amp_wp_translation_get( 'browsing' );
			$title     = amp_wp_translation_get( 'archive' );
		}
		return compact( 'icon', 'pre_title', 'title', 'description' );
	}
endif;

if ( ! function_exists( 'amp_wp_post_classes' ) ) :

	/**
	 * Handy function to generate class attribute for posts
	 *
	 * @param   string|array $append One or more classes to add to the class list.
	 * @since       1.0.0
	 * @return  void
	 */
	function amp_wp_post_classes( $append = '' ) {
		$class = get_post_class( $append );

		if ( ! has_post_thumbnail() ) {
			$class[] = 'no-thumbnail';
		} else {
			$class[] = 'have-thumbnail';
		}

		$class[] = 'clearfix';
		$class   = str_replace( 'hentry', '', join( ' ', $class ) );
		echo 'class = "' . $class . '"';
		unset( $class );
	}
endif;

if ( ! function_exists( 'amp_wp_related_posts_query_args' ) ) :

	/**
	 * Get Related Posts
	 *
	 * @param integer      $count  number of posts to return
	 * @param string       $type
	 * @param integer|null $post_id
	 * @param array        $params query extra arguments
	 *
	 * @return array  query args array
	 */
	function amp_wp_related_posts_query_args( $count = 5, $type = 'cat', $post_id = null, $params = array() ) {
		$post = get_post( $post_id );
		if ( ! $post_id && isset( $post->ID ) ) {
			$post_id = $post->ID;
		}

		$args = array(
			'posts_per_page'      => $count,
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => true,
		);
		switch ( $type ) {
			case 'cat':
				$args['category__in'] = wp_get_post_categories( $post_id );
				break;
			case 'tag':
				$tag_in = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
				if ( $tag_in && ! is_wp_error( $tag_in ) ) {
					$args['tag__in'] = $tag_in;
				}
				break;
			case 'author':
				if ( isset( $post->post_author ) ) {
					$args['author'] = $post->post_author;
				}
				break;
			case 'cat-tag':
				$args['category__in'] = wp_get_post_categories( $post_id );
				$args['tag__in']      = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
				break;
			case 'cat-tag-author':
				$args['category__in'] = wp_get_post_categories( $post_id );

				if ( isset( $post->post_author ) ) {
					$args['author'] = $post->post_author;
				}

				$tag_in = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
				if ( $tag_in && ! is_wp_error( $tag_in ) ) {
					$args['tag__in'] = $tag_in;
				}
				break;

			case 'rand':
			case 'random':
			case 'randomly':
				$args['orderby'] = 'rand';
				break;
		}

		if ( $params ) {
			$args = array_merge( $args, $params );
		}
		return $args;
	}
endif;

if ( ! function_exists( 'amp_wp_get_post_parent' ) ) :

	/**
	 * Get post parent
	 *
	 * @param int $attachment_id
	 *
	 * @since 1.0.0
	 * @return bool|WP_Post WP_Post on success or false on failure
	 */
	function amp_wp_get_post_parent( $attachment_id = null ) {
		$attachment = ( empty( $attachment_id ) && isset( $GLOBALS['post'] ) ) ? $GLOBALS['post'] : get_post( $attachment_id );

		// Validate attachment
		if ( ! $attachment || is_wp_error( $attachment ) ) {
			return false; }

		$parent = false;
		if ( ! empty( $attachment->post_parent ) ) {
			$parent = get_post( $attachment->post_parent );
			if ( ! $parent || is_wp_error( $parent ) ) {
				$parent = false;
			}
		}
		return $parent;
	}
endif;
// End Post Related Functions
// Start Scial Share Post Related Functions
if ( ! function_exists( 'amp_wp_social_share_fetch_count' ) ) {
	/**
	 * Fetch Share Count for URL
	 *
	 * @param $site_id
	 * @param $url
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	function amp_wp_social_share_fetch_count( $site_id, $url ) {

		$count       = 0;
		$remote_args = array( 'sslverify' => false );

		switch ( $site_id ) {
			case 'facebook':
				$remote = wp_safe_remote_get( 'http://graph.facebook.com/?fields=og_object{id},share&id=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					$response = json_decode( wp_remote_retrieve_body( $remote ), true );
					if ( isset( $response['share']['share_count'] ) ) {
						$count = $response['share']['share_count'];
					}
				}
				break;
			case 'twitter':
				$remote = wp_safe_remote_get( 'http://public.newsharecounts.com/count.json?callback=&url=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					$response = json_decode( wp_remote_retrieve_body( $remote ), true );
					if ( isset( $response['count'] ) ) {
						$count = $response['count'];
					}
				}
				break;
			/*
			case 'google_plus':
				$post_data = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode( $url ) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';
				$remote    = wp_safe_remote_get(
					'https://clients6.google.com/rpc',
					array(
						'body'      => $post_data,
						'headers'   => 'Content-type: application/json',
						'sslverify' => false,
					)
				);
				*/
			if ( ! is_wp_error( $remote ) ) {
				$response = json_decode( wp_remote_retrieve_body( $remote ), true );
				if ( isset( $response[0]['result']['metadata']['globalCounts']['count'] ) ) {
					$count = $response[0]['result']['metadata']['globalCounts']['count'];
				}
			}
				break;
			case 'pinterest':
				$remote = wp_safe_remote_get( 'http://api.pinterest.com/v1/urls/count.json?callback=CALLBACK&url=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					if ( preg_match( '/^\s*CALLBACK\s*\((.+)\)\s*$/', wp_remote_retrieve_body( $remote ), $match ) ) {
						$response = json_decode( $match[1], true );
						if ( isset( $response['count'] ) ) {
							$count = $response['count'];
						}
					}
				}
				break;
			case 'linkedin':
				$remote = wp_safe_remote_get( 'https://www.linkedin.com/countserv/count/share?format=json&url=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					$response = json_decode( wp_remote_retrieve_body( $remote ), true );
					if ( isset( $response['count'] ) ) {
						$count = $response['count'];
					}
				}
				break;
			case 'tumblr':
				$remote = wp_safe_remote_get( 'http://api.tumblr.com/v2/share/stats?url=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					$response = json_decode( wp_remote_retrieve_body( $remote ), true );
					if ( isset( $response['response']['note_count'] ) ) {
						$count = $response['response']['note_count'];
					}
				}
				break;
			case 'reddit':
				$remote = wp_safe_remote_get( 'http://www.reddit.com/api/info.json?url=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					$response = json_decode( $remote['body'], true );
					if ( isset( $response['data']['children']['0']['data']['score'] ) ) {
						$count = $response['data']['children']['0']['data']['score'];
					}
				}
				break;
			case 'stumbleupon':
				$remote = wp_safe_remote_get( 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $url, $remote_args );
				if ( ! is_wp_error( $remote ) ) {
					$response = json_decode( $remote['body'], true );
					if ( isset( $response['result']['views'] ) ) {
						$count = $response['result']['views'];
					}
				}
				break;
		}
		return $count;
	}
}

if ( ! function_exists( 'amp_wp_social_shares_count' ) ) :

	/**
	 * Returns all social share count for post.
	 *
	 * @param $sites
	 *
	 * @since 1.0.0
	 *
	 * @return array|mixed|void
	 */
	function amp_wp_social_shares_count( $sites ) {
		$sites = array_intersect_key(
			$sites,
			array(
				// Valid sites
				'facebook'    => '',
				'twitter'     => '',
				'google_plus' => '',
				'pinterest'   => '',
				'linkedin'    => '',
				'tumblr'      => '',
				'reddit'      => '',
				'stumbleupon' => '',
			)
		);

		// Disable social share in localhost
		if ( amp_wp_is_localhost() ) {
			return array();
		}

		$post_id      = get_queried_object_id();
		$expired      = (int) get_post_meta( $post_id, '_amp_wp_social_share_interval', true );
		$results      = array();
		$update_cache = false;

		if ( $expired < time() ) {
			$update_cache = true;
		} else {
			// Get count from cache storage
			foreach ( $sites as $site_id => $is_active ) {
				if ( ! $is_active ) {
					continue; }

				$count_number = get_post_meta( $post_id, '_amp_wp_social_share_' . $site_id, true );
				$update_cache = $count_number === '';

				if ( $update_cache ) {
					break; }
				$results[ $site_id ] = $count_number;
			}
		}

		if ( $update_cache ) { // Update cache storage if needed
			$current_page = amp_wp_social_share_current_page();
			foreach ( $sites as $site_id => $is_active ) {
				if ( ! $is_active ) {
					continue;
				}
				$count_number = amp_wp_social_share_fetch_count( $site_id, $current_page['page_permalink'] );
				update_post_meta( $post_id, '_amp_wp_social_share_' . $site_id, $count_number );
				$results[ $site_id ] = $count_number;
			}
			/**
			 * This filter can be used to change share count time.
			 */
			$cache_time = apply_filters( 'amp_wp_social_share_cache_time', MINUTE_IN_SECONDS * 120, $post_id );
			update_post_meta( $post_id, '_amp_wp_social_share_interval', time() + $cache_time );
		}
		return apply_filters( 'amp_wp_social_share_count', $results );
	}
endif;

if ( ! function_exists( 'amp_wp_social_share_current_page' ) ) :

	/**
	 * Get and Returns Current Page Info for Social Share
	 *
	 * @version 1.0.0
	 * @since       1.0.0
	 *
	 * @return  array
	 */
	function amp_wp_social_share_current_page() {

		$page_permalink                   = '';
		$social_share_on_post_link_format = '';
		$amp_wp_layout_settings           = get_option( 'amp_wp_layout_settings' );
		if ( isset( $amp_wp_layout_settings['social_share_on_post_link_format'] ) && ! empty( $amp_wp_layout_settings['social_share_on_post_link_format'] ) ) {
			$social_share_on_post_link_format = $amp_wp_layout_settings['social_share_on_post_link_format'];
		}
		$need_short_link = $social_share_on_post_link_format === 'short';

		if ( is_home() || is_front_page() ) {
			$page_title = get_bloginfo( 'name' );
		} elseif ( is_single( get_the_ID() ) && ! ( is_front_page() ) ) {
			$page_title = get_the_title();
			if ( $need_short_link ) {
				$page_permalink = wp_get_shortlink();
			}
		} elseif ( is_page() ) {
			$page_title = get_the_title();
			if ( $need_short_link ) {
				$page_permalink = wp_get_shortlink();
			}
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$page_title = single_term_title( '', false );
			if ( $need_short_link ) {
				$queried_object = get_queried_object();
				if ( ! empty( $queried_object->taxonomy ) ) {
					if ( 'category' == $queried_object->taxonomy ) {
						$page_permalink = "?cat=$queried_object->term_id";
					} else {
						$tax = get_taxonomy( $queried_object->taxonomy );
						if ( $tax->query_var ) {
							$page_permalink = "?$tax->query_var=$queried_object->slug";
						} else {
							$page_permalink = "?taxonomy=$queried_object->taxonomy&term=$queried_object->term_id";
						}
					}
					$page_permalink = home_url( $page_permalink );
				}
			}
		} else {
			$page_title = get_bloginfo( 'name' );
		}

		if ( ! $page_permalink ) {
			$page_permalink = amp_wp_guess_non_amp_url();
		}
		return compact( 'page_title', 'page_permalink' );
	}
endif;

if ( ! function_exists( 'amp_wp_social_share_get_li' ) ) :

	/**
	 * Used for Generating li's for Social Share List
	 *
	 * @param string $id Social ID e.g. email, facebook, twitter etc.
	 * @param bool   $show_title
	 * @param int    $count_label
	 *
	 * @since 1.0.0
	 * @since 1.5.0 Added AMP Social Share Button.
	 *
	 * @return  string
	 */
	function amp_wp_social_share_get_li( $id = '', $show_title = true, $count_label = 0 ) {

		if ( empty( $id ) ) {
			return ''; }

		static $initialized;
		static $page_title;
		static $page_permalink;

		// Fix for after other loops.
		wp_reset_postdata();

		$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );

		if ( is_null( $initialized ) ) {
			$cur_page = amp_wp_social_share_current_page();
			if ( is_array( $cur_page ) ) {
				$page_title     = $cur_page['page_title'];
				$page_permalink = $cur_page['page_permalink'];
				$initialized    = true;
			}
		}

		switch ( $id ) {
			case 'email':
				$area_label = 'Email';
				$type       = 'email';
				$param      = ' data-param-subject="' . esc_attr( $page_title ) . '" data-param-body="' . esc_url( $page_permalink ) . '"';
				break;

			case 'facebook':
				if ( isset( $amp_wp_layout_settings['facebook_app_id'] ) && ! empty( $amp_wp_layout_settings['facebook_app_id'] ) ) {
					$area_label = 'Facebook';
					$type       = 'facebook';
					$param      = ' data-param-app_id="' . esc_attr( $amp_wp_layout_settings['facebook_app_id'] ) . '" data-param-href="' . esc_url( $page_permalink ) . '" data-param-quote="' . esc_attr( $page_title ) . '" ';
				}
				break;
			case 'linkedin':
				$area_label = 'LinkedIn';
				$type       = 'linkedin';
				$param      = ' data-share-endpoint="https://www.linkedin.com/sharing/share-offsite" data-param-url="' . esc_url( $page_permalink ) . '"';
				break;
			case 'pinterest':
				$area_label = 'Pinterest';
				$type       = 'pinterest';
				$param      = ' data-param-url="' . esc_url( $page_permalink ) . '" data-param-description="' . esc_attr( $page_title ) . '"';

				$_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if ( $_img_src[0] ) {
					$param .= ' data-param-media="' . esc_url( $_img_src[0] ) . '"';
				}
				break;
			case 'tumblr':
				$area_label = 'Tumblr';
				$type       = 'tumblr';
				$param      = ' data-param-url="' . esc_url( $page_permalink ) . '" data-param-text="' . esc_attr( $page_title ) . '" ';
				break;
			case 'twitter':
				$area_label = 'Twitter';
				$type       = 'twitter';
				$param      = 'data-param-href="' . esc_url( $page_permalink ) . '" data-param-text="' . esc_attr( $page_title ) . '" ';
				break;
			case 'whatsapp':
				$area_label = 'WhatsApp';
				$type       = 'whatsapp';
				$param      = 'data-param-text="' . esc_attr( $page_title ) . ' - ' . esc_url( $page_permalink ) . '" ';
				break;
			case 'line':
				$area_label = 'LINE';
				$type       = 'line';
				$param      = ' data-param-url="' . esc_url( $page_permalink ) . '" data-param-text="' . esc_attr( $page_title ) . '" ';
				break;
			case 'stumbleupon':
				$area_label = 'StumbleUpon';
				$type       = 'stumbleupon';
				$param      = ' data-share-endpoint="https://www.stumbleupon.com/submit" data-param-text="' . esc_attr( $page_title ) . '" data-param-url="' . esc_url( $page_permalink ) . '" ';
				break;
			case 'telegram':
				$area_label = 'Telegram';
				$type       = 'telegram';
				$param      = ' data-share-endpoint="https://telegram.me/share/url" data-param-text="' . esc_attr( $page_title ) . '" data-param-url="' . esc_url( $page_permalink ) . '" ';
				break;
			case 'digg':
				$area_label = 'Digg';
				$type       = 'digg';
				$param      = ' data-share-endpoint="https://www.digg.com/submit" data-param-text="' . esc_attr( $page_title ) . '" data-param-url="' . esc_url( $page_permalink ) . '" ';
				break;
			case 'reddit':
				$area_label = 'Reddit';
				$type       = 'reddit';
				$param      = ' data-share-endpoint="https://reddit.com/submit" data-param-text="' . esc_attr( $page_title ) . '" data-param-url="' . esc_url( $page_permalink ) . '" ';
				break;
			case 'vk':
				$area_label = 'VK';
				$type       = 'vk';
				$param      = ' data-share-endpoint="https://vkontakte.ru/share.php" data-param-text="' . esc_attr( $page_title ) . '" data-param-url="' . esc_url( $page_permalink ) . '" ';
				break;
			default:
				return '';
		}

		$output = '';
		if ( isset( $type ) && ! empty( $type ) ) {
			$extra_classes   = $count_label ? ' has-count' : '';
			$output         .= '<li class="' . $extra_classes . '">';
				$output     .= '<amp-social-share ';
					$output .= 'type="' . esc_attr( $type ) . '" ';
					$output .= 'width="30" ';
					$output .= 'height="30" ';
					$output .= 'aria-label="Share on "' . esc_attr( $area_label ) . '';
					$output .= $param;
					$output .= 'class="rounded amp-social-share-' . esc_attr( $type ) . '" ';
			$output         .= '>';

				$output .= '</amp-social-share>';
			if ( $count_label ) {
				$output .= sprintf( '<span class="number">%s</span>', amp_wp_human_number_format( $count_label ) );
			}
			$output .= '</li>';
		}

		// Return String.
		return $output;
	}
endif;
// End Scial Share Post Related Functions.

// Start Comments Related Functions.
if ( ! function_exists( 'amp_wp_get_comment_link' ) ) :

	/**
	 * Returns Non-AMP comment link for AMP post
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function amp_wp_get_comment_link() {
		$prev         = Amp_WP_Content_Sanitizer::turn_url_transform_off_on( false );
		$comments_url = get_permalink() . '#respond';
		Amp_WP_Content_Sanitizer::turn_url_transform_off_on( $prev );
		return $comments_url;
	}
endif;

if ( ! function_exists( 'amp_wp_comment_reply_link' ) ) :

	/**
	 * Retrieve the HTML Content for Reply to Comment Link.
	 *
	 * @param array $args @see comment_reply_link for documentation.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return void|false|string
	 */
	function amp_wp_comment_reply_link( $args = array() ) {
		$current_value                                  = Amp_WP_Content_Sanitizer::$enable_url_transform;
		Amp_WP_Content_Sanitizer::$enable_url_transform = false;
		$result = comment_reply_link( $args );
		Amp_WP_Content_Sanitizer::$enable_url_transform = $current_value;
		return $result;
	}
endif;

if ( ! function_exists( 'amp_wp_comment_link' ) ) :

	/**
	 * Non-AMP comment link for AMP post
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	function amp_wp_comment_link() {
		echo esc_attr( amp_wp_get_comment_link() );
	}
endif;

if ( ! function_exists( 'amp_wp_list_comments' ) ) :

	/**
	 * List comments for a particular post.
	 *
	 * @see wp_list_comments for more documentation
	 *
	 * @param   string|array $args   wp_list_comments first argument
	 * @param   array        $comment_query_args comment query arguments
	 *
	 * @global  WP_Query    $wp_query    Global WP_Query instance.
	 *
	 * @since   1.0.0
	 *
	 * @return  string|void
	 */
	function amp_wp_list_comments( $args = array(), $comment_query_args = array() ) {
		global $wp_query;
		$post_id      = get_the_ID();
		$comment_args = array(
			'orderby'       => 'comment_date_gmt',
			'order'         => 'ASC',
			'status'        => 'approve',
			'post_id'       => $post_id,
			'no_found_rows' => false,
		);
		if ( empty( $args['callback'] ) && amp_wp_locate_template( 'comment-item.php' ) ) {
			$args['callback']     = 'amp_wp_comment_item';
			$args['end-callback'] = 'amp_wp_comment_item_end';
		}
		$comments = new WP_Comment_Query( array_merge( $comment_args, $comment_query_args ) );

		/**
		 * Filters the comments array.
		 *
		 * @see comments_template
		 *
		 * @param array $comments Array of comments supplied to the comments template.
		 * @param int   $post_ID  Post ID.
		 */
		$comments_list = apply_filters( 'comments_array', $comments->comments, $post_id );

		// Save comments list to comments property of the main query to enable WordPress core
		// function such as get_next_comments_link works in comments page.
		$wp_query->comments = $comments_list;
		return wp_list_comments( $args );
	}
endif;

if ( ! function_exists( 'amp_wp_comments_paginate' ) ) :

	/**
	 * Displays pagination links for the comments on the current post.
	 *
	 * @see   wp_list_comments for more documentation
	 *
	 * @since 1.0.0
	 */
	function amp_wp_comments_paginate() {
		// Nav texts with RTL support.
		if ( is_rtl() ) {
			$prev = '<i class="fa fa-angle-double-right"></i> ' . amp_wp_translation_get( 'comment_previous' );
			$next = amp_wp_translation_get( 'comment_next' ) . ' <i class="fa fa-angle-double-left"></i>';
		} else {
			$next = amp_wp_translation_get( 'comment_next' ) . ' <i class="fa fa-angle-double-right"></i>';
			$prev = '<i class="fa fa-angle-double-left"></i> ' . amp_wp_translation_get( 'comment_previous' );
		}
		previous_comments_link( $prev );
		next_comments_link( $next );
	}
endif;

if ( ! function_exists( 'amp_wp_comment_item' ) ) :

	/**
	 * Load comment-item.php file in the current or parent template.
	 *
	 * @staticvar string $path
	 * @param WP_Comment_Query $comment
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_comment_item( $comment ) {
		static $path;
		if ( is_null( $path ) ) {
			$path = amp_wp_locate_template( 'comment-item.php' );
		}
		if ( $path ) {
			include $path;
		}
	}
endif;

if ( ! function_exists( 'amp_wp_comment_item_end' ) ) :

	/**
	 * Print li Closing Tag
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function amp_wp_comment_item_end() {
		echo '</li>';
	}
endif;
// End Comments Related Functions
if ( ! function_exists( 'amp_wp_min_suffix' ) ) :

	/**
	 * Returns Appropriate Suffix for Static Files (Min or Not)
	 *
	 * @param string $before
	 * @param string $after
	 *
	 * @return string
	 */
	function amp_wp_min_suffix( $before = '', $after = '' ) {
		static $suffix;
		if ( ! $suffix ) {
			$suffix = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'AMP_WP_DEV_MODE' ) && AMP_WP_DEV_MODE ) ) ? '' : '.min';
		}
		return "$before$suffix$after";
	}
endif;

if ( ! function_exists( 'amp_wp_url_format' ) ) :

	/**
	 * Get the structure URL of AMP Pages Permalink.
	 *
	 * @since 1.0.4
	 * @return string start-point or end-pint
	 */
	function amp_wp_url_format() {
		return apply_filters( 'amp_wp_url_format_filter', 'start-point' );
	}
endif;

if ( ! function_exists( 'amp_wp_excluded_urls_format' ) ) :

	/**
	 * Get URL Path List which is/are not available in AMP version.
	 *
	 * @since   1.4.1
	 * @return  array
	 */
	function amp_wp_excluded_urls_format() {
		return apply_filters( 'amp_wp_url_excluded', array() );
	}
endif;

if ( ! function_exists( 'amp_wp_collect_post_type_slugs' ) ) {
	/**
	 * Collect list of custom post type rewrite slug.
	 *
	 * @param string $post_type
	 * @param object $post_type_object WP_Post_Type
	 *
	 * @since 1.5.0
	 *
	 * @see amp_wp_site_url
	 */
	function amp_wp_collect_post_type_slugs( $post_type, $post_type_object ) {
		global $amp_wp_post_type_slugs;
		if ( ! empty( $post_type_object->rewrite['slug'] ) ) {
			$amp_wp_post_type_slugs[ $post_type ] = $post_type_object->rewrite['slug'];
		}
	}
}
add_action( 'registered_post_type', 'amp_wp_collect_post_type_slugs', 8, 2 );
