<?php

namespace Kenzol\Modules;

if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Class DynamicCSS
 *
 * @package Kenzol\Modules
 */
class DynamicCSS {


	var $source_path;


	var $css_path;


	var $dynamic_file_name;


	var $css_file_name;


	var $uploads;


	/**
	 * Imposto le variabili principali
	 *
	 * @param array $args
	 * @param       $newdata //newdata corrisponde alla variabile da passare al file php. La cosa migliore è passare un
	 *                       array di tutto ciò che dovete stampare nel css.
	 */

	public function __construct( $args = [ ], $newdata )
	{

		/** Define some vars **/

		$this->source_path       = $args['source_path'];
		$this->dynamic_file_name = $args['dynamic_file_name'];
		$this->css_file_name     = $args['css_file_name'];


		if ( is_multisite() ) {
			$this->uploads  = wp_upload_dir();
			$this->css_path = trailingslashit( $this->uploads['basedir'] );
		} else
			$this->css_path = $args['css_path'];

		$data = $newdata;

		if ( $this->generate_css( $data ) )
			$this->hooks();

		return true;

	}


	/**
	 * Genero il CSS dinamico
	 *
	 * @return bool
	 */

	public function generate_css( $data )
	{

		/** Capture CSS output **/
		ob_start();
		require( $this->source_path . $this->dynamic_file_name );
		$css = ob_get_clean();

		/** Write to options.css file **/
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		WP_Filesystem();
		global $wp_filesystem;

		if ( ! $wp_filesystem->put_contents( $this->css_path . $this->css_file_name, $css, 0644 ) ) {
			return true;
		}

		return false;

	}


	/**
	 * Register and Enqueue the new generated dnynamic file.
	 */

	public function register_style()
	{
		wp_register_style( $this->css_file_name, $this->css_path . $this->css_file_name );
		wp_enqueue_style( $this->css_file_name );
	}


	/**
	 * Hook the file
	 */

	public function hooks()
	{
		add_action( 'wp_print_styles', $this->css_file_name );
	}

}
