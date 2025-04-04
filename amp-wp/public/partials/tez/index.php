<?php
/**
 * The Template for displaying post archives
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/index.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 * @package Amp_WP/Templates
 * @version 2.0.0
 */

// Header
amp_wp_get_header();
?>
	<div class="amp-wp-container">
		<?php
		// Slider.
		amp_wp_template_part( 'components/slider/slider' );

		// Post Listing.
		amp_wp_template_part( 'template-parts/' . amp_wp_page_listing() );

		// Pagination.
		amp_wp_template_part( 'components/pagination/pagination' );
		?>
	</div>
<?php
// Footer.
amp_wp_get_footer();
