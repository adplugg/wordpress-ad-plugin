<?php

/**
 * The AdPluggTest class includes tests for testing the main AdPlugg_Admin
 * class (in the class-admin.php file).
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class AdPluggTest extends WP_UnitTestCase {

    /**
     * Assert that the expected constants are declared and accessible.
     */    
    function testConstants() {
        $this->assertNotEmpty(ADPLUGG_PATH);
        $this->assertNotEmpty(ADPLUGG_BASENAME);
        $this->assertNotEmpty(ADPLUGG_ADJSSERVER);
        $this->assertNotEmpty(ADPLUGG_ADHTMLSERVER);
        $this->assertNotEmpty(ADPLUGG_VERSION);
        $this->assertNotEmpty(ADPLUGG_OPTIONS_NAME);
        $this->assertNotEmpty(ADPLUGG_FACEBOOK_OPTIONS_NAME);
        $this->assertNotEmpty(ADPLUGG_NOTICES_NAME);
        $this->assertNotEmpty(ADPLUGG_WIDGET_OPTIONS_NAME);
    }
    
}

