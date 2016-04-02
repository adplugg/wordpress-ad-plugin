<?php

require_once( ADPLUGG_PATH . 'admin/help/help-dispatch.php' );

/**
 * The HelpDispatchTest class includes tests for testing the functions in the
 * help-dispatch.php file.
 *
 * @package AdPlugg
 * @since 1.1.29
 */
class HelpDispatchTest extends WP_UnitTestCase {
    
    /**
     * Test that the adplugg_help_dispatch function properly dispatches help for
     * the options page.
     */    
    public function test_help_dispatch_for_options_page() {
        //set up the variables
        $contextual_help = '';
        global $adplugg_hook;
        $adplugg_hook = 'mock-hook';
        $screen_id = 'toplevel_page_' . $adplugg_hook;
        $screen = WP_Screen::get( $screen_id );
        
        //Assert that the AdPlugg help is not in the screen.
        $this->assertNotContains( 'AdPlugg Plugin Help', serialize( $screen ) );
        
        //run the function
        adplugg_help_dispatch( $contextual_help, $screen_id, $screen );
        
        //Asset that the AdPlugg help is now in the screen.
        $this->assertContains( 'AdPlugg Plugin Help', serialize( $screen ) );
    }
    
    /**
     * Test that the adplugg_help_dispatch function properly dispatches help for
     * the facebook options page.
     */    
    public function test_help_dispatch_for_facebook_page() {
        //set up the variables
        $contextual_help = '';
        global $adplugg_hook;
        $adplugg_hook = 'mock-hook';
        $screen_id = $adplugg_hook . '_page_adplugg_facebook_settings';
        $screen = WP_Screen::get( $screen_id );
        
        //Assert that the Facebook settings help is not in the screen.
        $this->assertNotContains( 'Facebook Settings Help', serialize( $screen ) );
        
        //run the function
        adplugg_help_dispatch( $contextual_help, $screen_id, $screen );
        
        //Asset that the Facebook settings help is now in the screen.
        $this->assertContains( 'Facebook Settings Help', serialize( $screen ) );
    }
    
    /**
     * Test that the adplugg_help_dispatch function properly dispatches help for
     * the options widgets page.
     */    
    public function test_help_dispatch_for_widgets_page() {
        //set up the variables
        $contextual_help = '';
        $screen_id = 'widgets';
        $screen = WP_Screen::get( $screen_id );
        
        //Assert that the AdPlugg help is not in the screen.
        $this->assertNotContains( 'AdPlugg Widget Help', serialize( $screen ) );
        
        //run the function
        adplugg_help_dispatch( $contextual_help, $screen_id, $screen );
        
        //Asset that the AdPlugg help is now in the screen.
        $this->assertContains( 'AdPlugg Widget Help', serialize( $screen ) );
    }
    
}

