<?php
/**
 * Provide admin area view for the translation
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://pixelative.co
 * @since      1.1.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials/settings
 */
?>
<div id="settings-translation" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<?php wp_original_referer_field( true, 'previous' ); ?>
		<input type="hidden" value="1" name="admin_notices">
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Translation', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( __( 'Save Changes' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<!-- Header -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Header', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="header"><?php esc_html_e( 'Header:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="header" name="amp-wp-translation[header]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['header'] ) ) ? esc_attr( $amp_wp_translation_option['header'] ) : 'Header'; ?>" placeholder="Header" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Header -->

			<!-- Search -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Search', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="search_on_site"><?php esc_html_e( 'Search on site:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="search_on_site" name="amp-wp-translation[search_on_site]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['search_on_site'] ) ) ? esc_attr( $amp_wp_translation_option['search_on_site'] ) : 'Search on site'; ?>" placeholder="Search on site" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="search_input_placeholder"><?php esc_html_e( 'Search input placeholder:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="search_input_placeholder" name="amp-wp-translation[search_input_placeholder]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['search_input_placeholder'] ) ) ? esc_attr( $amp_wp_translation_option['search_input_placeholder'] ) : 'Search &hellip;'; ?>" placeholder="Search &hellip;" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="search_button"><?php esc_html_e( 'Search button:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="search_button" name="amp-wp-translation[search_button]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['search_button'] ) ) ? esc_attr( $amp_wp_translation_option['search_button'] ) : 'Search'; ?>" placeholder="Search" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Search -->

			<!-- Navigation -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Navigation', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="prev"><?php esc_html_e( 'Previous:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="prev" name="amp-wp-translation[prev]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['prev'] ) ) ? esc_attr( $amp_wp_translation_option['prev'] ) : 'Previous'; ?>" placeholder="Previous" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="next"><?php esc_html_e( 'Next:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="next" name="amp-wp-translation[next]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['next'] ) ) ? esc_attr( $amp_wp_translation_option['next'] ) : 'Next'; ?>" placeholder="Next" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="page"><?php esc_html_e( 'Page:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="page" name="amp-wp-translation[page]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['page'] ) ) ? esc_attr( $amp_wp_translation_option['page'] ) : 'Page'; ?>" placeholder="Page" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="page_of"><?php esc_html_e( 'of %d:', 'amp-wp' ); ?></label></th>
						<td>
							<input type="text" id="page_of" name="amp-wp-translation[page_of]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['page_of'] ) ) ? esc_attr( $amp_wp_translation_option['page_of'] ) : 'of %d'; ?>" placeholder="of %d" />
							<p class="description"><?php esc_html_e( '%d will be replace with page number.', 'amp-wp' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- /Navigation -->

			<!-- Archives -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Archives', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="archive"><?php esc_html_e( 'Archive:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="archive" name="amp-wp-translation[archive]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['archive'] ) ) ? esc_attr( $amp_wp_translation_option['archive'] ) : 'Archive'; ?>" placeholder="Archive" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing"><?php esc_html_e( 'Browsing:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing" name="amp-wp-translation[browsing]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing'] ) ) ? esc_attr( $amp_wp_translation_option['browsing'] ) : 'Browsing'; ?>" placeholder="Browsing" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browse_author_articles"><?php esc_html_e( 'Browse Author Articles:', 'amp-wp' ); ?></label></th>
						<td>
							<input type="text" id="browse_author_articles" name="amp-wp-translation[browse_author_articles]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browse_author_articles'] ) ) ? esc_attr( $amp_wp_translation_option['browse_author_articles'] ) : 'Browse Author Articles'; ?>" placeholder="Browse Author Articles" />
							<p class="description"><?php esc_html_e( '%1$s1 is author name and %2$s2 is post publish date.', 'amp-wp' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_category"><?php esc_html_e( 'Browsing category:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_category" name="amp-wp-translation[browsing_category]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_category'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_category'] ) : 'Browsing category'; ?>" placeholder="Browsing category" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_tag"><?php esc_html_e( 'Browsing tag:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_tag" name="amp-wp-translation[browsing_tag]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_tag'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_tag'] ) : 'Browsing tag'; ?>" placeholder="Browsing tag" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_author"><?php esc_html_e( 'Browsing author:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_author" name="amp-wp-translation[browsing_author]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_author'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_author'] ) : 'Browsing author'; ?>" placeholder="Browsing author" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_yearly"><?php esc_html_e( 'Browsing yearly archive:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_yearly" name="amp-wp-translation[browsing_yearly]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_yearly'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_yearly'] ) : 'Browsing yearly archive'; ?>" placeholder="Browsing yearly archive" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_monthly"><?php esc_html_e( 'Browsing monthly archive:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_monthly" name="amp-wp-translation[browsing_monthly]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_monthly'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_monthly'] ) : 'Browsing monthly archive'; ?>" placeholder="Browsing monthly archive" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_daily"><?php esc_html_e( 'Browsing daily archive:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_daily" name="amp-wp-translation[browsing_daily]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_daily'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_daily'] ) : 'Browsing daily archive'; ?>" placeholder="Browsing daily archive" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="browsing_archive"><?php esc_html_e( 'Browsing archive:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="browsing_archive" name="amp-wp-translation[browsing_archive]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['browsing_archive'] ) ) ? esc_attr( $amp_wp_translation_option['browsing_archive'] ) : 'Browsing archive'; ?>" placeholder="Browsing archive" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Archives -->

			<!-- Posts -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Posts', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="by_on"><?php esc_html_e( 'By %1$s1 on %2$s2:', 'amp-wp' ); ?></label></th>
						<td>
							<input type="text" id="by_on" name="amp-wp-translation[by_on]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['by_on'] ) ) ? esc_attr( $amp_wp_translation_option['by_on'] ) : '%s1 &#9679; %s2'; ?>" placeholder="%s1 &#9679; %s2" />
							<p class="description"><?php esc_html_e( '%1$s1 is author name and %2$s2 is post publish date.', 'amp-wp' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="share"><?php esc_html_e( 'Share:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="share" name="amp-wp-translation[share]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['share'] ) ) ? esc_attr( $amp_wp_translation_option['share'] ) : 'Share'; ?>" placeholder="Share" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="listing_2_date"><?php esc_html_e( 'Large Listing Date Format:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="listing_2_date" name="amp-wp-translation[listing_2_date]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['listing_2_date'] ) ) ? esc_attr( $amp_wp_translation_option['listing_2_date'] ) : 'M d, Y'; ?>" placeholder="M d, Y" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="tags"><?php esc_html_e( 'Tags:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="tags" name="amp-wp-translation[tags]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['tags'] ) ) ? esc_attr( $amp_wp_translation_option['tags'] ) : 'Tags'; ?>" placeholder="Tags" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="related_posts"><?php esc_html_e( 'Related Posts:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="related_posts" name="amp-wp-translation[related_posts]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['related_posts'] ) ) ? esc_attr( $amp_wp_translation_option['related_posts'] ) : 'Related Posts'; ?>" placeholder="Related Posts" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Posts -->

			<!-- Post Formats -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Post Formats', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="asides"><?php esc_html_e( 'Asides:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="asides" name="amp-wp-translation[asides]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['asides'] ) ) ? esc_attr( $amp_wp_translation_option['asides'] ) : 'Asides'; ?>" placeholder="Asides" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="galleries"><?php esc_html_e( 'Galleries:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="galleries" name="amp-wp-translation[galleries]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['galleries'] ) ) ? esc_attr( $amp_wp_translation_option['galleries'] ) : 'Galleries'; ?>" placeholder="Galleries" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="images"><?php esc_html_e( 'Images:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="images" name="amp-wp-translation[images]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['images'] ) ) ? esc_attr( $amp_wp_translation_option['images'] ) : 'Images'; ?>" placeholder="Images" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="videos"><?php esc_html_e( 'Videos:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="videos" name="amp-wp-translation[videos]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['videos'] ) ) ? esc_attr( $amp_wp_translation_option['videos'] ) : 'Videos'; ?>" placeholder="Videos" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="quotes"><?php esc_html_e( 'Quotes:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="quotes" name="amp-wp-translation[quotes]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['quotes'] ) ) ? esc_attr( $amp_wp_translation_option['quotes'] ) : 'Quotes'; ?>" placeholder="Quotes" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="links"><?php esc_html_e( 'Links:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="links" name="amp-wp-translation[links]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['links'] ) ) ? esc_attr( $amp_wp_translation_option['links'] ) : 'Links'; ?>" placeholder="Links" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="statuses"><?php esc_html_e( 'Statuses:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="statuses" name="amp-wp-translation[statuses]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['statuses'] ) ) ? esc_attr( $amp_wp_translation_option['statuses'] ) : 'Statuses'; ?>" placeholder="Statuses" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="audio"><?php esc_html_e( 'Audio:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="audio" name="amp-wp-translation[audio]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['audio'] ) ) ? esc_attr( $amp_wp_translation_option['audio'] ) : 'Audio'; ?>" placeholder="Audio" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="chats"><?php esc_html_e( 'Chats:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="chats" name="amp-wp-translation[chats]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['chats'] ) ) ? esc_attr( $amp_wp_translation_option['chats'] ) : 'Chats'; ?>" placeholder="Chats" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Post Formats -->

			<!-- Attachment Texts -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Attachment Texts', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="attachment-return-to"><?php esc_html_e( 'Return to post:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="attachment-return-to" name="amp-wp-translation[attachment-return-to]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['attachment-return-to'] ) ) ? esc_attr( $amp_wp_translation_option['attachment-return-to'] ) : 'Return to &quot;%s&quot;'; ?>" placeholder='Return to "%s"' /></td>
					</tr>
					<tr>
						<th scope="row"><label for="click-here"><?php esc_html_e( 'Click here:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="click-here" name="amp-wp-translation[click-here]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['click-here'] ) ) ? esc_attr( $amp_wp_translation_option['click-here'] ) : 'Click here'; ?>" placeholder="Click here" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="attachment-play-video"><?php esc_html_e( 'Play Video:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="attachment-play-video" name="amp-wp-translation[attachment-play-video]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['attachment-play-video'] ) ) ? esc_attr( $amp_wp_translation_option['attachment-play-video'] ) : '%s to play video'; ?>" placeholder="%s to play video" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="attachment-play-audio"><?php esc_html_e( 'Play Audio:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="attachment-play-audio" name="amp-wp-translation[attachment-play-audio]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['attachment-play-audio'] ) ) ? esc_attr( $amp_wp_translation_option['attachment-play-audio'] ) : '%s to play audio'; ?>" placeholder="%s to play audio" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="attachment-download-file"><?php esc_html_e( 'Download File:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="attachment-download-file" name="amp-wp-translation[attachment-download-file]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['attachment-download-file'] ) ) ? esc_attr( $amp_wp_translation_option['attachment-download-file'] ) : '%s to Download File'; ?>" placeholder="%s to Download File" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="attachment-next"><?php esc_html_e( 'Next Attachment:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="attachment-next" name="amp-wp-translation[attachment-next]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['attachment-next'] ) ) ? esc_attr( $amp_wp_translation_option['attachment-next'] ) : 'Next'; ?>" placeholder="Next" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="attachment-prev"><?php esc_html_e( 'Previous Attachment:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="attachment-prev" name="amp-wp-translation[attachment-prev]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['attachment-prev'] ) ) ? esc_attr( $amp_wp_translation_option['attachment-prev'] ) : 'Previous'; ?>" placeholder="Previous" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Attachment Texts -->

			<!-- Comments -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Comments', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<?php foreach ( $sections['comments']['fields'] as $field ) : ?>
					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $field['id'] ); ?>"><?php echo esc_attr( $field['title'] ); ?></label></th>
						<td><input type="<?php echo esc_attr( $field['type'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>" name="amp-wp-translation[<?php echo esc_attr( $field['id'] ); ?>]" size="30" value="<?php echo esc_attr( $field['default'] ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" /></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<!-- /Comments -->

			<!-- Footer -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'Footer', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="view_desktop"><?php esc_html_e( 'View Desktop Version:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="view_desktop" name="amp-wp-translation[view_desktop]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['view_desktop'] ) ) ? esc_attr( $amp_wp_translation_option['view_desktop'] ) : 'View Desktop Version'; ?>" placeholder="View Desktop Version" /></td>
					</tr>
				</tbody>
			</table>
			<!-- /Footer -->

			<!-- 404 -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( '404 Page', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="404_message"><?php esc_html_e( '404 Page Message:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="404_message" name="amp-wp-translation[404_message]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['404_message'] ) ) ? esc_attr( $amp_wp_translation_option['404_message'] ) : 'Oops! That page cannot be found.'; ?>" placeholder="Oops! That page cannot be found." /></td>
					</tr>
				</tbody>
			</table>
			<!-- 404 -->

			<!-- 404 -->
			<h3 class="amp-wp-form-section-title"><?php esc_html_e( 'OneSignal – Web Push Notifications', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="onesignal_subscribe"><?php esc_html_e( 'Subscribe:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="onesignal_subscribe" name="amp-wp-translation[onesignal_subscribe]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['onesignal_subscribe'] ) ) ? esc_attr( $amp_wp_translation_option['onesignal_subscribe'] ) : 'Subscribe to updates'; ?>" placeholder="Subscribe to updates" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="onesignal_unsubsribe"><?php esc_html_e( 'Unsubsribe:', 'amp-wp' ); ?></label></th>
						<td><input type="text" id="onesignal_unsubsribe" name="amp-wp-translation[onesignal_unsubsribe]" size="30" value="<?php echo ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['onesignal_unsubsribe'] ) ) ? esc_attr( $amp_wp_translation_option['onesignal_unsubsribe'] ) : 'Unsubscribe from updates'; ?>" placeholder="Unsubscribe from updates" /></td>
					</tr>
				</tbody>
			</table>
			<!-- 404 -->
		</div>
		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Translation', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( __( 'Save Changes' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
	</form>
</div>
