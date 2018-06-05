<?php

require_once( ADPLUGG_INCLUDES . 'admin/pages/class-adplugg-options-page.php' );

/**
 * The Test_Options_Page class includes tests for testing the AdPlugg_Options_Page
 * class
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class Test_Options_Page extends WP_UnitTestCase {
	
	/**
	 * Test the constructor
	 * 
	 * @global $wp_filter
	 */	
	public function test_constructor() {
		global $wp_filter;
		
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		//Assert that the init function is registered.
		$function_names = get_function_names( $wp_filter['admin_menu'] );
		$this->assertContains( 'add_to_menu', $function_names );
				
		//Assert that the init function is registered.
		$function_names = get_function_names( $wp_filter['admin_init'] );
		$this->assertContains( 'admin_init', $function_names );
	}
	
	/**
	 * Test the render_page function.
	 */	
	public function test_render_page() {
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		//Assert that the options page was rendered
		ob_start();
		$adplugg_options_page->render_page();
		$output = ob_get_contents();
		ob_end_clean();
		$this->assertContains( 'AdPlugg General Settings', $output );
	}
	
	/**
	 * Test the add_to_menu function.
	 */	
	public function test_add_to_menu() {
		wp_set_current_user( $this->factory->user->create( array( 'role' => 'administrator' ) ) );
		
		//Assert that the menu page doesn't yet exist
		$this->assertEquals( '', menu_page_url( 'adplugg', false ) );
		
		$adplugg_options_page = new AdPlugg_Options_Page();
		$adplugg_options_page->add_to_menu();
		
		//Assert that the menu page was added
		$expected = 'http://example.org/wp-admin/admin.php?page=adplugg';
		$this->assertEquals( $expected, menu_page_url( 'adplugg', false ) );
	}
	
	/**
	 * Test the render_access_code function.
	 */	
	public function test_render_access_section_text() {
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		//Assert that the access section was rendered
		ob_start();
		$adplugg_options_page->render_access_section_text();
		$output = ob_get_contents();
		ob_end_clean();
		$this->assertContains( 'To use AdPlugg', $output );
	}
	
	/**
	 * Test the render_access_code function.
	 */	
	public function test_render_access_code() {
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		//Assert that the access section was rendered
		ob_start();
		$adplugg_options_page->render_access_code();
		$output = ob_get_contents();
		ob_end_clean();
		$this->assertContains( 'AdPlugg Access Code', $output );
	}
	
	/**
	 * Test the admin_init function.
	 * @global array $wp_settings_sections
	 * @global array $wp_settings_fields
	 */	
	public function test_admin_init() {
		global $wp_settings_sections;
		global $wp_settings_fields;
		
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		//Run the function
		$adplugg_options_page->admin_init();
		
		//---------------------------------------------------//
		//Get the output from rendering the main form
		ob_start();
		settings_fields( 'adplugg_options', 'access_code' );
		$output = ob_get_contents();
		ob_end_clean();
		
		//Assert that the adplugg_options hidden field is registered/rendered
		$this->assertContains( "value='adplugg_options'", $output );
		
		//Assert that the _secret_wpnonce field is registered/rendered.
		$this->assertContains( '<input type="hidden" id="_wpnonce" name="_wpnonce"', $output );
		
		//Assert that the _wp_http_referer field is registered/rendered.
		$this->assertContains( '<input type="hidden" name="_wp_http_referer"', $output );
		
		
		//---------------------------------------------------//
		//assert that the adplugg_options_access_section section is registered
		$this->assertArrayHasKey( 'adplugg_options_access_section', $wp_settings_sections['adplugg'] );
		
		//assert that the access_code field is registered
		$this->assertArrayHasKey( 'access_code', $wp_settings_fields['adplugg']['adplugg_options_access_section'] );
	}
	
	/**
	 * Test that the validate function returns an error
	 * when the input is invalid.
	 */
	public function test_validate_invalid() {
		//Clear out any previous settings errors.
		global $wp_settings_errors;
		$wp_settings_errors = null;
		
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		$input = array();
		$input['access_code'] = 'not valid';
		
		//Run the function.
		$new_options = $adplugg_options_page->validate( $input );
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that an error was thrown
		$this->assertEquals( 'error', $settings_errors[0]['type'] );
		
		//Assert that the settings were not stored.
		$this->assertTrue( empty( $new_options['access_code'] ) );
	}
	
	/**
	 * Test that the validate function returns an error
	 * when the input contains html and javascript.
	 */
	public function test_validate_attack() {
		//Clear out any previous settings errors.
		global $wp_settings_errors;
		$wp_settings_errors = null;
		
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		$input = array();
		$input['access_code'] = '"><script>alert(document.cookie)</script>';
		
		//Run the function.
		$new_options = $adplugg_options_page->validate($input);
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that an error was thrown
		$this->assertEquals( 'error', $settings_errors[0]['type'] );
		
		//Assert that the settings were not stored.
		$this->assertTrue( empty( $new_options['access_code'] ) );
	}
	
	/**
	 * Test the validate function doesn't throw any errors when
	 * the input is valid.
	 * 
	 * @global $wp_settings_errors
	 */
	public function test_validate_valid() {
		global $wp_settings_errors;
		
		//set up the test data
		$access_code = 'A0000';
		
		//Clear out any previous settings errors.
		$wp_settings_errors = null;
		
		
		$adplugg_options_page = new AdPlugg_Options_Page();
		
		$input = array();
		$input['access_code'] = $access_code;
		
		//Run the function.
		$new_options = $adplugg_options_page->validate( $input );
		
		//Get the messages
		$settings_errors = get_settings_errors();
		
		//Assert that no errors were thrown.
		$this->assertEmpty( $settings_errors );
		
		//Assert that the settings were stored.
		$this->assertEquals( $access_code, $new_options['access_code'] );
	}
}

