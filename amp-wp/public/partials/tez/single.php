<?php
/**
 * The Template for Displaying Single Post
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single.php.
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
	amp_wp_enqueue_block_style( 'single', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/pages/single/single' );
	amp_wp_enqueue_block_style( 'post', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/post/post' );


	amp_wp_the_post();
?>
	<div class="amp-wp-container">
		<article <?php amp_wp_post_classes( 'single-post clearfix' ); ?>>

			<!-- Ad Location 2: Before Post Title -->
			<?php amp_wp_show_ad_location( 'amp_wp_post_title_before' ); ?>

			<!-- Featured Image Template -->
			<?php amp_wp_template_part( 'single-post/post-thumbnails' ); ?>

			<!-- Ad Location 3: After Post Title -->
			<?php amp_wp_show_ad_location( 'amp_wp_post_title_after' ); ?>

			<!-- Ad Location 4: Above Post Content -->
			<?php amp_wp_show_ad_location( 'amp_wp_post_content_before' ); ?>

			<!-- Description -->
			<?php amp_wp_template_part( 'single-post/description' ); ?>

			<!-- Custom Action (Hook): Below Post Content -->
			<?php do_action( 'amp_wp_post_content_below' ); ?>

			<!-- Ad Location 6: Below Post Content -->
			<?php amp_wp_show_ad_location( 'amp_wp_post_content_after' ); ?>

			<!-- Post Terms -->
			<?php amp_wp_template_part( 'single-post/post-terms' ); ?>
		</article>

		<?php
		// Social Share Template.
		amp_wp_template_part( 'components/social-list/social-share' );

		// Related Post Template.
		amp_wp_template_part( 'single-post/related' );

		// Comment Listing.
		amp_wp_template_part( 'single-post/comments' );

		// Ad Location 7: After Comments in Posts.
		amp_wp_show_ad_location( 'amp_wp_post_comment_after' );
		?>
		<!-- Ad Location 8: Footer (In All Pages) -->
		<?php amp_wp_show_ad_location( 'amp_wp_footer_before' ); ?>
	</div><!-- /container -->
<?php
// Footer
amp_wp_get_footer();
