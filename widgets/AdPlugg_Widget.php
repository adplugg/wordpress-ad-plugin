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
     * Constructor.
     */
    function AdPlugg_Widget() {
        $widget_options = array( 'classname' => 'adplugg', 'description' => 'A widget for displaying ads.' );
        parent::__construct( 'adplugg', $name = 'AdPlugg', $widget_options );
    }

    /**
     * Widget form creation. Displays the form in the widget admin.
     * @param array $instance Current settings
     */
    function form( $instance ) {
        
        // Check values
	$title = ( ( $instance ) && ( isset( $instance['title'] ) ) ) 
                    ? $instance['title'] : '';
        $zone = ( ( $instance ) && ( isset( $instance['zone'] ) ) ) 
                    ? $instance['zone'] : '';
        $width = ( ( $instance ) && ( isset( $instance['width'] ) ) ) 
                    ? $instance['width'] : '';
        $height = ( ( $instance ) && ( isset( $instance['height'] ) ) ) 
                    ? $instance['height'] : '';
        $default = ( ( $instance ) && ( isset( $instance['default'] ) ) ) 
                    ? $instance['default'] : 0;
        
        //This is used below to set the title of the widget that is displayed within the admin.
        //It is passed to widgets.js based on the '-title' id suffix
        $widget_title = ( $zone != '' ) ? $zone : '';
        
        //Render the form
        ?>
            <p>
                <a href="http://www.adplugg.com" target="_blank" title="Configure at adplugg.com">Configure at adplugg.com</a>
                |
                <a href="#" onclick="jQuery( '#contextual-help-link' ).trigger('click'); return false;" title="Help">Help</a>
            </p>
            <fieldset class="adplugg-widget-fieldset">
                <legend class="adplugg_widget_optional_legend">Optional Settings</legend>
                <legend class="adplugg_widget_legend">Settings</legend>
                <?php // ------ title ------ ?>
                <label for="<?php echo $this->get_field_id( 'title' ) ?>'">Title:</label>
                <input type="hidden" id="widget-title" value="<?php echo $widget_title; ?>">
                <?php echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />'; ?>
                <small>Enter a title for the widget.</small><br/>
                <?php // ------ zone ------ ?>
                <label for="<?php echo $this->get_field_id( 'zone' ); ?>">Zone:</label>
                <?php echo '<input class="widefat" id="' . $this->get_field_id( 'zone' ) . '" name="' . $this->get_field_name( 'zone' ) . '" type="text" value="' . $zone . '" />'; ?>
                <small>Enter the zone machine name.</small><br/>
                <?php // ------ width ------ ?>
                <label class="adplugg-fbia-only" for="<?php echo $this->get_field_id( 'width' ); ?>">Width:</label>
                <?php echo '<input class="widefat adplugg-fbia-only" id="' . $this->get_field_id( 'width' ) . '" name="' . $this->get_field_name( 'width' ) . '" type="text" value="' . $width . '" />'; ?>
                <small class="adplugg-fbia-only">Enter the width.</small><br class="adplugg-fbia-only"/>
                <?php // ------ height ------ ?>
                <label class="adplugg-fbia-only" for="<?php echo $this->get_field_id( 'height' ); ?>">Height:</label>
                <?php echo '<input class="widefat adplugg-fbia-only" id="' . $this->get_field_id( 'height' ) . '" name="' . $this->get_field_name( 'height' ) . '" type="text" value="' . $height . '" />'; ?>
                <small class="adplugg-fbia-only">Enter the height.</small><br class="adplugg-fbia-only"/>
                <?php // ------ default ------ ?>
                <label class="adplugg-fbia-only" for="<?php echo $this->get_field_id( 'default' ); ?>">
                    <?php echo '<input class="adplugg-fbia-only" type="checkbox" id="' . $this->get_field_id( 'default' ) . '" name="' . $this->get_field_name( 'default' ) . '" value="1" ' . checked( 1, $default, false ) . '" />'; ?>
                    Default
                </label><br class="adplugg-fbia-only"/>
                <small class="adplugg-fbia-only">Check to make this zone the default.</small><br class="adplugg-fbia-only"/>
        <?php
    }

    /**
     * Widget update. Called when widget admin form is submitted.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['zone'] = sanitize_key( $new_instance['zone'] );
        $instance['width'] = sanitize_key( $new_instance['width'] );
        $instance['height'] = sanitize_key( $new_instance['height'] );
        $instance['default'] = sanitize_key( $new_instance['default'] );
        
        return $instance;
    }

    /**
     * Widget frontend display
     */
    function widget( $args, $instance ) {
        
        extract($args);
        
        //------ Set up the variables ---//
        $title = ( isset($instance['title'] ) ) 
                    ? apply_filters( 'widget_title', $instance['title'] )
                    : null;
        $zone = ( isset( $instance['zone'] ) ) ? $instance['zone'] : null;
        $zone_attribute = ( $zone ) ? ' data-adplugg-zone="' . $zone . '"' : '';
        $width = ( isset( $instance['width'] ) ) ? $instance['width'] : 300;
        $height = ( isset( $instance['height'] ) ) ? $instance['height'] : 250;
        $default = ( isset( $instance['default'] ) && $instance['default'] == 1 ) ? 1 : 0;
        
        //------ Render the Widget ------//
        if( ( isset( $args['id'] ) ) && ( $args['id'] == 'facebook_ia_header_ads' ) ) {
            // ------------- FACEBOOK INSTANT ARTICLES FEED ----------//
            //configure variables
            $post_url = $GLOBALS['adplugg_fbia_canonical_url'];
            $host = urlencode( parse_url( $post_url, PHP_URL_HOST ) );
            $path = urlencode( parse_url( $post_url, PHP_URL_PATH ) );
            $zone_param = ( isset( $zone ) ) ? '&zn=' . urlencode( $zone ) : '';
            $iframe_src = 'http://' . ADPLUGG_ADHTMLSERVER . '/serve/' . adplugg_get_active_access_code() . '/html/1.1/index.html?hn=' . $host . '&bu=' . $path . $zone_param;
            $default_class = ($default) ? ' op-ad-default' : '';
            
            //output ad tags
            echo "<figure class=\"op-ad" . $default_class . "\">\n";
            echo     '<iframe src="' . $iframe_src . '" height="' . $height . '" width="' . $width . '"></iframe>' . "\n";
            echo "</figure>\n";
            
        } else {
            // --------------------- NORMAL OUTPUT -------------------//
            echo $before_widget;
            // Render the title (if there is one).
            if ( $title ) {
                echo $before_title . $title . $after_title;
            }

            // Add the AdPlugg tag
            echo '<div class="adplugg-tag"' . $zone_attribute . '></div>';
            echo $after_widget;
        }
        
    }
}
