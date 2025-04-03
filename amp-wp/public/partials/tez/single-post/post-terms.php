<?php
/**
 * Single Post Terms
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/post-terms.php.
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
 * @version     1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$show_tags              = ( isset( $amp_wp_layout_settings['show_tags'] ) && ! empty( $amp_wp_layout_settings['show_tags'] ) ) ? $amp_wp_layout_settings['show_tags'] : '';
if ( '1' != $show_tags ) :
	return;
endif;

amp_wp_enqueue_block_style( 'post-terms', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/post-terms/post-terms' );
the_tags(
	'<div class="post-terms tags"><span class="term-type"><i class="fa fa-tags"></i></span>',
	'',
	'</div>'
);
