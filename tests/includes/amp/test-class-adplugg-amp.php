<?php

require_once( ADPLUGG_PATH . 'tests/mocks/mock-amp-base-sanitizer.php' );

/**
 * The Test_AdPlugg_AMP class includes tests for testing the AdPlugg_AMP class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_AMP extends WP_UnitTestCase {

	/**
	 * Test the constructor
	 * @global $wp_filter
	 */	
	public function test_constructor() {
		global $wp_filter;
		
		$adplugg_amp = new AdPlugg_AMP( new \AdPlugg_Ad_Tag_Collection() );
		
		//Assert that the init function is registered.
		$function_names = get_function_names( $wp_filter['widgets_init'] );
		$this->assertContains( 'amp_ads_widget_area_init', $function_names );
				
		//Assert that the init function is registered.
		$function_names = get_function_names( $wp_filter['amp_content_sanitizers'] );
		$this->assertContains( 'add_ad_sanitizer', $function_names );
	}
	
	/**
	 * Test the amp_ads_widget_area_init() function.
	 */	
	function test_amp_ads_widget_area_init() {
		
		//enable automatic placement
		$options['amp_enable_automatic_placement'] = 1;
		update_option(ADPLUGG_AMP_OPTIONS_NAME, $options);
		
		//assert that the sidebar is not registered
		$this->assertFalse( array_key_exists( 'amp_ads', $GLOBALS['wp_registered_sidebars'] ) );
		
		//get the singleton instance
		$adplugg_amp = AdPlugg_AMP::get_instance();
		
		//call the function
		$adplugg_amp->amp_ads_widget_area_init();
		
		//assert that the sidebar is now registed
		$this->assertTrue( array_key_exists( 'amp_ads', $GLOBALS['wp_registered_sidebars'] ) );
		
	}
	
	/**
	 * Test the add_ad_sanitizer() function.
	 */	
	function test_add_ad_sanitizer() {
		//Enable automatic placement
		$options['amp_enable_automatic_placement'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//mock some test data
		$sanitizer_classes = array();
		$post = array();
		
		//get the singleton instance
		$adplugg_amp = new AdPlugg_AMP( new \AdPlugg_Ad_Tag_Collection() );
		
		//call the function
		$sanitizer_classes = $adplugg_amp->add_ad_sanitizer( $sanitizer_classes, $post );
		
		//Assert that our sanitizer was added
		$this->assertArrayHasKey( 'AdPlugg_AMP_Ad_Injection_Sanitizer', $sanitizer_classes );
	}
	
	/**
	 * Test the is_amp_automatic_placement_enabled() function.
	 */	
	function test_is_amp_automatic_placement_enabled() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//Assert function correctly determines automatic placement is not enabled
		$this->assertFalse( AdPlugg_AMP::is_amp_automatic_placement_enabled() );

		//Enable automatic placement
		$options['amp_enable_automatic_placement'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );

		//Assert function correctly determines automatic placement enabled
		$this->assertTrue( AdPlugg_AMP::is_amp_automatic_placement_enabled() );
	}
	
}

