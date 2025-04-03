<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://pixelative.co
 * @since      1.0.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials
 */

$nav_array = array(
	array(
		'menu-title'      => __( 'Welcome', 'amp-wp' ),
		'menu-page-class' => 'amp-wp-welcome',
		'menu-url'        => add_query_arg( array( 'page' => 'amp-wp-welcome' ), 'admin.php' ),
		'menu-class'      => 'welcome',
	),
	array(
		'menu-title'      => __( 'Settings', 'amp-wp' ),
		'menu-page-class' => 'amp-wp-settings',
		'menu-url'        => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
		'menu-class'      => 'settings',
		'sub-menu-links'  => array(
			'general-url'      => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
			'layout-url'       => add_query_arg( array( 'page' => 'amp-wp-settings#settings-layout' ), 'admin.php' ),
			'social-links-url' => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
			'analytics-url'    => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
			'translation-url'  => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
			'notice-bar-url'   => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
			'gdpr-url'         => add_query_arg( array( 'page' => 'amp-wp-settings' ), 'admin.php' ),
		),
	),
	array(
		'menu-title'      => __( 'Customize AMP Theme', 'amp-wp' ),
		'menu-page-class' => '',
		'menu-url'        => add_query_arg(
			array(
				'return'    => urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
				'url'       => urlencode( amp_wp_site_url() ),
				'autofocus' => array( 'panel' => 'amp-wp-panel' ),
			),
			'customize.php'
		),
		'menu-class'      => 'customize',
	),
	array(
		'menu-title'      => __( 'Add-Ons', 'amp-wp' ),
		'menu-page-class' => 'amp-wp-add-ons',
		'menu-url'        => add_query_arg( array( 'page' => 'amp-wp-add-ons' ), 'admin.php' ),
		'menu-class'      => 'add-ons',
	),
	array(
		'menu-title'      => __( 'Help', 'amp-wp' ),
		'menu-page-class' => 'amp-wp-help',
		'menu-url'        => add_query_arg( array( 'page' => 'amp-wp-help' ), 'admin.php' ),
		'menu-class'      => 'help',
	),
	array(
		'menu-title'      => __( 'System Status', 'amp-wp' ),
		'menu-page-class' => 'amp-wp-system-status',
		'menu-url'        => add_query_arg( array( 'page' => 'amp-wp-system-status' ), 'admin.php' ),
		'menu-class'      => 'system-status',
	),
);

$amp_wp_wordpress_version_check = amp_wp_version_check_using_wpapi();
?>

<!-- Start Header -->
<div class="amp-wp-header">
	<div class="amp-wp-logo">
		<img src="<?php echo esc_url( AMP_WP_DIR_URL . 'admin/images/amp-wp-logo.svg' ); ?>" alt="Welcome AMP WP" />
	</div>
	<div class="amp-wp-title">
		<h1><?php esc_html_e( 'AMP WP', 'amp-wp' ); ?></h1>
		<h3><?php echo esc_attr( AMP_WP_SLOGAN ); ?></h3>
		<div class="amp-wp-version">
			<h4 class="amp-wp-v-i">
				<?php esc_html_e( 'Installed: ', 'amp-wp' ); ?>
				<strong><?php printf( esc_html__( 'v%s', 'amp-wp' ), AMP_WP_VERSION ); ?></strong>
			</h4>
			<h4 class="amp-wp-v-sep"><?php esc_html_e( '|', 'amp-wp' ); ?></h4>
			<h4 class="amp-wp-v-l">
				<?php esc_html_e( 'Latest: ', 'amp-wp' ); ?>
				<strong><?php printf( esc_html__( 'v%s', 'amp-wp' ), $amp_wp_wordpress_version_check ); ?></strong>
				<?php if ( $amp_wp_wordpress_version_check > AMP_WP_VERSION ) { ?>
				<a href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>"><?php esc_html_e( 'Update(s) available!', 'amp-wp' ); ?></a>
				<?php } ?>
			</h4>
		</div>
	</div>
</div>

<hr class="amp-wp-section-sep">

<div class="amp-wp-htabs">
	<?php $i = 1; foreach ( $nav_array as $val ) : ?>
	<a href="<?php echo esc_url( $val['menu-url'] ); ?>" class="nav-tab <?php echo sanitize_html_class( $val['menu-class'] ); ?> <?php echo ( sanitize_html_class( $val['menu-page-class'] ) == $page ) ? 'nav-tab-active' : ''; ?>"><span><?php echo intval( $i ); ?></span><?php echo esc_attr( $val['menu-title'] ); ?></a>
		<?php
		$i++;
endforeach;
	?>
</div>
<hr class="amp-wp-section-sep">
<!-- End Header -->
