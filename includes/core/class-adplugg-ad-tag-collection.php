<?php

/**
 * AdPlugg_Ad_Tag_Collection class is a class for storing a collection of
 * AdPlugg_Ad_Tags
 *
 * @package AdPlugg
 * @since 1.7.0
 * @todo Add unit testing
 */
class AdPlugg_Ad_Tag_Collection {
	
	/** @var array */
	private $ad_tags;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->ad_tags = array();
	}
	
	/**
	 * Add the passed Ad Tag to the collection.
	 * @param AdPlugg_Ad_Tag $ad_tag
	 */
	public function add( AdPlugg_Ad_Tag $ad_tag ) {
		array_push( $this->ad_tags, $ad_tag );
	}
	
	/**
	 * Get the ad at the passed index.
	 * @param integer $idx The index of the ad that you want.
	 * @return AdPlugg_Ad_Tag Returns the AdPlugg_Ad_Tag at the passed index.
	 */
	public function get( $idx ) {
		return $this->ad_tags[$idx];
	}
	
	/**
	 * Get the ad at the passed index.
	 * @param integer $idx The index of the ad tag that you want.
	 * @return integer The number of ad tags in the collection.
	 */
	public function size() {
		return count( $this->ad_tags );
	}
	
	/**
	 * Get the ad tag collection as an array.
	 * @return array Returns the ad tag collection as an array.
	 */
	public function to_array() {
		return $this->ad_tags;
	}
	
}

