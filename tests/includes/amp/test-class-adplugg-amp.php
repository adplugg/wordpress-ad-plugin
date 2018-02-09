<?php

/**
 * The Test_AdPlugg_Amp class includes tests for testing the AdPlugg_Amp class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_Amp extends WP_UnitTestCase {

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
		$adplugg_amp = AdPlugg_Amp::get_instance();
		
		//call the function
		$filtered_content = $adplugg_amp->amp_ads_widget_area_init();
		
		//assert that the sidebar is now registed
		$this->assertTrue( array_key_exists( 'amp_ads', $GLOBALS['wp_registered_sidebars'] ) );
		
	}
	
	/**
	 * Test the is_amp_automatic_placement_enabled() function.
	 */	
	function test_is_amp_automatic_placement_enabled() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );
		
		//Assert function correctly determines automatic placement is not enabled
		$this->assertFalse( AdPlugg_Amp::is_amp_automatic_placement_enabled() );

		//Enable automatic placement
		$options['amp_enable_automatic_placement'] = 1;
		update_option( ADPLUGG_AMP_OPTIONS_NAME, $options );

		//Assert function correctly determines automatic placement enabled
		$this->assertTrue( AdPlugg_Amp::is_amp_automatic_placement_enabled() );
	}
	
}

