<?php

require_once(ADPLUGG_PATH . 'admin/help/options-page-help.php');

/**
 * The OptionsPageHelpTest class includes tests for testing the functions in the
 * options-page-help.php file.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class OptionsPageHelpTest extends WP_UnitTestCase {
    
    /**
     * Test the adplugg_options_page_help function.
     */
    public function test_adplugg_options_page_help() {
        //set up the variables
        $contextual_help = '';
        $adplugg_hook = 'mock-hook';
        $screen_id = $adplugg_hook;
        $screen = WP_Screen::get( $adplugg_hook );
        
        //run the function
        adplugg_options_page_help( $contextual_help, $screen_id, $screen );
        
        //Asset that the AdPlugg help is now in the screen.
        $this->assertContains( 'AdPlugg Plugin Help', serialize( $screen ) );
    }
    
}

