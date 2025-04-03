<?php
/**
 * The template for displaying social links
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/components/social-list/social-links.php.
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
if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.

amp_wp_enqueue_block_style( 'social-list', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/social-list/social-list' );

$amp_wp_social_links_settings = get_option( 'amp_wp_social_links_settings' );
$facebook_switch              = ( isset( $amp_wp_social_links_settings['facebook_switch'] ) && ! empty( $amp_wp_social_links_settings['facebook_switch'] ) ) ? $amp_wp_social_links_settings['facebook_switch'] : '';
$facebook                     = ( isset( $amp_wp_social_links_settings['facebook'] ) && ! empty( $amp_wp_social_links_settings['facebook'] ) ) ? $amp_wp_social_links_settings['facebook'] : '';

$twitter_switch = ( isset( $amp_wp_social_links_settings['twitter_switch'] ) && ! empty( $amp_wp_social_links_settings['twitter_switch'] ) ) ? $amp_wp_social_links_settings['twitter_switch'] : '';
$twitter        = ( isset( $amp_wp_social_links_settings['twitter'] ) && ! empty( $amp_wp_social_links_settings['twitter'] ) ) ? $amp_wp_social_links_settings['twitter'] : '';

// $google_plus_switch = ( isset( $amp_wp_social_links_settings['google_plus_switch'] ) && ! empty( $amp_wp_social_links_settings['google_plus_switch'] ) ) ? $amp_wp_social_links_settings['google_plus_switch'] : '';
// $google_plus        = ( isset( $amp_wp_social_links_settings['google_plus'] ) && ! empty( $amp_wp_social_links_settings['google_plus'] ) ) ? $amp_wp_social_links_settings['google_plus'] : '';

$pinterest_switch = ( isset( $amp_wp_social_links_settings['pinterest_switch'] ) && ! empty( $amp_wp_social_links_settings['pinterest_switch'] ) ) ? $amp_wp_social_links_settings['pinterest_switch'] : '';
$pinterest        = ( isset( $amp_wp_social_links_settings['pinterest'] ) && ! empty( $amp_wp_social_links_settings['pinterest'] ) ) ? $amp_wp_social_links_settings['pinterest'] : '';

$instagram_switch = ( isset( $amp_wp_social_links_settings['instagram_switch'] ) && ! empty( $amp_wp_social_links_settings['instagram_switch'] ) ) ? $amp_wp_social_links_settings['instagram_switch'] : '';
$instagram        = ( isset( $amp_wp_social_links_settings['instagram'] ) && ! empty( $amp_wp_social_links_settings['instagram'] ) ) ? $amp_wp_social_links_settings['instagram'] : '';

$linkedin_switch = ( isset( $amp_wp_social_links_settings['linkedin_switch'] ) && ! empty( $amp_wp_social_links_settings['linkedin_switch'] ) ) ? $amp_wp_social_links_settings['linkedin_switch'] : '';
$linkedin        = ( isset( $amp_wp_social_links_settings['linkedin'] ) && ! empty( $amp_wp_social_links_settings['linkedin'] ) ) ? $amp_wp_social_links_settings['linkedin'] : '';

$youtube_switch = ( isset( $amp_wp_social_links_settings['youtube_switch'] ) && ! empty( $amp_wp_social_links_settings['youtube_switch'] ) ) ? $amp_wp_social_links_settings['youtube_switch'] : '';
$youtube        = ( isset( $amp_wp_social_links_settings['youtube'] ) && ! empty( $amp_wp_social_links_settings['youtube'] ) ) ? $amp_wp_social_links_settings['youtube'] : '';

$email_switch = ( isset( $amp_wp_social_links_settings['email_switch'] ) && ! empty( $amp_wp_social_links_settings['email_switch'] ) ) ? $amp_wp_social_links_settings['email_switch'] : '';
$email        = ( isset( $amp_wp_social_links_settings['email'] ) && ! empty( $amp_wp_social_links_settings['email'] ) ) ? $amp_wp_social_links_settings['email'] : '';
?>
<div class="amp-social-list-wrapper">
	<ul class="social-list">
		<?php if ( '1' == $facebook_switch && ! empty( $facebook ) ) : ?>
		<li class="facebook">
			<a href="<?php echo esc_url( $facebook ); ?>" title="<?php _e( 'Facebook', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
		</li>
		<?php endif; ?>

		<?php if ( '1' == $twitter_switch && ! empty( $twitter ) ) : ?>
		<li class="twitter">
			<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" title="<?php _e( 'Twitter', 'amp-wp' ); ?>"><i class="fa fa-twitter"></i></a>
		</li>
		<?php endif; ?>

		<!--
		< ?php if ( '1' == $google_plus_switch && ! empty( $google_plus ) ) : ?>
		<li class="google_plus">
			<a href="< ?php echo esc_url( $google_plus ); ?>" title="< ?php _e( 'Google Plus', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
		</li>
		< ?php endif; ?>
		-->

		<?php if ( '1' == $pinterest_switch && ! empty( $pinterest ) ) : ?>
		<li class="pinterest">
			<a href="<?php echo esc_url( $pinterest ); ?>" title="<?php _e( 'Pinterest', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
		</li>
		<?php endif; ?>

		<?php if ( '1' == $instagram_switch && ! empty( $instagram ) ) : ?>
		<li class="instagram">
			<a href="<?php echo esc_url( $instagram ); ?>" title="<?php _e( 'Instagram', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
		</li>
		<?php endif; ?>

		<?php if ( '1' == $linkedin_switch && ! empty( $linkedin ) ) : ?>
		<li class="linkedin">
			<a href="<?php echo esc_url( $linkedin ); ?>" title="<?php _e( 'LinkedIn', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
		</li>
		<?php endif; ?>

		<?php if ( '1' == $youtube_switch && ! empty( $youtube ) ) : ?>
		<li class="youtube">
			<a href="<?php echo esc_url( $youtube ); ?>" title="<?php _e( 'YouTube', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-youtube"></i></a>
		</li>
		<?php endif; ?>

		<?php if ( '1' == $email_switch && ! empty( $email ) ) : ?>
		<li class="youtube">
			<a href="mailto:<?php echo antispambot( $email ); ?>" title="<?php _e( 'Email', 'amp-wp' ); ?>" target="_blank"><i class="fa fa-envelope-open"></i></a>
		</li>
		<?php endif; ?>
	</ul>
</div>
