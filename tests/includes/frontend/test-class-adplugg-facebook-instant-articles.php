<?php

require_once( ADPLUGG_INCLUDES . 'frontend/class-adplugg-feed.php' );
require_once( ADPLUGG_PATH . 'tests/mocks/mock-instant-articles-post.php' );

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
    
    /**
     * Test the header_injector function.
     */    
    public function test_header_injector() {
        //get the singleton instance
        $adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
        
        //Enable the AdPlugg IA placement option
        $options = array(
                        'ia_enable_automatic_placement' => 1
                    );
        update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );
        
        //Filter the 'is_active_sidebar' response so that it returns true
        add_filter( 'is_active_sidebar', array( 'Instant_Articles_Post', 'fake_is_active_sidebar' ), 10, 2 );
        
        //mock an Instant_Articles_Post
        $post_vars = new stdClass();
        $post_vars->ID = 1;
        $post = new WP_Post( $post_vars );
        $ia_post = new Instant_Articles_Post( $post );
        
        //call the function
        ob_start();
        $adplugg_fbia->header_injector( $ia_post );
        $output = ob_get_contents();
        ob_end_clean();
        
        //assert that the output was as expected
        $this->assertContains( '<section class="op-ad-template">', $output );
    }
    
    
}

