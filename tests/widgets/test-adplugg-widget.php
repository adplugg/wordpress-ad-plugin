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
        $adplugg_widget = new AdPlugg_Widget();
        
        //Assert that the widget is constructed
        $this->assertEquals('AdPlugg_Widget', get_class($adplugg_widget));    
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
        $this->assertContains('adplugg-widget-fieldset', $outbound);
    }
    
    /**
     * Test the update function.
     */    
    public function test_update() {
        $old_title = 'old_title';
        $new_title = 'new_title';
        $old_zone = 'old_zone';
        $new_zone = 'new_zone';
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['title'] = $old_title;
        $old_instance['zone'] = $old_zone;
        
        $new_instance = array();
        $new_instance['title'] = $new_title;
        $new_instance['zone'] = $new_zone;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the ret_instance title is the new title
        $this->assertEquals($ret_instance['title'], $new_title);
        
        //Assert that the ret_instance zone is the new zone
        $this->assertEquals($ret_instance['zone'], $new_zone);
    }
    
    /**
     * Test the update function's validation strips illegal and malicious data.
     */
    public function test_update_validation_passes_when_valid() {
        $old_title = 'old_title';
        $new_title = 'Our Sponsors';
        $old_zone = 'old_zone';
        $new_zone = 'new_zone';
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['title'] = $old_title;
        $old_instance['zone'] = $old_zone;
        
        $new_instance = array();
        $new_instance['title'] = $new_title;
        $new_instance['zone'] = $new_zone;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the validation passed and the title was set as expected
        $this->assertEquals($new_title, $ret_instance['title']);
        
        //Assert that the validation passed and the zone was set as expected
        $this->assertEquals($new_zone, $ret_instance['zone']);
    }
    
    /**
     * Test the update function's validation strips illegal and malicious data.
     */
    public function test_update_validation_strips_illegals() {
        $old_title = 'old_title';
        $new_title = '"><script>alert(document.cookie)</script>';
        $old_zone = 'old_zone';
        $new_zone = '"><script>alert(document.cookie)</script>';
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['title'] = $old_title;
        $old_instance['zone'] = $old_zone;
        
        $new_instance = array();
        $new_instance['title'] = $new_title;
        $new_instance['zone'] = $new_zone;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the malicious code was removed
        $illegal_regex = "/\<script\>/";
        //echo $ret_instance['title'];
        //echo $ret_instance['zone'];
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['title']));
        
        //Assert that the ret_instance zone does not include illegal characters
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['zone']));
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
    
    /**
     * Test the widget function outputs zone info (when set).
     */    
    public function test_widget_zones() {
        //Set up the variables.
        $adplugg_widget = new AdPlugg_Widget();
        $args = array();
        $args['before_widget'] = '';
        $args['after_widget'] = '';
        $instance = array();
        $instance['zone'] = 'test_zone';
        
        //Assert that the widget form is output with zone info.
        ob_start();
        $adplugg_widget->widget($args, $instance);
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('data-adplugg-zone="test_zone"', $outbound);
    }
    
    /**
     * Test the widget function outputs title (when set).
     */    
    public function test_widget_title() {
        //Set up the variables.
        $adplugg_widget = new AdPlugg_Widget();
        $args = array();
        $args['before_widget'] = '';
        $args['after_widget'] = '';
        $args['before_title'] = '';
        $args['after_title'] = '';
        $instance = array();
        $instance['title'] = 'test_title';
        
        //Assert that the widget form is output with a title.
        ob_start();
        $adplugg_widget->widget($args, $instance);
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('test_title', $outbound);
    }
    
}

