<?php
/**
 * Miscellaneous functions used by the plugin.
 * @package AdPlugg
 * @since 1.0
 */
    
/**
 * Function that looks to see if an adplugg access code has been installed.
 * @return boolean Returns true if an access code is installed, otherwise
 * returns false.
 */
function adplugg_is_access_code_installed() {
    $options = get_option( ADPLUGG_OPTIONS_NAME, array() );
    
    if( ! empty( $options['access_code'] ) ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Function that gets the active access_code
 * @return string Returns the active access code.
 */
function adplugg_get_active_access_code() {
    $access_code = null;
    $options = get_option( ADPLUGG_OPTIONS_NAME, array() );
    if( ! empty( $options['access_code'] ) ) {
        $access_code = $options['access_code'];
    }
    if( defined( 'ADPLUGG_OVERRIDE_ACCESS_CODE' ) ) {
        $access_code = ADPLUGG_OVERRIDE_ACCESS_CODE;
    }
    
    return $access_code;
}

/**
 * Function that looks to see if the AdPlugg Widget has been activated.
 * @return boolean Returns true if the widget is activated, otherwise
 * returns false.
 */
function adplugg_is_widget_active() {
    $widget_options = get_option( ADPLUGG_WIDGET_OPTIONS_NAME );
    
    /* is_active_widget doesn't work if the plugin is deactivated and then reactivated.
     * if the widget is active it will have more than one option, so this works.
     */
    if( ( ! is_null( $widget_options ) ) && ( sizeof( $widget_options ) > 1 ) ) {
        return true;
    } else {
        return false;
    }
}
