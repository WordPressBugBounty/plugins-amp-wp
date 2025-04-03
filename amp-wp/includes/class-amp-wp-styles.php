<?php
/**
 * Dependencies API: Amp_WP_Styles class
 *
 * @since 1.0.0
 *
 * @package Amp_WP
 * @subpackage WordPress Dependencies
 */

/**
 * Class used to register styles for AMP.
 *
 * @since 1.0.0
 *
 * @see WP_Styles
 */
class Amp_WP_Styles extends WP_Styles {
	/**
	 * Store inline css codes
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $inline_styles = array();

	/**
	 * Register inline css code
	 *
	 * @param string $handle Name of the stylesheet to.
	 * @param string $code   the CSS styles to be added.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_inline_style( $handle, $code ) {
		if ( empty( $handle ) ) {
			$this->inline_styles[] = $code;
		} else {
			$this->inline_styles[ $handle ] = $code;
		}
	}

	/**
	 * Processes the items
	 *
	 * @see     WP_Dependencies::do_items for more documentation
	 *
	 * @param   bool $handles
	 * @param   bool $group
	 *
	 * @since   1.0.0
	 * @since   1.4.3.1 Added filter to remove Jetpack 'style_loader_tag'
	 *
	 * @return  void
	 */
	public function do_items( $handles = false, $group = false ) {
		$this->print_inline_styles();
		remove_filter( 'style_loader_tag', array( 'Jetpack', 'maybe_inline_style' ) );
		parent::do_items( $handles, $group );
	}

	/**
	 * Print inline css styles in single <style> tag
	 *
	 * AMP just accept single <style> tag
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function print_inline_styles() {
		if ( $this->inline_styles ) {
			echo '<style amp-custom>';
			foreach ( $this->inline_styles as $code ) {
				echo "\n", $code, "\n";
			}
			echo '</style>';
		}
	}

	/**
	 * Determines style dependencies.
	 *
	 * @param mixed          $handles   Item handle and argument (string) or item handles and arguments (array of strings).
	 * @param bool           $recursion Internal flag that function is calling itself.
	 * @param bool|false|int $group     Group level: (int) level, (false) no groups.
	 *
	 * @since 1.0.0
	 * @return bool True on success, false on failure.
	 */
	public function all_deps( $handles, $recursion = false, $group = false ) {
		return WP_Dependencies::all_deps( $handles, $recursion, $group );
	}
}

/**
 * Remove Version from WordPress enqueued CSS File
 *
 * @param   $src    The `<link>` tag for the enqueued CSS.
 * @param   $handle CSS's registered handle.
 *
 * @since   1.0.0
 *
 * @return  mixed
 */
function switch_stylesheet_src( $src, $handle ) {
	$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'switch_stylesheet_src', 10, 2 );
