<?php
/**
 * Base component class
 *
 * AMP components can extend this class and use the utility methods
 *
 * Methods:
 *
 *
 * ├── Cache Methods:
 *      ├── cache_get: Fetch data from cache storage
 *      │
 *      └── cache_set: Store data in cache
 *
 * @since 1.0.0
 */
abstract class Amp_WP_Component_Base {

	/**
	 * Flag to enable component scripts
	 *
	 * If( true ):
	 *      The component script will print before </head> tag scripts list should added in config method
	 *
	 * @see     Amp_WP_Component_Interface::config documentation
	 *
	 * If( false )
	 *   The scripts will not append into theme head
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	public $enable_enqueue_scripts = false;

	/**
	 * Retrieve the content of the highest priority amp template file that exists.
	 *
	 * @param   array|string $template_names
	 * @param   array        $props
	 * @param   bool         $load         If true the template file will be loaded if it is found.
	 * @param   bool         $require_once Whether to require_once or require. Default true. Has no effect if $load is
	 *                                   false.
	 *
	 * @since 1.0.0
	 *
	 * @return string file content
	 */
	protected function locate_template( $template_names, $props = array(), $load = true, $require_once = true ) {
		ob_start();
		amp_wp_set_prop( get_class( $this ), $props );
		amp_wp_locate_template( $template_names, $load, $require_once );
		return ob_get_clean();
	}
}
