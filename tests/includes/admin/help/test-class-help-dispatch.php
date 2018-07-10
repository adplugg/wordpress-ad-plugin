<?php

require_once( ADPLUGG_INCLUDES . 'admin/help/class-help-dispatch.php' );

/**
 * The Test_Help_Dispatch class includes tests for testing the
 * AdPlugg_Help_Dispatch class.
 *
 * @package AdPlugg
 * @since 1.1.29
 */
class Test_Help_Dispatch extends WP_UnitTestCase {
	
	/**
	 * Test the constructor.
	 * @global array $wp_filter
	 */	
	public function test_constructor() {
		global $wp_filter;
		
		$adplugg_help_dispatch = new AdPlugg_Help_Dispatch();
		
		//Assert that the dispatch function is registered.
		$function_names = get_function_names( $wp_filter['contextual_help'] );
		//var_dump( $function_names );
		$this->assertContains( 'dispatch', $function_names );
	}
	
	/**
	 * Test that the dispatch function properly dispatches help for the options
	 * page.
	 * @global string $adplugg_hook
	 */	
	public function test_dispatch_for_options_page() {
		global $adplugg_hook;

		//set up the variables
		$contextual_help = '';
		$adplugg_hook = 'mock-hook';
		$screen_id = 'toplevel_page_' . $adplugg_hook;
		
		// Init the class.
		$adplugg_help_dispatch = new AdPlugg_Help_Dispatch();
		
		// Get the screen.
		$screen = WP_Screen::get( $screen_id );
		
		//Assert that the AdPlugg help is not in the screen.
		$this->assertNotContains( 'AdPlugg Plugin Help', serialize( $screen ) );
		
		//run the function
		$adplugg_help_dispatch->dispatch( $contextual_help, $screen_id, $screen );
		
		//Asset that the AdPlugg help is now in the screen.
		$this->assertContains( 'AdPlugg Plugin Help', serialize( $screen ) );
	}
	
	/**
	 * Test that the dispatch function properly dispatches help for the facebook
	 * options page.
	 * @global string $adplugg_hook
	 */	
	public function test_dispatch_for_facebook_page() {
		global $adplugg_hook;
		
		//set up the variables
		$contextual_help = '';
		$adplugg_hook = 'mock-hook';
		$screen_id = $adplugg_hook . '_page_adplugg_facebook_settings';
		$screen = WP_Screen::get( $screen_id );
		
		// Init the class.
		$adplugg_help_dispatch = new AdPlugg_Help_Dispatch();
		
		//Assert that the Facebook settings help is not in the screen.
		$this->assertNotContains( 'Facebook Settings Help', serialize( $screen ) );
		
		//run the function
		$adplugg_help_dispatch->dispatch( $contextual_help, $screen_id, $screen );
		
		//Asset that the Facebook settings help is now in the screen.
		$this->assertContains( 'Facebook Settings Help', serialize( $screen ) );
	}
	
	/**
	 * Test that the dispatch function properly dispatches help for the options
	 * widgets page.
	 */	
	public function test_dispatch_for_widgets_page() {
		//set up the variables
		$contextual_help = '';
		$screen_id = 'widgets';
		$screen = WP_Screen::get( $screen_id );
		
		//Assert that the AdPlugg help is not in the screen.
		$this->assertNotContains( 'AdPlugg Widget Help', serialize( $screen ) );
		
		// Init the class.
		$adplugg_help_dispatch = new AdPlugg_Help_Dispatch();
		
		//run the function
		$adplugg_help_dispatch->dispatch( $contextual_help, $screen_id, $screen );
		
		//Asset that the AdPlugg help is now in the screen.
		$this->assertContains( 'AdPlugg Widget Help', serialize( $screen ) );
	}
	
}
