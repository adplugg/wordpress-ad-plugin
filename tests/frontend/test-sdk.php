<?php

require_once(ADPLUGG_PATH . 'frontend/sdk.php');

/**
 * The SdkTest class includes tests for testing the functions in the
 * frontend/sdk.php file.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class SdkTest extends WP_UnitTestCase {
    
    /**
     * Test that the adplugg_add_sdk function doesn't output anything if the
     * access_code is not set. Note that if the override is set, the SDK will
     * be output.
     * TODO: Figure out a way to disable the override for this test.
     */    
    public function test_adplugg_add_sdk_doesnt_serve_without_access_code() {
        
        //Assert that nothing was output
        ob_start();
        adplugg_add_sdk();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        if(defined('ADPLUGG_OVERRIDE_ACCESS_CODE')) {
            $this->assertContains(ADPLUGG_OVERRIDE_ACCESS_CODE, $outbound);
        } else {
            $this->assertEquals('', $outbound);
        }
    }
    
    /**
     * Test that the adplugg_add_sdk function outputs the sdk when the 
     * access_code is set.
     */    
    public function test_adplugg_add_sdk_outputs_sdk() {
        
        //Set the access_code
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $options['access_code'] = 'A0000';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Output the SDK
        ob_start();
        adplugg_add_sdk();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        //Assert that the SDK is output.
        $this->assertContains('<script', $outbound);
        
    }
    
    /**
     * Test that the adplugg_add_sdk function outputs the qunit interface when
     * ADPLUGG_LOAD_QUNIT is set to TRUE.
     */    
    public function test_adplugg_add_sdk_outputs_qunit() {
        //Set the ADPLUGG_LOAD_QUNIT constant
        if(!defined('ADPLUGG_LOAD_QUNIT')) { define('ADPLUGG_LOAD_QUNIT', true); }
        
        //Set the access_code (SDK won't render without it)
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $options['access_code'] = 'A0000';
        update_option(ADPLUGG_OPTIONS_NAME, $options);
        
        //Assert that the QUnit interface is output.
        ob_start();
        adplugg_add_sdk();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('qunit', $outbound);
    }
    
    
}

