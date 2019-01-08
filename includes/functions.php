<?php
/**
 * Miscellaneous functions used by the plugin.
 *
 * @package AdPlugg
 * @since 1.0
 */

/**
 * Function that looks to see if the AdPlugg Widget has been activated.
 *
 * @return boolean Returns true if the widget is activated, otherwise, returns
 * false.
 */
function adplugg_is_widget_active() {
	$widget_options = get_option( ADPLUGG_WIDGET_OPTIONS_NAME );

	// is_active_widget doesn't work if the plugin is deactivated and then
	// reactivated. If the widget is active, it will have more than one option,
	// so this works.
	if ( ( ! is_null( $widget_options ) ) && ( count( $widget_options ) > 1 ) ) {
		return true;
	} else {
		return false;
	}
}
