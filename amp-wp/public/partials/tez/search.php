<?php
/**
 * The Template for Search Post
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/search.php.
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
?>
	<div class="amp-wp-container">
		<?php
		// Enqueue CSS.
		amp_wp_enqueue_block_style( 'search', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/pages/search/search' );

		// Search Form.
		amp_wp_get_search_form();

		// Show Search Result Only When User Searched!
		if ( get_search_query( false ) !== '' ) {

			// Post Listing.
			amp_wp_template_part( 'template-parts/' . amp_wp_page_listing() );

			// Pagination.
			amp_wp_template_part( 'components/pagination/pagination' );
		}
		?>

		<!-- Ad Location 8: Footer (In All Pages) -->
		<?php amp_wp_show_ad_location( 'amp_wp_footer_before' ); ?>
	</div><!-- /container -->
<?php
// Footer
amp_wp_get_footer();
