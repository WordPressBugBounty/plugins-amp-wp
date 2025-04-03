<?php
/**
 * The template for displaying post meta author in content loops
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/post-meta-author.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://help.ampwp.io/article-categories/developer-documentation/
 *
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
if (
	! isset( $amp_wp_layout_settings['show_author_in_archive'] ) &&
	empty( $amp_wp_layout_settings['show_author_in_archive'] )
) {
	return;
}
?>
<div class="post-meta">
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="post-author"><?php the_author_meta( 'display_name' ); ?></a>
</div>
