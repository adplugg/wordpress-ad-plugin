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
        $widget_options = array( 'classname' => 'adplugg', 'description' => 'A widget for displaying ads.' );
        parent::__construct('adplugg', $name = 'AdPlugg', $widget_options);
    }

    /**
     * Widget form creation
     * @param array $instance Current settings
     */
    function form($instance) {
        // Check values
	      $title = (($instance) && (isset($instance['title']))) 
                    ? $instance['title'] : '';
        $zone = (($instance) && (isset($instance['zone']))) 
                    ? $instance['zone'] : '';
        
        //Render the form
        echo '<p>
                  <a href="http://www.adplugg.com" target="_blank" title="Configure at adplugg.com">Configure at adplugg.com</a>
                  |
                  <a href="#" onclick="jQuery(\'a#contextual-help-link\').trigger(\'click\'); return false;" title="Help">Help</a>
              </p>
              <fieldset class="adplugg-widget-fieldset">
                  <legend>Optional Settings</legend>
                  <label for="' . $this->get_field_id('title') .'">Title:</label>
                  <input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
                  <small>Enter a title for the widget.</small><br/>
                  <label for="' . $this->get_field_id('zone') .'">Zone:</label>
                  <input class="widefat" id="' . $this->get_field_id('zone') . '" name="' . $this->get_field_name('zone') . '" type="text" value="' . $zone . '" />
                  <small>Enter the zone machine name.</small><br/>
              </fieldset>';
    }

    /**
     * Widget update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_title($new_instance['title']);
        $instance['zone'] = sanitize_key($new_instance['zone']);
        
        return $instance;
    }

    /**
     * Widget display
     */
    function widget($args, $instance) {
        extract($args);
        //------ Set up the variables ---//
        $title = (isset($instance['title'])) 
                    ? apply_filters('widget_title', $instance['title'])
                    : null;
        $zone = (isset($instance['zone'])) ? $instance['zone'] : null;
        $zone_attribute = ($zone) ? ' data-adplugg-zone="' . $zone . '"' : '';
        
        //------ Render the Widget ------//
        echo $before_widget;
        
        // Render the title (if there is one).
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        // Add the AdPlugg tag
        echo '<div class="adplugg-tag"'. $zone_attribute.'></div>';

        echo $after_widget;
    }
}
