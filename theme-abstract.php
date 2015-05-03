<?php

abstract class Theme_Base {


	protected $config;


	public function __get( $prop )
	{
		if ( property_exists( $this, $prop ) ) {
			return $this->$prop;
		}
	}


	public function __set( $prop, $val )
	{
		if ( property_exists( $this, $prop ) ) {
			$this->$prop = $val;
		}

		return $this;
	}

}