<?php
/**
 * Functions for rendering the AdPlugg contextual help within the WordPress
 * Administrator.
 * @package AdPlugg
 * @since 1.1.29
 */

require_once( ADPLUGG_INCLUDES . 'admin/help/options-page-help.php' );
require_once( ADPLUGG_INCLUDES . 'admin/help/facebook-options-page-help.php' );
require_once( ADPLUGG_INCLUDES . 'admin/help/widgets-page-help.php' );
    
/**
 * Add help for the AdPlugg plugin to the WordPress admin help system.
 * @global type $adplugg_hook
 * @param string $contextual_help The default contextual help that our 
 * function is going to replace.
 * @param string $screen_id Used to identify the page that we are on.
 * @param string $screen Used to access the elements of the current page.
 * @return string The new contextual help.
 */
function adplugg_help_dispatch( $contextual_help, $screen_id, $screen ) {
    global $adplugg_hook;
    
    switch ( $screen_id ) {
        case 'toplevel_page_' . $adplugg_hook:
            $contextual_help = adplugg_options_page_help( $contextual_help, $screen_id, $screen );
            break;
        case $adplugg_hook . '_page_adplugg_facebook_settings':
            $contextual_help = adplugg_facebook_options_page_help( $contextual_help, $screen_id, $screen );
            break;
        case 'widgets':
            $contextual_help = adplugg_widgets_page_help( $contextual_help, $screen_id, $screen );
            break;
    }
    
    return $contextual_help;
}
