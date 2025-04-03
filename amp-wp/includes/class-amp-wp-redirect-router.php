<?php
/**
 * Amp_WP_Redirect_Router Class
 *
 * This is used to define AMP WP Redirect Router.
 *
 * @link        https://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP
 * @subpackage  Amp_WP/includes
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Redirect_Router {

	/**
	 * Store self instance
	 *
	 * @var self
	 *
	 * @since 1.4.0
	 */
	protected static $instance;

	/**
	 * Store AMP query var.
	 *
	 * @var string
	 *
	 * @since 1.4.0
	 */
	protected $query_var;

	/**
	 * Store Requested URL path.
	 *
	 * @var     string
	 *
	 * @since   1.4.0
	 */
	protected $request_url;

	/**
	 * Get Singleton Instance of the Class.
	 *
	 * @since   1.4.0
	 * @return  self
	 */
	public static function Run() {

		if ( ! self::$instance instanceof self ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Initialize the Module.
	 *
	 * @since 1.4.0
	 */
	public function init() {
		add_action( 'template_redirect', array( $this, 'redirect_to_amp_url' ) );
	}

	/**
	 * Redirect AMP URLs to main valid URL.
	 *
	 * @hooked template_redirect
	 *
	 * @since  1.4.0
	 */
	public function redirect_to_amp_url() {

		if ( ! amp_wp_get_permalink_structure() ) {
			return;
		}

		// Disable functionality in customizer preview.
		if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
			return;
		}

		list( $req_uri )   = explode( '?', $_SERVER['REQUEST_URI'] );
		$this->query_var   = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : Amp_WP_Public::SLUG;
		$this->request_url = str_replace( amp_wp_get_wp_installation_slug(), '', $req_uri );

		if ( ! Amp_WP_Public::amp_version_exists() ) {
			$new_url = Amp_WP_Content_Sanitizer::transform_to_non_amp_url( amp_wp_get_canonical_url(), true );
		} elseif ( 'start-point' == amp_wp_url_format() ) {
			$new_url = $this->transform_to_start_point_url();
		} else {
			$new_url = $this->transform_to_end_point_url();
		}

		if ( $this->can_redirect_url( $new_url ) ) {
			wp_redirect( $new_url, 301 );
			exit();
		}
	}

	/**
	 * Whether to check ability to redirect user to given URL.
	 *
	 * @param string|null $url The URL to check for redirection.
	 * @since 1.4.0
	 *
	 * @return bool True if redirection is possible; otherwise false.
	 */
	protected function can_redirect_url( $url ) {
		// Check if $url is not null and is a string.
		if ( ! is_string( $url ) ) {
			return false; // Or handle the case as needed.
		}

		list( $url ) = explode( '?', $url );
		return ! empty( $url ) && trim( str_replace( get_option( 'home' ), '', $url ), '/' ) !== trim( $this->request_url, '/' );
	}

	/**
	 * Redirect Start Point AMP URLs to End Point
	 *
	 * @since 1.4.0
	 *
	 * @return string
	 */
	public function transform_to_end_point_url() {

		if ( ! preg_match( '#^/?([^/]+)(.+)#', $this->request_url, $match ) ) {
			return '';
		}

		$slug = Amp_WP_Public::SLUG;

		if ( $match[1] !== $slug ) {
			return $this->single_post_pagination_amp_url();
		}

		/**
		 * Skip redirection for amp pages because it looks like like start-point!
		 *
		 * Example given
		 *  amp/page/2   right
		 *  /page/2/amp  wrong
		 */
		if ( preg_match( "#$slug/page/?([0-9]{1,})/?$#", $this->request_url ) ) {
			return '';
		}

		if ( trim( $match[2], '/' ) !== '' ) {

			return trailingslashit(
				Amp_WP_Content_Sanitizer::transform_to_amp_url( home_url( $match[2] ) )
			);
		}
	}

	/**
	 * Redirect End Point AMP URLs to Start Point
	 *
	 * @since   1.4.0
	 * @return  string
	 */
	public function transform_to_start_point_url() {

		// /amp at the end of some urls cause 404 error
		if ( false === get_query_var( $this->query_var, false ) && ! is_404() ) {
			return '';
		}

		$url_prefix = preg_quote( amp_wp_permalink_prefix(), '#' );

		$automattic_amp_match = array();
		preg_match( "#^/*$url_prefix(.*?)/{$this->query_var}/*$#", $this->request_url, $automattic_amp_match );

		if ( ! Amp_WP_Public::amp_version_exists() ) {
			if ( ! empty( $automattic_amp_match[1] ) ) {
				return home_url( $automattic_amp_match[1] );
			} elseif ( preg_match( "#^/*{$this->query_var}/+(.*?)/*$#", $this->request_url, $matched ) ) {
				return home_url( $matched[1] );
			}
			return amp_wp_get_canonical_url();
		}

		if ( ! empty( $automattic_amp_match[1] ) ) {
			return trailingslashit( Amp_WP_Content_Sanitizer::transform_to_amp_url( home_url( $automattic_amp_match[1] ) ) );
		}

		return '';
	}

	/**
	 * Convert the Following URL.
	 *
	 *  [single post]/[page-number]/amp to [single post]/amp/[page-number]
	 *
	 * @since   1.4.0
	 * @return  string
	 */
	protected function single_post_pagination_amp_url() {

		if ( is_archive() ) {
			return ''; }

		global $wp_rewrite;

		$single_post_format = str_replace( $wp_rewrite->rewritecode, $wp_rewrite->rewritereplace, get_option( 'permalink_structure' ) );
		$test_pattern       = '(' . $single_post_format . ')'; // Capture as the First Item $match[1].
		$test_pattern      .= '(\d+)/+'; // Capture as the Last Item array_pop( $match ).
		$test_pattern      .= $this->query_var . '/?';

		if ( preg_match( "#^$test_pattern$#", $this->request_url, $match ) ) {
			$page_number         = array_pop( $match );
			$non_amp_request_url = $match[1];
			return home_url( $non_amp_request_url . $this->query_var . '/' . $page_number );
		}
		return '';
	}
}
