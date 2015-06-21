<?php

namespace Kenzol\Admin;

class Breadcrumb {


	/**
	 * Contructor
	 */
	public function __construct()
	{
		add_action( 'admin_menu', [ &$this, 'options_page' ] );
		add_action( 'admin_init', [ &$this, 'register_fields' ] );
	}


	/**
	 * Register Breadrcumb option page under the settings menu
	 */
	public function options_page()
	{
		add_options_page( __( 'Impostazioni breadcrumb', 'kenzol' ), 'Breadcrumb', 'manage_options', 'kenzol-breadcrumb', [
			&$this,
			'option_page'
		] );
	}


	/**
	 * Build the HTML Breadcrumb option page
	 */
	public function option_page()
	{ ?>
		<div class="wrap">
			<h2><?= __( 'Impostazioni breadcrumb', 'kenzol' ); ?></h2>

			<form method="post" action="options.php">
				<?php
				settings_fields( "section" );
				do_settings_sections( "breadcrumb-options" );
				submit_button();
				?>
			</form>
		</div>
	<?php }


	public function post_type_elements()
	{
		$types = get_post_types( [
			'_builtin' => false
		] );
		echo '<pre>'; print_r( $types ); echo '</pre>';
		//echo '<input type="text" name="twitter_url" id="twitter_url" value="' . get_option( 'twitter_url' ) . '" />';
	}


	/**
	 * Register options fields
	 */
	public function register_fields()
	{
		add_settings_section( 'breadcrumb_options', 'Breadcrumb Options', null, 'kenzol-breadcrumb' );

		add_settings_field(
			'breadcrumb_options',
			'Breadcrumb Options',
			[ &$this, 'post_type_elements' ],
			'kenzol-breadcrumb',
			'ection'
		);

//		add_settings_field( 'facebook_url', 'acebook Profile Url', 'isplay_facebook_element', 'heme-options', 'ection' );
//
//		register_setting( 'breadcrumb_options', 'breadcrumb_options' );
//		register_setting( 'breadcrumb_options', 'breadcrumb_options' );
	}

}