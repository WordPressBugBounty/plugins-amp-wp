<?php
/**
 * The Template for Displaying Ads
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/components/notification/notification.php.
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
?>
<amp-user-notification layout="nodisplay" id="amp-user-notification">
	<p><?php echo esc_attr( $noticebar_consent ); ?></p>
	<button on="tap:amp-user-notification.dismiss" class="amp-btn"><?php echo esc_attr( $noticebar_accept_button_text ); ?></button>
</amp-user-notification>
