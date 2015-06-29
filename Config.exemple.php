<?php
$conf = [
	'version'    => '0.1.0',
	'styles'     => [
		'base'         => [
			'url'          => 'base.min.css',
			'dependencies' => [ ],
			'version'      => '1.0',
			'admin'        => false
		],
		'font-awesome' => [
			'url'          => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
			'dependencies' => [ ],
			'version'      => '4.3.0',
			'admin'        => false
		]
	],
	'scripts'    => [
		'bootstrap' => [
			'url'          => 'bootstrap.min.js',
			'dependencies' => [ 'jquery' ],
			'version'      => '3.3.4',
			'footer'       => true
		],
		'main'      => [
			'url'          => 'main.min.js',
			'dependencies' => [ 'jquery' ],
			'version'      => '0.1.0',
			'footer'       => true
		]
	],
	/**
	 * Textdomain support
	 *
	 * @args: text => textdomain name (ex. fs), path => path to de languages folder.
	 */
	'textdomain' => [ 'text' => 'your-custom-text-domain' ],
	'menus'      => [
		'main' => [
			'theme_location'  => 'main_menu',
			'menu'            => '',
			'container'       => 'nav',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => '',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		]
	],
	'sidebars'   => [
		[
			'name'          => 'My sidebar name',
			'id'            => 'my-sidebar-id',
			'description'   => 'My custom sidebar description',
			'class'         => '',
			'before_widget' => '<div class="widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		]
	]
];
