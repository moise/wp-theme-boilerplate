<?php

class Autoloader {


	static public function loader( $className )
	{
		$filename = strtolower( str_replace( "\\", "/", $className ) . ".php" );

		if ( file_exists( BASEPATH . '/' . $filename ) ) {
			require_once( strtolower( BASEPATH . '/' . $filename ) );
			if ( class_exists( $className ) ) {
				return true;
			}
		}

		return false;
	}
}

spl_autoload_register( 'Autoloader::loader' );