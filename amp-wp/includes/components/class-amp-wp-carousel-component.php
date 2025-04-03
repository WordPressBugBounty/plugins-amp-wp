<?php
/**
 * AMP carousel component use to handle gallery
 *
 * Class Amp_WP_Carousel_Component
 *
 * @since 1.0.0
 */
class Amp_WP_Carousel_Component extends Amp_WP_Component_Base implements Amp_WP_Component_Interface {

	/**
	 * Just Implement contact
	 *
	 * @since 1.0.0
	 *
	 * @param Amp_WP_Html_Util $instance
	 *
	 * @return Amp_WP_Html_Util
	 */
	public function transform( Amp_WP_Html_Util $instance ) {
		return $instance;
	}

	/**
	 * Register shortcode to display galleries as carousel on amp version
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function config() {

		$array_mohsin = array(
			'shortcodes' => array(
				'gallery'       => array( $this, 'handle_gallery' ),
				'amp-wp-slider' => array( $this, 'handle_slider' ),
			),
			'scripts'    => array(
				'amp-carousel' => 'https://cdn.ampproject.org/v0/amp-carousel-0.2.js',
			),
		);

		return array(
			'shortcodes' => array(
				'gallery'       => array( $this, 'handle_gallery' ),
				'amp-wp-slider' => array( $this, 'handle_slider' ),
			),
			'scripts'    => array(
				'amp-carousel' => 'https://cdn.ampproject.org/v0/amp-carousel-0.2.js',
			),
		);
	}

	/**
	 * Gallery shortcode handler
	 *
	 * @param array $attr
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function handle_gallery( $attr ) {

		global $post;
		if ( ! empty( $attr['ids'] ) ) {

			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}
		$atts = shortcode_atts(
			array(
				'order'   => 'ASC',
				'orderby' => 'menu_order ID',
				'id'      => $post ? $post->ID : 0,
				'size'    => 'thumbnail',
				'include' => '',
				'exclude' => '',
				'link'    => '',
			),
			$attr,
			'gallery'
		);
		return $this->gallery_attachments( $atts );
	}


	/**
	 * Slider shortcode handler
	 *
	 * @param array $attr
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function handle_slider( $attr ) {
		$atts = shortcode_atts(
			array(
				'posts' => '',
			),
			$attr,
			'gallery'
		);
		return $this->slider_posts( $atts );
	}


	/**
	 * @param array $atts
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function slider_posts( $atts ) {

		if ( empty( $atts['posts'] ) ) {
			return '';
		}
		query_posts(
			array(
				'post__in' => explode( ',', $atts['posts'] ),
			)
		);
		$return = $this->locate_template( 'shortcodes/amp-slider.php' );
		wp_reset_query();
		$this->enable_enqueue_scripts = true;
		return $return;
	}


	/**
	 * @param array $atts
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function gallery_attachments( $atts ) {
		$id = intval( $atts['id'] );
		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts(
				array(
					'include'        => $atts['include'],
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $atts['order'],
					'orderby'        => $atts['orderby'],
				)
			);
			$attachments  = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'exclude'        => $atts['exclude'],
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $atts['order'],
					'orderby'        => $atts['orderby'],
				)
			);
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $atts['order'],
					'orderby'        => $atts['orderby'],
				)
			);
		}
		if ( empty( $attachments ) ) {
			return '';
		}
		$this->enable_enqueue_scripts = true;
		return $this->locate_template( 'shortcodes/gallery.php', compact( 'attachments' ), true, false );
	}
}

// Register component class.
amp_wp_register_component( 'Amp_WP_Carousel_Component' );
