<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link http://pixelative.co
 * @since 1.0.0
 *
 * @package Amp_WP
 * @subpackage Amp_WP/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Amp_WP
 * @subpackage Amp_WP/public
 * @author     Pixelative <mohsin@pixelative.co>
 */
class Amp_WP_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Default endpoint for AMP URL of site. This can be overridden by filter.
	 *
	 * @since   1.0.4
	 */
	const SLUG = 'amp';

	/**
	 * Default Endpoint for AMP URL of Site.
	 * This cna Can Be Overridden by Filter
	 *
	 * @var      string
	 *
	 * @since   1.0.0
	 */
	const AMP_WP_STARTPOINT = self::SLUG;

	/**
	 * Hook 'pre_get_posts' priority
	 *
	 * @var      int
	 *
	 * @since   1.0.0
	 */
	const AMP_WP_ISOLATE_QUERY_HOOK_PRIORITY = 100;

	/**
	 * Store amp_wp_head action callbacks
	 *
	 * @see amp_wp_collect_and_remove_head_actions
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	private $head_actions;

	/**
	 * Store Array of Posts Id to Exlucde Transform Permalinks to Amp
	 *
	 * Array structure: array {
	 *      'post id' => dont care,
	 *      ...
	 * }
	 *
	 * @see amp_wp_transform_post_link_to_amp
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	public $excluded_posts_id = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param   string $plugin_name    The name of the plugin.
	 * @param   string $version        The version of this plugin.
	 * @since       1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		// Setup Initial Configurations for AMP WP.
		add_action( 'amp_wp_default_configurations', array( $this, 'default_configurations' ) );

		$this->register_autoload();

		// Registers the AMP Rewrite Rules.
		add_action( 'init', array( $this, 'amp_wp_add_rewrite' ) );
		add_action( 'init', array( $this, 'amp_wp_append_index_rewrite_rule' ) );

		// Initialize AMP Components.
		add_action( 'init', array( $this, 'amp_wp_include_components' ) );

		// Changes Page Template File With AMP Template File.
		add_filter( 'template_include', array( $this, 'amp_wp_include_template_file' ), 9999 );

		// Override Template File.
		add_filter( 'comments_template', array( $this, 'amp_wp_override_comments_template' ), 9999 );

		// Initialize AMP Theme and It’s Functionality.
		add_action( 'after_setup_theme', array( $this, 'amp_wp_template_functions' ), 1 );

		// Register the AMP special shortcode ports.
		add_filter( 'the_content', array( $this, 'register_components_shortcodes' ), 1 );

		// Replace All Links Inside Contents to AMP Version.
		// Stops User to Go Outside of AMP Version.
		add_action( 'wp', array( $this, 'amp_wp_replace_internal_links_with_amp_version' ) );

		// Registers All Components Scripts Into the Header Style and Scripts.
		add_action( 'amp_wp_template_enqueue_scripts', array( $this, 'amp_wp_enqueue_components_scripts' ) );

		// Let the Components to Do Their Functionality in Head.
		add_action( 'amp_wp_template_head', array( $this, 'amp_wp_trigger_component_head' ), 0 );

		// Collect All Output to Can Enqueue Only Needed Scripts and Styles in Pages.
		add_filter( 'template_include', array( $this, 'amp_wp_buffer_start' ), 1 );
		add_action( 'amp_wp_template_footer', array( $this, 'amp_wp_buffer_end' ), 999 );

		// Collect and Rollback All Main Query Posts to Disable Thirdparty Codes to Change Main Query!
		// Action After 1000 Priority Can Work.
		add_action( 'pre_get_posts', array( $this, 'amp_wp_isolate_pre_get_posts_start' ), 1 );
		add_action( 'pre_get_posts', array( $this, 'amp_wp_isolate_pre_get_posts_end' ), self::AMP_WP_ISOLATE_QUERY_HOOK_PRIORITY );

		add_action( 'template_redirect', array( $this, 'amp_wp_redirect_endpoint_url' ) );
		add_filter( 'redirect_canonical', array( $this, 'amp_wp_fix_prevent_extra_redirect_single_pagination' ) );

		add_filter( 'request', array( $this, 'amp_wp_fix_search_page_queries' ) );

		// Auto Redirect Mobile Users.
		add_action( 'template_redirect', array( $this, 'amp_wp_auto_redirect_to_amp' ), 1 );

		// Init AMP WP JSON-LD.
		add_action( 'template_redirect', 'Amp_WP_Public::amp_wp_init_json_ld', 1 );

		$this->amp_wp_fix_front_page_display_options();

		// Fire the modules.
		Amp_WP_Redirect_Router::Run();
		Amp_WP_Custom_Script::Run();
	}

	/**
	 * Setup Initial Configurations for AMP WP
	 *
	 * @since       1.2.1
	 * @since       1.3.0       Added default options for meta date, author & tags,
	 */
	public function default_configurations() {

		$this->amp_wp_add_rewrite();
		set_transient( 'amp-wp-flush-rules', true );

		update_option( 'amp_wp_general_settings', array( 'theme_name' => 'tez' ) );

		// General Settings Setup.
		$general_default_settings = array(
			'amp_on_home'          => 1,
			'amp_on_search'        => 1,
			'url_structure'        => 'end-point',
			'mobile_auto_redirect' => 1,
			'theme_name'           => 'tez',
		);

		$general_stored_settings   = get_option( 'amp_wp_general_settings', array() );
		$general_settings_to_store = array_merge( $general_default_settings, $general_stored_settings );
		update_option( 'amp_wp_general_settings', $general_settings_to_store );

		// Layout Settings Setup.
		$layout_default_settings = array(
			'is_show_search'                   => 1,
			'is_sticky_header'                 => 1,
			'is_show_sidebar'                  => 1,
			'non_amp_version'                  => 1,
			'home_page_layout'                 => 'listing-2',
			'slider_on_home'                   => 1,
			'slider_on_home_count'             => 3,
			'slider_on_home_post_date'         => 1,
			'slider_on_home_post_author'       => 1,
			'archive_page_layout'              => 'listing-2',
			'show_author_in_archive'           => 1,
			'show_date_in_archive'             => 1,
			'show_thumbnail'                   => 1,
			'show_author_in_single'            => 1,
			'show_date_in_single'              => 1,
			'show_tags'                        => 1,
			'social_share_on_post'             => 'show',
			'social_share_on_post_count'       => 'total',
			'social_share_on_post_link_format' => 'standard',
			'social_share_links'               => array(
				'email'       => 'Email',
				'facebook'    => 'Facebook',
				'twitter'     => 'Twitter',
				'google_plus' => 'Google Plus',
			),
			'show_related_posts'               => 1,
			'show_related_post_count'          => 3,
			'show_related_post_algorithm'      => 'cat',
			'show_related_post_thumbnail'      => 1,
			'show_related_post_date'           => 1,
			'show_related_post_author'         => 1,
			'show_comments'                    => 1,
		);

		$layout_stored_settings   = get_option( 'amp_wp_layout_settings', array() );
		$layout_settings_to_store = array_merge( $layout_default_settings, $layout_stored_settings );
		update_option( 'amp_wp_layout_settings', $layout_settings_to_store );

		if ( ! is_network_admin() ) {
			set_transient( '_amp_wp_page_welcome_redirect', 1, 30 );
		}
	}

	/**
	 * Register an autoloader for AMP WP classes
	 *
	 * @since 1.0.0
	 */
	public function register_autoload() {
		spl_autoload_register( array( __CLASS__, 'autoload_amp_classes' ) );
	}

	/**
	 * Autoload handler for AMP WP classes only
	 *
	 * @param string $class_name Class to include.
	 *
	 * @since 1.0.0
	 */
	public static function autoload_amp_classes( $class_name ) {
		if ( substr( $class_name, 0, 7 ) !== 'Amp_WP_' ) {
			return;
		}

		$is_interface         = substr( $class_name, - 10 ) === '_Interface';
		$class_name_prefix    = $is_interface ? 'interface-' : 'class-';
		$sanitized_class_name = strtolower( $class_name );
		$sanitized_class_name = str_replace( '_', '-', $sanitized_class_name );

		// Remove interface suffix.
		if ( $is_interface ) {
			$sanitized_class_name = substr( $sanitized_class_name, 0, - 10 );
		}

		$class_file = AMP_WP_DIR_PATH . 'includes/' . $class_name_prefix . $sanitized_class_name . '.php';

		if ( file_exists( $class_file ) ) {
			require_once $class_file;
		}
	}

	/**
	 * Callback:    Add Rewrite Rules
	 * Action:      init
	 *
	 * @version     1.0.0
	 * @version     2.0.0   Added AMP End Point Rewrite Rule
	 * @since       1.0.0
	 */
	public function amp_wp_add_rewrite() {
		amp_wp_add_rewrite_start_point( self::AMP_WP_STARTPOINT, EP_ALL );

		/**
		 * "Automattic AMP for WordPress" Plugin Compatibility
		 */
		$amp_query_variable = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : self::AMP_WP_STARTPOINT;
		amp_wp_add_rewrite_end_point( $amp_query_variable, EP_ALL );
	}

	/**
	 * Add Rewrite Rule to Detect site.com/amp/ Requests
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_append_index_rewrite_rule() {
		add_rewrite_rule( self::AMP_WP_STARTPOINT . '/?$', 'index.php?amp=index', 'top' );
	}

	/**
	 * Include Active Template functions.php File If Exits
	 *
	 * Callback:    include
	 * action:      after_setup_theme
	 *
	 * @since       1.0.0
	 */
	public function amp_wp_template_functions() {
		if ( file_exists( AMP_WP_DIR_PATH . 'includes/functions/amp-wp-template-functions.php' ) ) {
			require_once AMP_WP_DIR_PATH . 'includes/functions/amp-wp-template-functions.php';
		}
	}

	/**
	 * Callback:    Include registered AMP components
	 * Action:      init
	 *
	 * @since       1.0.0
	 */
	public function amp_wp_include_components() {
		include AMP_WP_DIR_PATH . 'includes/components/class-amp-wp-img-component.php';
		include AMP_WP_DIR_PATH . 'includes/components/class-amp-wp-iframe-component.php';
		include AMP_WP_DIR_PATH . 'includes/components/class-amp-wp-carousel-component.php';
		include AMP_WP_DIR_PATH . 'includes/components/class-amp-wp-instagram-component.php';
		include AMP_WP_DIR_PATH . 'includes/components/class-amp-wp-playbuzz-component.php';
	}

	/**
	 * Callback:    Include AMP template file in AMP pages
	 * Action:      template_include
	 *
	 * @param       string $template_file_path Original Template File Path
	 *
	 * @access      public
	 * @version     1.0.0
	 * @since       1.0.0
	 *
	 * @return      string
	 */
	public function amp_wp_include_template_file( $template_file_path ) {
		if ( ! is_amp_wp() ) {
			return $template_file_path;
		}

		$include = $this->amp_wp_template_loader();
		if ( $include ) {
			return $include;
		}
	}

	/**
	 * Load a Template
	 *
	 * Handles Template Usage so That We Can Use Our Own Templates Instead of the Themes
	 *
	 * Templates are in the 'templates' folder. amp-wp looks for theme.
	 * overrides in /yourtheme/amp-wp/ by default.
	 *
	 * @see     Template Hierarchy Reference https://developer.wordpress.org/files/2014/10/wp-hierarchy.png
	 * @access  protected
	 * @return  string
	 */
	protected function amp_wp_template_loader() {

		if ( function_exists( 'is_embed' ) && is_embed() && $template = amp_wp_embed_template() ) :
		elseif ( is_404() && $template = amp_wp_404_template() ) :
		elseif ( is_search() && $template = amp_wp_search_template() ) :
		elseif ( amp_wp_is_static_home_page() && $template = amp_wp_static_home_page_template() ) :
			$this->amp_wp_set_page_query( apply_filters( 'amp_wp_template_page_on_front', 0 ) );
		elseif ( is_front_page() && $template = amp_wp_front_page_template() ) :
		elseif ( is_home() && $template = amp_wp_home_template() ) :
		elseif ( is_post_type_archive() && $template = amp_wp_post_type_archive_template() ) :
		elseif ( is_tax() && $template = amp_wp_taxonomy_template() ) :
		elseif ( is_attachment() && $template = amp_wp_attachment_template() ) :
			remove_filter( 'the_content', 'prepend_attachment' );
		elseif ( is_single() && $template = amp_wp_single_template() ) :
		elseif ( is_page() && $template = amp_wp_page_template() ) :
		elseif ( is_singular() && $template = amp_wp_singular_template() ) :
		elseif ( is_category() && $template = amp_wp_category_template() ) :
		elseif ( is_tag() && $template = amp_wp_tag_template() ) :
		elseif ( is_author() && $template = amp_wp_author_template() ) :
		elseif ( is_date() && $template = amp_wp_date_template() ) :
		elseif ( is_archive() && $template = amp_wp_archive_template() ) :
		elseif ( is_paged() && $template = amp_wp_paged_template() ) :
		else :
			$template = amp_wp_index_template();
		endif;

		return $template;
	}

	/**
	 * Replace amp comment file with theme file
	 *
	 * @param string $file
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function amp_wp_override_comments_template( $file ) {
		if ( is_amp_wp() ) {
			if ( $path = amp_wp_locate_template( basename( $file ) ) ) {
				return $path;
			}
		}
		return $file;
	}

	/**
	 * Add components shortcode before do_shortcodes
	 *
	 * @param string $content
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function register_components_shortcodes( $content = '' ) {

		if ( ! is_amp_wp() ) {
			return $content;
		}

		$this->amp_wp_call_components_method( 'register_shortcodes' );

		return $content;
	}

	/**
	 * Replaces All Website Internal Links With AMP Version
	 *
	 * @hooked wp
	 *
	 * @param WP $wp
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function amp_wp_replace_internal_links_with_amp_version( $wp ) {

		// if( empty( $wp->query_vars['amp'] ) ) {.
		if ( ! isset( $wp->query_vars['amp'] ) ) {
			return;
		}

		add_filter( 'nav_menu_link_attributes', array( 'Amp_WP_Content_Sanitizer', 'replace_href_with_amp' ) );
		add_filter( 'the_content', array( 'Amp_WP_Content_Sanitizer', 'transform_all_links_to_amp' ) );

		add_filter( 'author_link', array( 'Amp_WP_Content_Sanitizer', 'transform_to_amp_url' ) );
		add_filter( 'term_link', array( 'Amp_WP_Content_Sanitizer', 'transform_to_amp_url' ) );

		add_filter( 'post_link', array( $this, 'amp_wp_transform_post_link_to_amp' ), 20, 2 );
		add_filter( 'page_link', array( $this, 'amp_wp_transform_post_link_to_amp' ), 20, 2 );
		add_filter( 'attachment_link', array( 'Amp_WP_Content_Sanitizer', 'transform_to_amp_url' ) );
		add_filter( 'post_type_link', array( 'Amp_WP_Content_Sanitizer', 'transform_to_amp_url' ) );
	}

	/**
	 * Transform allowed posts URL to AMP
	 *
	 * @param string      $url  The Post's Permalink.
	 * @param WP_Post|int $post The post object/id of the post.
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	public function amp_wp_transform_post_link_to_amp( $url, $post ) {
		$post_id = isset( $post->ID ) ? $post->ID : $post;

		if ( 'page' == $this->amp_wp_get_option( 'show_on_front' ) && $post_id == $this->amp_wp_get_option( 'page_on_front' ) ) {
			$url = home_url( '/' );
		}

		if ( isset( $this->excluded_posts_id[ $post_id ] ) ) {
			return $url;
		}

		return Amp_WP_Content_Sanitizer::transform_to_amp_url( $url );
	}

	/**
	 * Append AMP Components JavaScript If AMP Version Requested
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_enqueue_components_scripts() {
		$deps = array( 'ampproject' );
		amp_wp_enqueue_script( $deps[0], 'https://cdn.ampproject.org/v0.js' );

		// Enqueues all needed scripts of components with 'ampproject' dependency.
		$this->amp_wp_call_components_method( 'enqueue_amp_scripts', $deps );

		if ( current_theme_supports( 'amp-wp-navigation' ) && current_theme_supports( 'amp-wp-has-nav-child' ) ) {
			amp_wp_enqueue_script( 'amp-accordion', 'https://cdn.ampproject.org/v0/amp-accordion-0.1.js' );
		}
		if ( current_theme_supports( 'amp-wp-form' ) ) {
			amp_wp_enqueue_script( 'amp-form', 'https://cdn.ampproject.org/v0/amp-form-0.1.js' );
		}
	}

	/**
	 * Callback: Fire head method of component for following purpose:
	 * 1) Component able to add_filter or add_action if needed
	 * 2) Create fresh instance of each component and cache
	 *
	 * Action:  amp_wp_template_head
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_trigger_component_head() {
		$this->amp_wp_call_components_method( 'head' );
	}

	/**
	 * Callback: Starts the Collecting Output to Enable Components to Add Style Into Head
	 * Print Theme Completely Then Fire amp_wp_head() Callbacks and Append It Before </head>
	 *
	 * Filter:  template_include
	 *
	 * @see     amp_wp_buffer_end
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_buffer_start( $template ) {

		if ( is_amp_wp() ) {
			ob_start();
		}

		return $template;
	}

	/**
	 * Collect amp_wp_head actions and remove those actions
	 *
	 * @see   amp_wp_head
	 *
	 * @since 1.0.0
	 */
	public function amp_wp_collect_and_remove_head_actions() {
		$actions            = &$GLOBALS['wp_filter']['amp_wp_template_head'];
		$this->head_actions = $actions;
		$actions            = array();
	}

	/**
	 * Callback: Fire amp_wp_head() and print buffered output
	 * Action:  amp_wp_template_footer
	 *
	 * @see amp_wp_buffer_start
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_buffer_end() {

		/*
		$content = ob_get_clean();
		$prepend = '';

		if ( ! amp_wp_is_customize_preview() ) {
			$prepend .= '</head>';

			// Convert Output to Valid AMP HTML
			$instance = new Amp_WP_Html_Util();
			$instance->loadHTML( '<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html; charset=utf-8">' . $content . '</body></html>', null, false );

			preg_match( '#(<\s*body[^>]*>)#isx', $content, $match );
			$prepend .= isset( $match[1] ) ? $match[1] : '<body>'; // Open body tag.

			$this->amp_wp_render_content( $instance, true ); // Convert HTML top amp html
			// @see 'Amp_WP_Component::enqueue_amp_tags_script'.
			$this->amp_wp_call_components_method( 'enqueue_amp_tags_script', $instance );

			$content = $instance->get_content( true );
			// End convert output to valid amp html.
		}

		$GLOBALS['wp_filter']['amp_wp_template_head'] = $this->head_actions;
		$this->head_actions                           = array();
		do_action( 'amp_wp_template_head' );
		echo $prepend, $content;
		*/
		$content = ob_get_clean();
		if ( ! amp_wp_is_customize_preview() ) {

			// Convert output to valid amp html.
			$instance = new Amp_WP_Html_Util();
			$instance->loadHTML( $content . '</body></html>', null, false );
			$this->amp_wp_render_content( $instance, true ); // Convert HTML top amp html.

			// @see Amp_WP_Component::enqueue_amp_tags_script
			$this->amp_wp_call_components_method( 'enqueue_amp_tags_script', $instance );
			$content  = $instance->saveHTML();
			$instance = null;
		}

		if ( ! preg_match( '#^(.*?)(<\s*\/\s*head[^>]*> .+) $#isx', $content, $match ) ) {
			echo $content;
			return;
		}

		$content = null;

		// markup upto </head> tag.
		echo $match[1];

		do_action( 'amp_wp_template_head_deferred' );

		// markup </head> and <body>.
		echo $match[2];
	}

	/**
	 * Transforms HTML Content to AMP Content
	 *
	 * todo: Add File Caching
	 *
	 * @param   Amp_WP_Html_Util $instance
	 * @param   boolean          $sanitize
	 *
	 * @since   1.0.0
	 */
	public function amp_wp_render_content( Amp_WP_Html_Util $instance, $sanitize = false ) {
		$this->amp_wp_call_components_method( 'render', $instance );
		if ( $sanitize ) {
			$sanitizer = new Amp_WP_Content_Sanitizer( $instance );
			$sanitizer->sanitize();
		}
	}

	/**
	 * Fire specific method of all components
	 *
	 * @param string $method_name component method
	 *
	 * @param mixed  $param
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function amp_wp_call_components_method( $method_name, $param = null ) {
		global $amp_wp_registered_components;

		if ( ! $amp_wp_registered_components ) {
			return $param;
		}

		// Collect and prepare method arguments.
		$args = func_get_args();
		$args = array_slice( $args, 1 );
		if ( ! isset( $args[0] ) ) {
			$args[0] = null;
		}

		// Iterate registered components and call method on them.
		foreach ( $amp_wp_registered_components as $component ) {
			$instance = Amp_WP_Component::instance( $component['component_class'] );
			if ( $this->_amp_wp_can_call_component_method( $instance, $method_name, $args ) ) {
				$args[0] = call_user_func_array( array( $instance, $method_name ), $args );
			}
		}
		return $args[0];
	}

	/**
	 * Determines that method exists and is callable on object instance
	 *
	 * @param   Amp_WP_Component $instance    Live object of Amp_WP_Component
	 * @param   string           $method_name Method of object
	 * @param   array            $args
	 *
	 * @access  private
	 * @since   1.0.0
	 *
	 * @return bool
	 */
	private function _amp_wp_can_call_component_method( &$instance, &$method_name, &$args ) {
		$return = is_callable( array( $instance, $method_name ) );
		switch ( $method_name ) {
			case 'enqueue_amp_scripts':
				$return = $return && $instance->can_enqueue_scripts();
				break;
		}
		return $return;
	}

	/**
	 * Callback: Prevent Third Party Codes to Change the Main Query on AMP Version
	 *
	 * You Can Add Action To 'pre_get_posts' With Priority Greater Than 1000 to Change It.
	 *
	 * Action:  pre_get_posts
	 *
	 * @see     amp_wp_isolate_pre_get_posts_end
	 *
	 * @param   WP_Query $wp_query
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_isolate_pre_get_posts_start( $wp_query ) {
		global $amp_wp_isolate_pre_get_posts;
		if ( is_amp_wp( $wp_query ) && ! is_admin() && $wp_query->is_main_query() ) {
			$amp_wp_isolate_pre_get_posts = $wp_query->query_vars;
		}
	}

	/**
	 * Rollback the Main Query Vars.
	 *
	 * @see 'amp_wp_isolate_pre_get_posts_end' for more documentation
	 *
	 * Action:  pre_get_posts
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param WP_Query $wp_query
	 */
	public function amp_wp_isolate_pre_get_posts_end( &$wp_query ) {
		global $amp_wp_isolate_pre_get_posts;
		if ( is_amp_wp( $wp_query ) && ! is_admin() && $wp_query->is_main_query() ) {
			if ( $amp_wp_isolate_pre_get_posts ) {
				$wp_query->query_vars = $amp_wp_isolate_pre_get_posts;
				unset( $amp_wp_isolate_pre_get_posts );
			}
		}
	}

	/**
	 * Handy fix for changing search query
	 *
	 * @param   mixed $q
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  mixed
	 */
	public function amp_wp_fix_search_page_queries( $q ) {
		if ( ! empty( $q['amp'] ) && ! empty( $q['s'] ) ) {
			$q['post_type'] = array( 'post' );
		}
		return $q;
	}

	/**
	 * "Automattic AMP" Plugin Compatibility
	 *
	 * Redirect AMP URLs With AMP Endpoint to New AMP URL
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_redirect_endpoint_url() {
		if ( ! amp_wp_get_permalink_structure() ) {
			return;
		}

		if ( amp_wp_url_format() === 'start-point' ) {
			$this->redirect_to_start_point_amp();
		} else {
			$this->redirect_to_end_point_amp();
		}
	}

	/**
	 * Redirect end-point AMP URLs to start-point
	 *
	 * @since 1.0.4
	 */
	public function redirect_to_start_point_amp() {

		// Disable Functionality in Customizer Preview.
		if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
			return; }

		$amp_qv = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : 'amp';
		if ( get_query_var( $amp_qv, false ) === false ) {
			if ( ! is_404() ) { // /amp at the end of some urls cause 404 error
				return;
			}
		}

		$path        = amp_wp_get_wp_installation_slug();
		$request_url = str_replace( $path, '', $_SERVER['REQUEST_URI'] );
		$url_prefix  = preg_quote( amp_wp_permalink_prefix(), '#' );
		preg_match( "#^/*$url_prefix(.*?)/$amp_qv/*$#", $request_url, $automattic_amp_match );

		if ( ! $this->amp_version_exists() ) {
			if ( ! empty( $automattic_amp_match[1] ) ) {
				$redirect_url = home_url( $automattic_amp_match[1] );
			} elseif ( preg_match( "#^/*$amp_qv/+(.*?)/*$#", $request_url, $matched ) ) {
				$redirect_url = home_url( $matched[1] );
			} else {
				$redirect_url = amp_wp_get_canonical_url();
			}
			if ( $redirect_url ) {
				wp_redirect( $redirect_url );
				exit;
			}
		}

		if ( ! empty( $automattic_amp_match[1] ) ) {
			$new_amp_url = Amp_WP_Content_Sanitizer::transform_to_amp_url( site_url( $automattic_amp_match[1] ) );
			$new_amp_url = trailingslashit( $new_amp_url );

			if ( $new_amp_url && trim( str_replace( site_url(), '', $new_amp_url ), '/' ) !== trim( $request_url, '/' ) ) {
				wp_redirect( $new_amp_url, 301 );
				exit;
			}
		}
	}

	/**
	 * Redirect end-point AMP URLs to end-point
	 *
	 * @since 1.0.4
	 */
	public function redirect_to_end_point_amp() {

		// Disable Functionality in Customizer Preview.
		if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
			return; }

		$request_url = str_replace( amp_wp_get_wp_installation_slug(), '', $_SERVER['REQUEST_URI'] );
		if ( ! preg_match( '#^/?([^/]+)(.+)#', $request_url, $match ) ) {
			return; }

		$slug = self::SLUG;
		if ( $match[1] !== $slug ) {
			return; }

		/**
		 * Skip redirection for AMP pages because it looks like like start-point!
		 *
		 * EX:
		 *  amp/page/2   ✔
		 *  /page/2/amp  ✘
		 */
		if ( preg_match( "#$slug/page/?([0-9]{1,})/?$#", $request_url ) ) {
			return;
		}

		$new_amp_url = trailingslashit( Amp_WP_Content_Sanitizer::transform_to_amp_url( home_url( $match[2] ) ) );
		if ( $new_amp_url && trim( $match[2], '/' ) !== '' ) {
			wp_redirect( $new_amp_url, 301 );
			exit;
		}
	}

	/**
	 * Prevent Redirect Pages Within Single Post
	 *
	 * @param   bool $redirect
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @return  bool
	 */
	public function amp_wp_fix_prevent_extra_redirect_single_pagination( $redirect ) {
		if ( $redirect && is_amp_wp() && get_query_var( 'page' ) > 1 ) {
			return false;
		}
		return $redirect;
	}

	/**
	 * Get Requested Page URL
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	public static function amp_wp_get_requested_page_url() {
		if ( isset( $_SERVER['HTTP_HOST'] ) ) {
			$requested_url  = is_ssl() ? 'https://' : 'http://';
			$requested_url .= $_SERVER['HTTP_HOST'];
			$requested_url .= $_SERVER['REQUEST_URI'];

			return $requested_url;
		}
		return '';
	}

	/**
	 * Redirect users to AMP version of the page automatically.
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_auto_redirect_to_amp() {
		if ( is_amp_wp() ) {
			return;
		}
		if ( ! apply_filters( 'amp_wp_template_auto_redirect', false ) ) {
			return;
		}

		if ( ! empty( $_GET['amp-wp-skip-redirect'] ) || ! empty( $_COOKIE['amp-wp-skip-redirect'] ) ) {
			if ( ! isset( $_COOKIE['amp-wp-skip-redirect'] ) ) {
				setcookie( 'amp-wp-skip-redirect', true, time() + DAY_IN_SECONDS, '/' );
			}
			return;
		} else {
			if ( isset( $_COOKIE['amp-wp-skip-redirect'] ) ) {
				unset( $_COOKIE['amp-wp-skip-redirect'] );
			}
		}

		// if post have not AMP version.
		if ( ! $this->amp_version_exists() ) {
			return;
		}

		if ( wp_is_mobile() ) {
			$requested_url = self::amp_wp_get_requested_page_url();
			$amp_permalink = Amp_WP_Content_Sanitizer::transform_to_amp_url( $requested_url );

			if ( $requested_url && $amp_permalink && $amp_permalink !== $requested_url ) {
				wp_redirect( $amp_permalink );
				exit;
			}
		} elseif ( self::amp_wp_have_cache_plugin() ) {
			// Adds advanced javascript code to page to redirect page in front end!
			// Last and safest way to redirect but it will have a little delay!
			add_action( 'wp_print_scripts', array( $this, 'amp_wp_print_mobile_redirect_script' ) );
		}
	}

	/**
	 * Is Any Caching Plugin Install on This WordPress Installation
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return bool
	 */
	public function amp_wp_have_cache_plugin() {
		if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
			return true;
		}

		// Fix for "WP Fastest Cache" plugin.
		if ( $plugins = array_flip( wp_get_active_and_valid_plugins() ) ) {
			return isset( $plugins[ WP_PLUGIN_DIR . '/wp-fastest-cache/wpFastestCache.php' ] );
		}

		return false;
	}

	/**
	 * Print Script to Redirect Mobile Devices to AMP Version
	 *
	 * @access  public
	 * @version 1.0.0
	 * @since       1.0.0
	 * @since       1.0.4       Fix: Mobile users force redirect.
	 */
	public function amp_wp_print_mobile_redirect_script() {
		$requested_url = self::amp_wp_get_requested_page_url();
		$amp_permalink = Amp_WP_Content_Sanitizer::transform_to_amp_url( $requested_url );

		if ( ! $requested_url || ! $amp_permalink || $amp_permalink === $requested_url ) {
			return;
		}

		$script = amp_wp_file_get_contents( amp_wp_min_suffix( AMP_WP_DIR_PATH . 'public/js/mobile_redirect', '.js' ) );
		$script = str_replace( '%%amp_permalink%%', $amp_permalink, $script );
		?>
		<script><?php echo $script; ?></script>
		<?php
	}

	/**
	 * Initialize AMP WP JSON-LD
	 */
	public static function amp_wp_init_json_ld() {
		if ( ! is_amp_wp() ) {
			return;
		}

		$amp_wp_structured_data_settings = get_option( 'amp_wp_structured_data_settings' );
		$structured_data_switch          = ( isset( $amp_wp_structured_data_settings['structured_data_switch'] ) && ! empty( $amp_wp_structured_data_settings['structured_data_switch'] ) ) ? $amp_wp_structured_data_settings['structured_data_switch'] : '';

		if ( '1' == $structured_data_switch ) {

			if ( ! class_exists( 'Amp_WP_Json_Ld_Generator' ) ) {
				include AMP_WP_DIR_PATH . 'includes/class-amp-wp-json-ld-generator.php';
			}

			// Config AMP WP JSON-LD.
			add_filter( 'amp_wp_json_ld_config', 'Amp_WP_Public::config_json_ld', 15 );
		}
	}

	/**
	 * Configurations of JSON-LD
	 *
	 * @param   $config
	 * @since   1.0.0
	 *
	 * @return  mixed
	 */
	public static function config_json_ld( $config ) {
		$branding = amp_wp_get_branding_info();
		if ( ! empty( $branding['logo']['src'] ) ) {
			$config['logo'] = $branding['logo']['src'];
		}
		return $config;
	}

	/**
	 * Fix Front Page Display Option to Detect Homepage
	 *
	 * @access  1.0.0
	 * @version 1.0.0
	 * @since   1.0.0
	 * @since   1.5.5   Update hook from ad_action to add_filter
	 */
	public function amp_wp_fix_front_page_display_options() {
		add_filter( 'pre_option_page_on_front', array( $this, 'amp_wp_return_zero_in_amp' ) );
		add_filter( 'pre_option_show_on_front', array( $this, 'amp_wp_fix_show_on_front' ) );
	}

	/**
	 * Just Return Zero in AMP Version
	 *
	 * @param mixed $current
	 *
	 * @access  1.0.0
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return mixed
	 */
	public function amp_wp_return_zero_in_amp( $current ) {
		if ( is_amp_wp() && empty( $GLOBALS['_amp_bypass_option'] ) ) {
			return 0;
		}
		return $current;
	}

	/**
	 * Just Return ‘Posts’ String in AMP Version
	 *
	 * @param mixed $current
	 *
	 * @access  1.0.0
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return mixed
	 */
	public function amp_wp_fix_show_on_front( $current ) {
		if ( is_amp_wp() && empty( $GLOBALS['_amp_bypass_option'] ) ) {
			return 'posts';
		}
		return $current;
	}

	/**
	 * Setup page query
	 *
	 * @param $page_id
	 *
	 * @access  1.0.0
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function amp_wp_set_page_query( $page_id ) {
		query_posts( 'page_id=' . $page_id . '&amp=' . get_query_var( 'amp' ) );
	}

	/**
	 * Check AMP version of the posts exists
	 *
	 * @since 1.0.0
	 * @return bool of exists
	 */
	public static function amp_version_exists() {

		static $filters;

		if ( self::is_amp_excluded_by_url() ) {
			return apply_filters( 'amp_wp_amp_version_exists', false );
		}

		if ( ! isset( $filters ) ) {
			$filters = wp_parse_args(
				apply_filters(
					'amp_wp_filter_config_list',
					array()
				),
				array(
					'disabled_post_types' => array(),
					'disabled_taxonomies' => array(),
					'disabled_homepage'   => false,
					'disabled_search'     => false,
				)
			);
		}

		if ( is_singular() ) {
			$post_id = get_queried_object_id();
		} elseif ( is_home() && amp_wp_is_static_home_page() ) {
			$post_id = intval( apply_filters( 'amp_wp_template_page_on_front', 0 ) );
		} else {
			$post_id = 0;
		}

		if ( $post_id ) {
			// if( get_post_meta( $post_id, 'disable-amp-wp', true ) || isset( $this->excluded_posts_id[$post_id] ) ) {.
			if ( get_post_meta( $post_id, 'disable-amp-wp', true ) ) {
				return apply_filters( 'amp_wp_amp_version_exists', false );
			}
		}

		if ( empty( $filters ) ) {
			return apply_filters( 'amp_wp_amp_version_exists', true );
		}

		if ( is_home() || is_front_page() ) {
			return apply_filters( 'amp_wp_amp_version_exists', ! $filters['disabled_homepage'] );
		}

		if ( is_search() ) {
			return apply_filters( 'amp_wp_amp_version_exists', ! $filters['disabled_search'] );
		}

		if ( is_singular() ) {
			return apply_filters( 'amp_wp_amp_version_exists', ! in_array( get_queried_object()->post_type, $filters['disabled_post_types'] ) );
		}

		if ( is_post_type_archive() ) {
			$queried_object = get_queried_object();
			if ( $queried_object instanceof WP_Post_Type ) { // WP >= 4.6.0.
				$post_type = $queried_object->name;
			} elseif ( $queried_object instanceof WP_Post ) { // WP < 4.6.0.
				$post_type = $queried_object->post_type;
			} else {
				return apply_filters( 'amp_wp_amp_version_exists', false );
			}
			return apply_filters( 'amp_wp_amp_version_exists', ! in_array( $post_type, $filters['disabled_post_types'] ) );
		}

		if ( is_tax() || is_category() || is_tag() ) {
			return apply_filters( 'amp_wp_amp_version_exists', ! in_array( get_queried_object()->taxonomy, $filters['disabled_taxonomies'] ) );
		}

		return apply_filters( 'amp_wp_amp_version_exists', true );
	}

	/**
	 * Whether to check if current page has been marked as non-AMP version?
	 *
	 * @since 1.4.1
	 *
	 * @return bool
	 */
	protected static function is_amp_excluded_by_url() {

		$excluded_patterns = amp_wp_excluded_urls_format();

		if ( ! $excluded_patterns ) {
			return false;
		}

		/**
		 * Get current page.
		 * $current_path = trim( str_replace( home_url(), '', amp_wp_guess_non_amp_url() ), '/' );
		 */
		$current_path = amp_wp_guess_non_amp_url();
		foreach ( $excluded_patterns as $url_format ) {

			if ( empty( $url_format ) ) {
				continue;
			}

			$url_format    = trim( $url_format );
			$apply_reg_exp = substr( $url_format, strlen( $url_format ) - 1 ) == '*';
			if ( $apply_reg_exp ) {

				// Format given url to valid PCRE regex.
				$pattern = amp_wp_transpile_text_to_pattern( $url_format, '/' );
				$pattern = '/' . trim( $pattern ) . '/';
				if ( preg_match( $pattern, $current_path ) ) {
					return true;
				}
			} else {
				if ( trim( $url_format, '/' ) == trim( $current_path, '/' ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Get WordPress option
	 *
	 * @param   string $option
	 * @param   mixed  $default   Boolean Variable.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	public static function amp_wp_get_option( $option, $default = false ) {
		$tmp                           = isset( $GLOBALS['_amp_bypass_option'] ) ? $GLOBALS['_amp_bypass_option'] : false;
		$GLOBALS['_amp_bypass_option'] = true;
		$results                       = get_option( $option, $default );
		$GLOBALS['_amp_bypass_option'] = $tmp;

		return $results;
	}
}
