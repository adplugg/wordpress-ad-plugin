<?php
/**
 * Miscellaneous functions used by the plugin.
 * @package AdPlugg
 * @since 1.0
 */
    
/**
 * Function that looks to see if an adplugg access key has been installed.
 * @return boolean Returns true if an access key is installed, otherwise
 * returns false.
 */
function adplugg_is_access_key_installed() {
    $options = get_option(ADPLUGG_OPTIONS_NAME, array() );
    if($options['access_code']) {
        return true;
    } else {
        return false;
    }
}



