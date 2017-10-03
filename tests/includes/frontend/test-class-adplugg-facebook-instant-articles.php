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
        $adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
        
        //assert that the instance is returned and is the expected class.
        $this->assertEquals( 'AdPlugg_Facebook_Instant_Articles', get_class( $adplugg_fbia ) );
    }
    
    /**
     * Test the head_injector function.
     */    
    public function test_head_injector() {
        //get the singleton instance
        $adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
        
        //Enable the AdPlugg IA placement option
        $options = array(
                        'ia_enable_automatic_placement' => 1
                    );
        update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );
        
        //mock some data
        $ia_post = new \stdClass();
        
        //call the function
        ob_start();
        $adplugg_fbia->head_injector( $ia_post );
        $output = ob_get_contents();
        ob_end_clean();
        
        //assert that the output was as expected
        $this->assertContains( '<meta property="fb:use_automatic_ad_placement" content="true">', $output );
    }
    
    
}

