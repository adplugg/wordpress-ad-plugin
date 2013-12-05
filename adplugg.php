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
 * The main index/control file for the AdPlugg WordPress Plugin.
 * 
 */

/*
Plugin Name: AdPlugg
Plugin URI: http://www.adplugg.com
Description: The AdPlugg WordPress Plugin is a simple plugin that allows you to easily insert ads on your WordPress blog.
Version: 1.0
Author: AdPlugg
Author URI: www.adplugg.com
*/

if(!defined( 'ADPLUGG_PATH' )) {
    define('ADPLUGG_PATH', plugin_dir_path( __FILE__ ));
}

// Register the AdPlugg Widget
require_once(ADPLUGG_PATH . 'widgets/AdPlugg_Widget.php');
add_action('widgets_init', create_function('', 'return register_widget("AdPlugg_Widget");'));


if(is_admin()) {
    //---- ADMIN ----//
    //set up the options page
    require_once(ADPLUGG_PATH . 'admin/pages/options.php' );
    add_action('admin_menu', 'adplugg_add_options_page_to_menu');
    add_action('admin_init', 'adplugg_options_init');
} else {
    //---- FRONT END ----//
    //add the API
    require_once(ADPLUGG_PATH . 'frontend/api.php');
    add_action('wp_footer', 'adplugg_add_api');
    
}


