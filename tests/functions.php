<?php
/**
 * Shared functions for testing the plugin.
 * @package AdPlugg
 * @since 1.1.16
 */

/**
 * Given a base registry array entry, this private function will return all
 * function names within that array.
 * @param array $reg_array_1 The base registry array that you want to search
 * through.
 * @return array An array of the function names that were found.
 */
function get_function_names( $reg_array_1 ) {
	$function_names = array();
	foreach ( $reg_array_1 as $reg_array_2 ) {
		foreach ( $reg_array_2 as $reg_array_3 ) {
			$function_names[] = $reg_array_3['function'][1];
		}
	}
	
	return $function_names;
}
