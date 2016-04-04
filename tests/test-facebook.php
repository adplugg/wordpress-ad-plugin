<?php

/**
 * The AdPluggFacebookTest class includes tests for testing the AdPlugg_Facebook
 * class.
 *
 * @package AdPlugg
 * @since 1.3.0
 */
class AdPluggFacebookTest extends WP_UnitTestCase {

    /**
     * Test the is_ia_automatic_placement_enabled() function.
     */    
    function test_facebook_instant_articles_header_widget_area_init() {
        
        //enable automatic placement
        $options['ia_enable_automatic_placement'] = 1;
        update_option(ADPLUGG_FACEBOOK_OPTIONS_NAME, $options);
        
        //assert that the sidebar is not registered
        $this->assertFalse( array_key_exists( 'facebook_ia_header_ads', $GLOBALS['wp_registered_sidebars'] ) );
        
        //get the singleton instance
        $adplugg_facebook = AdPlugg_Facebook::get_instance();
        
        //call the function
        $filtered_content = $adplugg_facebook->facebook_instant_articles_header_widget_area_init();
        
        //assert that the sidebar is registed
        $this->assertTrue( array_key_exists( 'facebook_ia_header_ads', $GLOBALS['wp_registered_sidebars'] ) );
        
    }
    
    /**
     * Test the is_ia_automatic_placement_enabled() function.
     */    
    function test_is_ia_automatic_placement_enabled() {
        //Clear out any options
        $options = array();
        update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );
        
        //Assert function correctly determines automatic placement is not enabled
        $this->assertFalse( AdPlugg_Facebook::is_ia_automatic_placement_enabled() );

        //Enable automatic placement
        $options['ia_enable_automatic_placement'] = 1;
        update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );

        //Assert function correctly determines automatic placement enabled
        $this->assertTrue( AdPlugg_Facebook::is_ia_automatic_placement_enabled() );
    }
    
}

