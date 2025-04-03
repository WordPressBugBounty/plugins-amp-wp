<?php
/**
 * AMP WP Utility Functions
 *
 * @category    Utility
 * @package     Amp_WP/Functions
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018, Pixelative
 */

if ( ! function_exists( 'amp_wp_remove_query_string' ) ) :
	/**
	 * Remove anything after question mark
	 *
	 * Example: pixelative.co/?publisher=great
	 * becomes: pixelative.co/
	 *
	 * @param string $string
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function amp_wp_remove_query_string( $string ) {

		$matches = array();
		if ( preg_match( '/([^\?]+)\?/', $string, $matches ) ) {
			return $matches[1];
		}
		return $string;
	}
endif;

if ( ! function_exists( 'amp_wp_filter_attributes' ) ) :
	/**
	 * Filter AMP element attributes
	 *
	 * @param   array  $attributes         key-value paired attributes list.
	 * @param   array  $valid_attributes   valid attributes key.
	 * @param   string $tag_name           optional. amp tag-name.
	 *
	 * @since   1.0.0
	 *
	 * @return  array   filtered attributes
	 */
	function amp_wp_filter_attributes( $attributes, $valid_attributes, $tag_name = '' ) {
		$attributes = wp_array_slice_assoc( $attributes, $valid_attributes );
		return apply_filters( 'amp_wp_html_dom_filter_attributes', $attributes, $tag_name, $valid_attributes );
	}
endif;

if ( ! function_exists( 'amp_wp_remove_class_filter' ) ) :
	/**
	 * Remove Class Filter Without Access to Class Object
	 *
	 * In order to use the core WordPress remove_filter() on a filter added with the callback
	 * to a class, you either have to have access to that class object, or it has to be a call
	 * to a static method.  This method allows you to remove filters with a callback to a class
	 * you don't have access to.
	 *
	 * Works with WordPress 1.2+ (4.7+ support added 9-19-2016)
	 * Updated 2-27-2017 to use internal WordPress removal for 4.7+ (to prevent PHP warnings output)
	 *
	 * @param string $tag         Filter to remove.
	 * @param string $class_name  Class name for the filter's callback.
	 * @param string $method_name Method name for the filter's callback.
	 * @param int    $priority    Priority of the filter. (default 10)
	 *
	 *
	 * Copyright: https://gist.github.com/tripflex/c6518efc1753cf2392559866b4bd1a53
	 *
	 * @return bool Whether the function is removed.
	 */
	function amp_wp_remove_class_filter( $tag, $class_name = '', $method_name = '', $priority = 10 ) {
		global $wp_filter;

		// Check that filter actually exists first.
		if ( ! isset( $wp_filter[ $tag ] ) ) {
			return false; }

		/**
		 * If filter config is an object, means we're using WordPress 4.7+ and the config is no longer
		 * a simple array, rather it is an object that implements the ArrayAccess interface.
		 *
		 * To be backwards compatible, we set $callbacks equal to the correct array as a reference (so $wp_filter is updated)
		 *
		 * @see https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/
		 */
		if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {

			// Create $fob object from filter tag, to use below.
			$fob       = $wp_filter[ $tag ];
			$callbacks = &$wp_filter[ $tag ]->callbacks;
		} else {
			$callbacks = &$wp_filter[ $tag ];
		}

		// Exit if there aren't any callbacks for specified priority.
		if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) {
			return false;
		}

		// Loop through each filter for the specified priority, looking for our class & method.
		foreach ( (array) $callbacks[ $priority ] as $filter_id => $filter ) {

			// Filter should always be an array - array( $this, 'method' ), if not goto next.
			if ( ! isset( $filter['function'] ) || ! is_array( $filter['function'] ) ) {
				continue;
			}
			// If first value in array is not an object, it can't be a class.
			if ( ! is_object( $filter['function'][0] ) ) {
				continue;
			}
			// Method doesn't match the one we're looking for, goto next.
			if ( $filter['function'][1] !== $method_name ) {
				continue;
			}
			// Method matched, now let's check the Class.
			if ( get_class( $filter['function'][0] ) === $class_name ) {

				// WordPress 4.7+ use core remove_filter() since we found the class object.
				if ( isset( $fob ) ) {
					// Handles removing filter, reseting callback priority keys mid-iteration, etc.
					$fob->remove_filter( $tag, $filter['function'], $priority );
				} else {
					// Use legacy removal process (pre 4.7).
					unset( $callbacks[ $priority ][ $filter_id ] );

					// and if it was the only filter in that priority, unset that priority.
					if ( empty( $callbacks[ $priority ] ) ) {
						unset( $callbacks[ $priority ] );
					}

					// and if the only filter for that tag, set the tag to an empty array.
					if ( empty( $callbacks ) ) {
						$callbacks = array();
					}

					// Remove this filter from merged_filters, which specifies if filters have been sorted.
					unset( $GLOBALS['merged_filters'][ $tag ] );
				}
				return true;
			}
		}
		return false;
	}
endif;

if ( ! function_exists( 'amp_wp_remove_class_action' ) ) :
	/**
	 * In order to use the core WordPress remove_action() on an action added with the callback
	 * to a class, you either have to have access to that class object, or it has to be a call
	 * to a static method.  This method allows you to remove actions with a callback to a class
	 * you don't have access to.
	 *
	 * Works with WordPress 1.2+ (4.7+ support added 9-19-2016)
	 *
	 * @param   string $tag            Action to remove.
	 * @param   string $class_name     Class name for the action's callback.
	 * @param   string $method_name    Method name for the action's callback.
	 * @param   int    $priority           Priority of the action (default 10).
	 *
	 *    Copyright: https://gist.github.com/tripflex/c6518efc1753cf2392559866b4bd1a53
	 *
	 * @return  bool Whether the function is removed.
	 */
	function amp_wp_remove_class_action( $tag, $class_name = '', $method_name = '', $priority = 10 ) {
		amp_wp_remove_class_filter( $tag, $class_name, $method_name, $priority );
	}
endif;

if ( ! function_exists( 'amp_wp_trans_allowed_html' ) ) :
	/**
	 *
	 * Handy function for translation wp_kses when we need it for descriptions and help HTMLs
	 */
	function amp_wp_trans_allowed_html() {
		return array(
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'id'     => array(),
				'class'  => array(),
				'rel'    => array(),
				'style'  => array(),
			),
			'span'   => array(
				'class' => array(),
				'id'    => array(),
				'style' => array(),
			),
			'p'      => array(
				'class' => array(),
				'id'    => array(),
				'style' => array(),
			),
			'strong' => array(
				'class' => array(),
				'style' => array(),
			),
			'hr'     => array(
				'class' => array(),
			),
			'br'     => '',
			'b'      => '',
			'h6'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h5'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h4'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h3'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h2'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h1'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'code'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(
				'class' => array(),
			),
			'i'      => array(
				'class' => array(),
			),
			'img'    => array(
				'class' => array(),
				'style' => array(),
			),
			'label'  => array(
				'for'   => array(),
				'style' => array(),
			),
			'ol'     => array(
				'class' => array(),
			),
			'ul'     => array(
				'class' => array(),
			),
			'li'     => array(
				'class' => array(),
			),
		);
	}
endif;

if ( ! function_exists( 'amp_wp_is' ) ) {
	/**
	 * Handy function for checking current AMP WP state
	 *
	 * @param string $id The state identifier.
	 * @return bool Whether the specified state is true or false.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	function amp_wp_is( $id = '' ) {
		switch ( $id ) {
			/**
			 * Doing Ajax
			 */
			case 'doing_ajax':
			case 'doing-ajax':
			case 'ajax':
				return defined( 'DOING_AJAX' ) && DOING_AJAX;
			/**
			 * Development Mode
			 */
			case 'dev':
				return defined( 'AMP_WP_DEV_MODE' ) && AMP_WP_DEV_MODE;
			/**
			 *
			 * Demo development mode,
			 * Define This If You Want to Load All Demo Importing Functionality From Your Local Not Remote Server
			 */
			case 'demo-dev':
				return defined( 'AMP_WP_DEMO_DEV_MODE' ) && AMP_WP_DEMO_DEV_MODE;
			default:
				return false;
		}
	}
}

/**
 * Retrieves the full AMP-specific permalink for the given post ID.
 *
 * @param int $post_id Post ID.
 * @return string  AMP permalink.
 *
 * @since 1.0.0
 */
function amp_wp_get_permalink( $post_id ) {

	/**
	 * Filters the AMP permalink to short-circuit normal generation.
	 *
	 * Returning a non-false value in this filter will cause the `get_permalink()` to get called and the `amp_wp_get_permalink` filter to not apply.
	 *
	 * @param false $url Short-circuited URL.
	 * @param int $post_id Post ID.
	 */
	$pre_url = apply_filters( 'amp_wp_pre_get_permalink', false, $post_id );

	if ( false !== $pre_url ) {
		return $pre_url;
	}

	if ( amp_wp_is_canonical() ) {
		$amp_url = get_permalink( $post_id );
	} else {
		$parsed_url = amp_wp_parse_url( get_permalink( $post_id ) );
		$structure  = get_option( 'permalink_structure' );

		if ( empty( $structure ) || ! empty( $parsed_url['query'] ) || is_post_type_hierarchical( get_post_type( $post_id ) ) ) {
			$amp_url = add_query_arg( Amp_WP_Public::AMP_WP_STARTPOINT, '', get_permalink( $post_id ) );
		} else {
			$amp_url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( Amp_WP_Public::AMP_WP_STARTPOINT, 'single_amp' );
		}
	}

	/**
	 * Filters AMP Permalink.
	 *
	 * @since 1.0.0
	 *
	 * @param false $amp_url AMP URL.
	 * @param int post_id Post ID.
	 */
	return apply_filters( 'amp_wp_get_permalink', $amp_url, $post_id );
}

/**
 * Whether this is in 'canonical mode.'
 *
 * Themes can register support for this with `add_theme_support( 'amp' )`.
 * Then, this will change the plugin from 'paired mode,' and it won't use its own templates.
 * Nor output frontend markup like the 'rel' link. If the theme registers support for AMP with:
 * `add_theme_support( 'amp', array( 'template_dir' => 'amp-wp' ) )`
 * it will retain 'paired mode.
 *
 * @return boolean Whether this is in AMP 'canonical mode'.
 */
function amp_wp_is_canonical() {
	$support = get_theme_support( 'amp' );
	if ( true === $support ) {
		return true;
	}
	if ( is_array( $support ) ) {
		$args = array_shift( $support );
		if ( empty( $args['template_dir'] ) ) {
			return true;
		}
	}

	return false;
}

if ( ! function_exists( 'amp_wp_transpile_text_to_pattern' ) ) :

	/**
	 * Compile the given string to valid PCRE pattern.
	 *
	 * @param   string $text       The formatted text.
	 * @param   string $delimiter  Pattern delimiter.
	 *
	 * @since   1.4.1
	 * @return  string
	 */
	function amp_wp_transpile_text_to_pattern( $text, $delimiter = '#' ) {

		$should_all_be_blocked = substr( $text, strlen( $text ) - 1 ) == '*';
		$pattern               = preg_replace( '/ ( (?<!\\\) \* ) /x', '@@CAPTURE@@', $text );
		$pattern               = preg_quote( $pattern, $delimiter );
		$pattern               = str_replace( '@@CAPTURE@@', ( $should_all_be_blocked ? '+.*' : '$' ), $pattern );

		return $pattern;
	}
endif;


if ( ! function_exists( 'amp_wp_parse_url' ) ) {
	/**
	 * Parse a URL and return its components.
	 *
	 * @param string $url Parsing URL.
	 * @param int    $component Components to be parse from the URL.
	 *
	 * @since 1.5.13
	 * @return array|string|false
	 */
	function amp_wp_parse_url( $url, $component = -1 ) {
		$encoded_url = preg_replace_callback(
			'%[^:/@?&=#]+%usD',
			function ( $matches ) {
				return urlencode( $matches[0] );
			},
			$url
		);

		$parts = wp_parse_url( $encoded_url, $component );
		if ( false === $parts ) {
			return array();
		}

		if ( ! empty( $parts ) && is_array( $parts ) ) {
			$parts = array_map( 'urldecode', $parts );
		}

		return $parts;
	}
}
