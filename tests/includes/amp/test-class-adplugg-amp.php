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
				
		//Assert that the add_additional_css_styles function is registered.
		$function_names = get_function_names( $wp_filter['amp_post_template_css'] );
		$this->assertContains( 'add_additional_css_styles', $function_names );
		
		//Assert that the add_ad_sanitizer function is registered.
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
	 * Test the add_ad_sanitizer function.
	 */	
	function test_add_ad_sanitizer() {
		//Enable automatic placement
		$options['amp_enable_automatic_placement'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//mock some test data
		$sanitizer_classes = array();
		$post = array();
		
		//Instantiate the SUT class
		$adplugg_amp = new AdPlugg_AMP( new \AdPlugg_Ad_Tag_Collection() );
		
		//call the function
		$sanitizer_classes = $adplugg_amp->add_ad_sanitizer( $sanitizer_classes, $post );
		
		//Assert that our sanitizer was added
		$this->assertArrayHasKey( 'AdPlugg_AMP_Ad_Injection_Sanitizer', $sanitizer_classes );
	}
	
	/**
	 * Test the add_additional_css_styles function.
	 */	
	function test_add_additional_css_styles() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );

		//Enable automatic placement
		$options['amp_enable_automatic_placement'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//Enable centering
		$options['amp_enable_centering'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//Instantiate the SUT class
		$adplugg_amp = new AdPlugg_AMP( new \AdPlugg_Ad_Tag_Collection() );
		
		//call the function and capture the output
		ob_start();
		$adplugg_amp->add_additional_css_styles( new stdClass() );
		$output = ob_get_contents();
		ob_end_clean();

		//Assert function output the expected css
		$this->assertContains( 'amp-ad[type="adplugg"]', $output );
	}
	
	/**
	 * Test the is_amp_automatic_placement_enabled function.
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
	
	/**
	 * Test the get_ad_density function.
	 */	
	function test_get_ad_density() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//Assert function correctly defaults to 250
		$this->assertEquals( 250, AdPlugg_AMP::get_ad_density() );

		//Set the ad density to 350
		$options['amp_ad_density'] = 350;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );

		//Assert function correctly returns the set ad density
		$this->assertEquals( 350, AdPlugg_AMP::get_ad_density() );
	}
	
	/**
	 * Test the is_centering_enabled function.
	 */	
	function test_is_centering_enabled() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//Assert function correctly determines centering is not enabled
		$this->assertFalse( AdPlugg_AMP::is_centering_enabled() );

		//Enable automatic placement
		$options['amp_enable_centering'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );

		//Assert function correctly determines that centering is enabled
		$this->assertTrue( AdPlugg_AMP::is_centering_enabled() );
	}
	
}

