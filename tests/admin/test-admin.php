<?php

require_once(ADPLUGG_PATH . 'admin/notices/class-notice.php');
require_once(ADPLUGG_PATH . 'admin/notices/notice-functions.php');
require_once(ADPLUGG_PATH . 'admin/notices/class-notice-controller.php');
require_once(ADPLUGG_PATH . 'admin/class-admin.php');


/**
 * The AdminTest class includes tests for testing the AdPlugg_Admin class.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class AdminTest extends WP_UnitTestCase {
    
    /**
     * Test the constructor
     */    
    public function test_constructor() {
        $adplugg_admin = new AdPlugg_Admin();
        
        global $wp_filter;

        //Assert that the settings link is registered.
        $function_names = get_function_names(
                              $wp_filter['plugin_action_links_' . ADPLUGG_BASENAME]
                          );
        $this->assertContains( 'add_settings_link_to_plugin_listing', $function_names );
        
        //Assert that the admin_footer_text filter is registered
        $function_names = get_function_names( $wp_filter['admin_footer_text'] );
        $this->assertContains( 'admin_footer_text', $function_names );
        
        //Assert that the init function is registered.
        $function_names = get_function_names( $wp_filter['admin_init'] );
        $this->assertContains( 'admin_init', $function_names );
        
        //Assert that the adplugg_rated function is registered.
        $function_names = get_function_names( $wp_filter['wp_ajax_adplugg_rated'] );
        $this->assertContains( 'rated_callback', $function_names ); 
    }
    
    /**
     * Test the add_settings_link_to_plugin_listing function.
     */    
    public function test_add_settings_link_to_plugin_listing() {
        $links = array();
        $adplugg_admin = new AdPlugg_Admin();
        $links = $adplugg_admin->add_settings_link_to_plugin_listing($links);
        
        $this->assertEquals(count($links), 1);
    }
    
    /**
     * Test the admin_init function.
     */    
    public function test_admin_init() {
        $adplugg_admin = new AdPlugg_Admin();
        
        //Set the version to something old/incorrect
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $options['version'] = 'old_version';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Run the function.
        $adplugg_admin->admin_init();
        
        //Assert that the version was updated
        $new_options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $this->assertEquals($new_options['version'], ADPLUGG_VERSION);
        
        //Assert that a notice of the upgrade was registered.
        $adplugg_notice_controller = new AdPlugg_Notice_Controller();
        ob_start();
        $adplugg_notice_controller->admin_notices();
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains("Upgraded version from", $outbound);
        
        //Assert that the admin stylesheet is registered
        global $wp_styles;
        $this->assertContains('adPluggAdminStylesheet', serialize($wp_styles));
    }
    
    /**
     * Test the admin_footer_text function when the plugin hasn't yet been
     * rated.
     */    
    public function test_admin_footer_text_when_not_yet_rated() {
        global $current_screen;
        
        //Load the AdPlugg_Admin
        $adplugg_admin = new AdPlugg_Admin();
        
        //Install an access_code
        $options['access_code'] = 'test';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Set the current screen to our settings page.
        $current_screen = WP_Screen::get( 'settings_page_adplugg' );
        
        //Get the footer text
        $footer_text = apply_filters( 'admin_footer_text', 'foo');
        
        //Assert that our 'rate us' text is in the footer text
        $this->assertContains( 'If you like', $footer_text );
    }
    
    /**
     * Test the admin_footer_text function when the plugin has already been
     * rated.
     */    
    public function test_admin_footer_text_when_already_rated() {
        global $current_screen;
        
        //Load the AdPlugg_Admin
        $adplugg_admin = new AdPlugg_Admin();
        
        //Install an access_code
        $options['access_code'] = 'test';
        update_option( ADPLUGG_OPTIONS_NAME, $options );
        
        //Set the rated flag
        update_option( ADPLUGG_RATED_NAME, 1 );
        
        //Set the current screen to our settings page.
        $current_screen = WP_Screen::get( 'settings_page_adplugg' );
        
        //Get the footer text
        $footer_text = apply_filters( 'admin_footer_text', 'foo');
        
        //Assert that our 'rate us' text is in the footer text
        $this->assertContains( 'Thank you for using AdPlugg', $footer_text );
    }
    
    /**
     * Test the set_notice_pref_callback function.
     */
    public function test_rated_callback() {
        $adplugg_admin = new AdPlugg_Admin();
        
        //Get the rated value
        $rated = get_option( ADPLUGG_RATED_NAME );
        
        //Assert that rated is not set
        $this->assertEquals( 0, $rated );
        
        //Call the function
        try {
            $adplugg_admin->rated_callback();
        } catch(WPDieException $ex) {
            //
        }
        
        //Get the rated value again
        $rated = get_option( ADPLUGG_RATED_NAME );
        
        //Assert that rated is now 1
        $this->assertEquals( 1, $rated );
    }
    
     /**
     * Test the uninstall function.
     */    
    public function test_uninstall() {
        $adplugg_admin = new AdPlugg_Admin();
        
        //init the plugin so that we can then uninstall it
        $adplugg_admin->admin_init();
        
        //assert that there are options
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $this->assertNotEmpty($options);
        
        //uninstall the plugin
        $adplugg_admin->uninstall();
        
        //assert that the options are now empty
        $options_new = get_option(ADPLUGG_OPTIONS_NAME, array());
        $this->assertEmpty($options_new);
    }
    
}

