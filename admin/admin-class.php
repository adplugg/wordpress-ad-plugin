<?php
/*
 * Copyright (c) 2013 AdPlugg <legal@adplugg.com>. All rights reserved.
 * 
 * This file is part of the Adplugg Ad Plugin.
 *
 * Permission is hereby granted, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to use and modify the
 * Software for commercial, personal, educational or governmental purposes, 
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * The Software may not be distributed without the express permission of
 * AdPlugg.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 */

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
     * @param type $links
     * @return type
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
        $options = get_option(ADPLUGG_OPTIONS_NAME);
        $data_version = $options['version'];
        if($data_version != ADPLUGG_VERSION) {
            $options['version'] = ADPLUGG_VERSION;
            update_option(ADPLUGG_OPTIONS_NAME, $options);
            if(!is_null($dataVersion)) {  //skip if not an upgrade
                //do any necessary version data upgrades here
                $notices = get_option(ADPLUGG_NOTICES_NAME);
                $notices[] = "Upgraded version $data_version to " . ADPLUGG_VERSION . ".";
                update_option('adplugg_notices', $notices);
            }
        }
    }

    /**
     * Add Notices in the administrator. Notices may be stored in the 
     * adplugg_options. Once the notices have been displayed, delete them from
     * the database.
     */
    function adplugg_admin_notices() {
        $options = get_option(ADPLUGG_OPTIONS_NAME);
        $stored_notices = get_option(ADPLUGG_NOTICES_NAME);
        $page = $_GET["page"];
        $notices = array();
        
        //stored notices
        if($stored_notices) {
            foreach($stored_notices as $notice) {
                $notices[] = $notice;
            }
            delete_option(ADPLUGG_NOTICES_NAME);
        }
        
        if(!adplugg_is_access_key_installed()) {
            if($page != "adplugg") {
                $notices[]= 'You\'ve activated the AdPlugg Plugin, Yay! Now lets <a href="options-general.php?page=adplugg">configure</a> it!';
            }
        }
        
        //print the notices
        foreach($notices as $notice) {
            echo '<div class="updated"><p>AdPlugg: ' . $notice . '</p></div>';
        }
    }
    
    /**
     * Called when the plugin is activated.  Adds an activated notice to the 
     * notices queue.
     */
    function adplugg_activation() {
        //
    }

    /**
     * Function called on AdPlugg deactivation
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
    }

}


