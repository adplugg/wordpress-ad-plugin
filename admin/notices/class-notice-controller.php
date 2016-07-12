<?php

/**
 * AdPlugg Notices class.
 * The AdPlugg Notices Controller class sets up and controls the AdPlugg 
 * notices.
 *
 * @package AdPlugg
 * @since 1.2
 */
class AdPlugg_Notice_Controller {
    
    /**
     * Constructor, constructs the AdPlugg_Notice_Controller and registers
     * actions.
     */
    function __construct() {
        add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
        add_action( 'wp_ajax_adplugg_set_notice_pref', array( &$this, 'set_notice_pref_callback' ) );
    }

    /**
     * Add Notices in the administrator. Adds both notices from the db and
     * notices based on the current state of the plugin (see code).
     */
    function admin_notices() {
        
        $screen = get_current_screen();
        $screen_id = ( ! empty( $screen ) ? $screen->id : null );
        
        // Start the notices array off with any that are queued.
        $notices = adplugg_notice_pull_all_queued();
        
        // Add any new notices based on the current state of the plugin, etc.
        if( ! adplugg_is_access_code_installed() ) {
            if( $screen_id != 'toplevel_page_adplugg' ) {
                $notices[] = AdPlugg_Notice::create( 'nag_configure', 'You\'ve activated the AdPlugg Plugin, yay! Now let\'s <a title="Configure the AdPlugg Plugin!" href="' . admin_url('admin.php?page=adplugg') . '">configure</a> it!', 'updated', true, '+30 days' );
            }
        } else {
            if( ! adplugg_is_widget_active() ) {
                if( $screen_id == 'widgets' ) {
                    $notices[] = AdPlugg_Notice::create( 'nag_widget_1', 'Drag the AdPlugg Widget into a Widget Area to display ads on your site.', 'updated', true, '+30 days' );
                } else {
                    $notices[] = AdPlugg_Notice::create( 'nag_widget_2', 'You\'re configured and ready to go. Now just drag the AdPlugg Widget into a Widget Area. Go to <a href="' . admin_url('widgets.php') . '">Widget Configuration</a>.', 'updated', true, '+30 days' );
                }
            }
        }
        
        //print the notices
        $out = '';
        foreach( $notices as $notice ) {
            $out .= $notice->get_rendered();
        }
        echo $out;
    }
    
    /**
     * Called via ajax to dismiss a notice. Registered in the constructor above.
     */
    function set_notice_pref_callback() {
        //Get the variables from the post request
        $notice_key = $_POST['notice_key'];
        $remind_when = $_POST['remind_when'];

        //Determine when to remind on
        $remind_on = null;
        if( $remind_when != null ) {
            $remind_on = strtotime( $remind_when );
        }
        
        //Add the dismissal to the database
        $dismissals = get_option( ADPLUGG_NOTICES_DISMISSED_NAME, array() );
        $dismissals[$notice_key] = $remind_on;
        update_option( ADPLUGG_NOTICES_DISMISSED_NAME, $dismissals );
        
        //Build the return array
        $ret = array();
        $ret['notice_key'] = $notice_key;
        $ret['status'] = 'success';
        
        //return the json
        echo json_encode( $ret );
	wp_die(); //terminate immediately and return a proper response
    }

}


