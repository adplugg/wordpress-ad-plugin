<?php

/**
 * The Functions_Test class includes tests for the functions in functions.php
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class Test_Functions extends WP_UnitTestCase {
	
	/**
	 * Assert that adplugg_is_widget_active() correctly returns whether or not
	 * the adplugg widget is active.
	 */	
	function test_adplugg_is_widget_active() {
		//Clear out any options
		$options = array();
		update_option( ADPLUGG_WIDGET_OPTIONS_NAME, $options );
		
		//Assert function correctly determines widget is not active
		$this->assertFalse( adplugg_is_widget_active() );

		//Activate the widget
		$options[2]['zone'] = '';
		$options['_multiwidget'] = 1;
		update_option( ADPLUGG_WIDGET_OPTIONS_NAME, $options );

		//Assert function correctly determines widget is active
		$this->assertTrue( adplugg_is_widget_active() );
	}
	
}
