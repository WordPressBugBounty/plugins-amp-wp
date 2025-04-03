<?php
/**
 * The Amp_WP_Scripts is a clone of the WP_Scripts
 *
 * @see   WP_Scripts
 *
 * @since 1.0.0
 */
class Amp_WP_Scripts extends WP_Scripts {

	public function __construct() {}

	/**
	 * Register an AMP Script
	 *
	 * @param string $handle
	 * @param string $src
	 * @param array  $deps
	 * @param bool   $ver
	 * @param null   $args
	 *
	 * @see   WP_Dependencies::add
	 * @since 1.0.0
	 * @return bool
	 */
	public function add( $handle, $src, $deps = array(), $ver = false, $args = null ) {
		if ( isset( $this->registered[ $handle ] ) ) {
			return false;
		}
		$this->registered[ $handle ] = new _WP_Dependency( $handle, $src, $deps, '', $args );
		return true;
	}

	/**
	 * Determines script dependencies.
	 *
	 * @param mixed          $handles   Item handle and argument (string) or item handles and arguments (array of strings).
	 * @param bool           $recursion Internal flag that function is calling itself.
	 * @param bool|false|int $group     Optional. Group level: (int) level, (false) no groups. Default false.
	 *
	 * @since 1.0.0
	 * @return bool True on success, false on failure.
	 */
	public function all_deps( $handles, $recursion = false, $group = false ) {
		return WP_Dependencies::all_deps( $handles, $recursion, $group );
	}
}

/**
 * Remove Version from WordPress enqueued JS File
 *
 * @param $tag       The `<script>` tag for the enqueued script.
 * @param $handle    script's registered handle.
 *
 * @since 1.0.0
 *
 * @return mixed
 */
function amp_wp_handle_scripts_tag_attrs( $tag, $handle ) {
	$scripts = amp_wp_scripts();
	if ( isset( $scripts->registered[ $handle ] ) ) {
		$handle = esc_attr( $handle );
		$attrs  = '';

		if ( substr( $handle, 0, 4 ) === 'amp-' && substr( $handle, 0, 12 ) !== 'amp-mustache' ) {
			$attrs .= " custom-element='$handle'";
		}
		
		if ( substr( $handle, 0, 12 ) === 'amp-mustache' ) {
			$attrs .= " custom-template='$handle'";
		}

		$tag = str_replace( ' src=', "$attrs async src=", $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'amp_wp_handle_scripts_tag_attrs', 99, 2 );

/**
 * @param   $src       The source of the enqueued script.
 * @param   $handle    script's registered handle.
 *
 * @since   1.0.0
 *
 * @return  mixed
 */
function amp_wp_handle_scripts_tag_src( $src, $handle ) {
	$scripts = amp_wp_scripts();
	if ( isset( $scripts->registered[ $handle ] ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'amp_wp_handle_scripts_tag_src', 99, 2 );

/**
 * Remove type='*' attributes and values from wp_enqueue'ed scripts and styles
 * using respective *_loader_tag hooks.
 *
 * @param   $src       The source of the enqueued script.
 * @param   $handle    script's registered handle.
 *
 * @since   1.0.0
 *
 * @return  mixed
 */
function amp_wp_remove_type_attr( $tag, $handle ) {
	return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}
add_filter( 'script_loader_tag', 'amp_wp_remove_type_attr', 10, 2 );
