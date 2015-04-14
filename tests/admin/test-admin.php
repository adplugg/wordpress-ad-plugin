<?php

require_once(ADPLUGG_PATH . 'admin/notices/notice-class.php');
require_once(ADPLUGG_PATH . 'admin/notices/notice-functions.php');
require_once(ADPLUGG_PATH . 'admin/notices/notice-controller-class.php');
require_once(ADPLUGG_PATH . 'admin/admin-class.php');


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
        $this->assertContains('adplugg_settings_link', $function_names);
        
        //Assert that the init function is registered.
        $function_names = get_function_names($wp_filter['admin_init']);
        $this->assertContains('adplugg_admin_init', $function_names);      
    }
    
    /**
     * Test the adplugg_settings_link function.
     */    
    public function test_adplugg_settings_link() {
        $links = array();
        $adplugg_admin = new AdPlugg_Admin();
        $links = $adplugg_admin->adplugg_settings_link($links);
        
        $this->assertEquals(count($links), 1);
    }
    
    /**
     * Test the adplugg_admin_init function.
     */    
    public function test_adplugg_admin_init() {
        $adplugg_admin = new AdPlugg_Admin();
        
        //Set the version to something old/incorrect
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $options['version'] = 'old_version';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Run the function.
        $adplugg_admin->adplugg_admin_init();
        
        //Assert that the version was updated
        $new_options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $this->assertEquals($new_options['version'], ADPLUGG_VERSION);
        
        //Assert that a notice of the upgrade was registered.
        $adplugg_notice_controller = new AdPlugg_Notice_Controller();
        ob_start();
        $adplugg_notice_controller->adplugg_admin_notices();
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains("Upgraded version from", $outbound);
        
        //Assert that the admin stylesheet is registered
        global $wp_styles;
        $this->assertContains('adPluggAdminStylesheet', serialize($wp_styles));
    }
    
     /**
     * Test the uninstall function.
     */    
    public function test_uninstall() {
        $adplugg_admin = new AdPlugg_Admin();
        
        //init the plugin so that we can then uninstall it
        $adplugg_admin->adplugg_admin_init();
        
        //assert that there are options
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $this->assertNotEmpty($options);
        
        //uninstall the plugin
        $adplugg_admin->adplugg_uninstall();
        
        //assert that the options are now empty
        $options_new = get_option(ADPLUGG_OPTIONS_NAME, array());
        $this->assertEmpty($options_new);
    }
    
}

