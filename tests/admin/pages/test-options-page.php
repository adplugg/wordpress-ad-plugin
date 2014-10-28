<?php

require_once(ADPLUGG_PATH . 'admin/pages/class-options-page.php');

/**
 * The OptionsPageTest class includes tests for testing the AdPlugg_Options_Page
 * class
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class OptionsPageTest extends WP_UnitTestCase {
    
    /**
     * Test the constructor
     */    
    public function test_constructor() {
        $adplugg_options_page = new AdPlugg_Options_Page();
        
        global $wp_filter;
        
        //Assert that the init function is registered.
        $function_names = get_function_names($wp_filter['admin_menu']);
        $this->assertContains('adplugg_add_options_page_to_menu', $function_names);
               
        //Assert that the init function is registered.
        $function_names = get_function_names($wp_filter['admin_init']);
        $this->assertContains('adplugg_options_init', $function_names);
    }
    
    /**
     * Test the adplugg_settings_link function.
     */    
    public function test_adplugg_options_render_page() {
        $adplugg_options_page = new AdPlugg_Options_Page();
        
        //Assert that the options page was rendered
        ob_start();
        $adplugg_options_page->adplugg_options_render_page();
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('AdPlugg Settings', $outbound);
    }
    
    /**
     * Test the adplugg_add_options_page_to_menu function.
     */    
    public function test_adplugg_add_options_page_to_menu() {
        //TODO
    }
    
    /**
     * Test the adplugg_options_render_access_code function.
     */    
    public function test_options_render_access_section_text() {
        $adplugg_options_page = new AdPlugg_Options_Page();
        
        //Assert that the access section was rendered
        ob_start();
        $adplugg_options_page->adplugg_options_render_access_section_text();
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('To use AdPlugg', $outbound);
    }
    
    /**
     * Test the adplugg_options_render_access_code function.
     */    
    public function test_options_render_access_code() {
        $adplugg_options_page = new AdPlugg_Options_Page();
        
        //Assert that the access section was rendered
        ob_start();
        $adplugg_options_page->adplugg_options_render_access_code();
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('AdPlugg Access Code', $outbound);
    }
    
    /**
     * Test the adplugg_options_init function.
     */    
    public function test_adplugg_options_init() {
        //TODO
    }
    
    /**
     * Test that the adplugg_options_validate function returns an error
     * when the input is invalid.
     */
    public function test_adplugg_options_validate_invalid() {
        //Clear out any previous settings errors.
        global $wp_settings_errors;
        $wp_settings_errors = null;
        
        $adplugg_options_page = new AdPlugg_Options_Page();
        
        $input = array();
        $input['access_code'] = 'not valid';
        
        //Run the function.
        $new_options = $adplugg_options_page->adplugg_options_validate($input);
        
        //Get the messages
        $settings_errors = get_settings_errors();
        
        //Assert that an error was thrown
        $this->assertEquals("error", $settings_errors[0]["type"]);  
    }
    
    /**
     * Test the adplugg_options_validate function doesn't throw any errors when
     * the input is valid.
     */
    public function test_adplugg_options_validate_valid() {
        //Clear out any previous settings errors.
        global $wp_settings_errors;
        $wp_settings_errors = null;
        
        $adplugg_options_page = new AdPlugg_Options_Page();
        
        $input = array();
        $input['access_code'] = 'A0000';
        
        //Run the function.
        $new_options = $adplugg_options_page->adplugg_options_validate($input);
        
        //Get the messages
        $settings_errors = get_settings_errors();
        $type = $settings_errors[0]["type"];
        
        //Assert that no errors were thrown.
        foreach ( $settings_errors as $key => $details ) {
            $this->assertNotEquals("error", $details['type']);
        }
        
        //Assert that the settings were saved.
        $this->assertEquals("updated", $settings_errors[0]["type"]);  
    }
    
}

