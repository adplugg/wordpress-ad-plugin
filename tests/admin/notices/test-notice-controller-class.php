<?php

require_once( ADPLUGG_PATH . 'admin/notices/class-notice-controller.php' );

/**
 * The NoticeControllerTest class includes tests for testing the various methods
 * and functions of the AdPlugg_Notice_Controller class.
 *
 * @package AdPlugg
 * @since 1.2.0
 */
class NoticeControllerTest extends WP_UnitTestCase {
    
    /**
     * Test the constructor
     */    
    public function test_constructor() {
        $adplugg_notice_controller = new AdPlugg_Notice_Controller();
        
        global $wp_filter;
        
        //Assert that the admin notices function is registered.
        $function_names = get_function_names( $wp_filter['admin_notices'] );
        //var_dump( $function_names );
        $this->assertContains( 'admin_notices', $function_names );
        
        //Assert that the admin notices function is registered.
        $function_names = get_function_names( $wp_filter['wp_ajax_adplugg_set_notice_pref'] );
        $this->assertContains( 'set_notice_pref_callback', $function_names ); 
    }
    
     /**
     * Test the admin_notices function.
     * TODO: add more tests for this function.
     */    
    public function test_admin_notices() {
        $adplugg_notice_controller = new AdPlugg_Notice_Controller();
        
        //assert that a notice was registered
        ob_start();
        $adplugg_notice_controller->admin_notices();
        $outbound = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains( 'AdPlugg', $outbound );
    }
    
    /**
     * Test the set_notice_pref_callback function.
     */
    public function test_set_notice_pref_callback() {
        $notice_key = 'test_notice';
        $remind_when = '+30 days';
        $expected = '{"notice_key":"'.$notice_key.'","status":"success"}';
        
        $_POST['notice_key'] = $notice_key;
        $_POST['remind_when'] = $remind_when;
        
        $adplugg_notice_controller = new AdPlugg_Notice_Controller();
        
        //Assert that the expected output string is returned.
        $this->expectOutputString( $expected );
        try {
            $adplugg_notice_controller->set_notice_pref_callback();
        } catch( WPDieException $ex ) {
            //
        }
    }
}

