<?php
/**
 * Related Posts
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/related.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 * @package Amp_WP/Templates
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$show_related_posts     = ( isset( $amp_wp_layout_settings['show_related_posts'] ) && ! empty( $amp_wp_layout_settings['show_related_posts'] ) ) ? $amp_wp_layout_settings['show_related_posts'] : '';
if ( '1' != $show_related_posts ) :
	return;
endif;

// Enqueue AMP carousel script.
amp_wp_enqueue_script( 'amp-carousel', 'https://cdn.ampproject.org/v0/amp-carousel-0.2.js' );

$show_related_post_count     = ( isset( $amp_wp_layout_settings['show_related_post_count'] ) && ! empty( $amp_wp_layout_settings['show_related_post_count'] ) ) ? $amp_wp_layout_settings['show_related_post_count'] : '';
$show_related_post_algorithm = ( isset( $amp_wp_layout_settings['show_related_post_algorithm'] ) && ! empty( $amp_wp_layout_settings['show_related_post_algorithm'] ) ) ? $amp_wp_layout_settings['show_related_post_algorithm'] : '';

$show_related_post_thumbnail = ( isset( $amp_wp_layout_settings['show_related_post_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_related_post_thumbnail'] ) ) ? $amp_wp_layout_settings['show_related_post_thumbnail'] : '';
$show_related_post_date      = ( isset( $amp_wp_layout_settings['show_related_post_date'] ) && ! empty( $amp_wp_layout_settings['show_related_post_date'] ) ) ? $amp_wp_layout_settings['show_related_post_date'] : '';
$show_related_post_author    = ( isset( $amp_wp_layout_settings['show_related_post_author'] ) && ! empty( $amp_wp_layout_settings['show_related_post_author'] ) ) ? $amp_wp_layout_settings['show_related_post_author'] : '';

$query_args = amp_wp_related_posts_query_args( $show_related_post_count, $show_related_post_algorithm, get_the_ID() );
$query      = new WP_Query( $query_args );
amp_wp_set_query( $query );

if ( amp_wp_have_posts() ) :
	?>
	<div class="related-posts-wrapper carousel">
		<h5><?php amp_wp_translation_echo( 'related_posts' ); ?></h5>
		<amp-carousel class="amp-carousel " layout="responsive" type="carousel" height="260">
			<?php
			while ( amp_wp_have_posts() ) {
				amp_wp_the_post();
				$id = amp_wp_element_unique_id();
				?>
				<div class="<?php echo $id; ?> carousel-item">
					<?php
					$img = amp_wp_get_thumbnail( 'amp-wp-normal' );
					if ( isset( $img['src'] ) && $show_related_post_thumbnail && has_post_thumbnail() ) {
						amp_wp_add_inline_style( '.' . $id . ' .img-holder{background-image:url(' . $img['src'] . ');width:205px}' );
						?>
					<a class="img-holder" href="<?php the_permalink(); ?>"></a>
					<?php } ?>
					<div class="content-holder">
						<?php if ( '1' == $show_related_post_date ) : ?>
						<div class="post-meta">
							<?php
							$time_string = '<time>%1$s</time>';
							if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
								$time_string = '<time class="published" style="display:none;">%1$s</time><time class="updated">%2$s</time>';
							}
							$post_time_string = sprintf(
								$time_string,
								esc_attr( get_the_time( amp_wp_translation_get( 'listing_2_date' ) ) ),
								esc_attr( get_the_modified_time( amp_wp_translation_get( 'listing_2_date' ) ) )
							);
							echo $post_time_string;
							?>
						</div>
						<?php endif; ?>

						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

						<?php if ( '1' == $show_related_post_author ) : ?>
						<div class="post-meta">
							<?php
							printf(
								'<a href="%1$s" class="author">%2$s</a>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								esc_attr( get_the_author() )
							);
							?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			<?php } ?>
		</amp-carousel>
	</div>
	<?php
endif;
amp_wp_clear_query();
