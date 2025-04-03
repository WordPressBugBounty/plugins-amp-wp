<!DOCTYPE html>
<html <?php amp_wp_language_attributes(); ?> amp>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1">
		<?php amp_wp_head(); ?>
	</head>
	<?php
	$header_layout          = ( ! empty( amp_wp_get_option( 'amp-wp-header-preset-options' ) ) ) ? amp_wp_get_option( 'amp-wp-header-preset-options' ) : 'logo-left-simple';
	$body_class             = 'body';
	$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
	$is_show_search         = ( isset( $amp_wp_layout_settings['is_show_search'] ) && ! empty( $amp_wp_layout_settings['is_show_search'] ) ) ? $amp_wp_layout_settings['is_show_search'] : '';
	$is_sticky_header       = ( isset( $amp_wp_layout_settings['is_sticky_header'] ) && ! empty( $amp_wp_layout_settings['is_sticky_header'] ) ) ? $amp_wp_layout_settings['is_sticky_header'] : '';
	$is_show_sidebar        = ( isset( $amp_wp_layout_settings['is_show_sidebar'] ) && ! empty( $amp_wp_layout_settings['is_show_sidebar'] ) ) ? $amp_wp_layout_settings['is_show_sidebar'] : '';

	if ( is_search() ) {
		$body_class .= ' search search-results';
	}
	if ( '1' == $is_sticky_header ) {
		$body_class .= ' sticky-nav';
	}
	?>
	<body class="<?php echo $body_class; ?>" <?php echo ( $header_height = amp_wp_get_option( 'amp-wp-header-height' ) ) ? 'style="padding-top: ' . $header_height . 'px "' : ''; ?>>
		<?php
		do_action( 'amp_wp_template_body_start' );
		do_action( 'amp_wp_body_beginning' );
		if ( '1' == $is_show_sidebar ) {
			amp_wp_get_sidebar();
		}
		?>
		<header itemscope itemtype="https://schema.org/WPHeader" class="site-header" <?php echo ( $header_height = amp_wp_get_option( 'amp-wp-header-height' ) ) ? 'style="height: ' . $header_height . 'px "' : ''; ?>>
			<div class="flex-row<?php echo ( 'logo-left-simple' == $header_layout ) ? '' : ' logo-center'; ?>">

				<!-- Logo -->
				<div id="logo" class="flex-col logo">
					<?php echo amp_wp_default_theme_logo(); ?>
				</div>

				<?php if ( 'logo-left-simple' == $header_layout ) : ?>
				<div class="flex-col flex-grow flex-right elements">
					<ul class="header-nav right">
						<?php if ( '1' == $is_show_search ) { ?>
						<li><a href="<?php echo esc_url( amp_wp_get_search_page_url() ); ?>" class="navbar-search"><i class="fa fa-search" aria-hidden="true"></i></a></li>
						<?php } ?>
						<?php if ( '1' == $is_show_sidebar ) { ?>
						<li><button class="fa fa-bars navbar-toggle" on="tap:amp-wpSidebar.toggle"></button></li>
						<?php } ?>
					</ul>
				</div>
				<?php else : ?>

				<!-- Left Element -->
				<div class="flex-col flex-left">
					<ul class="header-nav left">
						<?php if ( '1' == $is_show_sidebar ) { ?>
						<li><button class="fa fa-bars navbar-toggle" on="tap:amp-wpSidebar.toggle"></button></li>
						<?php } ?>
					</ul>
				</div>
				<!-- Right Element -->
				<div class="flex-col flex-right">
					<ul class="header-nav right">
						<?php if ( '1' == $is_show_search ) { ?>
						<li><a href="<?php echo esc_url( amp_wp_get_search_page_url() ); ?>" class="navbar-search"><i class="fa fa-search" aria-hidden="true"></i></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</header><!-- End Main Nav -->

		<!-- Ad Location 1: After Header (In All Pages) -->
		<?php amp_wp_show_ad_location( 'amp_wp_header_after' ); ?>

		<div class="amp-wp-wrapper">
