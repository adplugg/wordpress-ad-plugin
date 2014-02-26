<?php

/*
Plugin Name: AdPlugg
Plugin URI: http://www.adplugg.com
Description: The AdPlugg WordPress Ad Plugin is a simple plugin that allows you to easily insert ads on your WordPress blog. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="https://www.adplugg.com/apusers/signup">Sign up for a free AdPlugg account</a>, and 3) Go to the AdPlugg configuration page, and save your AdPlugg Access Code.
Version: 1.1.1
Author: AdPlugg
Author URI: www.adplugg.com
License: GPL v3

AdPlugg WordPress Ad Plugin
Copyright (c) 2013 AdPlugg <legal@adplugg.com>

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

// Included the optional conffig.php file
include_once(ADPLUGG_PATH . 'config.php');

if(!defined('ADPLUGG_ADSERVER')) { define('ADPLUGG_ADSERVER', 'www.adplugg.com/apusers'); }
if(!defined('ADPLUGG_VERSION')) { define('ADPLUGG_VERSION', '1.1'); }

define('ADPLUGG_OPTIONS_NAME', 'adplugg_options');
define('ADPLUGG_NOTICES_NAME', 'adplugg_notices');
define('ADPLUGG_WIDGET_OPTIONS_NAME', 'widget_adplugg');


// Register the AdPlugg Widget
require_once(ADPLUGG_PATH . 'widgets/AdPlugg_Widget.php');
add_action('widgets_init', create_function('', 'return register_widget("AdPlugg_Widget");'));


if(is_admin()) {
    //---- ADMIN ----//
    //includes
    require_once(ADPLUGG_PATH . 'functions.php');
    require_once(ADPLUGG_PATH . 'admin/admin-class.php');
    require_once(ADPLUGG_PATH . 'admin/pages/class-options-page.php' );
    require_once(ADPLUGG_PATH . 'admin/help/options-page-help.php' );
    
    //Plugin setup and registrations
    $adplugg_admin = new AdPlugg_Admin();
    register_activation_hook(__FILE__, array('AdPlugg_Admin', 'adplugg_activation' ) );
    register_deactivation_hook(__FILE__, array('AdPlugg_Admin', 'adplugg_deactivation'));
    register_uninstall_hook(__FILE__, array('AdPlugg_Admin', 'adplugg_uninstall'));
    
    //set up the options page 
    $adplugg_options_page = new AdPlugg_Options_Page();
    add_filter('contextual_help', 'adplugg_options_page_help', 10, 3);

} else {
    //---- FRONT END ----//
    //add the API
    require_once(ADPLUGG_PATH . 'frontend/api.php');
    add_action('wp_footer', 'adplugg_add_api');
    
}
