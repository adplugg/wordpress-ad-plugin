<?php

/**
 * AdPlugg Admin class.
 * The AdPlugg Admin class sets up and controls the AdPlugg Plugin administrator
 * interace.
 *
 * @package AdPlugg
 * @since 1.0
 */
class AdPlugg_Admin {
    
    /**
     * Constructor, constructs the options page and adds it to the Settings
     * menu.
     */
    function __construct() {
        add_filter("plugin_action_links_" . ADPLUGG_BASENAME, array(&$this, 'adplugg_settings_link'));
        
        add_action('admin_init', array(&$this, 'adplugg_admin_init'));
        add_action('admin_notices', array(&$this, 'adplugg_admin_notices'));
    }
    
    /**
     * Add settings link on plugin page
     * @param array $links An array of existing links for the plugin
     * @return array The new array of links
     */
    function adplugg_settings_link($links) { 
        $settings_link = '<a href="options-general.php?page=adplugg">Settings</a>'; 
        array_unshift($links, $settings_link); 
        return $links; 
    }

    /**
     * Init the adplugg admin
     */
    function adplugg_admin_init() {
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $data_version = (array_key_exists('version', $options)) ? $options['version'] : null;
        if($data_version != ADPLUGG_VERSION) {
            $options['version'] = ADPLUGG_VERSION;
            update_option(ADPLUGG_OPTIONS_NAME, $options);
            if(!is_null($data_version)) {  //skip if not an upgrade
                //do any necessary version data upgrades here
                $upgrade_notice = AdPlugg_Notice::create('notify_upgrade', "Upgraded version from $data_version to " . ADPLUGG_VERSION . ".");
                adplugg_notice_add_to_queue($upgrade_notice);
            }
        }
        
        //Add the AdPlugg admin stylesheet to the WP admin head
        wp_register_style('adPluggAdminStylesheet', plugins_url('../css/admin.css', __FILE__) );
        wp_enqueue_style('adPluggAdminStylesheet');
    }

    /**
     * Add Notices in the administrator. Notices may be stored in the 
     * adplugg_options. Once the notices have been displayed, delete them from
     * the database.
     */
    function adplugg_admin_notices() {
        
        $screen = get_current_screen();
        $screen_id = (!empty($screen) ? $screen->id : null);
        
        // Start the notices array off with any that are queued.
        $notices = adplugg_notice_pull_all_queued();
        
        // Add any new notices based on the current state of the plugin, etc.
        if(!adplugg_is_access_code_installed()) {
            if($screen_id != "settings_page_adplugg") {
                
                $notices[]= AdPlugg_Notice::create('nag_configure', 'You\'ve activated the AdPlugg Plugin, yay! Now let\'s <a href="options-general.php?page=adplugg">configure</a> it!');
            }
        } else {
            if(!adplugg_is_widget_active()) {
                if($screen_id == "widgets") {
                    $notices[]= AdPlugg_Notice::create('nag_widget_1', 'Drag the AdPlugg Widget into a Widget Area to display ads on your site.', 'updated', true);
                } else {
                    $notices[]= AdPlugg_Notice::create('nag_widget_2', 'You\'re configured and ready to go. Now just drag the AdPlugg Widget into a Widget Area. Go to <a href="' . admin_url('widgets.php') . '">Widget Configuration</a>.', 'updated', true);
                }
            }
        }
        
        //print the notices
        $out = '';
        foreach($notices as $notice) {
            $out .= '<div class="' . $notice->get_type() . ' adplugg-notice">';
            $out .=     '<p>' .
                            '<strong>AdPlugg:</strong> ' .
                            $notice->get_message() . 
                        '</p>';
            if($notice->is_dismissible()) {
                $out .= '<p>' .
                            '<button type="button">Remind Me Later</button>' .
                            '<button type="button">Don\'t Remind Me Again</button>' .
                        '</p>';
            }
            $out .= '</div>';
        }
        echo $out;
    }
    
    /**
     * Called when the plugin is activated.
     */
    static function adplugg_activation() {
        //
    }

    /**
     * Called when the plugin is deactivated.
     */
    static function adplugg_deactivation() {
        //
    }
    
    /**
     * Function called when AdPlugg is uninstalled
     */
    static function adplugg_uninstall() {
        delete_option(ADPLUGG_OPTIONS_NAME);
        delete_option(ADPLUGG_NOTICES_NAME);
        delete_option(ADPLUGG_WIDGET_OPTIONS_NAME);
    }

}


