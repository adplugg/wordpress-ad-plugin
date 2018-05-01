<?php

require_once( ADPLUGG_INCLUDES . 'frontend/class-adplugg-sdk.php' );

/**
 * The Test_AdPlugg_Sdk class includes tests for testing the AdPlugg_Sdk
 * class.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class Test_AdPlugg_Sdk extends WP_UnitTestCase {
	
	/**
	 * Test the constructor.
	 * @global array $wp_filter
	 */
	public function test_constructor() {
		global $wp_filter;
		
		$sdk = new AdPlugg_Sdk();
		
		//Assert that the render_sdk function is registered.
		$function_names = get_function_names( $wp_filter['wp_head'] );
		$this->assertContains( 'render_sdk', $function_names );
	}
	
	/**
	 * Test that the render_sdk function doesn't output anything if the
	 * access_code is not set. Note that if the override is set, the SDK will
	 * be output.
	 * TODO: Figure out a way to disable the override for this test.
	 */	
	public function test_render_sdk_doesnt_serve_without_access_code() {
		
		$sdk = AdPlugg_Sdk::get_instance();
		
		//Assert that nothing was output
		ob_start();
		$sdk->render_sdk();
		$outbound = ob_get_contents();
		ob_end_clean();
		
		if ( defined( 'ADPLUGG_OVERRIDE_ACCESS_CODE' ) ) {
			$this->assertContains( ADPLUGG_OVERRIDE_ACCESS_CODE, $outbound );
		} else {
			$this->assertEquals( '', $outbound );
		}
	}
	
	/**
	 * Test that the render_sdk function outputs the sdk when the access_code is
	 * set.
	 */	
	public function test_render_sdk_outputs_sdk() {
		
		$sdk = AdPlugg_Sdk::get_instance();
		
		//Set the access_code
		$options = get_option( ADPLUGG_OPTIONS_NAME, array() );
		$options['access_code'] = 'A0000';
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//Output the SDK
		ob_start();
		$sdk->render_sdk();
		$outbound = ob_get_contents();
		ob_end_clean();
		
		//Assert that the SDK is output.
		$this->assertContains( '<script', $outbound );
		
	}
	
	/**
	 * Test that the render_sdk function outputs the qunit interface when
	 * ADPLUGG_LOAD_QUNIT is set to TRUE.
	 */	
	public function test_render_sdk_outputs_qunit() {
		
		$sdk = AdPlugg_Sdk::get_instance();
		
		//Set the ADPLUGG_LOAD_QUNIT constant
		if ( ! defined( 'ADPLUGG_LOAD_QUNIT' ) ) {
			define( 'ADPLUGG_LOAD_QUNIT', true ); 
		}
		
		//Set the access_code (SDK won't render without it)
		$options = get_option( ADPLUGG_OPTIONS_NAME, array() );
		$options['access_code'] = 'A0000';
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//Assert that the QUnit interface is output.
		ob_start();
		$sdk->render_sdk();
		$outbound = ob_get_contents();
		ob_end_clean();
		
		$this->assertContains( 'qunit', $outbound );
	}
	
	/**
	 * Test the get_instance function.
	 */	
	public function test_get_instance() {
		//get the singleton instance
		$sdk = AdPlugg_Sdk::get_instance();
		
		//assert that the instance is returned and is the expected class.
		$this->assertEquals( 'AdPlugg_Sdk', get_class( $sdk ) );
	}
	
}
