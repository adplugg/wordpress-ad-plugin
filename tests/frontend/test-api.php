<?php

require_once(ADPLUGG_PATH . 'frontend/api.php');

/**
 * The ApiTest class includes tests for testing the functions in the
 * frontend/api.php file.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class ApiTest extends WP_UnitTestCase {
    
    /**
     * Test that the adplugg_add_api function doesn't output anything if the
     * access_code is not set. Note that if the override is set, the API will
     * be output.
     * TODO: Figure out a way to disable the override for this test.
     */    
    public function test_adplugg_add_api_doesnt_serve_without_access_code() {
        
        //Assert that nothing was output
        ob_start();
        adplugg_add_api();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        if(defined('ADPLUGG_OVERRIDE_ACCESS_CODE')) {
            $this->assertContains(ADPLUGG_OVERRIDE_ACCESS_CODE, $outbound);
        } else {
            $this->assertEquals('', $outbound);
        }
    }
    
    /**
     * Test that the adplugg_add_api function outputs the api when the 
     * access_code is set.
     */    
    public function test_adplugg_add_api_outputs_api() {
        
        //Set the access_code
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $options['access_code'] = 'A0000';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Output the API
        ob_start();
        adplugg_add_api();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        //Assert that the API is output.
        $this->assertContains('<script', $outbound);
        
    }
    
    /**
     * Test that the adplugg_add_api function outputs the qunit interface when
     * ADPLUGG_LOAD_QUNIT is set to TRUE.
     */    
    public function test_adplugg_add_api_outputs_qunit() {
        //Set the ADPLUGG_LOAD_QUNIT constant
        if(!defined('ADPLUGG_LOAD_QUNIT')) { define('ADPLUGG_LOAD_QUNIT', true); }
        
        //Set the access_code (API won't render without it)
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $options['access_code'] = 'A0000';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Assert that the QUnit interface is output.
        ob_start();
        adplugg_add_api();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('qunit', $outbound);
    }
    
    
}

