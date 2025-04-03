<?php
/**
 * The Template for Displaying Ads
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/components/gdpr/gdpr.php.
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
<amp-geo layout="nodisplay">
	<script type="application/json">
	{
		"ISOCountryGroups": {
			"eu" : [ <?php echo '"' . implode( '","', array_values( $gdpr_countries ) ) . '"'; ?> ]
		}
	}
	</script>
</amp-geo>
<amp-consent id="ampwpconsent" layout="nodisplay">
	<script type="application/json">
	{
		"consents": {
			"eu": {
				"promptIfUnknownForGeoGroup": "eu",
				"promptUI": "gdpr_by_country"
			}
		},
		"postPromptUI": "post-consent-ui"
	}
	</script>
	<div id="gdpr_by_country" class="gdpr">
		<div class="gdpr-wrapper">
			<!-- <div class="dismiss-button" role="button" tabindex="0" on="tap:ampwpconsent.dismiss">< ?php _e('X', 'amp-wp'); ?></div> -->
			<div class="gdpr-content">
				<div class="gdpr-title">
					<h3><?php echo esc_attr( $gdpr_headline_text ); ?></h3>
					<?php if ( ! empty( $gdpr_message ) ) : ?>
					<p><?php echo esc_attr( $gdpr_message ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $gdpr_privacy_page ) ) : ?>
					<div class="gdpr-privacy-policy-content">
						<?php if ( ! empty( $gdpr_for_more_privacy_info ) ) : ?>
						<span><?php echo esc_attr( $gdpr_for_more_privacy_info ); ?></span>
						<?php endif; ?>
						<a class="gdpr_fmi pri_page_link" href=<?php echo esc_url( $privacy_page ); ?> target="_blank"><?php echo esc_attr( $gdpr_privacy_page_button_text ); ?></a>
					</div>
				<?php endif; ?>
			</div>
			<div id="gdpr_yn" class="gdpr-actions">
				<div class="gdpr-btns">
					<form method="post" class="acp" action-xhr="<?php echo esc_url( $form_url ); ?>" target="_top">
						<button type="submit" on="tap:ampwpconsent.accept" class="amp-btn gdpr-amp-btn"><?php echo esc_attr( $gdpr_accept_button_text ); ?></button>
					</form>
					<form method="post" class="rej" action-xhr="<?php echo esc_url( $form_url ); ?>" target="_top">
						<button type="submit" on="tap:ampwpconsent.reject" class="amp-btn amp-btn-default"><?php echo esc_attr( $gdpr_reject_button_text ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="post-consent-ui">
		<button on="tap:ampwpconsent.prompt();" class="amp-btn"><?php echo esc_attr( $settings ); ?></button>
	</div>
</amp-consent>
