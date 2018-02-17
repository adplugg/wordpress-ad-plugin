<?php

/**
 * AdPlugg_Amp_Ad_Collection class is a class for storing a collection of
 * AdPlugg_Amp_Ads
 *
 * @package AdPlugg
 * @since 1.7.0
 * @todo Add unit testing
 */
class AdPlugg_Amp_Ad_Collection {
	
	private $ads;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->ads = array();
	}
	
	/**
	 * Add the passed Ad to the collection.
	 * @param AdPlugg_Amp_Ad $ad
	 */
	public function add( AdPlugg_Amp_Ad $ad ) {
		array_push( $this->ads, $ad );
	}
	
	/**
	 * Get the ad at the passed index.
	 * @param integer $idx The index of the ad that you want.
	 * @return AdPlugg_Amp_Ad $ad The ad.
	 */
	public function get( $idx ) {
		return $this->ads[$idx];
	}
	
	/**
	 * Get the ad at the passed index.
	 * @param integer $idx The index of the ad that you want.
	 * @return AdPlugg_Amp_Ad $ad The ad.
	 */
	public function size() {
		return count( $this->ads );
	}
	
}

