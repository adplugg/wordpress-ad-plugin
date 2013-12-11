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
    $options = get_option(ADPLUGG_OPTIONS_NAME, array() );
    if($options['access_code']) {
        return true;
    } else {
        return false;
    }
}

/**
 * Function that looks to see if the AdPlugg Widget has been activated.
 * @return boolean Returns true if the widget is activated, otherwise
 * returns false.
 */
function adplugg_is_widget_active() {
    if(is_active_widget(false, false, 'adplugg', true )) {
        return true;
    } else {
        return false;
    }
}



