<?php

/**
 * AdPlugg_Ad_Tag_Collection class is a class for storing a collection of
 * AdPlugg_Ad_Tags
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class AdPlugg_Ad_Tag_Collection {
	
	/** @var array */
	private $ad_tags;
	
	/** 
	 * The current index. Used when iterating through the collection. Defaults
	 * to -1.
	 * @var integer 
	 */
	private $current_index;
	
	/**
	 * The default AdPlugg_Ad_Tag
	 * @var AdPlugg_Ad_Tag
	 */
	private $default;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->current_index = -1;
		$this->ad_tags = array();
	}
	
	/**
	 * Add the passed Ad Tag to the collection.
	 * @param AdPlugg_Ad_Tag $ad_tag
	 */
	public function add( AdPlugg_Ad_Tag $ad_tag ) {
		array_push( $this->ad_tags, $ad_tag );
		
		if ( $ad_tag->is_default_for_reuse() ) {
			$this->default = $ad_tag;
		}
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
	 * Resets the current index to -1.
	 */
	public function reset() {
		$this->current_index = -1;
	}
	
	/**
	 * Returns the next ad tag in the collection. If there are no more ad tags,
	 * it returns the default. If there are no more ad tags and no default, it
	 * returns null.
	 * @return \AdPlugg_Ad_Tag
	 */
	public function next() {
		$ret = null;
		
		//if there is a next, increment and return the next one.
		if ( $this->current_index <= ( count( $this->ad_tags ) -2 ) ) {
			$this->current_index++;
			$ret = $this->ad_tags[ $this->current_index ];
		} else {
			
			//if there is not a next but there is a default, return the default.
			if ( $this->default !== null ) {
				$ret = $this->default;
			}
			
		}
		
		return $ret;
	}
	
	/**
	 * Get the ad tag collection as an array.
	 * @return array Returns the ad tag collection as an array.
	 */
	public function to_array() {
		return $this->ad_tags;
	}
	
}

