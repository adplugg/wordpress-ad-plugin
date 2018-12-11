<?php

require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-widgets-page-help.php';

/**
 * The Test_AdPlugg_Widgets_Page_Help class includes tests for testing the
 * AdPlugg_Widgets_Page_Help class.
 *
 * @package AdPlugg
 * @since 1.1.29
 */
class Test_AdPlugg_Widgets_Page_Help extends WP_UnitTestCase {

	/**
	 * Test the constructor.
	 *
	 * @global array $wp_filter
	 */
	public function test_constructor() {
		global $wp_filter;

		// Call the constructor.
		$adplugg_widgets_page_help = new AdPlugg_Widgets_Page_Help();

		$function_names = get_function_names( $wp_filter['contextual_help'] );

		// Assert that the add_help function is registered.
		$this->assertContains( 'add_help', $function_names );
	}

	/**
	 * Test the add_help function.
	 *
	 * @global string $adplugg_hook
	 */
	public function test_add_help() {
		global $adplugg_hook;

		//set up the variables
		$contextual_help = '';
		$adplugg_hook    = 'mock-hook';
		$screen_id       = 'widgets';
		$screen          = WP_Screen::get( $adplugg_hook );

		// Instanitate the SUT (System Under Test) class.
		$adplugg_widgets_page_help = new AdPlugg_Widgets_Page_Help();

		// Assert that the AdPlugg settings help is not in the screen.
		// phpcs:disable
		$this->assertNotContains( 'AdPlugg Widget Help', serialize( $screen ) );
		// phpcs:enable

		// Run the function.
		$adplugg_widgets_page_help->add_help(
			$contextual_help,
			$screen_id,
			$screen
		);

		// Asset that the AdPlugg plugin help is now in the screen.
		// phpcs:disable
		$this->assertContains( 'AdPlugg Widget Help', serialize( $screen ) );
		// phpcs:enable
	}

	/**
	 * Test that the add_help function doesn't add help to a page that is not
	 * the target page.
	 *
	 * @global string $adplugg_hook
	 */
	public function test_add_help_for_different_page() {
		global $adplugg_hook;

		//set up the variables
		$contextual_help = '';
		$adplugg_hook    = 'mock-hook';
		$screen_id       = 'options-general';
		$screen          = WP_Screen::get( 'widgets' );

		// Instanitate the SUT (System Under Test) class.
		$adplugg_widgets_page_help = new AdPlugg_Widgets_Page_Help();

		// Run the function.
		$adplugg_widgets_page_help->add_help(
			$contextual_help,
			$screen_id,
			$screen
		);

		// Assert that the AdPlugg plugin help is not in the screen.
		// phpcs:disable
		$this->assertNotContains( 'AdPlugg Widget Help', serialize( $screen ) );
		// phpcs:enable
	}

}

