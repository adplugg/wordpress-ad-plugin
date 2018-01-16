<?php

/**
 * Mocks the Instant_Articles_Option_Ads class
 *
 * @package AdPlugg
 * @since 1.6.18
 */
class Instant_Articles_Option_Ads {
	
	/**
	 * Fake get_option_decoded method.
	 * @return array
	 */
	public static function get_option_decoded() {
		$options = array(
			'ad_source' => 'adplugg'
		);
		
		return $options;
	}
}
