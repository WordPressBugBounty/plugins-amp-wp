<?php
/**
 * The template for displaying product content style 1 within loops
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/listing-1.php.
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

amp_wp_enqueue_block_style( 'listing-1', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/listing/listing-1' );
?>
<div class="posts-listing posts-listing-1">
	<?php
	if ( is_amp_wp_ads_manager_plugin_active() ) {
		$ad_after_each = (int) Amp_WP_Ads_Manager::get_option( 'amp_wp_archive_after_x_number' );
		$counter       = 1;
	} else {
		$ad_after_each = false;
	}

	while ( amp_wp_have_posts() ) :
		amp_wp_the_post();
		?>
		<article <?php amp_wp_post_classes( 'listing-item listing-1-item clearfix' ); ?>>
			<?php amp_wp_template_part( 'components/post-terms/post-terms-categories' ); ?>

			<div class="amp-wp-list-view">
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="post-thumbnail">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php amp_wp_the_post_thumbnail( 'amp-wp-small' ); ?>
						</a>
					</div>
				<?php } ?>

				<div class="post-content">
					<!-- Post Meta - Author -->
					<?php amp_wp_template_part( 'template-parts/post-meta-author' ); ?>

					<!-- Post Title -->
					<?php amp_wp_template_part( 'template-parts/post-title' ); ?>

					<!-- Post Meta - Date -->
					<?php amp_wp_template_part( 'template-parts/post-meta-date' ); ?>
				</div>
			</div>
		</article>
		<?php
		// Should be active and also there was another post after this post.
		if ( isset( $ad_after_each ) && $ad_after_each && amp_wp_have_posts() ) {
			if ( $counter === $ad_after_each ) {

				// Ad Location 10: Post Content Ads (After X Paragraph)
				amp_wp_show_ad_location( 'amp_wp_archive_after_x' );
				$counter = 1; // reset counter
			} else {
				$counter++;
			}
		}
	endwhile;
	?>
</div>
