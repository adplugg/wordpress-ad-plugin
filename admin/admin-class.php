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
                $notices = get_option(ADPLUGG_NOTICES_NAME);
                $notices[] = "Upgraded version from $data_version to " . ADPLUGG_VERSION . ".";
                update_option('adplugg_notices', $notices);
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
        $stored_notices = get_option(ADPLUGG_NOTICES_NAME);
        $page = (isset($_GET["page"])) ? $_GET["page"] : "";
        //$script = end((explode('/', $_SERVER['REQUEST_URI'])));
        $script = end(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $notices = array();
        
        //stored notices
        if($stored_notices) {
            foreach($stored_notices as $notice) {
                $notices[] = $notice;
            }
            delete_option(ADPLUGG_NOTICES_NAME);
        }
        
        if(!adplugg_is_access_code_installed()) {
            if($page != "adplugg") {
                $notices[]= 'You\'ve activated the AdPlugg Plugin, yay! Now let\'s <a href="options-general.php?page=adplugg">configure</a> it!';
            }
        } else {
            if(!adplugg_is_widget_active()) {
                if($script == "widgets.php") {
                    $notices[]= 'Drag the AdPlugg Widget into a Widget Area to display ads on your site.';
                } else {
                    $notices[]= 'You\'re configured and ready to go. Now just drag the AdPlugg Widget into a Widget Area. Go to <a href="' . admin_url('widgets.php') . '">Widget Configuration</a>.';
                }
            }
        }
        
        //print the notices
        foreach($notices as $notice) {
            echo '<div class="updated"><p><strong>AdPlugg:</strong> ' . $notice . '</p></div>';
        }
    }
    
    /**
     * Called when the plugin is activated.
     */
    function adplugg_activation() {
        //
    }

    /**
     * Called when the plugin is deactivated.
     */
    function adplugg_deactivation() {
        //
    }
    
    /**
     * Function called when AdPlugg is uninstalled
     */
    function adplugg_uninstall() {
        delete_option(ADPLUGG_OPTIONS_NAME);
        delete_option(ADPLUGG_NOTICES_NAME);
        delete_option(ADPLUGG_WIDGET_OPTIONS_NAME);
    }

}


