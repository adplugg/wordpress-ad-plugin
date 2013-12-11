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
        echo '<a href="http://www.adplugg.com" target="_blank">Configure at adplugg.com</a>';
    }

    /**
     * Widget update
     */
    function update($new_instance, $old_instance) {
        //
    }

    /**
     * Widget display
     */
    function widget($args, $instance) {
        extract($args);

        echo $before_widget;

        // Display the widget
        echo '<div class="adplugg-placement"></div>';

        echo $after_widget;
    }
}