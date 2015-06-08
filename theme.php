<?php

namespace Kenzol;

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! defined( 'THEMEPATH' ) )
	define( 'THEMEPATH', dirname( __FILE__ ) );

if ( ! defined( 'THEMEURI' ) )
	define( 'THEMEURI', get_template_directory_uri( __FILE__ ) );


//require_once( THEMEPATH . '/theme-abstract.php' );

/**
 * Class to init the WordPress theme
 *
 * @version: 0.1.2
 *
 * @package: Theme
 * @author : Moise Scalzo <moise.scalzo@gmail.com>
 */
class Theme {


	/**
	 * Init variable
	 *
	 * @var null
	 */

	private static $instance = null;


	/**
	 * Configuration array
	 *
	 * @access: public
	 * @since : 0.1.0
	 * @var   : array
	 */

	protected $conf = array();


	/**
	 * Styles
	 *
	 * @access: private
	 * @since : 0.1.0
	 * @var   : array
	 */

	private $styles = array();


	/**
	 * Scripts
	 *
	 * @access: private
	 * @since : 0.1.0
	 * @var   : array
	 */

	private $scripts = array();


	/**
	 * The path of Theme class
	 *
	 * @access: protected
	 * @since : 0.1.0
	 * @var
	 */
	protected $path;


	/**
	 * Query cache
	 *
	 * @access: protected
	 * @since : 0.1.0
	 * @var array
	 */

	protected $cache = array();


	/**
	 * Setup all the necessary constants
	 *
	 * @since : 0.1.0
	 */

	const VERSION = '0.1.0';


	/**
	 * Singleton pattern
	 *
	 * @access: private
	 * @since : 0.1.0
	 */

	private function __construct()
	{
		$this->path = THEMEPATH;
	}


	/**
	 * Public function to set the instance
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 * @param : $conf
	 * @return: null|\Theme
	 */

	public static function get_instance()
	{

		if ( self::$instance == null ) {
			self::$instance = new Theme();
			self::$instance->load_dependencies();
			self::$instance->add_hooks();
			self::$instance->sidebars();
			self::$instance->theme_support();
		}

		return self::$instance;
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Theme_Menu. Orchestrates the Menus.
	 * - All the custon file dependencies. Set them on the Theme configuration file.
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */

	private function load_dependencies()
	{

		$conf = [ ];

		// Required by the class
		require_once THEMEPATH . '/theme-config.php';
		$this->conf = $conf;
		require_once $this->path . '/modules/nav.class.php';
		require_once $this->path . '/modules/breadcrumb.class.php';
		require_once $this->path . '/modules/sidebar.class.php';

		//All the custom files
		if ( isset( $this->conf['dependencies'] ) ) {

			foreach ( $this->conf['dependencies'] as $dependency ) {
				require_once $dependency;
			}

		}
	}


	/**
	 * Add hooks
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 */

	public function add_hooks()
	{
		//Styles
		add_action( 'init', array( &$this, 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );

		//Scripts
		add_action( 'init', array( &$this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
	}


	/**
	 * Add theme support
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.2
	 */
	public function theme_support()
	{
		$textdomain = ( isset( $this->conf['texdomain'] ) ? $this->conf['texdomain']['text'] : 'ms' );
		$path       = ( isset( $this->conf['texdomain'] ) ? $this->conf['texdomain']['path'] : get_template_directory() . '/language' );

		load_theme_textdomain( $textdomain, $path );
	}


	/**
	 * Register styles
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 */

	public function register_styles()
	{
		$this->styles = $this->conf['styles'];

		if ( ! empty( $this->styles ) ) {

			foreach ( $this->styles as $name => $args ) {
				wp_register_style( $name, $args['url'], $args['dependencies'], $args['version'] );
			}
		}
	}


	/**
	 * Enqueue styles
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 */

	public function enqueue_styles()
	{
		if ( ! empty( $this->styles ) ) {

			foreach ( $this->styles as $name => $args ) {
				wp_enqueue_style( $name );
			}
		}
	}


	/**
	 * Register scripts
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 */

	public function register_scripts()
	{
		$this->scripts = $this->conf['scripts'];

		if ( ! empty( $this->scripts ) ) {
			foreach ( $this->scripts as $name => $args ) {
				wp_register_script( $name, $args['url'], $args['dependencies'], $args['version'], $args['footer'] );
			}
		}
	}


	/**
	 * Enqueue scripts
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 */

	public function enqueue_scripts()
	{
		foreach ( $this->scripts as $name => $args ) {
			if ( ! isset( $args['enqueue'] ) || $args['enqueue'] != false )
				if ( ! is_admin() )
					wp_enqueue_script( $name );
		}

		//$this->localize_scripts();
	}


	/*	function localize_scripts()
		{
			wp_localize_script( 'cuztom', 'Cuztom', array(
				'home_url'     => get_home_url(),
				'ajax_url'     => admin_url( 'admin-ajax.php' ),
				'date_format'  => get_option( 'date_format' ),
				'wp_version'   => get_bloginfo( 'version' ),
				'remove_image' => __( 'Remove current image', 'cuztom' ),
				'remove_file'  => __( 'Remove current file', 'cuztom' )
			) );
		}*/

	public function menu( $name )
	{

		$menu = new Modules\Theme_Menu( $this->conf, $name );

		return $menu;
	}


	/**
	 * Add breadcrumb
	 *
	 * @param array $templates
	 * @param array $options
	 * @return Modules\Theme_Breadcrumb
	 */

	public function breadcrumb( $templates = array(), $options = array() )
	{
		$breadcrumb = new Modules\Theme_Breadcrumb( $templates, $options );

		return $breadcrumb;
	}


	/**
	 * Add sidebars
	 *
	 * @param array $templates
	 * @param array $options
	 * @return Modules\Sidebar
	 */

	public function sidebars()
	{
		$sidebars = [ ];

		foreach ( $this->conf['sidebars'] as $args ) :

			$sidebars[] = new Modules\Sidebar( $args );

		endforeach;

		return $sidebars;
	}


	/**
	 * Get sidebar.
	 *
	 * @return object
	 */
	public function _sidebar( $name )
	{
		if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $name ) ) :
			echo sprintf( __( 'La sidebar %s non esiste' ), $name );
		endif;
	}
	
	
	/**
	 * Make a dynamic CSS.
	 * Args are: $source_path; $css_path; $dynamic_file_name; $css_file_name;
	 * Data are: all the data need to be passed to the dynamic file.
	 * 
	 * @param $args
	 * @param $data
	 * @return Modules\DynamicCSS
	 */

	public function dynamic_css( $args, $data )
	{
		$file = new Modules\DynamicCSS( $args, $data );
		return $file;
	}



	/**
	 * Clean way to get the current queried object.
	 *
	 * @return object
	 */

	public function object()
	{
		return get_queried_object();
	}


	/**
	 * Custom query.
	 * The query is cached in the $cache variable as array.
	 *
	 * @param : $query_name   The query name to be cached
	 * @param : $args         The args passed to the query
	 * @return: mixed         Return array
	 */

	public function query( $query_name, $args )
	{
		if ( empty( $this->cache[ $query_name ] ) ) {
			$this->cache[ $query_name ] = new \WP_Query( $args );
			set_transient( $query_name, $this->cache[ $query_name ], 2 * HOUR_IN_SECONDS );
		}

		return get_transient( $query_name );
	}

}
