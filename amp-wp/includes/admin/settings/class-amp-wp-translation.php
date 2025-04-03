<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly
/**
 * Amp_WP_Translation Class
 *
 * This is used to define AMP WP Translation setting.
 *
 * @link            http://pixelative.co
 * @since           1.1.0
 *
 * @package     Amp_WP_Translation
 * @subpackage  Amp_WP_Translation/includes/admin
 * @author      Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Translation {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.1.0
	 */
	public function __construct() {

		// Filter -> Add Translation Settings Tab
		add_filter( 'amp_wp_settings_tab_menus', array( $this, 'amp_wp_add_translation_tab' ) );

		// Action -> Display Translation Settings
		add_action( 'amp_wp_settings_tab_section', array( $this, 'amp_wp_add_translation_settings' ) );

		// Action -> Save Translation Settings
		add_action( 'amp_wp_save_setting_sections', array( $this, 'amp_wp_save_translation_settings' ) );
	}

	/**
	 * Add Translation Settings Tab
	 *
	 * @since       1.1.0
	 *
	 * @param   array $tabs  Settings Tab
	 * @return  array  $tabs  Merge array of Settings Tab with Translation Tab.
	 */
	public function amp_wp_add_translation_tab( $tabs ) {

		$tabs['translation'] = __( '<i class="amp-wp-admin-icon-globe-1"></i><span>Translation</span>', 'amp-wp' );
		return $tabs;
	}

	/**
	 * Display Translation Settings
	 *
	 * This function is used to display translation settings.
	 *
	 * @since    1.1.0
	 */
	public function amp_wp_add_translation_settings() {
		$amp_wp_translation_option = get_option( 'amp-wp-translation' );
		$sections['comments']      = array(
			'title'  => __( 'Comments Area', 'amp-wp' ),
			'id'     => 'comments-area',
			'type'   => 'section',
			'fields' => apply_filters(
				'amp_wp_comment_fields',
				array(
					array(
						'id'          => 'comments',
						'type'        => 'text',
						'title'       => __( 'Comments', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comments'] ) ) ? esc_attr( $amp_wp_translation_option['comments'] ) : __( 'Comments', 'amp-wp' ),
						'placeholder' => __( 'Comments', 'amp-wp' ),
					),
					array(
						'id'          => 'add_comment',
						'type'        => 'text',
						'title'       => __( 'Add Comment', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['add_comment'] ) ) ? esc_attr( $amp_wp_translation_option['add_comment'] ) : __( 'Add Comment', 'amp-wp' ),
						'placeholder' => __( 'Add Comment', 'amp-wp' ),
					),
					array(
						'id'          => 'comments_edit',
						'type'        => 'text',
						'title'       => __( 'Edit Comment', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comments_edit'] ) ) ? esc_attr( $amp_wp_translation_option['comments_edit'] ) : __( 'Edit Comment', 'amp-wp' ),
						'placeholder' => __( 'Edit Comment', 'amp-wp' ),
					),
					array(
						'id'          => 'comments_reply',
						'type'        => 'text',
						'title'       => __( 'Leave a Reply', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comments_reply'] ) ) ? esc_attr( $amp_wp_translation_option['comments_reply'] ) : __( 'Leave a Reply', 'amp-wp' ),
						'placeholder' => __( 'Leave a Reply', 'amp-wp' ),
					),
					array(
						'id'          => 'comments_reply_to',
						'type'        => 'text',
						'title'       => __( 'Reply To %s', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comments_reply_to'] ) ) ? esc_attr( $amp_wp_translation_option['comments_reply_to'] ) : __( 'Reply To %s', 'amp-wp' ),
						'placeholder' => __( 'Reply To %s', 'amp-wp' ),
					),
					array(
						'id'          => 'comment_successful_message',
						'type'        => 'text',
						'title'       => __( 'Thank You Message', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comment_successful_message'] ) ) ? esc_attr( $amp_wp_translation_option['comment_successful_message'] ) : __( 'Thank you for submitting comment, we will review it and will get back to you.', 'amp-wp' ),
						'placeholder' => __( 'Thank you for submitting comment, we will review it and will get back to you.', 'amp-wp' ),
					),
					array(
						'id'          => 'cancel_reply_text',
						'type'        => 'text',
						'title'       => __( 'Cancel reply', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['cancel_reply_text'] ) ) ? esc_attr( $amp_wp_translation_option['cancel_reply_text'] ) : __( 'Cancel reply', 'amp-wp' ),
						'placeholder' => __( 'Cancel reply', 'amp-wp' ),
					),
					array(
						'id'          => 'post_comment_text',
						'type'        => 'text',
						'title'       => __( 'Post Comment', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['post_comment_text'] ) ) ? esc_attr( $amp_wp_translation_option['post_comment_text'] ) : __( 'Post Comment', 'amp-wp' ),
						'placeholder' => __( 'Post Comment', 'amp-wp' ),
					),
					array(
						'id'          => 'loggedin_text',
						'type'        => 'text',
						'title'       => __( 'Logged in as', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['loggedin_text'] ) ) ? esc_attr( $amp_wp_translation_option['loggedin_text'] ) : __( 'Logged in as', 'amp-wp' ),
						'placeholder' => __( 'Logged in as', 'amp-wp' ),
					),
					array(
						'id'          => 'logout_text',
						'type'        => 'text',
						'title'       => __( 'Log Out', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['logout_text'] ) ) ? esc_attr( $amp_wp_translation_option['logout_text'] ) : __( 'Log Out', 'amp-wp' ),
						'placeholder' => __( 'Log Out', 'amp-wp' ),
					),
					array(
						'id'          => 'name_text',
						'type'        => 'text',
						'title'       => __( 'Name', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['name_text'] ) ) ? esc_attr( $amp_wp_translation_option['name_text'] ) : __( 'Name', 'amp-wp' ),
						'placeholder' => __( 'Name', 'amp-wp' ),
					),
					array(
						'id'          => 'email_text',
						'type'        => 'text',
						'title'       => __( 'Email', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['email_text'] ) ) ? esc_attr( $amp_wp_translation_option['email_text'] ) : __( 'Email', 'amp-wp' ),
						'placeholder' => __( 'Email', 'amp-wp' ),
					),
					array(
						'id'          => 'website_text',
						'type'        => 'text',
						'title'       => __( 'Website', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['website_text'] ) ) ? esc_attr( $amp_wp_translation_option['website_text'] ) : __( 'Website', 'amp-wp' ),
						'placeholder' => __( 'Website', 'amp-wp' ),
					),
					array(
						'id'          => 'your_email_address_text',
						'type'        => 'text',
						'title'       => __( 'Your email address will not be published.', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['your_email_address_text'] ) ) ? esc_attr( $amp_wp_translation_option['your_email_address_text'] ) : __( 'Your email address will not be published.', 'amp-wp' ),
						'placeholder' => __( 'Your email address will not be published.', 'amp-wp' ),
					),
					array(
						'id'          => 'required_fields_text',
						'type'        => 'text',
						'title'       => __( 'Required fields are marked', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['required_fields_text'] ) ) ? esc_attr( $amp_wp_translation_option['required_fields_text'] ) : __( 'Required fields are marked', 'amp-wp' ),
						'placeholder' => __( 'Required fields are marked', 'amp-wp' ),
					),
					array(
						'id'          => 'comment_text',
						'type'        => 'text',
						'title'       => __( 'Comment', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comment_text'] ) ) ? esc_attr( $amp_wp_translation_option['comment_text'] ) : __( 'Comment', 'amp-wp' ),
						'placeholder' => __( 'Comment', 'amp-wp' ),
					),
					array(
						'id'          => 'comment_previous',
						'type'        => 'text',
						'title'       => __( 'Previous', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comment_previous'] ) ) ? esc_attr( $amp_wp_translation_option['comment_previous'] ) : __( 'Previous', 'amp-wp' ),
						'placeholder' => __( 'Previous', 'amp-wp' ),
					),
					array(
						'id'          => 'comment_next',
						'type'        => 'text',
						'title'       => __( 'Next', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comment_next'] ) ) ? esc_attr( $amp_wp_translation_option['comment_next'] ) : __( 'Next', 'amp-wp' ),
						'placeholder' => __( 'Next', 'amp-wp' ),
					),
					array(
						'id'          => 'comment_page_numbers',
						'type'        => 'text',
						'title'       => __( 'Page %1$s of %2$s', 'amp-wp' ),
						'default'     => ( isset( $amp_wp_translation_option ) && ! empty( $amp_wp_translation_option['comment_page_numbers'] ) ) ? esc_attr( $amp_wp_translation_option['comment_page_numbers'] ) : __( 'Page %1$s of %2$s', 'amp-wp' ),
						'placeholder' => __( 'Page %1$s of %2$s', 'amp-wp' ),
					),
				)
			),
		);
		require_once AMP_WP_DIR_PATH . 'admin/partials/settings/amp-wp-admin-translation.php';
	}

	/**
	 * Save Translation Settings
	 *
	 * This function is used to save translation settings.
	 *
	 * @since    1.1.0
	 */
	public function amp_wp_save_translation_settings() {
		// Check nonce.
		if ( ! isset( $_POST['amp_wp_settings_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amp_wp_settings_nonce_field'] ) ), 'amp_wp_settings_nonce' ) ) {
			// Nonce is not valid, handle accordingly (e.g., display an error message, redirect, etc.).
			return;
		}

		if ( isset( $_POST ) && ! empty( $_POST ) ) {
			$amp_wp_translation = filter_input_array( INPUT_POST );

			if ( $amp_wp_translation ) :
				foreach ( $amp_wp_translation as $key => $value ) {
					if ( strstr( $key, 'amp-wp-translation' ) ) {
						update_option( sanitize_key( $key ), $value );
					}
				}
			endif;
		}
	}
}
new Amp_WP_Translation();
