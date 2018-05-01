<?php

/**
 * The AdPlugg_Options_Test class includes tests for testing the AdPlugg_Options
 * class.
 *
 * @package AdPlugg
 * @since 1.6.10
 */
class AdPlugg_Options_Test extends WP_UnitTestCase {

	/**
	 * Assert that is_access_code_installed() correctly returns whether or not
	 * an AdPlugg access code has been installed. Tests both the false and true
	 * scenarios.
	 */	
	function test_is_access_code_installed() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//Assert function correctly determines access_code not installed
		$this->assertFalse( AdPlugg_Options::is_access_code_installed() );

		//Install the access_code
		$options['access_code'] = 'test';
		update_option( ADPLUGG_OPTIONS_NAME, $options );

		//Assert function correctly determines access_code installed
		$this->assertTrue( AdPlugg_Options::is_access_code_installed() );
	}
	
	/**
	 * Assert that get_active_access_code() returns a stored access code.
	 */	
	function test_get_active_access_code_returns_stored_access_code() {
		//Install the access_code
		$options = array();
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		$options['access_code'] = 'test';
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//call the function
		$access_code = AdPlugg_Options::get_active_access_code();

		if ( defined( 'ADPLUGG_OVERRIDE_ACCESS_CODE' ) ) {
			$this->assertContains( ADPLUGG_OVERRIDE_ACCESS_CODE, $access_code );
		} else {
			$this->assertEquals( 'test', $access_code );
		}
	}
	
	/**
	 * Assert that get_active_access_code() returns null when no access code is
	 * found.
	 */	
	function test_get_active_access_code_returns_null_when_no_access_code_stored() {
		//Delete the adplugg options data (including the access code).
		delete_option( ADPLUGG_OPTIONS_NAME );
		
		$access_code = AdPlugg_Options::get_active_access_code();

		if ( defined( 'ADPLUGG_OVERRIDE_ACCESS_CODE' ) ) {
			$this->assertContains( ADPLUGG_OVERRIDE_ACCESS_CODE, $access_code );
		} else {
			$this->assertNull( $access_code );
		}
	}

}
