<?php

/**
 * The FunctionsTest class includes tests for the functions in functions.php
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class FunctionsTest extends WP_UnitTestCase {

    /**
     * Assert that adplugg_is_access_code_installed() correctly returns whether
     * or not an AdPlugg access code has been installed.
     */    
    function test_adplugg_is_access_code_installed() {
        //Clear out any options
        $options = array();
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Assert function correctly determines access_code not installed
        $this->assertFalse( adplugg_is_access_code_installed() );

        //Install the access_code
        $options['access_code'] = 'test';
        update_option(ADPLUGG_OPTIONS_NAME, $options);

        //Assert function correctly determines access_code installed
        $this->assertTrue( adplugg_is_access_code_installed() );
    }
    
    /**
     * Assert that adplugg_get_active_access_code() returns the expected access
     * code.
     */    
    function test_adplugg_get_active_access_code() {
        //Install the access_code
        $options = array();
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        $options['access_code'] = 'test';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        $access_code = adplugg_get_active_access_code();

        if(defined('ADPLUGG_OVERRIDE_ACCESS_CODE')) {
            $this->assertContains(ADPLUGG_OVERRIDE_ACCESS_CODE, $access_code);
        } else {
            $this->assertEquals('test', $access_code);
        }
    }
    
    /**
     * Assert that adplugg_is_widget_active() correctly returns whether or not
     * the adplugg widget is active.
     */    
    function test_adplugg_is_widget_active() {
        //Clear out any options
        $options = array();
        update_option(ADPLUGG_WIDGET_OPTIONS_NAME, $options);
        
        //Assert function correctly determines widget is not active
        $this->assertFalse( adplugg_is_widget_active() );

        //Activate the widget
        $options[2]['zone'] = '';
        $options['_multiwidget'] = 1;
        update_option(ADPLUGG_WIDGET_OPTIONS_NAME, $options);

        //Assert function correctly determines widget is active
        $this->assertTrue( adplugg_is_widget_active() );
    }
    
}

