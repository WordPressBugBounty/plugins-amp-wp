<?php
/**
 * Component for amp-img
 * A runtime-managed replacement for the HTML img tag.
 *
 * @category    Core
 * @package     Amp_WP/includes/components
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018, Pixelative
 * @since 1.0.0
 */
class Amp_WP_IMG_Component extends Amp_WP_Component_Base implements Amp_WP_Component_Interface {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function head() {
		if ( ! amp_wp_is_customize_preview() ) {
			add_filter( 'post_thumbnail_html', array( $this, 'transform_image_tag_to_amp' ) );
			add_filter( 'get_avatar', array( $this, 'transform_image_tag_to_amp' ) );
		}
	}

	/**
	 * Contract implementation
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function config() {
		return array(
			'scripts' => array(
				'amp-anim' => 'https://cdn.ampproject.org/v0/amp-anim-0.1.js',
			),
		);
	}

	/**
	 * Transform <img> tags to the <amp-img> or <img-anim> tags
	 *
	 * @param Amp_WP_Html_Util $instance
	 *
	 * @return Amp_WP_Html_Util
	 * @since 1.0.0
	 */
	public function transform( Amp_WP_Html_Util $instance ) {

		// Get all img tags.
		$elements = $instance->getElementsByTagName( 'img' );

		/**
		 * Has all img tags from DOMElement
		 *
		 * @var DOMElement $element
		 */
		$nodes_count = $elements->length;
		if ( $nodes_count ) {
			for ( $i = $nodes_count - 1; $i >= 0; $i -- ) {
				$element = $elements->item( $i );
				if ( $this->is_animated_image_element( $element ) ) {
					$this->enable_enqueue_scripts = true;
					$tag_name                     = 'amp-anim';
				} else {
					$tag_name = 'amp-img';
				}

				$attributes = $instance->filter_attributes( $instance->get_node_attributes( $element ) );
				$attributes = $this->modify_attributes( $attributes );
				$attributes = $this->filter_attributes( $attributes, $tag_name );

				$instance->replace_node( $element, $tag_name, $attributes );
			}
		}

		return $instance;
	}

	/**
	 * Append or modify amp-img|amp-anim attributes
	 *
	 * @param array $attributes
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function modify_attributes( $attributes ) {
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = '';
		}
		$attributes['class'] .= ' amp-image-tag';

		if ( ! isset( $attributes['width'] ) || ! isset( $attributes['height'] ) ) {
			if ( isset( $attributes['src'] ) ) {
				$dim = $this->get_image_dimension( $attributes['src'] );
				if ( $dim ) {
					$attributes['width']  = $dim[0];
					$attributes['height'] = $dim[1];
				}
			}
		}

		return $this->enforce_sizes_attribute( $attributes );
	}

	/**
	 * Filter amp-img | amp-anim attributes list
	 *
	 * To-do list all valid amp attributes for amp-img & amp-anim
	 *
	 * @param array  $attributes
	 * @param string $tag_name
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function filter_attributes( $attributes, $tag_name ) {
		$valid_atts = array(
			'src',
			'height',
			'width',
			'class',
			'alt',
			'sizes',
			'on',
		);

		return amp_wp_filter_attributes( $attributes, $valid_atts, $tag_name );
	}

	/**
	 * Detect is given <img> element is animation
	 *
	 * @param DOMElement $element <img> element object.
	 *
	 * @since 1.0.0
	 *
	 * @return bool true if image was animated or false otherwise
	 */
	protected function is_animated_image_element( $element ) {

		// Get src attribute.
		$src = $element->attributes->getNamedItem( 'src' );
		if ( $src && isset( $src->value ) ) {
			return $this->is_animated_image_url( $src->value );
		}
		$class = $element->attributes->getNamedItem( 'class' );
		if ( $class && isset( $class->value ) ) {

			// Image will be animated if it has a animated class.
			return preg_match( '/\b animated-img \b/ix', $class->value );
		}
		return false;
	}

	/**
	 * Generate amp-image tag of attachment post
	 *
	 * @param WP_Post $attachment attachment post.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function print_attachment_image( $attachment ) {
		return $this->get_attachment_image( $attachment->ID );
	}

	/**
	 * Get an HTML img element representing an image attachment
	 *
	 * todo fix default size
	 *
	 * @see   wp_get_attachment_image for more documentation
	 *
	 * @param int          $attachment_id Image attachment ID.
	 * @param string|array $size          Optional. Image size. Accepts any valid image size, or an array of width
	 *                                    and height values in pixels (in that order). Default 'full'.
	 * @param bool         $icon          Optional. Whether the image should be treated as an icon. Default false.
	 * @param string|array $attr          Optional. Attributes for the image markup. Default empty.
	 *
	 * @since 1.0.0
	 *
	 * @return string HTML img element or empty string on failure.
	 */
	public function get_attachment_image( $attachment_id, $size = 'full', $icon = false, $attr = '' ) {

		$html  = '';
		$image = wp_get_attachment_image_src( $attachment_id, $size, $icon );

		if ( $image ) {

			list( $src, $width, $height ) = $image;
			$hwstring                     = image_hwstring( $width, $height );
			$size_class                   = $size;

			if ( is_array( $size_class ) ) {
				$size_class = join( 'x', $size_class );
			}

			$attachment   = get_post( $attachment_id );
			$default_attr = array(
				'src'   => $src,
				'class' => "attachment-$size_class size-$size_class",
				'alt'   => trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ), // Use Alt field first.
			);

			if ( empty( $default_attr['alt'] ) ) {
				$default_attr['alt'] = trim( wp_strip_all_tags( $attachment->post_excerpt ) );
			} // If not, Use the Caption

			if ( empty( $default_attr['alt'] ) ) {
				$default_attr['alt'] = trim( wp_strip_all_tags( $attachment->post_title ) );
			} // Finally, use the title

			$attr = wp_parse_args( $attr, $default_attr );

			// Generate 'srcset' and 'sizes' if not already present.
			if ( empty( $attr['srcset'] ) ) {
				$image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );
				if ( is_array( $image_meta ) ) {
					$size_array = array( absint( $width ), absint( $height ) );
					$srcset     = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attachment_id );
					$sizes      = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

					if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
						$attr['srcset'] = $srcset;

						if ( empty( $attr['sizes'] ) ) {
							$attr['sizes'] = $sizes;
						}
					}
				}
			}

			/**
			 * Filters the list of attachment image attributes.
			 *
			 * @since 1.0.0
			 *
			 * @param array        $attr       Attributes for the image markup.
			 * @param WP_Post      $attachment Image attachment post.
			 * @param string|array $size       Requested size. Image size or array of width and height values
			 *                                 (in that order). Default 'thumbnail'.
			 */
			$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
			$attr = $this->filter_attributes( $attr, 'amp-img' );
			$attr = array_map( 'esc_attr', $attr );

			$html = rtrim( "<amp-img $hwstring" );

			foreach ( $attr as $name => $value ) {
				$html .= " $name=" . '"' . $value . '"';
			}

			$html .= '></amp-img>';
		}

		return $html;
	}

	/**
	 * This is our workaround to enforce max sizing with layout=responsive.
	 *
	 * We want elements to not grow beyond their width and shrink to fill the screen on viewports smaller than their
	 * width.
	 *
	 * See https://github.com/ampproject/amphtml/issues/1280#issuecomment-171533526
	 * See https://github.com/Automattic/amp-wp/issues/101
	 *
	 * @since     1.0.0
	 *
	 * @copyright credit goes to automattic amp - github.com/Automattic/amp-wp
	 */
	public function enforce_sizes_attribute( $attributes ) {
		if ( ! isset( $attributes['width'], $attributes['height'] ) ) {
			return $attributes;
		}

		$max_width  = $attributes['width'];
		$_max_width = amp_wp_get_container_width();
		if ( ( $_max_width ) && $max_width > $_max_width ) {
			$max_width = $_max_width;
		}

		$attributes['sizes'] = sprintf( '(min-width: %1$dpx) %1$dpx, 100vw', absint( $max_width ) );
		return $attributes;
	}

	/**
	 * Fetch remote image dimension
	 *
	 * @param string $url Image URL.
	 *
	 * @see     github.com/tommoor/fastimage
	 * @since   1.0.0
	 * @return  bool|array  array of width & height on success or false on error.
	 * array {
	 *     0 => image width
	 *     1 => image height
	 * }
	 */
	public function fetch_image_dimension( $url ) {
		if ( ! class_exists( 'FastImage' ) ) {
			require AMP_WP_DIR_PATH . 'includes/Fastimage.php';
		}
		$fast_image = new FastImage( $url );
		return $fast_image->getSize();
	}

	/**
	 * Get remote image dimension
	 *
	 * @param string $url
	 *
	 * @since 1.0.0
	 *
	 * @return bool|array array on success or false on error. @see fetch_image_dimension  for more doc
	 */
	public function get_image_dimension( $url ) {

		$hash_key = 'amp_wp_dimension_' . md5( $url );

		$dimension = get_transient( $hash_key );
		if ( $dimension ) {
			return $dimension;
		}

		if ( $normalize_url = $this->normalize_url( $url ) ) {
			$dimension = $this->fetch_image_dimension( $normalize_url );
		} elseif ( $this->is_data_url( $url ) ) {
			if ( $size = @getimagesize( $url ) ) {
				$dimension = array( $size[0], $size[1] );
			}
		}

		if ( $dimension ) {
			set_transient( $hash_key, $dimension, HOUR_IN_SECONDS );
		} else {
			$dimension = array(
				738, // fallback for width
				400, // fallback for height
			);
		}

		return $dimension;
	}

	/**
	 * Is this a data-src URL?
	 *
	 * @param string $url The URL to check.
	 *
	 * @since 1.5.8
	 * @return bool true on success.
	 */
	public function is_data_url( $url ) {
		return (bool) preg_match( '#^\s*data\:.+#', $url );
	}

	/**
	 * @param string $url
	 *
	 * @since     1.0.0
	 * @copyright credit goes to automattic amp - github.com/Automattic/amp-wp
	 *
	 * @return bool|string url string on success
	 */
	public static function normalize_url( $url ) {
		if ( empty( $url ) ) {
			return false; }

		if ( 0 === strpos( $url, 'data:' ) ) {
			return false; }

		if ( 0 === strpos( $url, '//' ) ) {
			return set_url_scheme( $url, 'http' ); }

		// $parsed = wp_parse_url( $url );
		$parsed = amp_wp_parse_url( $url );

		if ( ! isset( $parsed['host'] ) ) {
			$path = '';
			if ( isset( $parsed['path'] ) ) {
				$path .= $parsed['path']; }

			if ( isset( $parsed['query'] ) ) {
				$path .= '?' . $parsed['query']; }

			$url = site_url( $path );
		}

		return $url;
	}

	/**
	 * Change <img> tag to <amp-img>
	 *
	 * @param string $html Has img tag strings.
	 *
	 * @since 1.0.0
	 */
	public function transform_image_tag_to_amp( $html ) {
		return preg_replace( '/<\s*img\s+/i', '<amp-img ', $html );
	}

	/**
	 * @param array $image
	 * @param bool  $echo
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function create_image( $image = array(), $echo = false ) {
		if ( empty( $image['src'] ) ) {
			return '';
		}

		$image   = $this->modify_attributes( $image );
		$is_anim = $this->is_animated_image_url( $image['src'] );

		if ( $is_anim ) {
			$this->enable_enqueue_scripts = true;
			$tag_name                     = 'amp-anim';
		} else {
			$tag_name = 'amp-img';
		}

		$instance = new Amp_WP_Html_Util();
		$node     = $instance->create_node( $tag_name, $image );
		$output   = $instance->saveXML( $node, LIBXML_NOEMPTYTAG );

		if ( $echo ) {
			echo $output;
		} else {
			return $output;
		}
	}

	/**
	 * Handy function to check image url is animated image or not
	 *
	 * @param string $url
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_animated_image_url( $url = '' ) {
		$url = amp_wp_remove_query_string( $url );
		return strtolower( substr( $url, - 4 ) ) === '.gif';
	}
}

// Register component class.
amp_wp_register_component( 'Amp_WP_IMG_Component' );

if ( ! function_exists( 'amp_wp_create_image' ) ) {

	/**
	 * Print AMP image from url
	 *
	 * @param      $image
	 * @param bool  $echo if true print image instead to return string.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function amp_wp_create_image( $image, $echo = true ) {
		/**
		 * @var Amp_WP_IMG_Component $img_component
		 */
		$img_component = Amp_WP_Component::instance( 'Amp_WP_IMG_Component' );
		if ( $echo ) {
			echo $img_component->create_image( $image );
		} else {
			return $img_component->create_image( $image );
		}
	}
}
