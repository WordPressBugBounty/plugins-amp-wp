<?php
/**
 * The Template for Displaying Archive Title
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/template-parts/archive-title.php.
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

amp_wp_enqueue_block_style( 'archive', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/pages/archive/archive' );
$title = amp_wp_get_archive_title_fields();
?>
<header class="amp-wp-page-header">
	<?php
	if ( ! empty( $title['pre_title'] ) ) {
		echo '<p class="pre-title">', $title['pre_title'], '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</header>

<div class="amp-wp-container">
	<div class="archive-wrapper">
		<h1 class="page-title"><?php echo $title['icon'] . '' . $title['title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
		<?php echo $title['description']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>
