<?php

require_once( ADPLUGG_INCLUDES . 'admin/help/amp-options-page-help.php' );

/**
 * The Test_AMP_Options_Page_Help class includes tests for testing the 
 * functions in the amp-options-page-help.php file.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AMP_Options_Page_Help extends WP_UnitTestCase {
	
	/**
	 * Test the adplugg_amp_options_page_help function.
	 */
	public function test_adplugg_amp_options_page_help() {
		//set up the variables
		$contextual_help = '';
		$adplugg_hook = 'mock-hook';
		$screen_id = $adplugg_hook . '_page_adplugg_amp_settings';
		$screen = WP_Screen::get( $adplugg_hook );
		
		//run the function
		adplugg_amp_options_page_help( $contextual_help, $screen_id, $screen );
		
		//Asset that the AdPlugg help is now in the screen.
		$this->assertContains( 'AMP Settings Help', serialize( $screen ) );
	}
	
}

