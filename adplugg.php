<?php
/**
 * Plugin Name: AdPlugg
 * Plugin URI: https://www.adplugg.com
 * Description: The AdPlugg WordPress Ad Plugin is a simple plugin that allows you to easily insert ads on your WordPress blog. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="https://www.adplugg.com/apusers/signup?utm_source=wpplugin&utm_medium=referral&utm_campaign=plugins-page-l1">Sign up for a free AdPlugg account</a> and create an ad, 3) Go to the AdPlugg configuration page, and save your AdPlugg Access Code, and 4) Go to Appearance > Widgets and drag the AdPlugg Widget into your Widget Area. Get more help at <a href="https://www.adplugg.com/support?utm_source=wpplugin&utm_campaign=plugins-page-l2">www.adplugg.com/support</a>.
 * Version: 1.9.30
 * Author: AdPlugg
 * Author URI: www.adplugg.com
 * License: GPL v3
 *
 * AdPlugg WordPress Ad Plugin
 * Copyright (c) 2019 AdPlugg <legal@adplugg.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package AdPlugg
 * @since 1.0
 */

// Define constants.
define( 'ADPLUGG_PATH', plugin_dir_path( __FILE__ ) );
define( 'ADPLUGG_INCLUDES', ADPLUGG_PATH . 'includes/' );
define( 'ADPLUGG_BASENAME', plugin_basename( __FILE__ ) );
define( 'ADPLUGG_URL', plugins_url( '/', __FILE__ ) );

// Include the optional config.php file.
if ( file_exists( ADPLUGG_PATH . 'config.php' ) ) {
	include_once ADPLUGG_PATH . 'config.php';
}

if ( ! defined( 'ADPLUGG_ADJSSERVER' ) ) {
	define( 'ADPLUGG_ADJSSERVER', 'www.adplugg.com/apusers' );
}
if ( ! defined( 'ADPLUGG_ADHTMLSERVER' ) ) {
	define( 'ADPLUGG_ADHTMLSERVER', 'www.adplugg.io' );
}
if ( ! defined( 'ADPLUGG_VERSION' ) ) {
	define( 'ADPLUGG_VERSION', '1.9.30' );
}

// Persisted options.
define( 'ADPLUGG_OPTIONS_NAME', 'adplugg_options' );
define( 'ADPLUGG_FACEBOOK_OPTIONS_NAME', 'adplugg_facebook_options' );
define( 'ADPLUGG_AMP_OPTIONS_NAME', 'adplugg_amp_options' );
define( 'ADPLUGG_NOTICES_NAME', 'adplugg_notices' );
define( 'ADPLUGG_NOTICES_DISMISSED_NAME', 'adplugg_notices_dismissed' );
define( 'ADPLUGG_RATED_NAME', 'adplugg_rated' );

define( 'ADPLUGG_WIDGET_OPTIONS_NAME', 'widget_adplugg' );

// Includes.
require_once ADPLUGG_INCLUDES . 'class-adplugg-options.php';
require_once ADPLUGG_INCLUDES . 'functions.php';
require_once ADPLUGG_INCLUDES . 'class-adplugg-facebook.php';
require_once ADPLUGG_PATH . 'tests/qunit.php';

require_once ADPLUGG_INCLUDES . 'core/class-adplugg-ad-tag.php';
require_once ADPLUGG_INCLUDES . 'core/class-adplugg-ad-tag-collection.php';
require_once ADPLUGG_INCLUDES . 'core/class-adplugg-ad-tag-collector.php';
require_once ADPLUGG_INCLUDES . 'amp/class-adplugg-amp.php';

require_once ADPLUGG_INCLUDES . 'widgets/class-adplugg-widget.php';

/**
 * Register Widgets.
 */
function adplugg_register_widgets() {
	register_widget( 'AdPlugg_Widget' );
}
add_action( 'widgets_init', 'adplugg_register_widgets' );

// Inits.
AdPlugg_Facebook::get_instance();
AdPlugg_AMP::get_instance();
AdPlugg_Ad_Tag_Collector::get_instance();

if ( is_admin() ) {
	// ---- ADMIN ---- //
	// Includes.
	require_once ADPLUGG_INCLUDES . 'admin/notices/class-adplugg-notice.php';
	require_once ADPLUGG_INCLUDES . 'admin/notices/class-adplugg-notice-controller.php';

	require_once ADPLUGG_INCLUDES . 'admin/class-adplugg-admin.php';
	require_once ADPLUGG_INCLUDES . 'admin/pages/class-adplugg-options-page.php';
	require_once ADPLUGG_INCLUDES . 'admin/pages/class-adplugg-facebook-options-page.php';
	require_once ADPLUGG_INCLUDES . 'admin/pages/class-adplugg-amp-options-page.php';
	require_once ADPLUGG_INCLUDES . 'admin/class-adplugg-privacy.php';

	// Help system includes.
	require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-options-page-help.php';
	require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-facebook-options-page-help.php';
	require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-amp-options-page-help.php';
	require_once ADPLUGG_INCLUDES . 'admin/help/class-adplugg-widgets-page-help.php';

	// Initialize notifications system.
	AdPlugg_Notice_Controller::get_instance();

	// Plugin setup and registrations.
	$adplugg_admin = new AdPlugg_Admin();
	register_activation_hook( __FILE__, array( 'AdPlugg_Admin', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'AdPlugg_Admin', 'deactivate' ) );
	register_uninstall_hook( __FILE__, array( 'AdPlugg_Admin', 'uninstall' ) );

	// Admin Initializations.
	AdPlugg_Options_Page::get_instance();
	AdPlugg_Options_Page_Help::get_instance();
	AdPlugg_Facebook_Options_Page::get_instance();
	AdPlugg_Facebook_Options_Page_Help::get_instance();
	AdPlugg_AMP_Options_Page::get_instance();
	AdPlugg_AMP_Options_Page_Help::get_instance();
	AdPlugg_Widgets_Page_Help::get_instance();
	AdPlugg_Privacy::get_instance();

	// Load QUnit.
	if ( ( defined( 'ADPLUGG_LOAD_QUNIT' ) ) && ( true === ADPLUGG_LOAD_QUNIT ) ) {
		add_action( 'admin_footer', 'adplugg_load_qunit' );
	}
} else {
	// ---- FRONT END ---- //
	// Add the SDK.
	require_once ADPLUGG_INCLUDES . 'frontend/class-adplugg-sdk.php';
	AdPlugg_Sdk::get_instance();

	// Feeds.
	require_once ADPLUGG_INCLUDES . 'frontend/class-adplugg-feed.php';
	AdPlugg_Feed::get_instance();

	// Facebook Instant Articles (only works on PHP 5.3.0 or higher).
	if ( version_compare( PHP_VERSION, '5.3.0' ) >= 0 ) {
		require_once ADPLUGG_INCLUDES . 'frontend/class-adplugg-facebook-instant-articles.php';
		AdPlugg_Facebook_Instant_Articles::get_instance();
	}
}
