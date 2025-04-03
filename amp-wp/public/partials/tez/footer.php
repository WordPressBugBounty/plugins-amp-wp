	</div> <!-- /wrapper -->
	<?php
	$amp_wp_general_settings = get_option( 'amp_wp_general_settings' );
	$amp_wp_layout_settings  = get_option( 'amp_wp_layout_settings' );
	$non_amp_version         = ( isset( $amp_wp_layout_settings['non_amp_version'] ) && ! empty( $amp_wp_layout_settings['non_amp_version'] ) ) ? $amp_wp_layout_settings['non_amp_version'] : '';
	?>
	<footer class="amp-wp-footer <?php echo amp_wp_get_global( 'footer-custom-class', '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
		<?php if ( 1 === $non_amp_version ) : ?>
		<div class="amp-wp-non-amp-url">
			<?php
			$args = array();

			// Disable Auto Redirect for This Link.
			$mobile_auto_redirect = '';
			if ( isset( $amp_wp_general_settings['mobile_auto_redirect'] ) && ! empty( $amp_wp_general_settings['mobile_auto_redirect'] ) ) {
				$mobile_auto_redirect = $amp_wp_general_settings['mobile_auto_redirect'];
			}

			if ( $mobile_auto_redirect ) {
				$args['query-args'] = array( array( 'amp-wp-skip-redirect', true ) );
			}
			?>
			<div class="amp-wp-main-link">
				<a href="<?php echo esc_url( amp_wp_guess_non_amp_url( $args ) ); ?>" class="amp-btn dark">
					<i class="fa fa-desktop"></i> <?php amp_wp_translation_echo( 'view_desktop' ); ?>
				</a>
			</div>
		</div>
		<?php endif; ?>

		<?php
		if ( has_nav_menu( 'amp-wp-footer' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'amp-wp-footer',
					'menu_class'      => 'footer-navigation',
					'container_class' => 'amp-wp-footer-nav',
				)
			);
		}

		?>

		<?php
		$footer_copyright_text = ( isset( $amp_wp_layout_settings['footer_copyright_text'] ) && ! empty( $amp_wp_layout_settings['footer_copyright_text'] ) ) ? $amp_wp_layout_settings['footer_copyright_text'] : '';
		if ( $footer_copyright_text ) :
			?>
		<div class="amp-wp-copyright"><?php echo wp_kses_post( $footer_copyright_text ); ?></div>
		<?php endif; ?>

		<?php
		/**
		 * Analytics
		 * - Google Analytics
		 * - Facebook Pixel
		 * - Segment Analytics
		 * - Quantcast p.code
		 * - Alexa Certified Metrics Tracking
		 * - Chartbeat Tracking
		 * - comScore UDM pageview Tracking
		 * - Yandex Metrica
		 * - AFS Analytics
		 * - Adobe Analytics
		 */
		do_action( 'amp_wp_analytics_ga' );
		do_action( 'amp_wp_analytics_fbp' );
		do_action( 'amp_wp_analytics_sa' );
		do_action( 'amp_wp_analytics_qc' );
		do_action( 'amp_wp_analytics_acm' );
		do_action( 'amp_wp_analytics_cb' );
		do_action( 'amp_wp_analytics_comscore' );
		do_action( 'amp_wp_analytics_yandex_metrica' );
		do_action( 'amp_wp_analytics_afs' );
		do_action( 'amp_wp_analytics_adobe' );
		?>

		<?php
		/**
		 * Notice Bar
		 */
		do_action( 'amp_wp_notifications_bar' );
		?>

		<?php
		/**
		 * GDPR Compliance
		 */
		do_action( 'amp_wp_gdpr_compliance' );
		?>
	</footer>
	<?php amp_wp_footer(); ?>
	</body>
</html>
