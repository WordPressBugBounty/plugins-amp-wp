<?php
/**
 * Post Description
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/description.php.
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
?>
<div class="post-content entry-content">
	<?php
	the_content();
	wp_link_pages(
		array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'amp-wp' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'amp-wp' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		)
	);
	?>
</div>
