<?php
/**
 * AMP WP Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @category    Core
 * @package     Amp_WP/Functions
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018, Pixelative
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

if ( ! function_exists( 'is_amp_wp' ) ) :

	/**
	 * Detect is the query for an AMP page?
	 *
	 * @param   null $wp_query Query object.
	 *
	 * @since 1.0.0
	 *
	 * @return  bool    True When Amp Page Requested
	 */
	function is_amp_wp( $wp_query = null ) {
		$amp_qv = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : 'amp';

		if ( $wp_query instanceof WP_Query ) {
			return false !== $wp_query->get( $amp_qv, false );
		}

		if ( did_action( 'template_redirect' ) && ! is_404() ) {
			global $wp_query;

			// check the $wp_query.
			if ( is_null( $wp_query ) ) {
				return false;
			}

			return false !== $wp_query->get( $amp_qv, false );
		} elseif ( amp_wp_get_permalink_structure() ) {

			$path = trim( dirname( $_SERVER['SCRIPT_NAME'] ), '/' );

			/**
			 * WPML Compatibility
			 *
			 * Append the language code after the path string when
			 *
			 * use 'Different languages in directories' wpml setting
			 */
			if ( function_exists( 'wpml_get_setting_filter' ) && wpml_get_setting_filter( false, 'language_negotiation_type' ) ) {
				if ( $current_lang = apply_filters( 'wpml_current_language', false ) ) {
					$path .= "/$current_lang";
				}
			}

			// $amp_qv = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : 'amp';
			return preg_match( "#^/?$path/*(.*?)/$amp_qv/*$#", $_SERVER['REQUEST_URI'] ) ||
				   preg_match( "#^/?$path/*$amp_qv/*#", $_SERVER['REQUEST_URI'] );
		} else {
			return ! empty( $amp_qv );
		}
	}
endif;

if ( ! function_exists( 'is_amp_endpoint' ) ) :

	/**
	 * Alias name for is_amp_wp()
	 *
	 * @since       1.0.4
	 * @return  bool
	 */
	function is_amp_endpoint() {
		return is_amp_wp();
	}
endif;

if ( ! function_exists( 'amp_wp_get_wp_installation_slug' ) ) :

	/**
	 * TODO: -P >.<
	 *
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_get_wp_installation_slug() {
		static $path;

		if ( $path ) {
			return $path; }

		$abspath_fix         = str_replace( '\\', '/', ABSPATH );
		$script_filename_dir = dirname( $_SERVER['SCRIPT_FILENAME'] );

		if ( $script_filename_dir . '/' == $abspath_fix ) {
			// Strip off any file/query params in the path.
			$path = preg_replace( '#/[^/]*$#i', '', $_SERVER['PHP_SELF'] );
		} elseif ( false !== strpos( $_SERVER['SCRIPT_FILENAME'], $abspath_fix ) ) {
			// Request is hitting a file inside ABSPATH.
			$directory = str_replace( ABSPATH, '', $script_filename_dir );
			// Strip off the sub directory, and any file/query params.
			$path = preg_replace( '#/' . preg_quote( $directory, '#' ) . '/[^/]*$#i', '', $_SERVER['REQUEST_URI'] );
		} elseif ( false !== strpos( $abspath_fix, $script_filename_dir ) ) {
			// Request is hitting a file above ABSPATH.
			$subdirectory = substr( $abspath_fix, strpos( $abspath_fix, $script_filename_dir ) + strlen( $script_filename_dir ) );
			// Strip off any file/query params from the path, appending the sub directory to the install.
			$path = preg_replace( '#/[^/]*$#i', '', $_SERVER['REQUEST_URI'] ) . $subdirectory;
		} else {
			$path = '';
		}

		/**
		 * Fix For Multi-site Installation
		 */
		if ( is_multisite() && ! is_main_site() ) {
			$current_site_url = get_site_url();
			$append_path      = str_replace( get_site_url( get_current_site()->blog_id ), '', $current_site_url );

			if ( $append_path !== $current_site_url ) {
				$path .= $append_path;
			}
		}
		return $path;
	}
endif;

if ( ! function_exists( 'amp_wp_styles' ) ) :
	/**
	 * Initialize $amp_wp_styles if it has not been set.
	 *
	 * @global  Amp_WP_Styles $amp_wp_styles
	 *
	 * @since   1.0.0
	 *
	 * @return  Amp_WP_Styles instance.
	 */
	function amp_wp_styles() {
		global $amp_wp_styles;
		if ( ! ( $amp_wp_styles instanceof Amp_WP_Styles ) ) {
			$amp_wp_styles = new Amp_WP_Styles();
		}
		return $amp_wp_styles;
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_style' ) ) :
	/**
	 * Enqueue a css file for amp version.
	 *
	 * @see   wp_enqueue_style
	 *
	 * @param string           $handle
	 * @param string           $src
	 * @param array            $deps
	 * @param string|bool|null $ver
	 * @param string           $media
	 *
	 * @since 1.0.0
	 */
	function amp_wp_enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
		$amp_wp_styles = amp_wp_styles();
		if ( $src ) {
			$_handle = explode( '?', $handle );
			$amp_wp_styles->add( $_handle[0], $src, $deps, $ver, $media );
		}
		$amp_wp_styles->enqueue( $handle );
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_block_style' ) ) :
	/**
	 * Add css file data of block
	 *
	 * @see   wp_add_inline_style for more information
	 *
	 * @param string  $handle Name of the stylesheet to add the extra styles to.
	 * @param string  $file   css file path
	 * @param boolean $rtl    add rtl
	 *
	 * @since 1.0.0
	 *
	 * @return bool True on success, false on failure.
	 */
	function amp_wp_enqueue_block_style( $handle, $file = '', $rtl = true ) {
		if ( empty( $handle ) ) {
			return false;
		}

		if ( empty( $file ) ) {
			$file = AMP_WP_TEMPLATE_DIR_CSS . $handle;
		}

		static $printed_files;
		if ( is_null( $printed_files ) ) {
			$printed_files = array();
		}

		if ( isset( $printed_files[ $file ] ) ) {
			return true;
		}

		amp_wp_enqueue_inline_style( amp_wp_min_suffix( $file, '.css' ), $handle );

		if ( $rtl && is_rtl() ) {
			amp_wp_enqueue_inline_style( amp_wp_min_suffix( $file . '.rtl', '.css' ), $handle . '-rtl' );
		}
		return $printed_files[ $file ] = true;
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_inline_style' ) ) :
	/**
	 * Add css file data as inline style
	 *
	 * @see   wp_add_inline_style for more information
	 *
	 * @param string $handle Name of the stylesheet to add the extra styles to.
	 * @param string $file   css file path
	 *
	 * @since 1.0.0
	 *
	 * @return bool True on success, false on failure.
	 */
	function amp_wp_enqueue_inline_style( $file, $handle = '' ) {

		static $printed_files;

		if ( is_null( $printed_files ) ) {
			$printed_files = array();
		}

		if ( isset( $printed_files[ $file ] ) ) {
			return true;
		}

		ob_start();
		amp_wp_locate_template( $file, true );
		if ( 'contact-form-7' === $handle ) {
			load_template( $file, true );
		}

		if ( 'wpforms' === $handle ) {
			load_template( $file, true );
		}

		$code = ob_get_clean();
		$code = apply_filters( "amp_wp_style_files_{$file}", $code );

		amp_wp_add_inline_style( $code, $handle );
		return $printed_files[ $file ] = true;
	}
endif;

if ( ! function_exists( 'amp_wp_print_styles' ) ) :
	/**
	 * Callback: Generate and echo stylesheet HTML tags
	 * action  : amp_wp_template_head
	 *
	 * @since 1.0.0
	 */
	function amp_wp_print_styles() {
		amp_wp_styles()->do_items();
	}
endif;

if ( ! function_exists( 'amp_wp_add_inline_style' ) ) :
	/**
	 * Add Extra CSS Styles to a Registered Stylesheet
	 *
	 * @see wp_add_inline_style for more information
	 *
	 * @param   string $handle Name of the Stylesheet to Add the Extra Styles To
	 * @param   string $data   String Containing the CSS Styles to Be Added
	 *
	 * @since   1.0.0
	 *
	 * @return  bool True on success, false on failure.
	 */
	function amp_wp_add_inline_style( $data, $handle = '' ) {

		if ( false !== stripos( $data, '</style>' ) ) {
			_doing_it_wrong(
				__FUNCTION__,
				sprintf(
					__( 'Do not pass %1$s tags to %2$s.', 'amp-wp' ),
					'<code>&lt;style&gt;</code>',
					'<code>amp_wp_add_inline_style()</code>'
				),
				'1.0.0'
			);
			$data = trim( preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $data ) );
		}
		$data = preg_replace( '/\s*!\s*important/', '', $data ); // Remove !important.

		amp_wp_styles()->add_inline_style( $handle, $data );
	}
endif;

if ( ! function_exists( 'amp_wp_register_component' ) ) :
	/**
	 * @param   string $component_class    component class name
	 * @param   array  $settings           component settings array {
	 *
	 * @type    array   $tags               component amp tag. Example: amp-img
	 * @type    array   $scripts_url        component javascript URL. Example: https://cdn.ampproject.org/v0/..
	 * }
	 *
	 * @global  array $amp_wp_registered_components
	 *                                amp-wp components information array
	 *
	 * @since   1.0.0
	 *
	 * @return  bool|WP_Error true on success or WP_Error on failure.
	 */
	function amp_wp_register_component( $component_class, $settings = array() ) {
		global $amp_wp_registered_components;

		if ( ! isset( $amp_wp_registered_components ) ) {
			$amp_wp_registered_components = array();
		}

		try {
			if ( ! class_exists( $component_class ) ) {
				throw new Exception( __( 'invalid component class name.', 'amp-wp' ) );
			}

			$interfaces = class_implements( 'Amp_WP_IMG_Component' );

			if ( ! isset( $interfaces ['Amp_WP_Component_Interface'] ) ) {
				throw new Exception( sprintf( __( 'Error! class %1$s must implements %2$s contracts!', 'amp-wp' ), $component_class, 'Amp_WP_Component_Interface' ) );
			}

			$amp_wp_registered_components[] = compact( 'component_class', 'settings' ); // maybe need add some extra indexes like __FILE__ in the future!

			return true;
		} catch ( Exception $e ) {
			return new WP_Error( 'error', $e->getMessage() );
		}
	}
endif;

if ( ! function_exists( 'amp_wp_scripts' ) ) :
	/**
	 * Initialize $amp_wp_scripts If It Has Not Been Set.
	 *
	 * @global  Amp_WP_Scripts $amp_wp_scripts
	 *
	 * @since   1.0.0
	 *
	 * @return  Amp_WP_Scripts instance.
	 */
	function amp_wp_scripts() {
		global $amp_wp_scripts;

		if ( ! ( $amp_wp_scripts instanceof Amp_WP_Scripts ) ) {
			$amp_wp_scripts = new Amp_WP_Scripts();
		}
		return $amp_wp_scripts;
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_script' ) ) :
	/**
	 * Enqueue a JS File for Amp Version.
	 *
	 * @see wp_enqueue_script
	 *
	 * @param string $handle
	 * @param string $src
	 * @param array  $deps
	 * @param string $media
	 *
	 * @since 1.0.0
	 */
	function amp_wp_enqueue_script( $handle, $src = '', $deps = array(), $media = 'all' ) {
		$amp_wp_scripts = amp_wp_scripts();
		if ( $src ) {
			$_handle = explode( '?', $handle );
			$amp_wp_scripts->add( $_handle[0], $src, $deps, false, $media );
		}
		$amp_wp_scripts->enqueue( $handle );
	}
endif;

if ( ! function_exists( 'amp_wp_print_scripts' ) ) :
	/**
	 * Callback: Generate and echo scripts HTML tags
	 * action: amp_wp_template_head
	 *
	 * @since 1.0.0
	 */
	function amp_wp_print_scripts() {
		amp_wp_scripts()->do_items();
	}
endif;

if ( ! function_exists( 'amp_wp_plugin_url' ) ) :
	/**
	 * Get URL of plugin directory
	 *
	 * @param string $path path to append the following url
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function amp_wp_plugin_url( $path = '' ) {
		$url = AMP_WP_DIR_URL;
		if ( $path ) {
			$url .= $path;
		}
		return $url;
	}
endif;

if ( ! function_exists( 'amp_wp_guess_non_amp_url' ) ) :
	/**
	 * Guess Non-AMP URL of Current Page
	 *
	 * @param   array $args
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function amp_wp_guess_non_amp_url( $args = array() ) {

		if ( ! amp_wp_get_permalink_structure() ) {
			return home_url( remove_query_arg( 'amp' ) );
		}

		$current_url = amp_wp_get_canonical_url();
		$non_amp_url = Amp_WP_Content_Sanitizer::transform_to_non_amp_url( $current_url );

		// Change Query Args From Outside.
		if ( isset( $args['query-args'] ) && is_array( $args['query-args'] ) ) {
			foreach ( $args['query-args'] as $arg ) {
				$non_amp_url = add_query_arg( $arg[0], $arg[1], $non_amp_url );
			}
		}
		return $non_amp_url;
	}
endif;

if ( ! function_exists( 'amp_wp_translation_get' ) ) :
	/**
	 * Returns Translation of Strings From Panel
	 *
	 * @param $key
	 *
	 * @since 1.0.0
	 *
	 * @return mixed|string
	 */
	function amp_wp_translation_get( $key ) {
		static $option;

		if ( ! $option ) {
			$option = get_option( 'amp-wp-translation' );
		}

		if ( ! empty( $option[ $key ] ) ) {
			return $option[ $key ];
		}

		static $std;
		if ( is_null( $std ) ) {
			$std = apply_filters( 'amp_wp_translation_std', array() );
		}
		if ( isset( $std[ $key ] ) ) {
			// save it for next time.
			$option[ $key ] = $std[ $key ];
			update_option( 'amp-wp-translation', $option );
			return $std[ $key ];
		}
		return '';
	}
endif;

if ( ! function_exists( 'amp_wp_translation_echo' ) ) :
	/**
	 * Prints Translation of Text
	 *
	 * @since 1.0.0
	 *
	 * @param $key
	 */
	function amp_wp_translation_echo( $key ) {
		echo amp_wp_translation_get( $key );
	}
endif;

if ( ! function_exists( 'amp_wp_unparse_url' ) ) :
	/**
	 * Converts Parsed URL to Printable Link
	 *
	 * @param $parsed_url contain parsed URL.
	 *
	 * @return string
	 */
	function amp_wp_unparse_url( $parsed_url ) {
		$scheme   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : '';
		$port     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : '';
		$user     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : '';
		$pass     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass'] : '';
		$pass     = ( $user || $pass ) ? "$pass@" : '';
		$path     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';
		$query    = isset( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';
		$fragment = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';

		// Schema has to be relative when there is no schema but host was defined!
		if ( ! empty( $parsed_url['host'] ) && empty( $parsed_url['scheme'] ) ) {
			$scheme = '//';
		}
		return "$scheme$user$pass$host$port$path$query$fragment";
	}
endif;

if ( ! function_exists( 'amp_wp_enqueue_ad' ) ) :
	/**
	 * Handy Function Used to Enqueue Style and Scripts of Ads
	 *
	 * @since   1.0.0
	 *
	 * @param   string $ad_type Ad type, needed to know the js should be printed or not
	 *
	 * @return  void
	 */
	function amp_wp_enqueue_ad( $ad_type = 'adsense' ) {

		if ( empty( $ad_type ) ) {
			return; }

		amp_wp_enqueue_block_style( 'amd-ad', AMP_WP_TEMPLATE_DIR_CSS . 'plugins/amp-wp-ads-manager/ads' );
		if ( 'custom_code' !== $ad_type || 'image' !== $ad_type ) {
			amp_wp_enqueue_script( 'amp-ad', 'https://cdn.ampproject.org/v0/amp-ad-0.1.js' );
		}
	}
endif;

if ( ! function_exists( 'amp_wp_compatibility_constants' ) ) {

	/**
	 * Define WP-AMP query constant for themes/plugins compatibility.
	 *
	 * @since 1.1.0
	 */
	function amp_wp_compatibility_constants() {
		if ( ! defined( 'AMP_QUERY_VAR' ) ) {
			define( 'AMP_QUERY_VAR', 'amp' ); }
	}
}

if ( ! function_exists( 'amp_wp_get_permalink_structure' ) ) :

	/**
	 * Return current WP installation's custom permalink structure.
	 *
	 * @since   1.0.4
	 * @return  string  Return custom structure if custom permalink is activated.
	 */
	function amp_wp_get_permalink_structure() {
		return get_option( 'permalink_structure' );
	}
endif;

if ( ! function_exists( 'amp_wp_permalink_prefix' ) ) :
	/**
	 * Get permalink structure prefix which is fixed in all URLs.
	 *
	 * @since   1.0.4
	 *
	 * @return  string
	 */
	function amp_wp_permalink_prefix() {
		$permalink_structure = get_option( 'permalink_structure' );
		$prefix              = substr( $permalink_structure, 0, strpos( $permalink_structure, '%' ) );
		return ltrim( $prefix, '/' );
	}
endif;

if ( ! function_exists( 'amp_wp_taxonomies_prefix' ) ) {
	/**
	 * Get taxonomies permalink prefix which is fixed in all urls.
	 *
	 * @since 1.5.12
	 *
	 * @return array
	 */
	function amp_wp_taxonomies_prefix() {
		global $wp_taxonomies;

		return array_filter(
			array_map(
				function ( $taxonomy ) {
					return $taxonomy->rewrite['slug'] ?? false;
				},
				$wp_taxonomies
			)
		);
	}
}

if ( ! function_exists( 'amp_wp_help_tip' ) ) :
	/**
	 * Display a AMP WP help tip.
	 *
	 * @since   1.4.1
	 *
	 * @param   string $tip Help tip text.
	 * @param   bool   $allow_html Allow sanitized HTML if true or escape.
	 * @return  string
	 */
	function amp_wp_help_tip( $tip, $allow_html = false ) {
		if ( $allow_html ) {
			$tip = amp_wp_sanitize_tooltip( $tip );
		} else {
			$tip = esc_attr( $tip );
		}

		return '<span class="help_tip" data-tip="' . $tip . '"><i class="amp-wp-admin-icon-question"></i></span>';
	}
endif;

if ( ! function_exists( 'amp_wp_get_server_database_version' ) ) :
	/**
	 * Retrieves the MySQL server version. Based on $wpdb.
	 *
	 * @since 1.4.1
	 * @return array Vesion information.
	 */
	function amp_wp_get_server_database_version() {
		global $wpdb;

		if ( empty( $wpdb->is_mysql ) ) {
			return array(
				'string' => '',
				'number' => '',
			);
		}

		if ( $wpdb->use_mysqli ) {
			$server_info = mysqli_get_server_info( $wpdb->dbh ); // @codingStandardsIgnoreLine.
		} else {
			$server_info = mysql_get_server_info( $wpdb->dbh ); // @codingStandardsIgnoreLine.
		}

		return array(
			'string' => $server_info,
			'number' => preg_replace( '/([^\d.]+).*/', '', $server_info ),
		);
	}
endif;

if ( ! function_exists( 'amp_wp_sanitize_css' ) ) :
	/**
	 * Sanitize and prepare CSS for amp version
	 *
	 * @param string $css
	 *
	 * @since 1.5.8
	 *
	 * @return string
	 */
	function amp_wp_sanitize_css( $css ) {

		// -- Remove !important qualifier. --
		$css = preg_replace( '/\s*!\s*important/im', '', $css );

		// -- Remove invalid properties. --
		$invalid_properties = array(
			'behavior',
			'-moz-binding',
			'filter',
			'animation',
			'transition',
		);
		$pattern            = '/((?:' . implode( '|', $invalid_properties ) . ')\s* :[^;]+ ;? \n*\t* )+/xs';
		$css                = preg_replace_callback(
			$pattern,
			function ( $var ) {
				return substr( $var[1], - 1 ) === '}' ? '}' : '';
			},
			$css
		);

		return $css;
	}
endif;

if ( ! function_exists( 'amp_wp_file_system_instance' ) ) {

	/**
	 * Get WP FileSystem Object.
	 *
	 * @since 1.5.12
	 *
	 * @return WP_Filesystem_Base
	 *
	 * @global WP_Filesystem_Base $wp_filesystem WordPress Filesystem Class
	 */
	function amp_wp_file_system_instance() {

		global $wp_filesystem;

		if ( ! $wp_filesystem instanceof WP_Filesystem_Base ) {

			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
			}

			$credentials['hostname'] = defined( 'FTP_HOST' ) ? FTP_HOST : '';
			$credentials['username'] = defined( 'FTP_USER' ) ? FTP_USER : '';
			$credentials['password'] = defined( 'FTP_PASS' ) ? FTP_PASS : '';

			WP_Filesystem( $credentials, WP_CONTENT_DIR, false );
		}

		return $wp_filesystem;
	}
}

if ( ! function_exists( 'amp_wp_file_get_contents' ) ) {

	/**
	 * Reads entire file into a string.
	 *
	 * @param string $file_path Name of the file to read.
	 *
	 * @since 1.5.12
	 *
	 * @return string|bool Read data on success, false on failure.
	 */
	function amp_wp_file_get_contents( $file_path ) {

		if ( empty( $file_path ) ) {
			return false;
		}

		$instance = amp_wp_file_system_instance();

		return $instance->get_contents( $file_path );
	}
}
