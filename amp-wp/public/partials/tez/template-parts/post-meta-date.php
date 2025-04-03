<?php
/**
 * The template for displaying post meta date in content loops
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/post-meta-date.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 *
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
if (
	! isset( $amp_wp_layout_settings['show_date_in_archive'] ) &&
	empty( $amp_wp_layout_settings['show_date_in_archive'] )
) {
	return;
}
?>
<div class="post-meta clearfix">
	<?php
	$time_string = '<time class="post-date">%1$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="post-date published" style="display:none;">%1$s</time><time class="post-date modified">%2$s</time>';
	}
	$post_time_string = sprintf(
		$time_string,
		esc_attr( get_the_time( amp_wp_translation_get( 'listing_2_date' ) ) ),
		esc_attr( get_the_modified_time( amp_wp_translation_get( 'listing_2_date' ) ) )
	);
	echo $post_time_string;
	?>
</div>
