<?php

/**
 * AdPlugg_Ad_Collection class is a class for storing a collection of
 * AdPlugg_Ads
 *
 * @package AdPlugg
 * @since 1.7.0
 * @todo Add unit testing
 */
class AdPlugg_Ad_Collection {
	
	/** @var array */
	private $ads;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->ads = array();
	}
	
	/**
	 * Add the passed Ad to the collection.
	 * @param AdPlugg_Ad $ad
	 */
	public function add( AdPlugg_Ad $ad ) {
		array_push( $this->ads, $ad );
	}
	
	/**
	 * Get the ad at the passed index.
	 * @param integer $idx The index of the ad that you want.
	 * @return AdPlugg_Ad $ad The ad.
	 */
	public function get( $idx ) {
		return $this->ads[$idx];
	}
	
	/**
	 * Get the ad at the passed index.
	 * @param integer $idx The index of the ad that you want.
	 * @return integer The number of ads in the collection.
	 */
	public function size() {
		return count( $this->ads );
	}
	
}

