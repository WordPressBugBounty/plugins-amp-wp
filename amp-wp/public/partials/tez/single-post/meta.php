<?php
/**
 * Single Post Meta
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/meta.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 * @author  Pixelative
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$show_date_in_single    = ( isset( $amp_wp_layout_settings['show_date_in_single'] ) && ! empty( $amp_wp_layout_settings['show_date_in_single'] ) ) ? $amp_wp_layout_settings['show_date_in_single'] : '';
$show_author_in_single  = ( isset( $amp_wp_layout_settings['show_author_in_single'] ) && ! empty( $amp_wp_layout_settings['show_author_in_single'] ) ) ? $amp_wp_layout_settings['show_author_in_single'] : '';

if ( empty( $show_date_in_single ) && empty( $show_author_in_single ) ) {
	return;
}
?>
<div class="post-meta">
	<?php
	$post_publised_date = '';
	$post_modified_date = '';
	if ( '1' == $show_date_in_single ) {
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$post_publised_date = esc_attr( get_the_time( amp_wp_translation_get( 'listing_2_date' ) ) );
			$post_modified_date = esc_attr( get_the_modified_time( amp_wp_translation_get( 'listing_2_date' ) ) );
		} else {
			$post_publised_date = esc_attr( get_the_time( amp_wp_translation_get( 'listing_2_date' ) ) );
		}
	}

	$post_publised_by     = '';
	$post_publised_by_url = '';
	if ( '1' == $show_author_in_single ) {
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
			'<a href="%1$s" class="post-author">%2$s</a>',
			$time_string,
		),
		amp_wp_translation_get( 'by_on' )
	);
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		printf( $meta_text, $post_publised_by_url, $post_publised_by, $post_publised_date, $post_modified_date );
	} else {
		printf( $meta_text, $post_publised_by_url, $post_publised_by, $post_publised_date );
	}
	?>
</div>
