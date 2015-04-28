<?php
/**
 * @author: Moise Scalzo
 * @date  : 25/04/15
 * @time  : 06:51
 */

$conf['version'] = (string) '0.1.0';
$conf['styles']  = array(
	'base' => array(
		'url'          => ASSETS . '/css/base.min.css',
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
	'font-lato' => array(
		'url'          => 'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic,700italic',
		'dependencies' => array(),
		'version'      => '1.0',
		'admin'        => false
	)
);
$conf['scripts'] = array(
	'bootstrap' => array(
		'url'          => ASSETS . '/js/bootstrap.min.js',
		'dependencies' => array( 'jquery' ),
		'version'      => '3.3.4',
		'footer'       => true
	),
	'main' => array(
		'url'          => ASSETS . '/js/main.js',
		'dependencies' => array( 'jquery' ),
		'version'      => '0.1.0',
		'footer'       => true
	)
);
$conf['menus']    = array(
	'main' => array(
		'theme_location'  => 'top_menu',
		'menu'            => '',
		'container'       => 'nav',
		'container_class' => 'top-menu-container col-md-24',
		'container_id'    => 'top-menu-container',
		'menu_class'      => 'dropdown top-menu',
		'menu_id'         => 'top-menu',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	)
);
$conf['dependencies'] = array(
	CUSTOM . '/navigation-menus.php'
);