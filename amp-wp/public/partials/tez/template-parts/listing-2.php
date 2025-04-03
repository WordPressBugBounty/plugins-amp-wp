<?php
/**
 * The template for displaying product content style 2 within loops
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/listing-2.php.
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
?>
<div class="posts-listing">
	<?php
	amp_wp_enqueue_block_style( 'listing-2', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/listing/listing-2' );
	if ( is_amp_wp_ads_manager_plugin_active() ) {
		$ad_after_each = (int) Amp_WP_Ads_Manager::get_option( 'amp_wp_archive_after_x_number' );
		$counter       = 1;
	} else {
		$ad_after_each = false;
	}

	/* Start the Loop */
	while ( amp_wp_have_posts() ) :
		amp_wp_the_post();
		amp_wp_template_part( 'template-parts/content' );

		// Should be active and also there was another post after this post
		if ( isset( $ad_after_each ) && $ad_after_each && amp_wp_have_posts() ) {
			if ( $counter === $ad_after_each ) {

				// Ad Location 10: Post Content Ads (After X Paragraph).
				amp_wp_show_ad_location( 'amp_wp_archive_after_x' );
				$counter = 1; // reset counter.
			} else {
				$counter++;
			}
		}
	endwhile;
	?>
</div><!-- .posts-listing -->
