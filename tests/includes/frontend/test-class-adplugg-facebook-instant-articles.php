<?php

require_once(ADPLUGG_INCLUDES . 'frontend/class-adplugg-feed.php');

/**
 * The Test_AdPlugg_Facebook_Instant_Articles class includes tests for testing
 * the AdPlugg_Facebook_Instant_Articles class.
 *
 * @package AdPlugg
 * @since 1.6.6
 */
class Test_AdPlugg_Facebook_Instant_Articles extends WP_UnitTestCase {
    
    /**
     * Test the get_instance function.
     */    
    public function test_get_instance() {
        //get the singleton instance
        $fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
        
        //assert that the instance is returned and is the expected class.
        $this->assertEquals( 'AdPlugg_Facebook_Instant_Articles', get_class( $fbia ) );
    }
    
    
}

