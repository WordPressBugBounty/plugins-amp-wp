<?php
/**
 * The template for displaying Social Share
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/components/social-list/social-share.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://help.ampwp.io/
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.

$amp_wp_layout_settings     = get_option( 'amp_wp_layout_settings' );
$social_share_on_post       = ( isset( $amp_wp_layout_settings['social_share_on_post'] ) && ! empty( $amp_wp_layout_settings['social_share_on_post'] ) ) ? $amp_wp_layout_settings['social_share_on_post'] : '';
$social_share_on_post_count = ( isset( $amp_wp_layout_settings['social_share_on_post_count'] ) && ! empty( $amp_wp_layout_settings['social_share_on_post_count'] ) ) ? $amp_wp_layout_settings['social_share_on_post_count'] : '';
$social_share_links         = ( isset( $amp_wp_layout_settings['social_share_links'] ) && ! empty( $amp_wp_layout_settings['social_share_links'] ) ) ? $amp_wp_layout_settings['social_share_links'] : array();

if ( '1' != $social_share_on_post ) :
	return;
endif;

// Enqueue AMP Social Share Script.
amp_wp_enqueue_script( 'amp-social-share', 'https://cdn.ampproject.org/v0/amp-social-share-0.1.js' );

amp_wp_enqueue_block_style( 'social-list', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/social-list/social-list' );
$in_customizer = is_customize_preview();

$show_count          = $social_share_on_post_count === 'total' || $social_share_on_post_count === 'total-and-site';
$show_count_per_site = $social_share_on_post_count === 'total-and-site';

$active_sites = amp_wp_get_theme_mod( 'amp-wp-post-social-share' );
unset( $active_sites['rand'] );
?>
<?php if ( $in_customizer ) { ?>
	<style>
		<?php if ( ! $show_count ) { ?>
		.post-social-list .share-handler .number { display: none; }
		<?php } ?>

		<?php if ( ! $show_count_per_site ) { ?>
		.post-social-list .number { display: none; }
		<?php } ?>
	</style>
<?php } ?>

<div class="amp-social-list-wrapper share-list post-social-list">
	<?php $count_labels = ( $show_count || $in_customizer ) ? amp_wp_social_shares_count( $active_sites ) : array(); ?>

	<span class="share-handler post-share-btn">
		<i class="fa fa-share-alt" aria-hidden="true"></i>
		<?php if ( ( $total_count = array_sum( $count_labels ) ) && ( $show_count || $in_customizer ) ) { ?>
		<span class="number"><?php echo amp_wp_human_number_format( $total_count ); ?></span>
		<?php } else { ?>
		<span class="text"><?php amp_wp_translation_echo( 'share' ); ?></span>
		<?php } ?>
	</span>
	<?php if ( is_array( $social_share_links ) && ! empty( $social_share_links ) ) { ?>
	<ul class="social-list clearfix">
		<?php
		foreach ( $social_share_links as $site_key ) {
			$count_label = ( $in_customizer || $show_count_per_site ) && isset( $count_labels[ $site_key ] ) ? $count_labels[ $site_key ] : 0;
			echo amp_wp_social_share_get_li( $site_key, false, $count_label ); // escaped before.
		}
		?>
	</ul>
	<?php } ?>
</div>
