<?php
/**
 * The Template for Displaying 404 Page Template
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/404.php.
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

amp_wp_enqueue_inline_style( amp_wp_min_suffix( AMP_WP_TEMPLATE_DIR_CSS . 'pages/404/404', '.css' ), '404' );
?>
<div class="amp-wp-container">
	<header class="error-404">
		<p class="page-title"><?php _e( '404', 'amp-wp' ); ?></p>
		<p class="lead"><?php amp_wp_translation_echo( '404_message' ); ?></p>
	</header>
	<!-- Ad Location 8: Footer (In All Pages) -->
	<?php amp_wp_show_ad_location( 'amp_wp_footer_before' ); ?>
</div><!-- /container -->
<?php
// Footer
amp_wp_get_footer();
