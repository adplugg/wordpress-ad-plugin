<?php
/**
 * Class to create the adplugg widget
 * @package AdPlugg
 * @since 1.0
 */

/**
 * Class to create the adplugg widget
 * @package AdPlugg
 * @since 1.0
 */
class AdPlugg_Widget extends WP_Widget {

    /**
     * Constructor
     */
    function AdPlugg_Widget() {
        $widget_options = array( 'classname' => 'adplugg', 'description' => __('A widget for displaying ads ', 'adplugg') );
        parent::__construct('adplugg', $name = __('AdPlugg', 'adplugg'), $widget_options);
    }

    /**
     * Widget form creation
     */
    function form($instance) {
        // Check values
	if( $instance) {
	     $zone = esc_attr($instance['zone']);
        } else {
	     $zone = '';
	}
        
        echo '<p>
                  <a href="http://www.adplugg.com" target="_blank" title="Configure at adplugg.com">Configure at adplugg.com</a>
              </p>
              <fieldset class="adplugg-fieldset">
                  <legend>Optional Settings</legend>
                  <label for="' . $this->get_field_id('zone') .'">Zone:</label>
                  <input class="widefat" id="' . $this->get_field_id('zone') . '" name="' . $this->get_field_name('zone') . '" type="text" value="' . $zone . '" />
                  <small>Enter the zone machine name.</small>
              </fieldset>';
    }

    /**
     * Widget update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['zone'] = strip_tags($new_instance['zone']);
        
        return $instance;
    }

    /**
     * Widget display
     */
    function widget($args, $instance) {
        extract($args);
        $zone = $instance['zone'];
        $zone_attribute = ($zone) ? ' data-adplugg-zone="' . $zone . '"' : '';
        
        echo $before_widget;

        // Display the widget
        echo '<div class="adplugg-tag"'. $zone_attribute.'></div>';

        echo $after_widget;
    }
}