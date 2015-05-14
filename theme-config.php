<?php
$conf = array(
	'version'    => '0.1.0',
	'styles'     => array(
		'base'         => array(
			'url'          => LIBRARY . '/css/base.min.css',
			'dependencies' => array(),
			'version'      => '1.0',
			'admin'        => false
		),
		'font-awesome' => array(
			'url'          => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
			'dependencies' => array(),
			'version'      => '4.3.0',
			'admin'        => false
		),
		'font-lato'    => array(
			'url'          => 'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic,700italic',
			'dependencies' => array(),
			'version'      => '1.0',
			'admin'        => false
		)
	),
	'scripts'    => array(
		'bootstrap' => array(
			'url'          => LIBRARY . '/js/bootstrap.min.js',
			'dependencies' => array( 'jquery' ),
			'version'      => '3.3.4',
			'footer'       => true
		),
		'main'      => array(
			'url'          => LIBRARY . '/js/main.js',
			'dependencies' => array( 'jquery' ),
			'version'      => '0.1.0',
			'footer'       => true
		)
	),
	/**
	 * Textdomain support
	 * @args: text => textdomain name (ex. fs), path => path to de languages folder.
	 */
	'textdomain' => array( 'text' => 'fs' )
);