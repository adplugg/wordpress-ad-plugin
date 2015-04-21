<?php

/*
Plugin Name: AdPlugg
Plugin URI: http://www.adplugg.com
Description: The AdPlugg WordPress Ad Plugin is a simple plugin that allows you to easily insert ads on your WordPress blog. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="https://www.adplugg.com/apusers/signup">Sign up for a free AdPlugg account</a>, and 3) Go to the AdPlugg configuration page, and save your AdPlugg Access Code.
Version: 1.2.1
Author: AdPlugg
Author URI: www.adplugg.com
License: GPL v3

AdPlugg WordPress Ad Plugin
Copyright (c) 2014 AdPlugg <legal@adplugg.com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @package AdPlugg
 * @since 1.0
 */

//define constants
define('ADPLUGG_PATH', plugin_dir_path( __FILE__ ));
define('ADPLUGG_BASENAME', plugin_basename(__FILE__));

// Include the optional config.php file
if(file_exists(ADPLUGG_PATH . 'config.php')) {
    include_once(ADPLUGG_PATH . 'config.php');
}

if(!defined('ADPLUGG_ADSERVER')) { define('ADPLUGG_ADSERVER', 'www.adplugg.com/apusers'); }
if(!defined('ADPLUGG_VERSION')) { define('ADPLUGG_VERSION', '1.2'); }

//Persisted options
define('ADPLUGG_OPTIONS_NAME', 'adplugg_options');
define('ADPLUGG_NOTICES_NAME', 'adplugg_notices');
define('ADPLUGG_NOTICES_DISMISSED_NAME', 'adplugg_notices_dismissed');

define('ADPLUGG_WIDGET_OPTIONS_NAME', 'widget_adplugg');

//includes
require_once(ADPLUGG_PATH . 'functions.php');
require_once(ADPLUGG_PATH . 'tests/qunit.php');
require_once(ADPLUGG_PATH . 'widgets/AdPlugg_Widget.php');

// Register the AdPlugg Widget
add_action('widgets_init', create_function('', 'return register_widget("AdPlugg_Widget");'));

if(is_admin()) {
    //---- ADMIN ----//
    //includes
    require_once(ADPLUGG_PATH . 'admin/notices/notice-class.php');
    require_once(ADPLUGG_PATH . 'admin/notices/notice-controller-class.php');
    require_once(ADPLUGG_PATH . 'admin/notices/notice-functions.php');
    
    require_once(ADPLUGG_PATH . 'admin/admin-class.php');
    require_once(ADPLUGG_PATH . 'admin/pages/class-options-page.php');
    require_once(ADPLUGG_PATH . 'admin/help/help-dispatch.php');
    
    //Set up the notifications system.
    $adplugg_notice_controller = new AdPlugg_Notice_Controller();
    
    //Plugin setup and registrations
    $adplugg_admin = new AdPlugg_Admin();
    register_activation_hook(__FILE__, array('AdPlugg_Admin', 'adplugg_activation'));
    register_deactivation_hook(__FILE__, array('AdPlugg_Admin', 'adplugg_deactivation'));
    register_uninstall_hook(__FILE__, array('AdPlugg_Admin', 'adplugg_uninstall'));
    
    //set up the options page 
    $adplugg_options_page = new AdPlugg_Options_Page();
    add_filter('contextual_help', 'adplugg_help_dispatch', 10, 3);
    
    //load qunit
    if( (defined('ADPLUGG_LOAD_QUNIT')) && (ADPLUGG_LOAD_QUNIT == true) ) {
        add_action('admin_footer', 'adplugg_load_qunit');
    }

} else {
    //---- FRONT END ----//
    //add the API
    require_once(ADPLUGG_PATH . 'frontend/api.php');
    add_action('wp_footer', 'adplugg_add_api');

}
