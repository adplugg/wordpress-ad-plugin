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
     * Constructor, constructs the class and registers filters and actions.
     */
    function __construct() {
        add_filter("plugin_action_links_" . ADPLUGG_BASENAME, array(&$this, 'adplugg_settings_link'));
        
        add_action('admin_init', array(&$this, 'adplugg_admin_init'));
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
        
        //Add the AdPlugg admin JavaScript page to the WP admin head
        wp_register_script('adPluggAdminJavaScriptPage', plugins_url('../js/admin.js', __FILE__) );
        wp_enqueue_script('adPluggAdminJavaScriptPage');
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
     * Called when plugin is uninstalled.
     */
    static function adplugg_uninstall() {
        delete_option(ADPLUGG_OPTIONS_NAME);
        delete_option(ADPLUGG_NOTICES_NAME);
        delete_option(ADPLUGG_NOTICES_DISMISSED_NAME);
        delete_option(ADPLUGG_WIDGET_OPTIONS_NAME);
    }

}


