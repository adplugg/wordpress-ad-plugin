<?php

require_once(ADPLUGG_PATH . 'widgets/AdPlugg_Widget.php');

/**
 * The AdPlugg_Widget_Test class includes tests for testing the AdPlugg_Widget
 * class.
 *
 * @package AdPlugg
 * @since 1.1.16
 */
class AdPlugg_Widget_Test extends WP_UnitTestCase {
    
    /**
     * Test the constructor.
     */    
    public function test_constructor() {
        //TODO     
    }
    
    /**
     * Test the form function.
     */    
    public function test_form() {
        $adplugg_widget = new AdPlugg_Widget();
        
        //Assert that the widget form is output.
        ob_start();
        $instance = null;
        $adplugg_widget->form($instance);
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('adplugg-fieldset', $outbound);
    }
    
    /**
     * Test the update function.
     */    
    public function test_update() {
        $old_zone = 'old_zone';
        $new_zone = 'new_zone';
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['zone'] = $old_zone;
        
        $new_instance = array();
        $new_instance['zone'] = $new_zone;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the ret_instance zone is the new zone
        $this->assertEquals($ret_instance['zone'], $new_zone);
    }
    
    /**
     * Test the widget function.
     */    
    public function test_widget() {
        //Set up the variables.
        $adplugg_widget = new AdPlugg_Widget();
        $args = array();
        $args['before_widget'] = '';
        $args['after_widget'] = '';
        $instance = null;
        
        //Assert that the widget form is output.
        ob_start();
        $adplugg_widget->widget($args, $instance);
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('adplugg-tag', $outbound);
        
    }
    
}

