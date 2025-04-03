<?php
/**
 * Description
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/single-post/comments.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/article-categories/developer-documentation/
 * @author  Pixelative
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$show_comments          = ( isset( $amp_wp_layout_settings['show_comments'] ) && ! empty( $amp_wp_layout_settings['show_comments'] ) ) ? $amp_wp_layout_settings['show_comments'] : '';

if ( ( '1' != $show_comments ) || ! comments_open() || ! get_comments_number() ) :
	return;
endif;

// Enqueue CSS
amp_wp_enqueue_block_style( 'comments', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/comments/comments' );

?>
<div class="amp-wp-comments-wrapper">
	<div class="amp-wp-comments-header clearfix">
		<div class="amp-wp-comments-title strong-label">
			<i class="fa fa-comments" aria-hidden="true"></i>
			<?php amp_wp_translation_echo( 'comments' ); ?>
			<span class="counts-label">( <?php echo number_format_i18n( get_comments_number() ); ?> )</span>
		</div>
		<?php
		$link = amp_wp_get_comment_link();

		// Disable Auto Redirect for This Link.
		$mobile_auto_redirect = '';
		if ( get_option( 'amp_wp_general_settings' ) ) {
			$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
			if ( isset( $amp_wp_general_settings['mobile_auto_redirect'] ) && ! empty( $amp_wp_general_settings['mobile_auto_redirect'] ) ) {
				$mobile_auto_redirect = $amp_wp_general_settings['mobile_auto_redirect'];
			}
		}

		if ( $mobile_auto_redirect ) {
			$link = add_query_arg( 'amp-wp-skip-redirect', true, $link );
		}
		?>
		<a href="<?php echo esc_url( $link ); ?>" class="amp-btn add-comment" rel="nofollow"><?php esc_attr( amp_wp_translation_echo( 'add_comment' ) ); ?></a>
	</div>
	<ul class="amp-wp-comment-list">
		<?php amp_wp_list_comments(); ?>
	</ul>
</div>
<?php do_action( 'amp_wp_after_comment_list' ); ?>

<?php if ( get_comment_pages_count() ) { ?>
<div class="comments-pagination pagination">
	<?php amp_wp_comments_paginate(); ?>
	<span class="page-numbers">
		<?php printf( amp_wp_translation_get( 'comment_page_numbers' ), get_query_var( 'cpage' ) ? absint( get_query_var( 'cpage' ) ) : 1, get_comment_pages_count() ); ?>
	</span>
</div>
	<?php
}
