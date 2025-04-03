<?php
/**
 * Library for json-ld support
 *
 * @since 1.0.0
 */
class Amp_WP_Json_Ld_Generator {

	/**
	 * Configurations
	 *
	 * @var array
	 */
	protected static $config = array(
		'active'         => true,
		'media_field_id' => '_featured_embed_code', // AMP WP Media Meta ID.
		'logo'           => '', // Logo for organization.
		'posts_type'     => 'BlogPosting', // Default posts schema type.
	);

	/**
	 * Store json-LD Generator Callback
	 *
	 * @var array
	 */
	protected static $generators = array();

	/**
	 * Global json-ld properties that is need in every data types
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	protected static $global_params = array(
		'@context' => 'http://schema.org',
	);

	/**
	 * Initialize library
	 *
	 * @since 1.0.0
	 */
	public static function init() {

		// Prepare data.
		add_action( 'template_redirect', 'Amp_WP_Json_Ld_Generator::prepare_data' );

		// Remove Yoast SEO JSON-LD to prevent plugin conflict.
		add_action( 'wpseo_json_ld', 'Amp_WP_Json_Ld_Generator::plugins_conflict', 1 );
	}

	/**
	 * Generate JSON-LD Information
	 *
	 * @since 1.0.0
	 */
	public static function prepare_data() {
		self::$config = apply_filters( 'amp_wp_json_ld_config', self::$config );
		if ( empty( self::$config['active'] ) ) {
			return;
		}

		// Organization.
		if ( ! empty( self::$config['logo'] ) ) {
			self::$generators[] = array(
				'type'     => 'organization',
				'callback' => array( 'Amp_WP_Json_Ld_Generator', 'generate_organization_schema' ),
			);
		}

		// Homepage.
		if ( is_home() || is_front_page() ) {
			self::$generators[] = array(
				'type'     => 'website',
				'callback' => array( 'Amp_WP_Json_Ld_Generator', 'generate_website_schema' ),
			);
		}

		// Single Items.
		if ( is_singular() && ! is_front_page() ) {
			$type = 'single';
			if ( function_exists( 'is_product' ) && is_product() ) {
				$type = 'product';
			} elseif ( is_page() ) {
				$type = 'page';
			}

			$callback = array( 'Amp_WP_Json_Ld_Generator', sprintf( 'generate_%s_schema', $type ) );

			if ( 'single' != $type && ! is_callable( $callback ) ) {
				$callback = array( 'Amp_WP_Json_Ld_Generator', sprintf( 'generate_single_schema', $type ) );
			}

			self::$generators[] = array(
				'type'     => 'single',
				'callback' => $callback,
			);
		}

		// Print data.
		if ( ! empty( self::$generators ) ) {
			add_action( 'wp_head', 'Amp_WP_Json_Ld_Generator::print_output' );
			add_action( 'amp_wp_template_head', 'Amp_WP_Json_Ld_Generator::print_output' );
		}
	}

	/**
	 * Generate Organization Schema
	 *
	 * @since   1.0.0
	 * @return  array
	 */
	public static function generate_organization_schema() {

		$data = array(
			'@context' => 'https://schema.org/',
			'@type'    => 'Organization',
			'@id'      => '#organization',
		);

		if ( ! empty( self::$config['logo'] ) ) {
			$data['logo'] = array(
				'@type' => 'ImageObject',
				'url'   => self::$config['logo'],
			);
		}

		$data['url']         = home_url( '/' );
		$data['name']        = get_bloginfo( 'name' );
		$data['description'] = self::esc_text( get_bloginfo( 'description' ) );

		return $data;
	}

	/**
	 * Generate Website Schema
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function generate_website_schema() {

		$data = array(
			'@context'      => 'https://schema.org/',
			'@type'         => 'WebSite',
			'name'          => get_bloginfo( 'name' ),
			'alternateName' => self::esc_text( get_bloginfo( 'description' ) ),
			'url'           => home_url( '/' ),
		);

		if ( is_home() || is_front_page() ) {
			$data['potentialAction'] = array(
				'@type'       => 'SearchAction',
				'target'      => get_search_link() . '{search_term}',
				'query-input' => 'required name=search_term',
			);
		}

		return $data;
	}

	/**
	 * Generate  Single Post Schema
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function generate_single_schema() {
		$amp_wp_structured_data_settings = get_option( 'amp_wp_structured_data_settings' );
		$schema_type_for_post            = ( isset( $amp_wp_structured_data_settings['schema_type_for_post'] ) && ! empty( $amp_wp_structured_data_settings['schema_type_for_post'] ) ) ? $amp_wp_structured_data_settings['schema_type_for_post'] : 'BlogPosting';
		return self::get_singular_schema( $schema_type_for_post );
	}

	/**
	 * Get Singular Post Schema
	 *
	 * @param string $type
	 * @param array  $args
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_singular_schema( $type = 'BlogPosting', $args = array() ) {

		global $post;

		if ( empty( $type ) ) {
			$type = self::$config['posts_type'];
		}

		if ( ! isset( $args['add_search'] ) ) {
			$args['add_search'] = true;
		}

		if ( ! isset( $args['add_date'] ) ) {
			$args['add_date'] = true;
		}

		if ( ! isset( $args['add_image'] ) ) {
			$args['add_image'] = true;
		}

		$permalink = get_permalink( $post->ID );

		$schema = array(
			'@context' => 'https://schema.org/',
			'@type'    => $type,
		);

		// Post Excerpt or Content.
		if ( $post->post_excerpt ) {
			$schema['description'] = $post->post_excerpt;
		} else {
			$schema['description'] = self::esc_text( $post->post_content, 250 );
		}

		// Add Headline.
		$schema['headline'] = $post->post_title;

		// Add Date.
		if ( $args['add_date'] ) {
			$schema['datePublished'] = get_the_date( 'Y-m-d' );
			$schema['dateModified']  = get_post_modified_time( 'Y-m-d' );
		}

		$schema['wordCount'] = str_word_count( wp_strip_all_tags( $post->post_content ) );

		if ( 'NewsArticle' == $type ) {
			$schema['name']        = $post->post_title;
			$schema['url']         = $permalink;
			$schema['articleBody'] = wp_strip_all_tags( $post->post_content );
		}

		// Current Web Page.
		$schema['mainEntityOfPage'] = $permalink;

		// Add Thumbnail.
		if ( $args['add_image'] ) {
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			if ( ! empty( $featured_image[0] ) ) {
				$schema['image'] = array(
					'@type' => 'ImageObject',
					'url'   => $featured_image[0],
				);

				// Add width and height.
				if ( ! empty( $featured_image[1] ) && ! empty( $featured_image[2] ) ) {
					$schema['image']['width']  = $featured_image[1];
					$schema['image']['height'] = $featured_image[2];
				}
			}
		}

		// Publisher.
		$schema['publisher'] = array(
			'@id' => '#organization',
		);

		// Add Author.
		$author           = get_the_author_meta( 'display_name', $post->post_author );
		$schema['author'] = array(
			'@type' => 'Person',
			'@id'   => '#person-' . $author,
			'name'  => $author,
		);

		$author                  = sanitize_html_class( $author );
		$schema['author']['@id'] = '#person-' . $author;

		// Change type to advanced format.
		if ( 'post' === $post->post_type ) {
			$format = get_post_format();
			switch ( $format ) {
				// Audio type.
				case 'audio':
					$schema['@type'] = 'AudioObject';

					// Add Media.
					if ( $media = get_post_meta( $post->ID, self::$config['media_field_id'], true ) ) {
						$schema['contentUrl'] = $media;
					}
					break;

				// Video type.
				case 'video':
					$schema['@type'] = 'VideoObject';
					// Add Media.
					if ( $media = get_post_meta( $post->ID, self::$config['media_field_id'], true ) ) {
						$schema['contentUrl'] = $media;
					}

					// Change to be valid!
					$schema['name']         = $schema['headline'];
					$schema['thumbnailUrl'] = $schema['image'] ? $schema['image']['url'] : '';
					$schema['uploadDate']   = $schema['datePublished'];
					unset(
						$schema['headline'],
						$schema['datePublished'],
						$schema['dateModified'],
						$schema['image']
					);
					break;

				// Image & Gallery type.
				case 'image':
				case 'gallery':
					$schema['@type'] = 'ImageObject';
					break;
			}
		} elseif ( 'attachment' === $post->post_type && wp_attachment_is_image() ) { // Image attachment.
			$schema['@type'] = 'ImageObject';
		} elseif ( 'attachment' === $post->post_type && wp_attachment_is( 'audio' ) ) { // Audio attachment.
			$schema['@type']      = 'AudioObject';
			$schema['contentUrl'] = wp_get_attachment_url();
		} elseif ( 'attachment' === $post->post_type && wp_attachment_is( 'video' ) ) { // Video attachment.
			$schema['@type']      = 'VideoObject';
			$schema['contentUrl'] = wp_get_attachment_url();
		}

		// Comments Count.
		if ( 'product' != $post->post_type && 'WebPage' != $post->post_type && post_type_supports( $post->post_type, 'comments' ) ) {
			$schema['interactionStatistic'][] = array(
				'@type'                => 'InteractionCounter',
				'interactionType'      => 'https://schema.org/CommentAction',
				'userInteractionCount' => get_comments_number( $post ),
			);
		}

		// Add Search for Pages.
		if ( 'WebPage' === $type ) {
			$search_link = get_search_link();
			if ( ! strstr( $search_link, '?' ) ) {
				$search_link = trailingslashit( $search_link );
			}

			$schema['potentialAction']['comments'] = array(
				'@type'       => 'SearchAction',
				'target'      => $search_link . '{search_term}',
				'query-input' => 'required name=search_term',
			);
		}

		return array_filter( $schema );
	}

	/**
	 * Generate WebPage Schema
	 *
	 * @since   1.0.0
	 * @return  array
	 */
	public static function generate_page_schema() {
		return self::get_singular_schema( 'WebPage', array( 'add_date' => false ) );
	}

	/**
	 * Generate WooCommerce Schema
	 *
	 * @since   1.0.0
	 * @return  array
	 *
	 * @check http://jsonld.com/product/
	 */
	public static function generate_product_schema() {

		$product = wc_get_product();
		$schema  = self::get_singular_schema( 'Product', false );

		// Change to product to be valid!
		$schema['@type']          = 'Product';
		$schema['name']           = $schema['headline'];
		$schema['brand']          = $schema['publisher'];
		$schema['productionDate'] = $schema['datePublished'];
		unset(
			$schema['headline'],
			$schema['publisher'],
			$schema['dateModified'],
			$schema['datePublished'],
			$schema['author']
		);

		if ( $rating_count = (int) $product->get_rating_count() ) {
			$schema['aggregateRating'] = array(
				'@type'       => 'AggregateRating',
				'ratingValue' => wc_format_decimal( $product->get_average_rating(), 2 ),
				'reviewCount' => $rating_count,
			);
		}

		$schema['offers'] = array(
			'@type'         => 'Offer',
			'priceCurrency' => get_woocommerce_currency(),
			'price'         => $product->get_price(),
			'availability'  => 'https://schema.org/' . ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
		);

		return $schema;
	}

	/**
	 * callback: Print json-ld output
	 *
	 * action: wp_head
	 *
	 * @since 1.0.0
	 */
	public static function print_output() {
		foreach ( self::$generators as $generator ) {
			if ( empty( $generator['type'] ) || empty( $generator['callback'] ) || ! is_callable( $generator['callback'] ) ) {
				continue;
			}

			$filter = sprintf( 'amp_wp_json_ld_%s_', $generator['type'] );
			if ( ! $data = apply_filters( $filter, call_user_func( $generator['callback'] ) ) ) {
				continue;
			}
			echo '<script type="application/ld+json">', wp_json_encode( $data, JSON_PRETTY_PRINT ), '</script>', PHP_EOL;
		}
	}

	/**
	 * Get the Post Author
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	public static function get_the_author() {
		return get_the_author();
	}

	/**
	 * Escape shortcodes and tags of text
	 *
	 * @param   string $text
	 * @param   int    $limit
	 * @since   1.0.0
	 *
	 * @return  string  $text
	 */
	private static function esc_text( $text, $limit = 0 ) {
		$text = wp_strip_all_tags( $text );
		$text = strip_shortcodes( $text );
		$text = str_replace( array( "\r", "\n" ), '', $text );

		if ( $limit ) {
			return self::substr_text( $text, $limit );
		} else {
			return $text;
		}
	}

	/**
	 * Return a pice of text
	 *
	 * @param   string $text
	 * @param   int    $length
	 * @since   1.0.0
	 *
	 * @return string $text
	 */
	private static function substr_text( $text = '', $length = 110 ) {
		if ( empty( $text ) ) {
			return $text;
		}

		return mb_substr( $text, 0, $length, 'UTF-8' );
	}

	/**
	 * Remove Yoast SEO JSON-LD to prevent plugin conflict
	 *
	 * @since 1.5.12
	 */
	public static function plugins_conflict() {
		amp_wp_remove_class_action( 'wpseo_json_ld', 'WPSEO_JSON_LD', 'website', 10 );
	}
}
Amp_WP_Json_Ld_Generator::init();
