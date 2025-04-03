<?php
/**
 * AMP WP Component Factory Class
 *
 * This class represents a factory for creating and managing AMP components.
 *
 * @package AMP_WP
 * @since 1.0.0
 */

/**
 * AMP WP Component Factory Class
 *
 * This class represents a factory for creating and managing AMP components.
 */
class Amp_WP_Component extends Amp_WP_Component_Base {

	/**
	 * The instance of the component class.
	 *
	 * @var Amp_WP_Component_Interface
	 * @since 1.0.0
	 */
	private $component;

	/**
	 * The class name of the component.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $class_name;

	/**
	 * Storage for component instances.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private static $instances;

	/**
	 * Get the instance of the component.
	 *
	 * This static method retrieves an instance of the component based on the provided component class name.
	 * An optional `$fresh` parameter can be set to `true` to force creating a new fresh object.
	 *
	 * @param string $component_class The component class name that implements Amp_WP_Component_Interface.
	 * @param bool   $fresh Whether to create a new fresh object. Default is `false`.
	 * @return Amp_WP_Component|bool The Amp_WP_Component object on success, or `false` on failure.
	 *
	 * @since 1.0.0
	 */
	public static function instance( $component_class, $fresh = false ) {
		if ( isset( self::$instances[ $component_class ] ) && ! $fresh ) {
			return self::$instances[ $component_class ];
		}

		if ( class_exists( $component_class ) ) {
			return self::$instances[ $component_class ] = new Amp_WP_Component( $component_class );
		}

		return false;
	}

	/**
	 * Clean instance storage cache
	 *
	 * @since 1.0.0
	 */
	public static function flush_instances() {
		self::$instances = array();
	}

	/**
	 * Constructor for the component wrapper class.
	 *
	 * This constructor initializes the component wrapper object.
	 * It takes a `$component_class` parameter representing the class name of the component to be instantiated.
	 *
	 * @since 1.0.0
	 *
	 * @param string $component_class The class name of the component.
	 */
	public function __construct( $component_class ) {
		$this->class_name = $component_class;
		$this->set_component_instance( new $this->class_name() );
	}

	/**
	 * Set a component class instance
	 *
	 * @param Amp_WP_Component_Interface $instance The instance of the component class.
	 * @since 1.0.0
	 */
	public function set_component_instance( Amp_WP_Component_Interface $instance ) {
		$this->component = $instance;
	}

	/**
	 * Get a component instance
	 *
	 * @return Amp_WP_Component_Interface;
	 *
	 * @since 1.0.0
	 */
	public function get_component_instance() {
		return $this->component;
	}

	/**
	 * Execute component and Transform HTML content to AMP content
	 *
	 * @param string $content The content to be transformed.
	 * @return string The transformed content.
	 *
	 * @since 1.0.0
	 */
	public function render( $content ) {
		return $this->component->transform( $content );
	}

	/**
	 * Get component config
	 *
	 * @see   Amp_WP_Component_Interface for more documentation
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_config() {
		return wp_parse_args(
			$this->component->config(),
			array(
				'shortcodes' => array(),
				'scripts'    => array(),
			)
		);
	}

	/**
	 * Registers shortcodes and blocks for the component.
	 *
	 * This method replaces the default shortcode with the component's shortcode and registers blocks for the component.
	 * It retrieves the component's configuration using the `get_config()` method.
	 * If the configuration defines any shortcodes, it iterates through them and replaces the existing shortcodes with the component's shortcodes using the `remove_shortcode()` and `add_shortcode()` functions.
	 * If the configuration defines any blocks, it iterates through them and unregisters the existing blocks with the same name using the `unregister_block_type()` function, then registers the component's blocks using the `register_block_type()` function.
	 *
	 * @since 1.0.0
	 */
	public function register_shortcodes() {
		$config = $this->get_config();
		if ( ! empty( $config['shortcodes'] ) ) {
			foreach ( $config['shortcodes'] as $shortcode => $callback ) {
				remove_shortcode( $shortcode );
				add_shortcode( $shortcode, $callback );
			}
		}

		if ( ! empty( $config['blocks'] ) ) {
			foreach ( $config['blocks'] as $name => $render_callback ) {
				unregister_block_type( $name );
				register_block_type( $name, compact( 'render_callback' ) );
			}
		}
	}

	/**
	 * Magic method handler for invoking component methods.
	 *
	 * Make private/protected methods readable for fire component method via this object instance
	 *
	 * @param string $method The name of the method to invoke.
	 * @param array  $args An array of arguments to pass to the method.
	 * @return mixed The result of the method call.
	 *
	 * @since 1.0.0
	 */
	public function __call( $method, $args ) {
		$callback = array( $this->component, $method );

		if ( is_callable( $callback ) ) {
			return call_user_func_array( $callback, $args );
		}
	}

	/**
	 * Enqueues the component script.
	 *
	 * @param array $deps An array of script dependencies. Default is an empty array.
	 * @return array The modified array of script dependencies.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_amp_scripts( $deps = array() ) {
		$config = $this->get_config();
		foreach ( $config['scripts'] as $name => $script ) {
			amp_wp_enqueue_script( $name, $script, $deps );
		}
		return $deps; // Pass $deps to work with series call {@see Amp_WP::call_component_method}.
	}

	/**
	 * Determines whether the script should be enqueued.
	 *
	 * @return bool Whether the script should be enqueued or not.
	 *
	 * @since 1.0.0
	 */
	public function can_enqueue_scripts() {
		return ! empty( $this->component->enable_enqueue_scripts );
	}

	/**
	 * Enqueue AMP component script if amp tag exists in the page and script was not printed yet
	 *
	 * @param Amp_WP_Html_Util $dom The HTML DOM object.
	 * @return Amp_WP_Html_Util The modified HTML DOM object.
	 */
	public function enqueue_amp_tags_script( $dom ) {
		$has_enqueue_scripts = $this->can_enqueue_scripts();

		// If script was not printed previously.
		if ( ! $has_enqueue_scripts ) {
			$config = $this->get_config();

			foreach ( $config['scripts'] as $tag => $script ) {
				if ( $dom->getElementsByTagName( $tag )->length ) {
					amp_wp_enqueue_script( $tag, $script, array( 'ampproject' ) );
				}
			}
		}
		return $dom;
	}
}
