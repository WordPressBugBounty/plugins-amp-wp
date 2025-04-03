<?php
/**
 * The template for displaying post content within loops
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/content.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 *
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

?>
<article <?php amp_wp_post_classes( 'listing-item listing-2-item' ); ?>>

	<?php if ( has_post_thumbnail() ) { ?>
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php amp_wp_the_post_thumbnail( 'amp-wp-large' ); ?></a>
		<?php amp_wp_template_part( 'components/post-terms/post-terms-categories' ); ?>
	</div>
	<?php } ?>

	<div class="post-content">

		<!-- Post Meta - Date -->
		<?php amp_wp_template_part( 'template-parts/post-meta-date' ); ?>

		<!-- Post Title -->
		<?php amp_wp_template_part( 'template-parts/post-title' ); ?>

		<div class="post-excerpt"><?php the_excerpt(); ?></div>

		<?php
		$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
		if (
			( isset( $amp_wp_layout_settings['show_author_in_archive'] ) && ! empty( $amp_wp_layout_settings['show_author_in_archive'] ) )
			||
			( amp_wp_get_theme_mod( 'amp-wp-post-show-comment' ) && ( comments_open() || get_comments_number() ) )
		) {
			?>
		<div class="post-meta lower">
			<?php
			if (
				isset( $amp_wp_layout_settings['show_author_in_archive'] ) &&
				! empty( $amp_wp_layout_settings['show_author_in_archive'] )
			) {
				?>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="post-author"><?php the_author_meta( 'display_name' ); ?></a>
			<?php } ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>
			<a href="<?php echo esc_url( get_comments_link( get_the_ID() ) ); ?>" class="post-comment"><i class="fa fa-comments" aria-hidden="true"></i> <?php echo number_format_i18n( get_comments_number() ); ?></a>
			<?php endif; ?>
		</div>
		<?php } ?>
	</div>
</article>
