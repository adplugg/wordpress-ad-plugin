<?php

require_once(ADPLUGG_PATH . 'admin/notices/class-notice.php');
require_once(ADPLUGG_PATH . 'admin/notices/notice-functions.php');

/**
 * The NoticeFunctionsTest class includes tests for testing the notice
 * functions.
 *
 * @package AdPlugg
 * @since 1.2.0
 */
class NoticeFunctionsTest extends WP_UnitTestCase {
    
    /**
     * Test the adplugg_notice_add_to_queue function.
     */    
    public function test_adplugg_notice_add_to_queue() {
        $notice_key = 'test_notice';
        $notice = AdPlugg_Notice::create($notice_key, 'This is a test notice');
        
        adplugg_notice_add_to_queue($notice);
        
        $notices = get_option(ADPLUGG_NOTICES_NAME);
        
        //Assert that the queued notice was found in the database.
        $this->assertNotEmpty($notices[$notice_key]);
    }
    
    /**
     * Test the adplugg_notice_pull_all_queued function.
     */    
    public function test_adplugg_notice_pull_all_queued() {
        $notice_key = 'test_notice';
        $notice = AdPlugg_Notice::create($notice_key, 'This is a test notice');
        
        //Add the notice to the database.
        $stored_notices = get_option(ADPLUGG_NOTICES_NAME);
        $stored_notices[$notice->get_notice_key()] = $notice->to_array();
        update_option(ADPLUGG_NOTICES_NAME, $stored_notices);
        
        $notices = adplugg_notice_pull_all_queued();
        
        /* @var $notice1 AdPlugg_Notice */
        $notice1 = $notices[0];
        
        //Assert that the queued notice was returned
        $this->assertEquals($notice_key, $notice1->get_notice_key());
        
        $stored_notices = get_option(ADPLUGG_NOTICES_NAME);
        
        //Assert that the queue is now empty
        $this->assertEmpty($stored_notices);
    }
    
    
}

