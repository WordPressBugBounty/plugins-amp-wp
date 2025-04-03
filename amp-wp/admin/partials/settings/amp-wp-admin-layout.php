<?php
/**
 * Provide a admin area view for the Layout
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://pixelative.co
 * @since      1.0.0
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/partials/settings
 */
?>
<div id="settings-layout" class="amp-wp-vtabs-content">
	<form id="amp_wp_setting_form" name="amp_wp_setting_form" method="post">
		<?php wp_nonce_field( 'amp_wp_settings_nonce', 'amp_wp_settings_nonce_field' ); ?>
		<input type="hidden" value="1" name="admin_notices">
		<div class="amp-wp-vtabs-header">
			<div class="amp-wp-vtabs-title">
				<h2><?php esc_html_e( 'Layout Settings', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
		<div class="amp-wp-vtabs-body">
			<!-- Header - START -->
			<h3 class="amp-wp-form-section-title"><?php _e( 'Header', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="is_show_search"><?php _e( 'Show Search', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[is_show_search]" id="is_show_search" <?php echo ( isset( $is_show_search ) && ! empty( $is_show_search ) ) ? 'checked="checked"' : ''; ?> />
								<label for="is_show_search"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="is_sticky_header"><?php _e( 'Sticky Header', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[is_sticky_header]" id="is_sticky_header" <?php echo ( isset( $is_sticky_header ) && ! empty( $is_sticky_header ) ) ? 'checked="checked"' : ''; ?> />
								<label for="is_sticky_header"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="is_show_sidebar"><?php _e( 'Show Sidebar', 'amp-wp' ); ?></label></th>
						<td>
							<div class="amp-wp-parent-child-field <?php echo ( '1' == $is_show_sidebar ) ? 'active' : ''; ?>">
								<div class="switch">
									<input type="checkbox" name="amp_wp_layout_settings[is_show_sidebar]" id="is_show_sidebar" <?php echo ( isset( $is_show_sidebar ) && ! empty( $is_show_sidebar ) ) ? 'checked="checked"' : ''; ?> />
									<label for="is_show_sidebar"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
								</div>
								<div class="amp-wp-child-field">
									<label for="sidebar_copyright_text"><?php _e( 'Copyright Text', 'amp-wp' ); ?></label>
									<textarea name="amp_wp_layout_settings[sidebar_copyright_text]" id="sidebar_copyright_text"><?php echo ( isset( $sidebar_copyright_text ) && ! empty( $sidebar_copyright_text ) ) ? wp_kses_post( $sidebar_copyright_text ) : ''; ?></textarea>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Header - END -->

			<!-- Footer - START -->
			<h3 class="amp-wp-form-section-title"><?php _e( 'Footer', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="non_amp_version"><?php _e( 'Show Non-AMP Version Link', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[non_amp_version]" id="non_amp_version" <?php echo ( isset( $non_amp_version ) && ! empty( $non_amp_version ) ) ? 'checked="checked"' : ''; ?> />
								<label for="non_amp_version"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="footer_copyright_text"><?php _e( 'Copyright Text', 'amp-wp' ); ?></label></th>
						<td>
							<textarea name="amp_wp_layout_settings[footer_copyright_text]" id="footer_copyright_text"><?php echo ( isset( $footer_copyright_text ) && ! empty( $footer_copyright_text ) ) ? wp_kses_post( $footer_copyright_text ) : ''; ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Footer - END -->

			<!-- Home Page - START -->
			<h3 class="amp-wp-form-section-title"><?php _e( 'Home Page', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="home_page_layout"><?php _e( 'Home Page Layout', 'amp-wp' ); ?></label></th>
						<td>
							<select name="amp_wp_layout_settings[home_page_layout]" id="home_page_layout" class="amp-wp-select">
								<option value="listing-2" <?php echo ( isset( $home_page_layout ) && 'listing-2' == $home_page_layout ) ? 'selected="selected"' : ''; ?>><?php _e( 'Classic View', '' ); ?></option>
								<option value="listing-1" <?php echo ( isset( $home_page_layout ) && 'listing-1' == $home_page_layout ) ? 'selected="selected"' : ''; ?>><?php _e( 'List View', '' ); ?></option>
							</select>

						</td>
					</tr>

					 <!-- Template for Parent/Child -->
					<div class="amp-wp-parent-child-field <?php echo ( $notice_switch == '1' ) ? 'active' : ''; ?>">
						<div class="switch">
						</div>
						<div class="amp-wp-child-field">
							<!-- Children Fields here -->
						</div>
					</div>
					<!-- Template for Parent/Child -->

					<tr>
						<th scope="row"><label for="slider_on_home"><?php _e( 'Show Slider on Home Page', 'amp-wp' ); ?></label></th>
						<td>
							<div class="amp-wp-parent-child-field <?php echo ( $slider_on_home == '1' ) ? 'active' : ''; ?>">
								<div class="switch">
									<input type="checkbox" name="amp_wp_layout_settings[slider_on_home]" id="slider_on_home" <?php echo ( isset( $slider_on_home ) && ! empty( $slider_on_home ) ) ? 'checked="checked"' : ''; ?> />
									<label for="slider_on_home"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
								</div>
								<div class="amp-wp-child-field">
									<label for="slider_on_home_count"><?php _e( 'Slider Posts Count', 'amp-wp' ); ?></label>
									<input type="number" name="amp_wp_layout_settings[slider_on_home_count]" id="slider_on_home_count" value="<?php echo ( isset( $slider_on_home_count ) && ! empty( $slider_on_home_count ) ) ? intval( $slider_on_home_count ) : 6; ?>" />

									<label for="slider_on_home_post_date"><?php _e( 'Show Post Date in Slider', 'amp-wp' ); ?></label>
									<div class="switch">
										<input type="checkbox" name="amp_wp_layout_settings[slider_on_home_post_date]" id="slider_on_home_post_date" <?php echo ( isset( $slider_on_home_post_date ) && ! empty( $slider_on_home_post_date ) ) ? 'checked="checked"' : ''; ?> />
										<label for="slider_on_home_post_date"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>

									<label for="slider_on_home_post_author"><?php _e( 'Show Post Author in Slider', 'amp-wp' ); ?></label>
									<div class="switch">
										<input type="checkbox" name="amp_wp_layout_settings[slider_on_home_post_author]" id="slider_on_home_post_author" <?php echo ( isset( $slider_on_home_post_author ) && ! empty( $slider_on_home_post_author ) ) ? 'checked="checked"' : ''; ?> />
										<label for="slider_on_home_post_author"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Home Page - END -->

			<!-- Archive Page - START -->
			<h3 class="amp-wp-form-section-title"><?php _e( 'Archive Page', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="archive_page_layout"><?php _e( 'Archive Page Layout', 'amp-wp' ); ?></label></th>
						<td>
							<select name="amp_wp_layout_settings[archive_page_layout]" id="archive_page_layout" class="amp-wp-select">
								<option value="listing-2" <?php echo ( isset( $archive_page_layout ) && 'listing-2' == $archive_page_layout ) ? 'selected="selected"' : ''; ?>><?php _e( 'Classic View', '' ); ?></option>
								<option value="listing-1" <?php echo ( isset( $archive_page_layout ) && 'listing-1' == $archive_page_layout ) ? 'selected="selected"' : ''; ?>><?php _e( 'List View', '' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="show_author_in_archive"><?php _e( 'Show Author in Archive', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_author_in_archive]" id="show_author_in_archive" <?php echo ( isset( $show_author_in_archive ) && ! empty( $show_author_in_archive ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_author_in_archive"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="show_date_in_archive"><?php _e( 'Show Date in Archive', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_date_in_archive]" id="show_date_in_archive" <?php echo ( isset( $show_date_in_archive ) && ! empty( $show_date_in_archive ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_date_in_archive"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Archive Page - END -->

			<!-- Single Post Page - START -->
			<h3 class="amp-wp-form-section-title"><?php _e( 'Single Post Page', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="show_thumbnail"><?php _e( 'Show Thumbnail', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_thumbnail]" id="show_thumbnail" <?php echo ( isset( $show_thumbnail ) && ! empty( $show_thumbnail ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_thumbnail"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="show_author_in_single"><?php _e( 'Show Author in Single', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_author_in_single]" id="show_author_in_single" <?php echo ( isset( $show_author_in_single ) && ! empty( $show_author_in_single ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_author_in_single"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="show_date_in_single"><?php _e( 'Show Date in Single', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_date_in_single]" id="show_date_in_single" <?php echo ( isset( $show_date_in_single ) && ! empty( $show_date_in_single ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_date_in_single"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="show_tags"><?php _e( 'Show Tags in Single', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_tags]" id="show_tags" <?php echo ( isset( $show_tags ) && ! empty( $show_tags ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_tags"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>

					<!-- Show Share Box - START -->
					<tr>
						<th scope="row"><label for="social_share_on_post"><?php _e( 'Show Share Box In Posts', 'amp-wp' ); ?></label></th>
						<td>
							<div class="amp-wp-parent-child-field <?php echo ( $social_share_on_post == '1' ) ? 'active' : ''; ?>">
								<div class="switch">
									<input type="checkbox" name="amp_wp_layout_settings[social_share_on_post]" id="social_share_on_post" <?php echo ( isset( $social_share_on_post ) && ! empty( $social_share_on_post ) ) ? 'checked="checked"' : ''; ?> />
									<label for="social_share_on_post"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
								</div>
								<div class="amp-wp-child-field">
									<label for="social_share_on_post_count"><?php _e( 'Show Share Count', 'amp-wp' ); ?></label>
									<select name="amp_wp_layout_settings[social_share_on_post_count]" id="social_share_on_post_count" class="amp-wp-select">
										<option value="total" <?php echo ( isset( $social_share_on_post_count ) && 'total' == $social_share_on_post_count ) ? 'selected="selected"' : ''; ?>><?php _e( 'Show, Total share count', 'amp-wp' ); ?></option>
										<option value="total-and-site" <?php echo ( isset( $social_share_on_post_count ) && 'total-and-site' == $social_share_on_post_count ) ? 'selected="selected"' : ''; ?>><?php _e( 'Show, Total share count + Each site count', 'amp-wp' ); ?></option>
										<option value="hide" <?php echo ( isset( $social_share_on_post_count ) && 'hide' == $social_share_on_post_count ) ? 'selected="selected"' : ''; ?>><?php _e( 'No, Don\'t show.', 'amp-wp' ); ?></option>
									</select>

									<label for="social_share_on_post_link_format"><?php _e( 'Share Box Link Format', 'amp-wp' ); ?></label>
									<select name="amp_wp_layout_settings[social_share_on_post_link_format]" id="social_share_on_post_link_format" class="amp-wp-select">
										<option value="standard" <?php echo ( isset( $social_share_on_post_link_format ) && 'standard' == $social_share_on_post_link_format ) ? 'selected="selected"' : ''; ?>><?php _e( 'Standard WordPress Permalink', 'amp-wp' ); ?></option>
										<option value="short" <?php echo ( isset( $social_share_on_post_link_format ) && 'short' == $social_share_on_post_link_format ) ? 'selected="selected"' : ''; ?>><?php _e( 'Short Link', 'amp-wp' ); ?></option>
									</select>

									<label for="social_share_links"><?php _e( 'Select Social Sites to Share Link', 'amp-wp' ); ?></label>
									<select name="amp_wp_layout_settings[social_share_links][]" id="social_share_links" multiple="multiple" class="amp-wp-select" data-placeholder="Select Sites">
									<?php
									foreach ( $active_sites as $key => $value ) :
										$selected = in_array( $key, $social_share_links ) ? ' selected="selected" ' : '';
										echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_attr( $value ) . '</option>';
									endforeach;
									?>
									</select>

									<label for="facebook_app_id"><?php _e( 'Facebook App ID', 'amp-wp' ); ?></label>
									<input type="text" name="amp_wp_layout_settings[facebook_app_id]" id="facebook_app_id" value="<?php echo ( isset( $facebook_app_id ) && ! empty( $facebook_app_id ) ) ? $facebook_app_id : ''; ?>" />
								</div>
							</div>

						</td>
					</tr>
					<!-- Show Share Box - END -->

					<!-- Show Related Posts - START -->
					<tr>
						<th scope="row"><label for="show_related_posts"><?php _e( 'Show Related Posts', 'amp-wp' ); ?></label></th>
						<td>
							<div class="amp-wp-parent-child-field <?php echo ( $show_related_posts == '1' ) ? 'active' : ''; ?>">
								<div class="switch">
									<input type="checkbox" name="amp_wp_layout_settings[show_related_posts]" id="show_related_posts" <?php echo ( isset( $show_related_posts ) && ! empty( $show_related_posts ) ) ? 'checked="checked"' : ''; ?> />
									<label for="show_related_posts"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
								</div>
								<div class="amp-wp-child-field">
									<label for="show_related_post_count"><?php _e( 'Related Posts Count', 'amp-wp' ); ?></label>
									<input type="number" name="amp_wp_layout_settings[show_related_post_count]" id="show_related_post_count" value="<?php echo ( isset( $show_related_post_count ) && ! empty( $show_related_post_count ) ) ? $show_related_post_count : 6; ?>" />

									<label for="show_related_post_algorithm"><?php _e( 'Related Posts Algorithm', 'amp-wp' ); ?></label>
									<select name="amp_wp_layout_settings[show_related_post_algorithm]" id="show_related_post_algorithm" class="amp-wp-select">
										<option value="cat" <?php echo ( isset( $show_related_post_algorithm ) && 'cat' == $show_related_post_algorithm ) ? 'selected="selected"' : ''; ?>><?php _e( 'by Category', 'amp-wp' ); ?></option>
										<option value="tag" <?php echo ( isset( $show_related_post_algorithm ) && 'tag' == $show_related_post_algorithm ) ? 'selected="selected"' : ''; ?>><?php _e( 'by Tag', 'amp-wp' ); ?></option>
										<option value="author" <?php echo ( isset( $show_related_post_algorithm ) && 'author' == $show_related_post_algorithm ) ? 'selected="selected"' : ''; ?>><?php _e( 'by Author', 'amp-wp' ); ?></option>
										<option value="cat-tag" <?php echo ( isset( $show_related_post_algorithm ) && 'cat-tag' == $show_related_post_algorithm ) ? 'selected="selected"' : ''; ?>><?php _e( 'by Category & Tag', 'amp-wp' ); ?></option>
										<option value="cat-tag-author" <?php echo ( isset( $show_related_post_algorithm ) && 'cat-tag-author' == $show_related_post_algorithm ) ? 'selected="selected"' : ''; ?>><?php _e( 'by Category, Tag & Author', 'amp-wp' ); ?></option>
										<option value="random" <?php echo ( isset( $show_related_post_algorithm ) && 'random' == $show_related_post_algorithm ) ? 'selected="selected"' : ''; ?>><?php _e( 'by Random', 'amp-wp' ); ?></option>
									</select>

									<label for="show_related_post_thumbnail"><?php _e( 'Show Thumbnails in Related Posts', 'amp-wp' ); ?></label>
									<div class="switch">
										<input type="checkbox" name="amp_wp_layout_settings[show_related_post_thumbnail]" id="show_related_post_thumbnail" <?php echo ( isset( $show_related_post_thumbnail ) && ! empty( $show_related_post_thumbnail ) ) ? 'checked="checked"' : ''; ?> />
										<label for="show_related_post_thumbnail"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>

									<label for="show_related_post_date"><?php _e( 'Show Date in Related Posts', 'amp-wp' ); ?></label>
									<div class="switch">
										<input type="checkbox" name="amp_wp_layout_settings[show_related_post_date]" id="show_related_post_date" <?php echo ( isset( $show_related_post_date ) && ! empty( $show_related_post_date ) ) ? 'checked="checked"' : ''; ?> />
										<label for="show_related_post_date"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>

									<label for="show_related_post_author"><?php _e( 'Show Author in Related Posts', 'amp-wp' ); ?></label>
									<div class="switch">
										<input type="checkbox" name="amp_wp_layout_settings[show_related_post_author]" id="show_related_post_author" <?php echo ( isset( $show_related_post_author ) && ! empty( $show_related_post_author ) ) ? 'checked="checked"' : ''; ?> />
										<label for="show_related_post_author"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<!-- Show Related Posts - END -->

					<tr>
						<th scope="row"><label for="show_comments"><?php _e( 'Show Comments', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_comments]" id="show_comments" <?php echo ( isset( $show_comments ) && ! empty( $show_comments ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_comments"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="featured_va_meta_key"><?php _e( 'Featured Video/Audio Meta Key', 'amp-wp' ); ?></label></th>
						<td>
							<input type="text" name="amp_wp_layout_settings[featured_va_meta_key]" id="featured_va_meta_key" value="<?php echo ( isset( $featured_va_meta_key ) && ! empty( $featured_va_meta_key ) ) ? $featured_va_meta_key : '_featured_embed_code'; ?>" />
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Single Post Page - END -->

			<!-- Default Page - START -->
			<h3 class="amp-wp-form-section-title"><?php _e( 'Default Page', 'amp-wp' ); ?></h3>
			<table class="form-table amp-wp-form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="show_page_thumbnail"><?php _e( 'Show Page Thumbnail', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[show_page_thumbnail]" id="show_page_thumbnail" <?php echo ( isset( $show_page_thumbnail ) && ! empty( $show_page_thumbnail ) ) ? 'checked="checked"' : ''; ?> />
								<label for="show_page_thumbnail"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="social_share_on_page"><?php _e( 'Show Share Box In Pages', 'amp-wp' ); ?></label></th>
						<td>
							<div class="switch">
								<input type="checkbox" name="amp_wp_layout_settings[social_share_on_page]" id="social_share_on_page" <?php echo ( isset( $social_share_on_page ) && ! empty( $social_share_on_page ) ) ? 'checked="checked"' : ''; ?> />
								<label for="social_share_on_page"><?php esc_html_e( '&nbsp;', 'amp-wp' ); ?></label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Default Page - END -->
		</div>
		<div class="amp-wp-vtabs-footer">
			<div class="amp-wp-vtabs-title">
				<h2><?php _e( 'Layout Settings', 'amp-wp' ); ?></h2>
			</div>
			<div class="amp-wp-vtabs-btn-toolbar">
				<?php submit_button( esc_html__( 'Save Changes', 'amp-wp' ), 'button-primary', 'save', false ); ?>
			</div>
		</div>
	</form>
</div>
