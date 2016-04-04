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
     * Test that the widget is registered with WordPress.
     */
    public function test_widget_registration() {
        $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
        
        //Assert that the widget is registered
        $this->assertTrue(in_array("AdPlugg_Widget", $widgets));       
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
        $old_width = 100;
        $new_width = 200;
        $old_height = 300;
        $new_height = 400;
        $old_default = 0;
        $new_default = 1;
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['title'] = $old_title;
        $old_instance['zone'] = $old_zone;
        $old_instance['width'] = $old_width;
        $old_instance['height'] = $old_height;
        $old_instance['default'] = $old_default;
        
        $new_instance = array();
        $new_instance['title'] = $new_title;
        $new_instance['zone'] = $new_zone;
        $new_instance['width'] = $new_width;
        $new_instance['height'] = $new_height;
        $new_instance['default'] = $new_default;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the ret_instance title is the new title
        $this->assertEquals($ret_instance['title'], $new_title);
        
        //Assert that the ret_instance zone is the new zone
        $this->assertEquals($ret_instance['zone'], $new_zone);
        
        //Assert that the ret_instance width is the new width
        $this->assertEquals($ret_instance['width'], $new_width);
        
        //Assert that the ret_instance height is the new height
        $this->assertEquals($ret_instance['height'], $new_height);
        
        //Assert that the ret_instance default is the new default
        $this->assertEquals($ret_instance['default'], $new_default);
    }
    
    /**
     * Test the update function's validation strips illegal and malicious data.
     */
    public function test_update_validation_passes_when_valid() {
        $old_title = 'old_title';
        $new_title = 'Our Sponsors';
        $old_zone = 'old_zone';
        $new_zone = 'new_zone';
        $old_width = 100;
        $new_width = 200;
        $old_height = 300;
        $new_height = 400;
        $old_default = 0;
        $new_default = 1;
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['title'] = $old_title;
        $old_instance['zone'] = $old_zone;
        $old_instance['width'] = $old_width;
        $old_instance['height'] = $old_height;
        $old_instance['default'] = $old_default;
        
        $new_instance = array();
        $new_instance['title'] = $new_title;
        $new_instance['zone'] = $new_zone;
        $new_instance['width'] = $new_width;
        $new_instance['height'] = $new_height;
        $new_instance['default'] = $new_default;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the validation passed and the title was set as expected
        $this->assertEquals($new_title, $ret_instance['title']);
        
        //Assert that the validation passed and the zone was set as expected
        $this->assertEquals($new_zone, $ret_instance['zone']);
        
        //Assert that the validation passed and the width was set as expected
        $this->assertEquals($new_width, $ret_instance['width']);
        
        //Assert that the validation passed and the height was set as expected
        $this->assertEquals($new_height, $ret_instance['height']);
        
        //Assert that the validation passed and the default was set as expected
        $this->assertEquals($new_default, $ret_instance['default']);
    }
    
    /**
     * Test the update function's validation strips illegal and malicious data.
     */
    public function test_update_validation_strips_illegals() {
        $old_title = 'old_title';
        $new_title = '"><script>alert(document.cookie)</script>';
        $old_zone = 'old_zone';
        $new_zone = '"><script>alert(document.cookie)</script>';
        $old_width = 100;
        $new_width = '"><script>alert(document.cookie)</script>';
        $old_height = 300;
        $new_height = '"><script>alert(document.cookie)</script>';
        $old_default = 0;
        $new_default = '"><script>alert(document.cookie)</script>';
        $adplugg_widget = new AdPlugg_Widget();
        
        $old_instance = array();
        $old_instance['title'] = $old_title;
        $old_instance['zone'] = $old_zone;
        $old_instance['width'] = $old_width;
        $old_instance['height'] = $old_height;
        $old_instance['default'] = $old_default;
        
        $new_instance = array();
        $new_instance['title'] = $new_title;
        $new_instance['zone'] = $new_zone;
        $new_instance['width'] = $new_width;
        $new_instance['height'] = $new_height;
        $new_instance['default'] = $new_default;
        
        //Run the function.
        $ret_instance = $adplugg_widget->update($new_instance, $old_instance);
        
        //Assert that the malicious code was removed
        $illegal_regex = "/\<script\>/";
        //echo $ret_instance['title'];
        //echo $ret_instance['zone'];
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['title']));
        
        //Assert that the ret_instance zone does not include illegal characters
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['zone']));
        
        //Assert that the ret_instance width does not include illegal characters
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['width']));
        
        //Assert that the ret_instance height does not include illegal characters
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['height']));
        
        //Assert that the ret_instance default does not include illegal characters
        $this->assertEquals(0, preg_match($illegal_regex, $ret_instance['default']));
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
    
    /**
     * Test the widget function outputs the expected Facebook Instant Articles
     * output.
     */    
    public function test_widget_render_for_instant_articles_with_all_values() {
        //Set up the variables.
        $adplugg_widget = new AdPlugg_Widget();
        $args = array();
        $args['before_widget'] = '';
        $args['after_widget'] = '';
        $args['before_title'] = '';
        $args['after_title'] = '';
        $args['id'] = 'facebook_ia_header_ads';
        $instance = array();
        $instance['zone'] = 'test_zone';
        $instance['width'] = 100;
        $instance['height'] = 200;
        $instance['default'] = 1;
        $GLOBALS['adplugg_fbia_canonical_url'] = 'http://www.example.com/blog/hello-world/';
        
        //Assert that the widget form is output with a title.
        ob_start();
        $adplugg_widget->widget($args, $instance);
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains('test_zone', $outbound);
        $this->assertContains("100", $outbound);
        $this->assertContains("200", $outbound);
        $this->assertContains('op-ad-default', $outbound);
        $this->assertContains('www.example.com', $outbound);
        $this->assertContains('/blog/hello-world/', urldecode( $outbound ) );
    }
    
    /**
     * Test the widget function outputs the expected Facebook Instant Articles
     * output.
     */    
    public function test_widget_render_for_instant_articles_with_no_values() {
        //Set up the variables.
        $adplugg_widget = new AdPlugg_Widget();
        $args = array();
        $args['before_widget'] = '';
        $args['after_widget'] = '';
        $args['before_title'] = '';
        $args['after_title'] = '';
        $args['id'] = 'facebook_ia_header_ads';
        $instance = array();
        $instance['zone'] = null;
        $instance['width'] = null;
        $instance['height'] = null;
        $instance['default'] = 0;
        $GLOBALS['adplugg_fbia_canonical_url'] = 'http://www.example.com/blog/hello-world';
        
        //Assert that the widget form is output with a title.
        ob_start();
        $adplugg_widget->widget($args, $instance);
        $outbound = ob_get_contents();
        ob_end_clean();
        $this->assertContains("300", $outbound);
        $this->assertContains("250", $outbound);
        $this->assertNotContains('op-ad-default', $outbound);
    }
    
}

