<?php
/**
 * The Template for displaying post archives
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/components/slider/slider.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 * @package Amp_WP/Templates
 * @version 2.0.0
 */

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$slider_on_home         = ( isset( $amp_wp_layout_settings['slider_on_home'] ) && ! empty( $amp_wp_layout_settings['slider_on_home'] ) ) ? $amp_wp_layout_settings['slider_on_home'] : '';

if ( '1' != $slider_on_home ) :
	return;
endif;

$slider_on_home_post_date   = ( isset( $amp_wp_layout_settings['slider_on_home_post_date'] ) && ! empty( $amp_wp_layout_settings['slider_on_home_post_date'] ) ) ? $amp_wp_layout_settings['slider_on_home_post_date'] : '';
$slider_on_home_post_author = ( isset( $amp_wp_layout_settings['slider_on_home_post_author'] ) && ! empty( $amp_wp_layout_settings['slider_on_home_post_author'] ) ) ? $amp_wp_layout_settings['slider_on_home_post_author'] : '';
$slider_on_home_count       = ( isset( $amp_wp_layout_settings['slider_on_home_post_author'] ) && ! empty( $amp_wp_layout_settings['slider_on_home_count'] ) ) ? intval( $amp_wp_layout_settings['slider_on_home_count'] ) : 3;

// Enqueue Post Terms CSS
amp_wp_enqueue_block_style( 'post-terms', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/post-terms/post-terms' );

// Enqueue AMP carousel CSS
amp_wp_enqueue_block_style( 'slider', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/slider/slider', false ); // no rtl style

// Enqueue AMP carousel script
amp_wp_enqueue_script( 'amp-carousel', 'https://cdn.ampproject.org/v0/amp-carousel-0.2.js' );

$featured_args  = array(
	'post_type'           => 'post',
	'posts_per_page'      => $slider_on_home_count,
	'ignore_sticky_posts' => true,
	'meta_query'          => array( // only posts with thumbnail
		'key'     => '_thumbnail_id',
		'compare' => 'EXISTS',
	),
);
$featured_query = new WP_Query( apply_filters( 'amp_wp_home_featured', $featured_args ) );
amp_wp_set_query( $featured_query );
?>
<div class="homepage-slider">
	<amp-carousel class="amp-slider amp-featured-slider" layout="responsive" type="slides" <?php amp_wp_hw_attr( '', 750 ); ?> delay="3500" autoplay>
		<?php
		while ( amp_wp_have_posts() ) {
			amp_wp_the_post();
			$img = amp_wp_get_thumbnail( 'amp-wp-large' );
			$id  = amp_wp_element_unique_id();
			amp_wp_add_inline_style( '.' . $id . ' .img-holder{ background-image:url(' . esc_url( $img['src'] ) . ') }' );
			?>
			<div class="<?php echo $id; ?>">
				<div class="img-holder"></div>
				<div class="img-layer"></div>
				<div class="content-holder">
					<?php amp_wp_template_part( 'components/post-terms/post-terms-categories' ); ?>
					<div class="slider-meta">
						<?php
						$post_publised_date = '';
						$post_modified_date = '';
						if ( '1' == $slider_on_home_post_date ) {
							if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
								$post_publised_date = get_the_time( amp_wp_translation_get( 'listing_2_date' ) );
								$post_modified_date = get_the_modified_time( amp_wp_translation_get( 'listing_2_date' ) );
							} else {
								$post_publised_date = get_the_time( amp_wp_translation_get( 'listing_2_date' ) );
							}
						}

						$post_publised_by     = '';
						$post_publised_by_url = '';
						if ( '1' == $slider_on_home_post_author ) {
							$post_publised_by     = get_the_author();
							$post_publised_by_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
						}

						$time_string = '<time class="post-date">%3$s</time>';
						if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
							$time_string = '<time class="post-date published" style="display:none;">%3$s</time><time class="post-date modified">%4$s</time>';
						}
						$meta_text = str_replace(
							array(
								'%s1',
								'%s2',
							),
							array(
								'<a href="%1$s" class="author">%2$s</a>',
								$time_string,
							),
							amp_wp_translation_get( 'by_on' )
						);
						if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
							printf( $meta_text, $post_publised_by_url, $post_publised_by, esc_attr( $post_publised_date ), esc_attr( $post_modified_date ) );
						} else {
							printf( $meta_text, $post_publised_by_url, $post_publised_by, esc_attr( $post_publised_date ) );
						}
						?>
					</div>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				</div>
			</div>
		<?php } ?>
	</amp-carousel>
</div>
<?php
amp_wp_clear_query();
