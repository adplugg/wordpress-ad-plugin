<?php
/**
 * Shared functions for testing the plugin.
 * @package AdPlugg
 * @since 1.1.16
 */

/**
 * Given a base registry array entry, this private function will return all
 * function names within that array.
 *
 * @param array $reg The base registry that you want to search through.
 * @return array An array of the function names that were found.
 */
function get_function_names( $reg ) {
	$function_names = array();

	$callbacks = $reg->callbacks;

	// Note: the variable names here could probably be improved.
	foreach ( $callbacks as $callback ) {
		foreach ( $callback as $function ) {
			$func = $function['function'];
			if (is_array($func)) {
				//$class = (is_object($func[0])) ? get_class($func[0]) : $func[0];
				$method = $func[1];
				//$function_name = $class . '::' . $method;
				$function_name = $method;
			} else {
				$function_name = $func;
			}
			$function_names[] = $function_name;
		}
	}

	return $function_names;
}
