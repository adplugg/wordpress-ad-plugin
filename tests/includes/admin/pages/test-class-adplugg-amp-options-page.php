<?php

require_once( ADPLUGG_INCLUDES . 'admin/pages/class-adplugg-amp-options-page.php' );

/**
 * The Test_AdPlugg_Amp_Options_Page class includes tests for testing the 
 * AdPlugg_Amp_Options_Page class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_Amp_Options_Page extends WP_UnitTestCase {
	
	/**
	 * Test the constructor
	 */	
	public function test_constructor() {
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		global $wp_filter;
		
		//Assert that the init function is registered.
		$function_names = get_function_names( $wp_filter['admin_menu'] );
		$this->assertContains( 'add_page_to_menu', $function_names );
				
		//Assert that the init function is registered.
		$function_names = get_function_names( $wp_filter['admin_init'] );
		$this->assertContains( 'admin_init', $function_names );
	}
	
	/**
	 * Test the admin_init function.
	 */	
	public function test_admin_init() {
		global $wp_filter;
		
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		//Run the function
		$adplugg_amp_options_page->admin_init();
		
		//Assert that the expected settings fields were registered and rendered
		ob_start();
		settings_fields( 'adplugg_amp_options' );
		$outbound = ob_get_contents();
		ob_end_clean();
	}
	
	/**
	 * Test the add_page_to_menu function.
	 */	
	public function test_add_page_to_menu() {
		$page_hook = 'adplugg_amp_settings';
		
		wp_set_current_user($this->factory->user->create( array( 'role' => 'administrator' ) ) );
		
		//Assert that the menu page doesn't yet exist
		$this->assertEquals( '', menu_page_url( $page_hook, false ) );
		
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		$adplugg_amp_options_page->add_page_to_menu();
		
		//Assert that the menu page was added
		$expected = 'http://example.org/wp-admin/adplugg?page=adplugg_amp_settings';
		$this->assertEquals($expected, menu_page_url( $page_hook, false ) );
	}
	
	/**
	 * Test the render_page function.
	 */	
	public function test_render_page() {
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		//Assert that the options page was rendered
		ob_start();
		$adplugg_amp_options_page->render_page();
		$outbound = ob_get_contents();
		ob_end_clean();
		$this->assertContains( 'AMP Settings - AdPlugg', $outbound );
	}
	
	/**
	 * Test the adplugg_amp_settings_section is rendered and
	 * includes the expected fields.
	 */	
	public function test_adplugg_amp_settings_section() {
		global $wp_filter;
		
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		//Run the function
		$adplugg_amp_options_page->admin_init();
		
		//Assert that the expected settings fields were registered and rendered
		ob_start();
		do_settings_sections( 'adplugg_amp_settings' );
		$outbound = ob_get_contents();
		ob_end_clean();
		
		//Assert that the enable field is registered/rendered.
		$this->assertContains( 'adplugg_amp_options[amp_enable_automatic_placement]', $outbound );
	}
	
	/**
	 * Test that the validate function doesn't throw any errors when the enable
	 * input is valid.
	 */
	public function test_validate_valid_enable_input() {
		//Set the enabple input that we will test with
		$enable_input = 1;
		
		//Clear out any previous settings errors.
		global $wp_settings_errors;
		$wp_settings_errors = null;
		
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		$input = array();
		$input['amp_enable_automatic_placement'] = $enable_input;
		
		//Run the function.
		$new_options = $adplugg_amp_options_page->validate( $input );
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that no errors were thrown.
		foreach ( $settings_errors as $key => $details ) {
			$this->assertNotEquals( 'error', $details['type'] );
		}
		
		//Assert that the settings were saved.
		$this->assertEquals( 'updated', $settings_errors[0]['type'] );
		
		//Assert that the settings were stored.
		$this->assertFalse( empty( $new_options['amp_enable_automatic_placement'] ) );
	}
	
	/**
	 * Test that the validate function returns an error when the enable input is
	 * invalid.
	 */
	public function test_validate_invalid_enable_input() {
		//Set the enable input that we will test with
		$enable_input = '2';
		
		//Clear out any previous settings errors.
		global $wp_settings_errors;
		$wp_settings_errors = null;
		
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		$input = array();
		$input['amp_enable_automatic_placement'] = $enable_input; //invalid
		
		//Run the function.
		$new_options = $adplugg_amp_options_page->validate( $input );
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that an error was thrown
		$this->assertEquals( 'error', $settings_errors[0]['type'] );
		
		//Assert that the settings were not stored.
		$this->assertTrue( empty( $new_options['amp_enable_automatic_placement'] ) );
	}
	
	/**
	 * Test that the validate function stores a 0 when an processing an
	 * injection attack.
	 */
	public function test_validate_enable_input_attack() {
		//Set the enable input that we will test with
		$enable_input = '<injection>';
		
		//Clear out any previous settings errors.
		global $wp_settings_errors;
		$wp_settings_errors = null;
		
		$adplugg_amp_options_page = new AdPlugg_Amp_Options_Page();
		
		$input = array();
		$input['amp_enable_automatic_placement'] = $enable_input; //invalid
		
		//Run the function.
		$new_options = $adplugg_amp_options_page->validate( $input );
		
		//Assert that a 0 was stored instead of the injection attempt.
		$this->assertEquals( 0, $new_options['amp_enable_automatic_placement'] );
	}
	
}
