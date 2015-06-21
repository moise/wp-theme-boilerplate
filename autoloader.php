<?php

class Autoloader {


	static public function loader( $className )
	{
		$filename = str_replace( "\\", "/", $className ) . ".php";

		if ( file_exists( BASEPATH . '/' . $filename ) ) {
			require_once( BASEPATH . '/' . $filename );
			if ( class_exists( $className ) ) {
				return true;
			}
		}

		return false;
	}
}

spl_autoload_register( 'Autoloader::loader' );