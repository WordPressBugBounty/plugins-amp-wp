<?php
/**
 * Class Amp_WP_Custom_Script
 *
 * @since 1.5.12
 */
class Amp_WP_Custom_Script {

	/**
	 * Store self instance.
	 *
	 * @since 1.5.12
	 * @var self
	 */
	protected static $instance;


	/**
	 * Data storage.
	 *
	 * @since 1.5.12
	 * @var array
	 */
	protected $stack = array();


	/**
	 * Store Linked shortcodes list.
	 *
	 * @since 1.5.12
	 * @var array
	 */
	protected $shortcodes = array();

	/**
	 * Get singleton instance.
	 *
	 * @since 1.5.12
	 * @return self
	 */
	public static function Run() {

		if ( ! self::$instance instanceof self ) {

			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Initialize the module.
	 *
	 * @since 1.5.12
	 */
	protected function init() {
		add_action( 'amp_wp_template_head_deferred', array( $this, 'print_hash_meta' ), 3 );
		add_action( 'amp_wp_template_head_deferred', array( $this, 'print_script_tags' ) );
		add_action( 'amp_wp_template_enqueue_scripts', array( $this, 'enqueue_amp_scripts' ) );
		add_action( 'amp_wp_template_body_start', array( $this, 'print_amp_script_tags' ), 99 );
	}

	/**
	 * Enqueue dependencies.
	 *
	 * @hooked better-amp/template/enqueue-scripts
	 *
	 * @since  1.5.12
	 */
	public function enqueue_amp_scripts() {

		if ( empty( $this->stack ) ) {
			return;
		}

		amp_wp_enqueue_script( 'amp-script', 'https://cdn.ampproject.org/v0/amp-script-0.1.js' );
	}

	/**
	 * Render linked shortcodes.
	 *
	 * @param array  $attributes
	 * @param string $content
	 * @param string $shortcode_tag
	 *
	 * @since 1.5.12
	 */
	public function render_shortcode( $attributes, $content, $shortcode_tag ) {

		if ( empty( $this->shortcodes[ $shortcode_tag ] ) ) {

			return 'There is something wrong. :-/';
		}

		$id              = $this->shortcodes[ $shortcode_tag ]['id'];
		$callback        = $this->shortcodes[ $shortcode_tag ]['callback'];
				$wrapper = $this->view_wrapper( $id );

		return $wrapper['before'] . $callback( $attributes, $content, $shortcode_tag ) . $wrapper['after'];
	}

	/**
	 * Add inline AMP custom script.
	 *
	 * @param string $id
	 * @param string $script
	 *
	 * @since 1.5.12
	 * @return bool true on success or false otherwise.
	 */
	public function add_inline( $id, $script ) {

		if ( empty( $script ) ) {

			return false;
		}

		$script = trim( $script );

		$this->stack[ $id ] = array(
			'type' => 'inline',
			'data' => $script,
			'hash' => $this->hash( $script ),
		);

		return true;
	}

	/**
	 * Add AMP custom script file.
	 *
	 * @param string $id         unique id.
	 * @param string $url        script file URL.
	 * @param string $local_file Absolute path to the script file.
	 *
	 * @since 1.5.12
	 * @return bool true on success or false otherwise.
	 */
	public function add( $id, $url, $local_file = '' ) {

		if ( ! is_ssl() && ( $contents = amp_wp_file_get_contents( $local_file ) ) ) {
			$this->add_inline( $id, $contents );
		} else {
			$this->stack[ $id ] = array(
				'type'  => 'file',
				'url'   => $url,
				'local' => $local_file,
			);
		}

		return true;
	}

	/**
	 * Link an script to a WordPress shortcode.
	 *
	 * @param string $id
	 * @param string $shortcode_tag
	 *
	 * @return bool true on success
	 */
	public function map_shortcode( $id, $shortcode_tag ) {
		global $shortcode_tags;

		if ( empty( $this->stack[ $id ] ) || empty( $shortcode_tags[ $shortcode_tag ] ) ) {

			return false;
		}

		$this->shortcodes[ $shortcode_tag ] = array(
			'callback' => $shortcode_tags[ $shortcode_tag ],
			'id'       => $id,
		);

		$this->stack[ $id ]['have_shortcode'] = true;

		add_shortcode( $shortcode_tag, array( $this, 'render_shortcode' ) );

		return true;
	}

	/**
	 * Print script contents hash.
	 *
	 * @since 1.5.12
	 */
	public function print_hash_meta() {

		$hash_list = '';

		foreach ( $this->stack as $script ) {

			if ( ! empty( $script['hash'] ) ) {
				$hash_list .= $script['hash'];
				$hash_list .= "\n";
			}
		}

		if ( $hash_list ) {
			printf( '%s<meta name="amp-script-src" content="%s" />', "\n\t", $hash_list );
		}

	}

	/**
	 * Print <script> tags.
	 *
	 * @since 1.5.12
	 */
	public function print_script_tags() {

		foreach ( $this->stack as $id => $script ) {

			if ( $script['type'] === 'inline' ) {
				printf( '%s<script id="%s" type="text/plain" target="amp-script">%s</script>', "\n\t", $id, $script['data'] );
			}
		}
	}

	/**
	 * Print <amp-script> tags.
	 *
	 * @since 1.5.12
	 */
	public function print_amp_script_tags() {

		foreach ( $this->stack as $id => $script ) {

			if ( $script['type'] === 'file' ) {
				printf( '%s<amp-script src="%s"></amp-script>', "\n\t", $script['url'] );
			}
		}
	}


	/**
	 * Generate sha384 hash.
	 *
	 * @param string $script
	 *
	 * @since 1.5.12
	 * @return string
	 */
	public function hash( $script ) {

		$sha384 = hash( 'sha384', $script, true );

		if ( false === $sha384 ) {

			return '';
		}

		return 'sha384-' . str_replace(
			array( '+', '/', '=' ),
			array( '-', '_', '.' ),
			base64_encode( $sha384 )
		);
	}

	/**
	 * Dose custom script have a linked view.
	 *
	 * @param string $id
	 *
	 * @since 1.5.12
	 * @return bool
	 */
	public function have_view( $id ) {

		return ! empty( $this->stack[ $id ]['have_shortcode'] );
	}


	/**
	 * Get wrapper for the view.
	 *
	 * @since 1.5.12
	 *
	 * @return array
	 */
	public function view_wrapper( $id ) {

		if ( empty( $this->stack[ $id ] ) ) {

			return array();
		}

		$script = &$this->stack[ $id ];

		if ( ! empty( $script['type'] ) && $script['type'] === 'inline' ) {

			$this->enqueue_amp_scripts();

			return array(
				'before' => sprintf( '<amp-script layout="container" script="%s">', $id ),
				'after'  => '</amp-script>',
			);
		}

		if ( ! empty( $script['url'] ) ) {

			$this->enqueue_amp_scripts();

			return array(
				'before' => sprintf( '<amp-script layout="container" src="%s">', $script['url'] ),
				'after'  => '</amp-script>',
			);
		}

		return array();
	}
}
