<?php

/**
 * Class to init the WordPress Menus
 *
 * @version   : 0.1.0
 *
 * @package   : Theme
 * @subpackage: Theme/includes
 * @author    : Moise Scalzo <moise.scalzo@gmail.com>
 */
class Theme_Menu extends Theme {


	/**
	 * The menu name to be loaded
	 *
	 * @var
	 */

	var $name;


	var $theme_location;


	/**
	 * Init menu.
	 *
	 * @param: $conf            The global config variable
	 * @param: $name            The menu name to be loaded
	 */

	public function __construct( $conf, $name )
	{
		$this->conf           = $conf;
		$this->name           = $name;
		$this->theme_location = $this->conf['menus'][ $this->name ]['theme_location'];
	}


	/**
	 * Load dynamic menu
	 *
	 * @author: Moise Scalzo
	 * @since : 0.1.0
	 * @return: mixed
	 */

	public function get_menu()
	{
		return wp_nav_menu( $this->conf['menus'][ $this->name ] );
	}


	public function add_element( $callback )
	{
		add_filter( 'wp_nav_menu_items', $callback, 10, 2 );
	}

}