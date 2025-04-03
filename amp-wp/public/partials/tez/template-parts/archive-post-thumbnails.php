<?php
/**
 * Single Post Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/post-thumbnails.php.
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
$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$show_image_thumbnail   = amp_wp_get_theme_mod( 'amp-wp-post-show-thumbnail' );
if ( empty( $show_image_thumbnail ) ) {
	if ( isset( $amp_wp_layout_settings['show_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_thumbnail'] ) ) {
		$show_image_thumbnail = $amp_wp_layout_settings['show_thumbnail'];
	}
}

$meta_key = ( isset( $amp_wp_layout_settings['featured_va_meta_key'] ) && ! empty( $amp_wp_layout_settings['featured_va_meta_key'] ) ) ?
		$amp_wp_layout_settings['featured_va_meta_key'] : '';

$media_url = get_post_meta( get_the_ID(), $meta_key, true );
if ( ! empty( $media_url ) ) {
	$embeded              = amp_wp_auto_embed_content( $media_url );
	$show_image_thumbnail = false;
	?>
	<div class="post-thumbnail embeded">
		<?php echo $embeded['content']; ?>
	</div>
	<?php
}
if ( $show_image_thumbnail && has_post_thumbnail() ) {
	?>
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php amp_wp_the_post_thumbnail( 'amp-wp-small' ); ?></a>
	</div>
	<?php
}
