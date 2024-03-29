<?php

require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-amp-options-page-help.php';

/**
 * The Test_AMP_Options_Page_Help class includes tests for testing the
 * AdPlugg_AMP_Options_Page_Help class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AMP_Options_Page_Help extends WP_UnitTestCase {

	/**
	 * Test the constructor.
	 *
	 * @global array $wp_filter
	 */
	public function test_constructor() {
		global $wp_filter;

		// Call the constructor.
		$adplugg_amp_options_page_help = new AdPlugg_AMP_Options_Page_Help();

		$function_names = get_function_names( $wp_filter['current_screen'] );

		// Assert that the add_help function is registered.
		$this->assertContains( 'add_help', $function_names );
	}

	/**
	 * Test the add_help function.
	 *
	 * @global string $adplugg_hook
	 * @global string $current_screen
	 */
	public function test_add_help() {
		global $adplugg_hook;
		global $current_screen;

		// Set up the variables.
		$adplugg_hook = 'mock-hook';
		$screen_id    = $adplugg_hook . '_page_adplugg_amp_settings';
		$screen       = WP_Screen::get( $screen_id );

		// Set the current screen (via $current_screen global).
		$current_screen = $screen;

		// Instanitate the SUT (System Under Test) class.
		$adplugg_amp_options_page_help = new AdPlugg_AMP_Options_Page_Help();

		// Assert that the AMP settings help is not in the screen.
		// phpcs:disable
		$this->assertStringNotContainsString(
			'AMP Settings Help',
			json_encode( $screen->get_help_tabs() )
		);
		// phpcs:enable

		// Run the function.
		$adplugg_amp_options_page_help->add_help();

		// Asset that the AdPlugg help is now in the screen..
		// phpcs:disable
		$this->assertStringContainsString(
			'AMP Settings Help',
			json_encode( $screen->get_help_tabs() )
		);
		// phpcs:enable
	}

	/**
	 * Test that the add_help function doesn't add help to a page that is not
	 * the target page.
	 *
	 * @global string $adplugg_hook
	 * @global string $current_screen
	 */
	public function test_add_help_for_different_page() {
		global $adplugg_hook;
		global $current_screen;

		// Set up the variables.
		$adplugg_hook = 'mock-hook';
		$screen_id    = 'widgets';
		$screen       = WP_Screen::get( $screen_id );

		// Set the current screen (via $current_screen global).
		$current_screen = $screen;

		// Instanitate the SUT (System Under Test) class.
		$adplugg_amp_options_page_help = new AdPlugg_AMP_Options_Page_Help();

		// Run the function.
		$adplugg_amp_options_page_help->add_help();

		// Assert that the AMP settings help is not in the screen.
		// phpcs:disable
		$this->assertStringNotContainsString(
			'AMP Settings Help',
			json_encode( $screen->get_help_tabs() )
		);
		// phpcs:enable
	}

}
