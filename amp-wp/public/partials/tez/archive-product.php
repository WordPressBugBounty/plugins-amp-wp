<?php
/**
 * The Template for Displaying Product Archives
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/archive-product.php.
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

// Header
amp_wp_get_header();

	// Enqueue CSS.
	amp_wp_enqueue_block_style( 'archive', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/archive' );

	// Archive Title.
	amp_wp_template_part( 'template-parts/archive-title' );

	// Print WooCommerce Notices.
	wc_print_notices();

	// Product Listing.
	amp_wp_template_part( 'woocommerce/loop' );

	// Pagination.
	amp_wp_template_part( 'components/pagination/pagination' );

// Footer
amp_wp_get_footer();
