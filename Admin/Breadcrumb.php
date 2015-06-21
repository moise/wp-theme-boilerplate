<?php

namespace Kenzol\Admin;

class Breadcrumb {


	public function __construct()
	{
		add_action( 'admin_menu', [ &$this, 'options_page' ] );
	}


	public function options_page()
	{
		add_options_page( __( 'Impostazioni breadcrumb', 'kenzol' ), 'Breadcrumb', 'manage_options', 'options-breadcrumb.php', [
			&$this,
			'options'
		] );
	}


	public function options()
	{
		echo 'This is the page content';
	}

}