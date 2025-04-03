<?php
/**
 * The template for displaying pagination
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/components/pagination/pagination.php.
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
amp_wp_enqueue_block_style( 'pagination', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/pagination/pagination' );
if ( is_rtl() ) {
	$prev = '<i class="fa fa-arrow-right" aria-hidden="true"></i>' . amp_wp_translation_get( 'prev' );
	$next = amp_wp_translation_get( 'next' ) . '<i class="fa fa-arrow-left" aria-hidden="true"></i>';
} else {
	$prev = '<i class="fa fa-arrow-left" aria-hidden="true"></i>' . amp_wp_translation_get( 'prev' );
	$next = amp_wp_translation_get( 'next' ) . '<i class="fa fa-arrow-right" aria-hidden="true"></i>';
}
the_posts_pagination(
	array(
		'mid_size'           => 0,
		'prev_text'          => $prev,
		'next_text'          => $next,
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . amp_wp_translation_get( 'page' ) . ' ',
		'after_page_number'  => ' ' . sprintf( amp_wp_translation_get( 'page_of' ), amp_wp_get_query()->max_num_pages ) . ' </span>',
	)
);
