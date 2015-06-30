<?php

namespace Kenzol\Modules;

class Shortcode {


	/**
	 * Set Shortcode name
	 *
	 * @var
	 */
	var $sc_name;


	/**
	 * Shortcode function callback
	 *
	 * @var
	 */
	var $sc_function;


	var $vc_integrate = false;


	var $vc_args = array();


	var $vc_params = array();


	/**
	 * @param $name
	 * @param $function
	 * @param $vc_integrate
	 * @param $vc_args
	 * @param $vc_params
	 */

	public function __construct( $name, $function, $vc_integrate, $vc_args, $vc_params )
	{
		$this->sc_name      = $name;
		$this->sc_function  = $function;
		$this->vc_integrate = $vc_integrate;
		$this->vc_args      = $vc_args;
		$this->vc_params    = $vc_params;

		$this->hooks();
	}


	/*
	 * Add hooks
	 */

	public function hooks()
	{
		if ( $this->vc_integrate )
			add_action( 'vc_before_init', [ &$this, 'VC_integegrate' ] );

		add_shortcode( $this->sc_name, $this->sc_function );
	}


	/**
	 * Integrate Shortcode with visual composer
	 *
	 * @param array $args
	 * @param array $params
	 */

	public function VC_integegrate()
	{
		vc_map( array(
			"name"     => $this->vc_args['name'],
			"base"     => $this->sc_name,
			"class"    => "",
			"icon"     => $this->vc_args['icon'],
			"category" => $this->vc_args['category'],
			"params"   => $this->vc_params
		) );
	}

}
