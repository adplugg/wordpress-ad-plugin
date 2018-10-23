<?php

require_once ADPLUGG_INCLUDES . 'admin/notices/class-adplugg-notice.php';
require_once ADPLUGG_INCLUDES . 'admin/notices/class-adplugg-notice-controller.php';

/**
 * The Test_AdPlugg_Notice_Controller class includes tests for testing the
 * various methods and functions of the AdPlugg_Notice_Controller class.
 *
 * @package AdPlugg
 * @since 1.2.0
 */
class Test_AdPlugg_Notice_Controller extends WP_UnitTestCase {

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

		// Spoof the nonce.
		$_REQUEST['_ajax_nonce'] = wp_create_nonce( 'adplugg_set_notice_pref' );

		// Set the post vars.
		$_POST['notice_key'] = $notice_key;
		$_POST['remind_when'] = $remind_when;

		$adplugg_notice_controller = new AdPlugg_Notice_Controller();

		// Assert that the expected output string is returned.
		$this->expectOutputString( $expected );
		try {
			$adplugg_notice_controller->set_notice_pref_callback();
		} catch( WPDieException $ex ) {
			//
		}
	}

	/**
	 * Test the add_to_queue function.
	 */
	public function test_add_to_queue() {
		$notice_key = 'test_notice';
		$notice = AdPlugg_Notice::create( $notice_key, 'This is a test notice' );

		//get the notice controller.
		$adplugg_notice_controller = AdPlugg_Notice_Controller::get_instance();

		//call the method
		$adplugg_notice_controller->add_to_queue( $notice );

		$notices = get_option( ADPLUGG_NOTICES_NAME );

		//Assert that the queued notice was found in the database.
		$this->assertNotEmpty( $notices[$notice_key] );
	}

	/**
	 * Test the pull_all_queued function.
	 */
	public function test_pull_all_queued() {
		$notice_key = 'test_notice';
		$notice = AdPlugg_Notice::create( $notice_key, 'This is a test notice' );

		//Add the notice to the database.
		$stored_notices = get_option( ADPLUGG_NOTICES_NAME );
		$stored_notices[$notice->get_notice_key()] = $notice->to_array();
		update_option( ADPLUGG_NOTICES_NAME, $stored_notices );

		//get the notice controller.
		$adplugg_notice_controller = AdPlugg_Notice_Controller::get_instance();

		//call the method.
		$notices = $adplugg_notice_controller->pull_all_queued();

		/* @var $notice1 AdPlugg_Notice */
		$notice1 = $notices[0];

		//Assert that the queued notice was returned
		$this->assertEquals( $notice_key, $notice1->get_notice_key() );

		$stored_notices = get_option( ADPLUGG_NOTICES_NAME );

		//Assert that the queue is now empty
		$this->assertEmpty( $stored_notices );
	}
}

