<?php

require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-facebook-options-page-help.php';

/**
 * The Test_Facebook_Options_Page_Help class includes tests for testing the
 * AdPlugg_Facebook_Options_Page_Help class.
 *
 * @package AdPlugg
 * @since 1.3.0
 */
class Test_Facebook_Options_Page_Help extends WP_UnitTestCase {

	/**
	 * Test the constructor.
	 *
	 * @global array $wp_filter
	 */
	public function test_constructor() {
		global $wp_filter;

		// Call the constructor.
		$adplugg_facebook_options_page_help = new AdPlugg_Facebook_Options_Page_Help();

		$function_names = get_function_names( $wp_filter['contextual_help'] );

		// Assert that the add_help function is registered.
		$this->assertContains( 'add_help', $function_names );
	}

	/**
	 * Test the add_help function.
	 * @global string $adplugg_hook
	 */
	public function test_add_help() {
		global $adplugg_hook;

		//set up the variables
		$contextual_help = '';
		$adplugg_hook    = 'mock-hook';
		$screen_id       = $adplugg_hook . '_page_adplugg_facebook_settings';
		$screen          = WP_Screen::get( $adplugg_hook );

		// Instanitate the SUT (System Under Test) class.
		$adplugg_facebook_options_page_help = new AdPlugg_Facebook_Options_Page_Help();

		// Assert that the Facebook settings help is not in the screen.
		// phpcs:disable
		$this->assertNotContains( 'Facebook Settings Help', serialize( $screen ) );
		// phpcs:enable

		// Run the function.
		$adplugg_facebook_options_page_help->add_help(
			$contextual_help,
			$screen_id,
			$screen
		);

		// Asset that the AdPlugg help is now in the screen..
		// phpcs:disable
		$this->assertContains( 'Facebook Settings Help', serialize( $screen ) );
		// phpcs:enable
	}

}

