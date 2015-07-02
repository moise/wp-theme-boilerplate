<?php

namespace Kenzol\Admin;

class Breadcrumb {


	/**
	 * Contructor
	 */
	public function __construct()
	{
		add_action( 'admin_menu', [ &$this, 'add_admin_menu' ] );
		add_action( 'admin_init', 'settings_init' );
	}


	public function add_admin_menu()
	{
		add_options_page( __( 'Breadcrumb Settings', 'kenzol' ), 'Breadcrumb', 'manage_options', 'options-breadcrub', [ &$this, 'options_page' ] );
	}


	function kenzol_settings_init()
	{

		register_setting( 'pluginPage', 'kenzol_settings' );

		add_settings_section(
			'kenzol_pluginPage_section',
			__( 'Your section description', 'kenzol' ),
			'kenzol_settings_section_callback',
			'pluginPage'
		);

		add_settings_field(
			'kenzol_select_field_0',
			__( 'Settings field description', 'kenzol' ),
			'kenzol_select_field_0_render',
			'pluginPage',
			'kenzol_pluginPage_section'
		);

		add_settings_field(
			'kenzol_select_field_1',
			__( 'Settings field description', 'kenzol' ),
			'kenzol_select_field_1_render',
			'pluginPage',
			'kenzol_pluginPage_section'
		);

	}


	function kenzol_select_field_0_render()
	{

		$options = get_option( 'kenzol_settings' );
		?>
		<select name='kenzol_settings[kenzol_select_field_0]'>
			<option value='1' <?php selected( $options['kenzol_select_field_0'], 1 ); ?>>Option 1</option>
			<option value='2' <?php selected( $options['kenzol_select_field_0'], 2 ); ?>>Option 2</option>
		</select>

	<?php

	}


	function kenzol_select_field_1_render()
	{

		$options = get_option( 'kenzol_settings' );
		?>
		<select name='kenzol_settings[kenzol_select_field_1]'>
			<option value='1' <?php selected( $options['kenzol_select_field_1'], 1 ); ?>>Option 1</option>
			<option value='2' <?php selected( $options['kenzol_select_field_1'], 2 ); ?>>Option 2</option>
		</select>

	<?php

	}


	function kenzol_settings_section_callback()
	{

		echo __( 'This section description', 'kenzol' );

	}


	public function options_page()
	{

		?>
		<form action='options.php' method='post'>

			<h2><?= __( 'Breadcrumb Settings', 'kenzol' ); ?></h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
	<?php

	}
}