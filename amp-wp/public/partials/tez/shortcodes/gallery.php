<?php

$atts = amp_wp_get_prop( 'Amp_WP_Carousel_Component' );

/**
 * @var Amp_WP_IMG_Component $img_component
 */
$img_component = Amp_WP_Component::instance( 'Amp_WP_IMG_Component' );

if ( empty( $atts['attachments'] ) ) {
	return;
}

?>
	<amp-carousel layout="responsive" type="slides" <?php amp_wp_hw_attr(); ?> autoplay>
		<?php
		foreach ( $atts['attachments'] as $attachment ) {
			echo $img_component->print_attachment_image( $attachment ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</amp-carousel>
<?php
