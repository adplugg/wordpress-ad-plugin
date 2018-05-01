<?php

/**
 * Mocks the Instant Articles Header class
 *
 * @package AdPlugg
 * @since 1.6.18
 */
class Header {

	/**
	 * @var array Array of Ads.
	 */
	private $ads;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Add an ad to the ads array
	 * @param Ad $ad
	 */
	public function addAd( $ad ) {
		if ( $this->ads == null ) {
			$this->ads = array();
		}
		
		array_push( $this->ads, $ad );
	}
	
	/**
	 * Get the array of ads
	 * @return array Returns the array of ads
	 */
	public function getAds()
	{
		return $this->ads;
	}
	
}
