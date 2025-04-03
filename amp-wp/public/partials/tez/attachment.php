<?php
/**
 * The Template for Displaying Attachments
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/attachment.php.
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

amp_wp_enqueue_block_style( 'attachment', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/pages/attachment/attachment' );
amp_wp_the_post();
$attachment_id = get_the_ID();
$parent        = amp_wp_get_post_parent( $attachment_id );
?>
<div <?php amp_wp_post_classes( 'single-post clearfix attachment' ); ?>>
	<?php if ( $parent ) { ?>
	<div class="return-to">
		<a href="<?php the_permalink( $parent ); ?>" class="amp-btn">
			<i class="fa fa-angle-<?php echo is_rtl() ? 'right' : 'left'; ?>"></i>
			<?php echo esc_html( sprintf( amp_wp_translation_get( 'attachment-return-to' ), wp_html_excerpt( get_the_title( $parent ), 100 ) ) ); ?>
		</a>
	</div>
	<?php } ?>

	<?php
	if ( wp_attachment_is( 'image' ) ) {
		if ( $img = wp_get_attachment_image_src( $attachment_id, 'full' ) ) {
			amp_wp_enqueue_script( 'amp-image-lightbox', 'https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js' );
			?>
			<amp-image-lightbox id="attachment-lightbox" layout="nodisplay"></amp-image-lightbox>
			<amp-img on="tap:attachment-lightbox"
					role="button"
					tabindex="0"
					layout="responsive"
					src="<?php echo esc_url( $img[0] ); ?>"
					width="<?php echo esc_attr( $img[1] ); ?>"
					height="<?php echo esc_attr( $img[2] ); ?>"
			>
			</amp-img>
			<?php
		}
	} else {
		$click_here = sprintf( '<a href="%s">%s</a>', wp_get_attachment_url( $attachment_id ), amp_wp_translation_get( 'click-here' ) );
		if ( wp_attachment_is( 'video' ) ) {
			printf( amp_wp_translation_get( 'attachment-play-video' ), $click_here );
		} elseif ( wp_attachment_is( 'audio' ) ) {
			printf( amp_wp_translation_get( 'attachment-play-audio' ), $click_here );
		} else {
			printf( amp_wp_translation_get( 'attachment-download-file' ), $click_here );
		}
	}
	?>
	<h3 class="post-title"><?php the_title(); ?></h3>
	<?php
	if ( is_rtl() ) {
		$older_text = '<i class="fa fa-angle-double-right"></i> ' . amp_wp_translation_get( 'attachment-next' );
		$next_text  = amp_wp_translation_get( 'attachment-prev' ) . ' <i class="fa fa-angle-double-left"></i>';
	} else {
		$next_text  = '<i class="fa fa-angle-double-left"></i> ' . amp_wp_translation_get( 'attachment-prev' );
		$older_text = amp_wp_translation_get( 'attachment-next' ) . ' <i class="fa fa-angle-double-right"></i>';
	}
	?>
	<div class="pagination amp-wp-links-pagination clearfix">
		<div class="newer"><?php next_image_link( false, $older_text ); ?></div>
		<div class="older"><?php previous_image_link( false, $next_text ); ?></div>
	</div>
	<?php
	// Show all images inside parent post here.
	if ( $parent ) {
		$images = get_attached_media( 'image', $parent );
		?>
	<div class="parent-images clearfix">
		<ul class="listing-attachment-siblings clearfix">
			<?php
			foreach ( (array) $images as $img ) {
				$src = wp_get_attachment_image_src( $img->ID, 'amp-wp-small' );
				?>
			<li class="listing-item item-<?php echo esc_attr( $img->ID ); ?>">
				<a itemprop="url" rel="bookmark" href="<?php echo esc_url( get_permalink( $img->ID ) ); ?>">
					<amp-img src="<?php echo esc_url( $src[0] ); ?>"
							width="<?php echo esc_attr( $src[1] ); ?>"
							height="<?php echo esc_attr( $src[2] ); ?>">
					</amp-img>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
</div>
<?php
// Footer
amp_wp_get_footer();
