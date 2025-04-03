<?php
/**
 * System Status Admin View
 *
 * @link        https://pixelative.co
 * @since       1.4.0
 *
 * @package     Amp_WP
 * @subpackage  Amp_WP/admin/partials
 */

?>
<div class="amp-wp-adb">
	<?php require_once AMP_WP_DIR_PATH . 'admin/partials/amp-wp-admin-header.php'; ?>

	<div class="amp-wp-content-wrap">
		<div class="amp-wp-content-header">
			<h2 class="amp-wp-content-title"><?php esc_html_e( 'System Status', 'amp-wp' ); ?></h2>
			<div class="amp-wp-content-btn-toolbar">
				<a href="#" class="button-primary debug-report"><?php esc_html_e( 'Get System Report', 'amp-wp' ); ?></a>
			</div>
		</div>

		<div class="amp-wp-content-body amp-wp-system-status">
			<p class="system-report-msg"><?php esc_html_e( 'Click the Get System Report button at the top right to produce a report, then copy and paste into your support ticket.', 'amp-wp' ); ?></p>
			<div class="get-system-status"></div>
			<div id="debug-report">
				<textarea id="debug-report-textarea" readonly="readonly"></textarea>
				<p class="submit"><button id="copy-for-support" class="button-primary" href="#" data-tip="<?php esc_html_e( 'Copied!', 'amp-wp' ); ?>"><?php esc_html_e( 'Copy for Support', 'amp-wp' ); ?></button></p>
			</div>

			<!-- WordPress Environment - START -->
			<table class="widefat amp-wp-table amp-wp-help-table" cellspacing="0">
				<thead>
					<tr>
						<th colspan="3" data-export-label="WordPress Environment"><?php esc_html_e( 'WordPress Environment', 'amp-wp' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td data-export-label="Home URL"><?php esc_html_e( 'Home URL', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The URL of your site\'s homepage.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_url_raw( $environment['home_url'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="Site URL"><?php esc_html_e( 'Site URL', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The root URL of your site.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_url_raw( $environment['site_url'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="AMP WP Version"><?php esc_html_e( 'AMP WP Version', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The version of AMP WP installed on your site.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_html( $environment['version'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="WP Version"><?php esc_html_e( 'WordPress Version', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The version of WordPress installed on your site.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							$latest_version = get_transient( 'amp_wp_system_status_wp_version_check' );

							if ( false === $latest_version ) {
								$response     = wp_safe_remote_get( 'https://api.wordpress.org/core/version-check/1.7/' );
								$api_response = json_decode( wp_remote_retrieve_body( $response ), true );

								if ( $api_response && isset( $api_response['offers'], $api_response['offers'][0], $api_response['offers'][0]['version'] ) ) {
									$latest_version = $api_response['offers'][0]['version'];
								} else {
									$latest_version = $environment['wp_version'];
								}
								set_transient( 'amp_wp_system_status_wp_version_check', $latest_version, DAY_IN_SECONDS );
							}

							if ( version_compare( $environment['wp_version'], $latest_version, '<' ) ) {
								/* Translators: %1$s: Current version, %2$s: New version */
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - There is a newer version of WordPress available (%2$s)', 'amp-wp' ), esc_html( $environment['wp_version'] ), esc_html( $latest_version ) ) . '</mark>';
							} else {
								echo '<mark class="yes">' . esc_html( $environment['wp_version'] ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="WP Multisite"><?php esc_html_e( 'WordPress Multisite', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Whether or not you have WordPress Multisite enabled.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo ( $environment['wp_multisite'] ) ? '&#10004;' : '&ndash;'; ?></td>
					</tr>
					<tr>
						<td data-export-label="WP Memory Limit"><?php esc_html_e( 'WordPress Memory Limit', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
						<?php
						if ( $environment['wp_memory_limit'] < 67108864 ) {
							/* Translators: %1$s: Memory limit, %2$s: Docs link. */
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting memory to at least 64MB. See: %2$s', 'amp-wp' ), esc_html( size_format( $environment['wp_memory_limit'] ) ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'amp-wp' ) . '</a>' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( size_format( $environment['wp_memory_limit'] ) ) . '</mark>';
						}
						?>
						</td>
					</tr>
					<tr>
						<td data-export-label="WP Debug Mode"><?php esc_html_e( 'WP Debug Mode', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Displays whether or not WordPress is in Debug Mode.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
						<?php if ( $environment['wp_debug_mode'] ) : ?>
							<mark class="yes">&#10004;</mark>
						<?php else : ?>
							<mark class="no">&ndash;</mark>
						<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="WP Cron"><?php esc_html_e( 'WordPress Cron', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Displays whether or not WP Cron Jobs are enabled.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php if ( $environment['wp_cron'] ) : ?>
								<mark class="yes">&#10004;</mark>
							<?php else : ?>
								<mark class="no">&ndash;</mark>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Language"><?php esc_html_e( 'Language', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The current language used by WordPress. Default = English', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_attr( get_locale() ); ?></td>
					</tr>
					<tr>
						<td data-export-label="External object cache"><?php esc_html_e( 'External Object Cache', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo wp_kses_post( amp_wp_help_tip( esc_html__( 'Displays whether or not WordPress is using an external object cache.', 'amp-wp' ) ) ); ?></td>
						<td>
							<?php if ( $environment['external_object_cache'] ) : ?>
								<mark class="yes">&#10004;</mark>
							<?php else : ?>
								<mark class="no">&ndash;</mark>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- WordPress Environment - END -->

			<!-- Server Environment - START -->
			<table class="widefat amp-wp-table amp-wp-help-table" cellspacing="0">
				<thead>
					<tr>
						<th colspan="3" data-export-label="Server Environment"><?php esc_html_e( 'Server Environment', 'amp-wp' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td data-export-label="Server Info"><?php esc_html_e( 'Server Info:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Information about the web server that is currently hosting your site.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_html( $environment['server_info'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="PHP Version"><?php esc_html_e( 'PHP Version:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The version of PHP installed on your hosting server.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							if ( version_compare( $environment['php_version'], '7.2', '>=' ) ) {
								echo '<mark class="yes">' . esc_html( $environment['php_version'] ) . '</mark>';
							} else {
								$update_link = ' <a href="https://wordpress.org/about/requirements/" target="_blank">' . esc_html__( 'WordPress Requirements', 'amp-wp' ) . '</a>';
								$class       = 'error';

								if ( version_compare( $environment['php_version'], '5.6', '<' ) ) {
									$notice = '<span class="dashicons dashicons-warning"></span> ' . __( 'AMP WP will run under this version of PHP, however, it has reached end of life. We recommend using PHP version 7.2 or above for greater performance and security.', 'amp-wp' ) . $update_link;
								} elseif ( version_compare( $environment['php_version'], '7.2', '<' ) ) {
									$notice = __( 'WordPress recommend PHP version 7.2 or above for greater performance and security.', 'amp-wp' ) . $update_link;
									$class  = 'recommendation';
								}
								echo '<mark class="' . esc_attr( $class ) . '">' . esc_html( $environment['php_version'] ) . ' - ' . wp_kses_post( $notice ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<?php if ( function_exists( 'ini_get' ) ) : ?>
						<tr>
							<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP Post Max Size:', 'amp-wp' ); ?></td>
							<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The largest file size that can be contained in one post.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
							<td><?php echo esc_html( size_format( $environment['php_post_max_size'] ) ); ?></td>
						</tr>
						<tr>
							<td data-export-label="PHP Time Limit"><?php esc_html_e( 'PHP Time Limit:', 'amp-wp' ); ?></td>
							<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
							<td>
								<?php
								$time_limit = $environment['php_max_execution_time'];

								if ( 180 > $time_limit && 0 != $time_limit ) {
									/* translators: %1$s: Current value. %2$s: URL. */
									echo '<mark class="error">' . sprintf( __( '%1$s - We recommend setting max execution time to at least 180.<br />See: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing max execution to PHP</a>', 'amp-wp' ), $time_limit, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>'; // WPCS: XSS ok.
								} else {
									echo '<mark class="yes">' . esc_html( $time_limit ) . '</mark>';
								}
								?>
							</td>
						</tr>
						<tr>
							<td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP Max Input Vars:', 'amp-wp' ); ?></td>
							<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
							<?php
							$registered_navs  = get_nav_menu_locations();
							$menu_items_count = array(
								'0' => '0',
							);
							foreach ( $registered_navs as $handle => $registered_nav ) {
								$navigation_menu_object = wp_get_nav_menu_object( $registered_nav ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
								if ( $navigation_menu_object ) {
									$menu_items_count[] = $navigation_menu_object->count;
								}
							}

							$max_items           = max( $menu_items_count );
							$required_input_vars = $max_items * 12;
							?>
							<td>
								<?php
								$max_input_vars      = $environment['php_max_input_vars'];
								$required_input_vars = $required_input_vars + ( 500 + 1000 );
								// 1000 = theme options
								if ( $max_input_vars < $required_input_vars ) {
									/* translators: %1$s: Current value. $2%s: Recommended value. %3$s: URL. */
									echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'amp-wp' ), $max_input_vars, '<strong>' . $required_input_vars . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>'; // WPCS: XSS ok.
								} else {
									echo '<mark class="yes">' . esc_attr( $max_input_vars ) . '</mark>';
								}
								?>
							</td>
						</tr>
						<tr>
							<td data-export-label="cURL Version"><?php esc_html_e( 'cURL version', 'amp-wp' ); ?>:</td>
							<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The version of cURL installed on your server.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
							<td><?php echo esc_html( $environment['curl_version'] ); ?></td>
						</tr>
						<tr>
							<td data-export-label="SUHOSIN Installed"><?php esc_html_e( 'SUHOSIN Installed:', 'amp-wp' ); ?></td>
							<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
							<td><?php echo ( $environment['suhosin_installed'] ) ? '&#10004;' : '&ndash;'; ?></td>
						</tr>
						<?php if ( extension_loaded( 'suhosin' ) ) : ?>
							<tr>
								<td data-export-label="Suhosin Post Max Vars"><?php esc_html_e( 'Suhosin Post Max Vars', 'amp-wp' ); ?>:</td>
								<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
								<?php
								$registered_navs  = get_nav_menu_locations();
								$menu_items_count = array(
									'0' => '0',
								);
								foreach ( $registered_navs as $handle => $registered_nav ) {
									$navigation_menu_object = wp_get_nav_menu_object( $registered_nav ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
									if ( $navigation_menu_object ) {
										$menu_items_count[] = $navigation_menu_object->count;
									}
								}

								$max_items           = max( $menu_items_count );
								$required_input_vars = $max_items * 12;
								?>
								<td>
									<?php
									$max_input_vars      = ini_get( 'suhosin.post.max_vars' );
									$required_input_vars = $required_input_vars + ( 500 + 1000 );

									if ( $max_input_vars < $required_input_vars ) {
										/* translators: %1$s: Current value. $2%s: Recommended value. %3$s: URL. */
										echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'amp-wp' ), $max_input_vars, '<strong>' . ( $required_input_vars ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>'; // WPCS: XSS ok.
									} else {
										echo '<mark class="yes">' . esc_attr( $max_input_vars ) . '</mark>';
									}
									?>
								</td>
							</tr>
							<tr>
								<td data-export-label="Suhosin Request Max Vars"><?php esc_html_e( 'Suhosin Request Max Vars:', 'amp-wp' ); ?></td>
								<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
								<?php
								$registered_navs  = get_nav_menu_locations();
								$menu_items_count = array(
									'0' => '0',
								);
								foreach ( $registered_navs as $handle => $registered_nav ) {
									$navigation_menu_object = wp_get_nav_menu_object( $registered_nav ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
									if ( $navigation_menu_object ) {
										$menu_items_count[] = $navigation_menu_object->count;
									}
								}

								$max_items           = max( $menu_items_count );
								$required_input_vars = ini_get( 'suhosin.request.max_vars' );
								?>
								<td>
									<?php
									$max_input_vars      = ini_get( 'suhosin.request.max_vars' );
									$required_input_vars = $required_input_vars + ( 500 + 1000 );

									if ( $max_input_vars < $required_input_vars ) {
										/* translators: %1$s: Current value. $2%s: Recommended value. %3$s: URL. */
										echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'amp-wp' ), $max_input_vars, '<strong>' . ( $required_input_vars + ( 500 + 1000 ) ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>'; // WPCS: XSS ok.
									} else {
										echo '<mark class="yes">' . esc_attr( $max_input_vars ) . '</mark>';
									}
									?>
								</td>
							</tr>
							<tr>
								<td data-export-label="Suhosin Post Max Value Length"><?php esc_html_e( 'Suhosin Post Max Value Length:', 'amp-wp' ); ?></td>
								<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Defines the maximum length of a variable that is registered through a POST request.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
								<td>
								<?php
									$suhosin_max_value_length     = ini_get( 'suhosin.post.max_value_length' );
									$recommended_max_value_length = 2000000;

								if ( $suhosin_max_value_length < $recommended_max_value_length ) {
									/* translators: %1$s: Current value. $2%s: Recommended value. %3$s: URL. */
									echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Post Max Value Length limitation may prohibit the Theme Options data from being saved to your database. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Suhosin Configuration Info</a>.', 'amp-wp' ), $suhosin_max_value_length, '<strong>' . $recommended_max_value_length . '</strong>', 'http://suhosin.org/stories/configuration.html' ) . '</mark>'; // WPCS: XSS ok.
								} else {
									echo '<mark class="yes">' . esc_attr( $suhosin_max_value_length ) . '</mark>';
								}
								?>
								</td>
							</tr>
						<?php endif; ?>
					<?php endif; ?>
					<tr>
						<td data-export-label="ZipArchive"><?php esc_html_e( 'ZipArchive:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'ZipArchive is required for importing AMP WP Option Settings. They are used to import and export zip files.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo class_exists( 'ZipArchive' ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">ZipArchive is not installed on your server, but is required if you need to import demo content.</mark>'; ?></td>
					</tr>
					<tr>
						<td data-export-label="MySQL Version"><?php esc_html_e( 'MySQL Version:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The version of MySQL installed on your hosting server.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							if ( version_compare( $environment['mysql_version'], '5.6', '<' ) && ! strstr( $environment['mysql_version_string'], 'MariaDB' ) ) {
								/* Translators: %1$s: MySQL version, %2$s: Recommended MySQL version. */
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend a minimum MySQL version of 5.6. See: %2$s', 'amp-wp' ), esc_html( $environment['mysql_version_string'] ), '<a href="https://wordpress.org/about/requirements/" target="_blank">' . esc_html__( 'WordPress requirements', 'amp-wp' ) . '</a>' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . esc_html( $environment['mysql_version_string'] ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max Upload Size:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The largest file size that can be uploaded to your WordPress installation.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_html( size_format( $environment['max_upload_size'] ) ); ?></td>
					</tr>
					<tr>
						<td data-export-label="Default Timezone is UTC"><?php esc_html_e( 'Default timezone is UTC', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The default timezone for your server.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							if ( 'UTC' !== $environment['default_timezone'] ) {
								/* Translators: %s: default timezone.. */
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Default timezone is %s - it should be UTC', 'amp-wp' ), esc_html( $environment['default_timezone'] ) ) . '</mark>';
							} else {
								echo '<mark class="yes">&#10004;</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="DOMDocument"><?php esc_html_e( 'DOMDocument:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo '<span class="help_tip" data-tip="' . esc_attr__( 'DOMDocument is required for document traversing to properly function.', 'amp-wp' ) . '"><i class="amp-wp-admin-icon-question"></i></span>'; ?></td>
						<td>
						<?php
						if ( $environment['domdocument_enabled'] ) {
							echo '<mark class="yes">&#10004;</mark>';
						} else {
							/* Translators: %s: classname and link. */
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'amp-wp' ), '<a href="https://php.net/manual/en/class.domdocument.php">DOMDocument</a>' ) . '</mark>';
						}
						?>
						</td>
					</tr>
					<tr>
						<td data-export-label="GZip"><?php esc_html_e( 'GZip', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'GZip (gzopen) is used to make your site load faster.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							if ( $environment['gzip_enabled'] ) {
								echo '<mark class="yes">&#10004;</mark>';
							} else {
								/* Translators: %s: classname and link. */
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not support the %s function - this is required to make your site load faster.', 'amp-wp' ), '<a href="https://php.net/manual/en/zlib.installation.php">gzopen</a>' ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="WP Remote Get"><?php esc_html_e( 'WP Remote Get:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'AMP WP uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							if ( $environment['remote_get_successful'] ) {
								echo '<mark class="yes">&#10004;</mark>';
							} else {
								/* Translators: %s: function name. */
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s failed. Contact your hosting provider.', 'amp-wp' ), 'wp_remote_get()' ) . ' ' . esc_html( $environment['remote_get_response'] ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="WP Remote Post"><?php esc_html_e( 'WP Remote Post:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'AMP WP uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							if ( $environment['remote_post_successful'] ) {
								echo '<mark class="yes">&#10004;</mark>';
							} else {
								/* Translators: %s: function name. */
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s failed. Contact your hosting provider.', 'amp-wp' ), 'wp_remote_post()' ) . ' ' . esc_html( $environment['remote_post_response'] ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="GD Library"><?php esc_html_e( 'GD Library:', 'amp-wp' ); ?></td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'AMP WP uses this library to resize images and speed up your site\'s loading time', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							$info = esc_attr__( 'Not Installed', 'amp-wp' );
							if ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
								$info    = esc_attr__( 'Installed', 'amp-wp' );
								$gd_info = gd_info();
								if ( isset( $gd_info['GD Version'] ) ) {
									$info = $gd_info['GD Version'];
								}
							}
							echo esc_attr( $info );
							?>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Server Environment - END -->

			<table class="widefat amp-wp-table amp-wp-help-table" cellspacing="0" id="status">
				<thead>
					<tr>
						<th colspan="3" data-export-label="Theme"><?php esc_html_e( 'Theme', 'amp-wp' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td data-export-label="Name"><?php esc_html_e( 'Name', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The name of the current active theme.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_html( $theme['name'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="Version"><?php esc_html_e( 'Version', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The installed version of the current active theme.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							echo esc_html( $theme['version'] );

							if ( version_compare( $theme['version'], $theme['version_latest'], '<' ) ) {
								/* translators: %s: theme latest version */
								echo ' &ndash; <strong style="color:red;">' . sprintf( esc_html__( '%s is available', 'amp-wp' ), esc_html( $theme['version_latest'] ) ) . '</strong>';
							}
							?>
						</td>
					</tr>
					<?php if ( isset( $theme['author_url'] ) && ! empty( $theme['author_url'] ) ) : ?>
					<tr>
						<td data-export-label="Author URL"><?php esc_html_e( 'Author URL', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The theme developers URL.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_url( $theme['author_url'] ); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td data-export-label="Child Theme"><?php esc_html_e( 'Child theme', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'Displays whether or not the current theme is a child theme.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
						<?php
						if ( $theme['is_child_theme'] ) {
							echo '<mark class="yes">&#10004;</mark>';
						} else {
							/* Translators: %s docs link. */
							echo '<span class="dashicons dashicons-no-alt"></span> &ndash; ' . wp_kses_post( sprintf( __( 'If you are modifying AMP WP on a parent theme that you did not build personally we recommend using a child theme. See: <a href="%s" target="_blank">How to create a child theme</a>', 'amp-wp' ), 'https://codex.wordpress.org/Child_Themes' ) );
						}
						?>
						</td>
					</tr>

					<?php if ( $theme['is_child_theme'] ) : ?>
					<tr>
						<td data-export-label="Parent Theme Name"><?php esc_html_e( 'Parent Theme Name', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The name of the parent theme.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_html( $theme['parent_name'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="Parent Theme Version"><?php esc_html_e( 'Parent Theme Version', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The installed version of the parent theme.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td>
							<?php
							echo esc_html( $theme['parent_version'] );
							if ( version_compare( $theme['parent_version'], $theme['parent_version_latest'], '<' ) ) {
								/* translators: %s: parent theme latest version */
								echo ' &ndash; <strong style="color:red;">' . sprintf( esc_html__( '%s is available', 'amp-wp' ), esc_html( $theme['parent_version_latest'] ) ) . '</strong>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Parent Theme Author URL"><?php esc_html_e( 'Parent Theme Author URL', 'amp-wp' ); ?>:</td>
						<td class="help"><?php echo amp_wp_help_tip( esc_html__( 'The parent theme developers URL.', 'amp-wp' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
						<td><?php echo esc_html( $theme['parent_author_url'] ); ?></td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>

			<!-- Active Plugins - START -->
			<?php
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$active_plugins = array_merge( $active_plugins, array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) );
			}
			?>
			<table class="widefat amp-wp-table amp-wp-help-table" cellspacing="0" id="status">
				<thead>
					<tr>
						<th colspan="3" data-export-label="Active Plugins (<?php echo count( $active_plugins ); ?>)"><?php esc_html_e( 'Active Plugins', 'amp-wp' ); ?> (<?php echo count( $active_plugins ); ?>)</th>
					</tr>
				</thead>
				<tbody>
					<?php

					foreach ( $active_plugins as $active_plugin ) {

						$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $active_plugin );
						$dirname        = dirname( $active_plugin );
						$version_string = '';
						$network_string = '';

						if ( ! empty( $plugin_data['Name'] ) ) {

							// Link the plugin name to the plugin url if available.
							if ( ! empty( $plugin_data['PluginURI'] ) ) {
								$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . __( 'Visit plugin homepage', 'amp-wp' ) . '">' . esc_html( $plugin_data['Name'] ) . '</a>';
							} else {
								$plugin_name = esc_html( $plugin_data['Name'] );
							}
							?>
							<tr>
								<td><?php echo $plugin_name; // WPCS: XSS ok. ?></td>
								<td class="help">&nbsp;</td>
								<td>
									<?php /* translators: plugin author. */ ?>
									<?php printf( esc_attr__( 'by %s', 'amp-wp' ), '<a href="' . esc_url( $plugin_data['AuthorURI'] ) . '" target="_blank">' . esc_html( $plugin_data['AuthorName'] ) . '</a>' ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; // WPCS: XSS ok. ?>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
			<!-- Active Plugins - END -->
		</div>


		<div class="amp-wp-content-footer">
			<h2 class="amp-wp-content-title"><?php esc_html_e( 'System Status', 'amp-wp' ); ?></h2>
			<div class="amp-wp-content-btn-toolbar">
				<a href="#" class="button-primary debug-report"><?php esc_html_e( 'Get System Report', 'amp-wp' ); ?></a>
			</div>
		</div>
	</div>
</div>
