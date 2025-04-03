<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; } // Exit if accessed directly.
/**
 * Amp_WP_Meta_Box class
 *
 * Defines the Post amp version.
 *
 * @since      1.0.0
 * @package    Amp_WP
 * @subpackage Amp_WP/admin/Metabox
 * @author     Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Meta_Box {

	public function __construct() {

		// Action -> Init Metabox.
		add_action( 'add_meta_boxes', array( $this, 'append_meta_boxes' ) );

		// Action -> Save Metabox.
		add_action( 'save_post', array( $this, 'save_metaboxes' ) );
	}

	/**
	 * Add Meta Box For Posts/Pages.
	 *
	 * @since 1.0.0
	 */
	public function append_meta_boxes() {

		add_meta_box(
			'amp-wp-settings',
			esc_html__( 'AMP WP Settings', 'amp-wp' ),
			array( $this, 'amp_wp_metabox_output' ),
			array(
				'post',
				'page',
			),
			'side',
			'low'
		);
	}

	/**
	 * Add job data meta box options.
	 *
	 * @since   1.0.0
	 */
	public static function amp_wp_metabox_output() {

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'amp-wp-meta-box', 'amp-wp-meta-box-nonce' );
		self::checkbox( 'enable', esc_html__( 'Disable AMP Version', 'amp-wp' ), '' );
	}

	/**
	 * Metabox
	 *
	 * @since 1.0.0
	 *
	 * @param   string $id     field id.
	 * @param   string $label  field label.
	 * @param   string $desc   field description.
	 * @return void
	 */
	public static function checkbox( $id, $label, $desc = '' ) {

		global $post;
?>
<p>
	<label for="amp-wp-<?php echo $id; ?>"><?php echo $label; ?></label>
	<input type="checkbox" id="amp-wp-<?php echo $id; ?>" name="amp-wp-<?php echo $id; ?>" value="1"
		   <?php checked( get_post_meta( $post->ID, 'disable-amp-wp', true ), 1 ); ?>
	/>
	<?php if ( $desc ) { ?>
	<span class="tips"><?php echo $desc; ?></span>
	<?php } ?>
</p>
<?php
	}

	/**
	 * Callback to save post metabox
	 *
	 * @since   1.0.0
	 *
	 * @param   int    $post_id
	 */
	public function save_metaboxes( $post_id ) {

		if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
			return;
		}

		/**
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if nonce is set.
		if ( null == filter_input( INPUT_POST, 'amp-wp-meta-box-nonce' ) ) {
			return;
		}

		// Verify that the nonce is valid.
		check_admin_referer( 'amp-wp-meta-box', 'amp-wp-meta-box-nonce' );

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$amp_wp_enable = filter_input( INPUT_POST, 'amp-wp-enable' );
		if ( empty( $amp_wp_enable ) ) {
			delete_post_meta( $post_id, 'disable-amp-wp' );
		} else {
			update_post_meta( $post_id, 'disable-amp-wp', '1' );
		}
	}
}
new Amp_WP_Meta_Box();
