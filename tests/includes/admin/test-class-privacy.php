<?php

require_once( ADPLUGG_INCLUDES . 'admin/class-adplugg-privacy.php' );

/**
 * The Test_AdPlugg_Privacy class includes tests for testing the AdPlugg_Privacy
 * class.
 *
 * @package AdPlugg
 * @since 1.9.0
 */
class Test_AdPlugg_Privacy extends WP_UnitTestCase {
	
	/**
	 * Test the constructor
	 * @global $wp_filter
	 */	
	public function test_constructor() {
		global $wp_filter;
		
		// Call the constructor.
		$adplugg_privacy = new AdPlugg_Privacy();
		
		//Assert that the add_privacy_message function is registered.
		$function_names = get_function_names( $wp_filter['admin_init'] );
		$this->assertContains( 'add_privacy_message', $function_names );
	}
	
	/**
	 * Test the get_privacy_message function.
	 */	
	public function test_get_privacy_message() {
		// Instantiate the SUT (System Under Test) class.
		$adplugg_privacy = new AdPlugg_Privacy();
		
		// Call the method.
		$content = $adplugg_privacy->get_privacy_message();
		
		// Assert that the returned value contains the expected content.
		$this->assertContains( 'This sample language', $content );
	}
	
}
