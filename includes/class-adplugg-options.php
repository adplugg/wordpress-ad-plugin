<?php
/**
 *
 * The AdPlugg_Options class includes functions for setting and getting AdPlugg
 * options.
 *
 * @package AdPlugg
 * @since 1.6.10
 */

/**
 * AdPlugg_Options class.
 */
abstract class AdPlugg_Options {

	/**
	 * Function that looks to see if an AdPlugg access code has been installed.
	 *
	 * @return boolean Returns true if an access code is installed, otherwise
	 * returns false.
	 */
	public static function is_access_code_installed() {
		$options = get_option( ADPLUGG_OPTIONS_NAME, array() );

		if ( ! empty( $options['access_code'] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Function that gets the active access_code.
	 *
	 * @return string|null Returns the active access code.
	 */
	public static function get_active_access_code() {
		$access_code = null;
		$options     = get_option( ADPLUGG_OPTIONS_NAME, array() );
		if ( ! empty( $options['access_code'] ) ) {
			$access_code = $options['access_code'];
		}
		if ( defined( 'ADPLUGG_OVERRIDE_ACCESS_CODE' ) ) {
			$access_code = ADPLUGG_OVERRIDE_ACCESS_CODE;
		}

		return $access_code;
	}

}
