<?php

require_once( ADPLUGG_PATH . 'admin/help/widgets-page-help.php' );

/**
 * The WidgetsPageHelpTest class includes tests for testing the functions in the
 * widgets-page-help.php file.
 *
 * @package AdPlugg
 * @since 1.1.29
 */
class WidgetsPageHelpTest extends WP_UnitTestCase {
    
    /**
     * Test the adplugg_widgets_page_help function.
     */
    public function test_adplugg_widgets_page_help() {
        //set up the variables
        $contextual_help = '';
        $screen_id = 'widgets';
        $screen = WP_Screen::get( $screen_id );
        
        //run the function
        adplugg_widgets_page_help( $contextual_help, $screen_id, $screen );
        
        //Asset that the AdPlugg help is now in the screen.
        $this->assertContains( 'AdPlugg Widget Help', serialize( $screen ) );
    }
    
}

