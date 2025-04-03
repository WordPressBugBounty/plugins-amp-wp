<?php
/**
 * Single Post Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/post-thumbnails.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

$show_image_thumbnail   = '';
$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
if ( isset( $amp_wp_layout_settings['show_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_thumbnail'] ) ) {
	$show_image_thumbnail = $amp_wp_layout_settings['show_thumbnail'];
}

$no_image  = 'image-holder-none';
$img_layer = 'none';
$img       = amp_wp_get_thumbnail( 'amp-wp-large' );
$id        = amp_wp_element_unique_id();

if ( isset( $img['src'] ) && $show_image_thumbnail && has_post_thumbnail() ) {
	amp_wp_add_inline_style( '.' . esc_attr( $id ) . ' .img-holder{ background-image:url(' . esc_url( $img['src'] ) . ') }' );
	$no_image  = '';
	$img_layer = '';
}
?>
<div class="post-header <?php echo esc_attr( $id ); ?>">
	<div class="img-holder <?php echo sanitize_html_class( $no_image ); ?>"></div>
	<div class="img-layer <?php echo sanitize_html_class( $img_layer ); ?>"></div>
	<div class="content-holder <?php echo sanitize_html_class( $no_image ); ?>">
		<?php
		// Post Categories
		amp_wp_template_part( 'components/post-terms/post-terms-categories' );

		// Post Title
		amp_wp_template_part( 'single-post/title' );

		// Post Meta - Author & Date
		amp_wp_template_part( 'single-post/meta' );
		?>
	</div>
</div>
