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
 * The main index/control file for the AdPlugg WordPress Ad Plugin.
 * @package AdPlugg
 * @since 1.0
 * 
 */

/*
Plugin Name: AdPlugg
Plugin URI: http://www.adplugg.com
Description: The AdPlugg WordPress Ad Plugin is a simple plugin that allows you to easily insert ads on your WordPress blog. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="https://www.adplugg.com/apusers/signup">Sign up for a free AdPlugg account</a>, and 3) Go to the AdPlugg configuration page, and save your AdPlugg Access Code.
Version: 1.0
Author: AdPlugg
Author URI: www.adplugg.com
*/

if(!defined('ADPLUGG_VERSION')) {
    define('ADPLUGG_VERSION', '1.0');
    define('ADPLUGG_PATH', plugin_dir_path( __FILE__ ));
    define('ADPLUGG_BASENAME', plugin_basename(__FILE__));
    define('ADPLUGG_OPTIONS_NAME', 'adplugg_options');
    define('ADPLUGG_NOTICES_NAME', 'adplugg_notices');
}

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
