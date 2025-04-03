<?php
/**
 * The Template for Page
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/page.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://help.ampwp.io/article-categories/developer-documentation/
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

// Header
amp_wp_get_header();

	amp_wp_enqueue_block_style( 'single', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/pages/single/single' );
	amp_wp_enqueue_block_style( 'page', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/pages/page/page' );
	amp_wp_the_post();

	$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
	$show_page_thumbnail    = ( isset( $amp_wp_layout_settings['show_page_thumbnail'] ) && ! empty( $amp_wp_layout_settings['show_page_thumbnail'] ) ) ? $amp_wp_layout_settings['show_page_thumbnail'] : '';
?>
	<div <?php amp_wp_post_classes( 'single-page clearfix' ); ?>>
		<?php if ( get_the_title() ) : ?>
		<header class="amp-wp-page-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>
		<?php endif; ?>

		<div class="amp-wp-container">
			<?php if ( $show_page_thumbnail && has_post_thumbnail() ) : ?>
				<div class="page-thumbnail">
					<?php amp_wp_the_post_thumbnail( 'amp-wp-large' ); ?>
				</div>
			<?php endif; ?>

			<div class="page-content entry-content"><?php the_content(); ?></div>

			<?php
			$social_share_on_page = ( isset( $amp_wp_layout_settings['social_share_on_page'] ) && ! empty( $amp_wp_layout_settings['social_share_on_page'] ) ) ? $amp_wp_layout_settings['social_share_on_page'] : '';
			if ( $social_share_on_page ) {

				// Social Share Template.
				amp_wp_template_part( 'components/social-list/social-share' );
			}
			?>
			<!-- Ad Location 8: Footer (In All Pages) -->
			<?php amp_wp_show_ad_location( 'amp_wp_footer_before' ); ?>
		</div><!-- /container -->
	</div>
<?php
// Footer
amp_wp_get_footer();
