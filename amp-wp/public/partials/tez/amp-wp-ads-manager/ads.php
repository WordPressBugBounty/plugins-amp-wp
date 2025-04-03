<?php
/**
 * The Template for Displaying Ads
 *
 * This template can be overridden by copying it to yourtheme/amp-wp/amp-wp-ads-manager/ads.php.
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

add_filter( 'amp_wp_ads_manager_fields', 'amp_wp_ad_options', 80 );

if ( ! function_exists( 'amp_wp_ad_options' ) ) {

	/**
	 * AMP WP Ads
	 *
	 * @param   $fields
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return array
	 */
	function amp_wp_ad_options( $fields ) {

		/**
		 * AMP WP Ads
		 */
		$fields['amp_ads'] = array(
			'name' => __( 'AMP WP Ads', 'amp-wp' ),
			'id'   => 'amp_wp_ads',
			'type' => 'tab',
			'icon' => 'amp-wp-icon',
		);

		$fields[] = array(
			'name' => __( 'Header Ads', 'amp-wp' ),
			'type' => 'heading',
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'After Header', 'amp-wp' ),
				'group_desc'  => __( '<code>Note:</code> This ad will be shown after header in all AMP pages.', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_header_after',
				'format'      => 'amp',
			)
		);

		$fields[] = array(
			'name' => __( 'Post Ads', 'amp-wp' ),
			'type' => 'heading',
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'Before Post Title', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_post_title_before',
				'format'      => 'amp',
			)
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'After Post Title', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_post_title_after',
				'format'      => 'amp',
			)
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'Above Post Content', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_post_content_before',
				'format'      => 'amp',
			)
		);

		/**
		 * AMP WP Post content ads
		 */
		amp_wp_ads_inject_ad_repeater_field_to_fields(
			$fields,
			array(
				'id_prefix'        => 'amp_post_inline',
				'group_title'      => __( 'Inside Post Content (After X Paragraph)', 'amp-wp' ),
				'field_desc'       => __( 'Add inline adds inside post content. <br>You can add multiple inline adds for multiple location of post content.', 'amp-wp' ),
				'field_add_label'  => '<i class="fa fa-plus"></i> ' . __( 'Add New Inline Ad', 'amp-wp' ),
				'field_item_title' => __( 'Inline Ad', 'amp-wp' ),
				'group_auto_close' => true,
				'format'           => 'amp',
				'field_end_fields' => array(
					'paragraph' => array(
						'name'          => __( 'After Paragraph', 'amp-wp' ),
						'id'            => 'paragraph',
						'desc'          => __( 'Content of each post will analyzed and it will inject an ad after the selected number of paragraphs.', 'amp-wp' ),
						'input-desc'    => __( 'After how many paragraphs the ad will display.', 'amp-wp' ),
						'type'          => 'text',
						'repeater_item' => true,
					),
				),
			)
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'Middle Post Content', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_post_content_middle',
				'format'      => 'amp',
			)
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'Below Post Content', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_post_content_after',
				'format'      => 'amp',
			)
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'After Comments & Share Section', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_post_comment_after',
				'format'      => 'amp',
			)
		);

		/**
		 * Footer Ads Fields
		 */
		$fields[] = array(
			'name' => __( 'Footer Ads', 'amp-wp' ),
			'type' => 'heading',
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'Footer Ad', 'amp-wp' ),
				'group_desc'  => __( '<code>Note:</code> This ad will be shown before footer in all AMP pages.', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_footer_before',
				'format'      => 'amp',
			)
		);

		/**
		 * Archive Page Ads Fields
		 */
		$fields[] = array(
			'name' => __( 'Archive Page Ads', 'amp-wp' ),
			'type' => 'heading',
		);
		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => true,
				'group_title' => __( 'After Archive Page Title', 'amp-wp' ),
				'group_desc'  => __( '<code>Note:</code> This ad will be shown after archive page title (category, tag...)', 'amp-wp' ),
				'group_state' => 'close',
				'id_prefix'   => 'amp_wp_archive_title_after',
				'format'      => 'amp',
			)
		);

		amp_wp_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'            => true,
				'group_title'      => __( 'After X Posts', 'amp-wp' ),
				'group_state'      => 'close',
				'group_auto_close' => false,
				'id_prefix'        => 'amp_wp_archive_after_x',
				'format'           => 'amp',
			)
		);
		$fields['amp_wp_archive_after_x_number'] = array(
			'name'       => __( 'After Each X Posts', 'amp-wp' ),
			'id'         => 'amp_wp_archive_after_x_number',
			'desc'       => __( 'Content of each post will analyzed and it will inject an ad after the selected number of paragraphs.', 'amp-wp' ),
			'input-desc' => __( 'After how many paragraphs the ad will display.', 'amp-wp' ),
			'type'       => 'text',
		);
		$fields[]                                = array(
			'type' => 'group_close',
		);

		return $fields;
	}
}

add_filter( 'amp_wp_ads_manager_std', 'amp_wp_ad_std', 33 );

if ( ! function_exists( 'amp_wp_ad_std' ) ) {

	/**
	 * Ads STD
	 *
	 * @param   $fields
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return array
	 */
	function amp_wp_ad_std( $fields ) {

		$ad_locations = array(
			'amp_wp_header_after', // Ad Location 1: After Header (In All Pages).

			'amp_wp_post_title_before', // Ad Location 2: Before Post Title.
			'amp_wp_post_title_after', // Ad Location 3: After Post Title.

			'amp_wp_post_content_before', // Ad Location 4: Above Post Content.
			'amp_wp_post_content_middle', // Ad Location 5: Middle in Post Content - In Progress.
			'amp_wp_post_content_after', // Ad Location 6: Below Post Content.

			'amp_wp_post_comment_after', // Ad Location 7: After Comments in Posts.
			'amp_wp_footer_before', // Ad Location 8: Footer (In All Pages).

			'amp_wp_archive_title_after', // Ad Location 9: After Title In Archive Pages.
			'amp_wp_archive_after_x', // Ad Location 10: Post Content Ads (After X Paragraph).
		);

		foreach ( $ad_locations as $location_id ) {
			$fields[ $location_id . '_type' ]     = array(
				'std' => '',
			);
			$fields[ $location_id . '_banner' ]   = array(
				'std' => 'none',
			);
			$fields[ $location_id . '_campaign' ] = array(
				'std' => 'none',
			);
			$fields[ $location_id . '_count' ]    = array(
				'std' => 1,
			);
			$fields[ $location_id . '_columns' ]  = array(
				'std' => 1,
			);
			$fields[ $location_id . '_orderby' ]  = array(
				'std' => 'rand',
			);
			$fields[ $location_id . '_order' ]    = array(
				'std' => 'ASC',
			);
			$fields[ $location_id . '_align' ]    = array(
				'std' => 'center',
			);
		}

		// Post Inline
		$fields['amp_post_inline'] = array(
			'default' => array(
				array(
					'type'      => '',
					'campaign'  => 'none',
					'banner'    => 'none',
					'align'     => 'center',
					'paragraph' => 3,
					'count'     => 2,
					'columns'   => 2,
					'orderby'   => 'rand',
					'order'     => 'ASC',
				),
			),
			'std'     => array(
				array(
					'type'      => '',
					'campaign'  => 'none',
					'banner'    => 'none',
					'align'     => 'center',
					'paragraph' => 3,
					'count'     => 2,
					'columns'   => 2,
					'orderby'   => 'rand',
					'order'     => 'ASC',
				),
			),
		);
		return $fields;
	}
}
