<?php
/**
 * The Template for Displaying Sidebar Panel
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/sidebar.php.
 *
 * HOWEVER, on occasion AMP WP will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://help.ampwp.io/article-categories/developer-documentation/
 * @package Amp_WP/Templates
 * @version 1.0.0
 */

amp_wp_enqueue_block_style( 'sidebar', AMP_WP_TEMPLATE_DIR_CSS . 'themes/' . AMP_WP_THEME_NAME . '/components/sidebar/sidebar' );
$header_layout          = ( ! empty( amp_wp_get_option( 'amp-wp-header-preset-options' ) ) ) ? amp_wp_get_option( 'amp-wp-header-preset-options' ) : 'logo-left-simple';
$site_branding          = amp_wp_get_branding_info( 'sidebar' );
$amp_wp_layout_settings = get_option( 'amp_wp_layout_settings' );
$sidebar_copyright_text = ( isset( $amp_wp_layout_settings['sidebar_copyright_text'] ) && ! empty( $amp_wp_layout_settings['sidebar_copyright_text'] ) ) ? $amp_wp_layout_settings['sidebar_copyright_text'] : '';
?>
<amp-sidebar id="amp-wpSidebar" layout="nodisplay" class="amp-wp-sidebar" side="<?php amp_wp_direction(); ?>">
	<div class="sidebar-container">
		<button on="tap:amp-wpSidebar.close" class="close-sidebar<?php echo ( 'logo-left-simple' != $header_layout ) ? ' right' : ''; ?>">
			<i class="fa fa-close" aria-hidden="true"></i>
		</button>
		<div class="sidebar-brand type-<?php echo empty( $site_branding['logo'] ) ? 'text' : 'logo'; ?>">
			<div class="logo">
				<?php
				if ( ! empty( $site_branding['logo-tag'] ) ) {
					echo $site_branding['logo-tag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					echo $site_branding['name']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
			<?php if ( ! empty( $site_branding['description'] ) ) { ?>
				<div class="brand-description"><?php echo $site_branding['description']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<?php } ?>
		</div>

		<?php
		if ( has_nav_menu( 'amp-wp-sidebar-nav' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'amp-wp-sidebar-nav',
					'items_wrap'     => '<nav id="%1$s" itemscope itemtype="http://schema.org/SiteNavigationElement" class="%2$s">%3$s</nav>',
					'container'      => false,
					'menu_id'        => 'menu',
					'menu_class'     => 'amp-menu',
				)
			);
		} elseif ( is_user_logged_in() ) {
			echo '<div class="no-sidebar-nav">';
			$user_can_edit_menu = current_user_can( 'edit_theme_options' );
			if ( $user_can_edit_menu ) {
				printf( '<a href="%s" class="wrap">', esc_attr( admin_url( '/nav-menus.php?action=locations' ) ) );
			}
			esc_html_e( 'Select a menu for "AMP Sidebar"', 'amp-wp' );
			if ( $user_can_edit_menu ) {
				echo '</a>';
			}
			echo '</div>';
		}
		?>
		<div class="sidebar-footer">
		<?php
		if ( $sidebar_copyright_text ) {
			echo '<p class="sidebar-footer-text">' . wp_kses_post( $sidebar_copyright_text ) . '</p>';
		}
		// Social Link Template.
		amp_wp_template_part( 'components/social-list/social-links' );
		?>
		</div>
	</div>
</amp-sidebar>
