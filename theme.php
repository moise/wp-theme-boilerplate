<?php

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

	private function __construct( $conf )
	{
		$this->conf = $conf;
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

	public static function get_instance( $conf )
	{
		if ( self::$instance == null ) {
			self::$instance = new Theme( $conf );
			self::$instance->load_dependencies();
			self::$instance->add_hooks();
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
		// Required by the class
		require_once $this->path . '/includes/nav.class.php';
		require_once $this->path . '/includes/breadcrumb.class.php';

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
		$menu = new Theme_Menu( $this->conf, $name );

		return $menu;
	}


	public function breadcrumb( $templates = array(), $options = array() )
	{
		$breadcrumb = new Theme_Breadcrumb( $templates, $options );

		return $breadcrumb;
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
			$this->cache[ $query_name ] = new WP_Query( $args );
		}

		return $this->cache[ $query_name ];
	}

}