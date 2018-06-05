<?php

require_once( ADPLUGG_INCLUDES . 'admin/pages/class-adplugg-facebook-options-page.php' );

/**
 * The Test_AdPlugg_Facebook_Options_Page class includes tests for testing the 
 * AdPlugg_Facebook_Options_Page class.
 *
 * @package AdPlugg
 * @since 1.3.0
 */
class Test_AdPlugg_Facebook_Options_Page extends WP_UnitTestCase {
	
	/**
	 * Test the constructor
	 */	
	public function test_constructor() {
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
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
	 * @global array $wp_settings_sections
	 * @global array $wp_settings_fields
	 */	
	public function test_admin_init() {
		global $wp_settings_sections;
		global $wp_settings_fields;
		
		// Instantiate the SUT (System Under Test) class.
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
		// Run the function.
		$adplugg_facebook_options_page->admin_init();
		
		//---------------------------------------------------//
		//Get the output from rendering the form
		ob_start();
		settings_fields( 'adplugg_facebook_options' );
		$output = ob_get_contents();
		ob_end_clean();
		
		// Assert that the adplugg_options hidden field is registered/rendered
		$this->assertContains( "value='adplugg_facebook_options'", $output );
		
		//---------------------------------------------------//
		//assert that the adplugg_options_access_section section is registered
		$this->assertArrayHasKey(
			'adplugg_facebook_instant_articles_section', 
			$wp_settings_sections['adplugg_facebook_instant_articles_settings'] 
		);
		
		//assert that the ia_enable_automatic_placement field is registered
		$this->assertArrayHasKey( 
			'ia_enable_automatic_placement', 
			$wp_settings_fields['adplugg_facebook_instant_articles_settings']['adplugg_facebook_instant_articles_section'] 
		);
	}
	
	/**
	 * Test the add_page_to_menu function.
	 */	
	public function test_add_page_to_menu() {
		$page_hook = 'adplugg_facebook_settings';
		
		wp_set_current_user($this->factory->user->create( array( 'role' => 'administrator' ) ) );
		
		//Assert that the menu page doesn't yet exist
		$this->assertEquals( '', menu_page_url( $page_hook, false ) );
		
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		$adplugg_facebook_options_page->add_page_to_menu();
		
		//Assert that the menu page was added
		$expected = 'http://example.org/wp-admin/adplugg?page=adplugg_facebook_settings';
		$this->assertEquals($expected, menu_page_url( $page_hook, false ) );
	}
	
	/**
	 * Test the render_page function.
	 */	
	public function test_render_page() {
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
		//Assert that the options page was rendered
		ob_start();
		$adplugg_facebook_options_page->render_page();
		$outbound = ob_get_contents();
		ob_end_clean();
		$this->assertContains( 'Facebook Settings - AdPlugg', $outbound );
	}
	
	/**
	 * Test the adplugg_facebook_instant_articles_settings_section is rendered and
	 * includes the expected fields.
	 */	
	public function test_adplugg_facebook_instant_articles_settings_section() {
		global $wp_filter;
		
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
		//Run the function
		$adplugg_facebook_options_page->admin_init();
		
		//Assert that the expected settings fields were registered and rendered
		ob_start();
		do_settings_sections( 'adplugg_facebook_instant_articles_settings' );
		$outbound = ob_get_contents();
		ob_end_clean();
		
		//Assert that the enable field is registered/rendered.
		$this->assertContains( 'adplugg_facebook_options[ia_enable_automatic_placement]', $outbound );
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
		
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
		$input = array();
		$input['ia_enable_automatic_placement'] = $enable_input;
		
		//Run the function.
		$new_options = $adplugg_facebook_options_page->validate( $input );
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that no errors were thrown.
		$this->assertEmpty( $settings_errors );
		
		//Assert that the settings were stored.
		$this->assertFalse( empty( $new_options['ia_enable_automatic_placement'] ) );
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
		
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
		$input = array();
		$input['ia_enable_automatic_placement'] = $enable_input; //invalid
		
		//Run the function.
		$new_options = $adplugg_facebook_options_page->validate( $input );
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that an error was thrown
		$this->assertEquals( 'error', $settings_errors[0]['type'] );
		
		//Assert that the settings were not stored.
		$this->assertTrue( empty( $new_options['ia_enable_automatic_placement'] ) );
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
		
		$adplugg_facebook_options_page = new AdPlugg_Facebook_Options_Page();
		
		$input = array();
		$input['ia_enable_automatic_placement'] = $enable_input; //invalid
		
		//Run the function.
		$new_options = $adplugg_facebook_options_page->validate( $input );
		
		//Assert that a 0 was stored instead of the injection attempt.
		$this->assertEquals( 0, $new_options['ia_enable_automatic_placement'] );
	}
	
}
