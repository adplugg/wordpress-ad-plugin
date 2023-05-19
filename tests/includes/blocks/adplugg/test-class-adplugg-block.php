<?php

/**
 * The Test_AdPlugg_Block class includes tests for testing the AdPlugg_Block
 * class.
 *
 * @package AdPlugg
 * @since 1.11.0
 */
class Test_AdPlugg_Block extends WP_UnitTestCase {

	/**
	 * Test the constructor.
	 */
	public function test_constructor() {
		global $wp_filter;

		// Instantiate the SUT (System Under Test) class.
		$adplugg_block = new AdPlugg_Block();

		// Assert that the block is instantiated as expected.
		$this->assertEquals( 'AdPlugg_Block', get_class( $adplugg_block ) );

		// Assert that the register_block function is registered.
		$function_names = get_function_names( $wp_filter['init'] );
		$this->assertContains( 'register_block', $function_names );
	}

	/**
	 * Test that the block is registered with WordPress.
	 */
	public function test_block_registration() {

		// Get an array of registered block type names.
		$block_types = WP_Block_Type_Registry::get_instance()
			->get_all_registered();
		$keys = array();
		foreach ($block_types as $key) {
			$keys[] = $key->name;
		}

		// Assert that the block is registered.
		$this->assertTrue( in_array( 'adplugg/adplugg', $keys ) );
	}

}
