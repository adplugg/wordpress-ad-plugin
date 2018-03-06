<?php

/**
 * The Test_AdPlugg class includes tests for testing the code in the main
 * adplugg.php file.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class Test_AdPlugg extends WP_UnitTestCase {

	/**
	 * Assert that the expected constants are declared and accessible.
	 */	
	function testConstants() {
		$this->assertNotEmpty( ADPLUGG_PATH );
		$this->assertNotEmpty( ADPLUGG_INCLUDES );
		$this->assertNotEmpty( ADPLUGG_BASENAME );
		$this->assertNotEmpty( ADPLUGG_ADJSSERVER );
		$this->assertNotEmpty( ADPLUGG_ADHTMLSERVER );
		$this->assertNotEmpty( ADPLUGG_VERSION) ;
		$this->assertNotEmpty( ADPLUGG_OPTIONS_NAME );
		$this->assertNotEmpty( ADPLUGG_FACEBOOK_OPTIONS_NAME );
		$this->assertNotEmpty( ADPLUGG_AMP_OPTIONS_NAME );
		$this->assertNotEmpty( ADPLUGG_NOTICES_NAME );
		$this->assertNotEmpty( ADPLUGG_WIDGET_OPTIONS_NAME );
	}
	
}

