<?php

/**
 * The Test_AdPlugg_MailPoet class includes tests for testing the
 * AdPlugg_MailPoet class.
 *
 * @package AdPlugg
 * @since 1.10.0
 */
class Test_AdPlugg_MailPoet extends WP_UnitTestCase {

	/**
	 * Test the render_mailpoet_shortcode() function.
	 */
	function test_render_mailpoet_shortcode() {

		// Set up the test data.
		$shortcode       = '[custom:adplugg:ad zone="12345" idx="0"]';
		$newsletter      = null; // Not used by our function.
		$subscriber      = null; // Not used by our function.
		$queue           = null; // Not used by our function.
		$newsletter_body = null; // Not used by our function.
		$arguments       = array(
			'zone' => '12345',
			'idx'  => '0',
		);

		// Get the singleton instance
		$adplugg_mailpoet = AdPlugg_MailPoet::get_instance();

		// Call the function.
		$filtered_content = $adplugg_mailpoet->render_mailpoet_shortcode(
			$shortcode,
			$newsletter,
			$subscriber,
			$queue,
			$newsletter_body,
			$arguments
		);

		// Assert that the tag is returned as expected.
		$this->assertStringContainsString( 'adplugg-emailtag', $filtered_content );

	}

}

