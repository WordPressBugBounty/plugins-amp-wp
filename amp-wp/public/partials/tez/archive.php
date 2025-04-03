<?php
/**
 * The Template for Displaying Post Archives
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/archive.php.
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

	// Archive Title.
	amp_wp_template_part( 'template-parts/archive-title' );
?>
	<div class="amp-wp-container">
		<?php
		// Ad Location 9: After Title In Archive Pages.
		amp_wp_show_ad_location( 'amp_wp_archive_title_after' );

		// Post Listing.
		amp_wp_template_part( 'template-parts/' . amp_wp_page_listing() );

		// Pagination.
		amp_wp_template_part( 'components/pagination/pagination' );
		?>

		<!-- Ad Location 8: Footer (In All Pages) -->
		<?php amp_wp_show_ad_location( 'amp_wp_footer_before' ); ?>
	</div> <!-- /container -->
<?php
// Footer
amp_wp_get_footer();
