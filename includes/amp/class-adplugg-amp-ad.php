<?php

/**
 * AdPlugg_Amp_Ad class. The AdPlugg_Amp_Ad class represents an AdPlugg AMP ad.
 *
 * @package AdPlugg
 * @since 1.7.0
 * @todo Add unit testing
 */
class AdPlugg_Amp_Ad {
	
	/**
     * @var int The width of the ad. Default 300px.
     */
    private $width;
	
	/**
     * @var int The height of the ad. Default 250px.
     */
    private $height;
	
	/**
     * @var string (optional) The zone for the ad.
     */
    private $zone;
	
	/**
     * @var boolean Ad will be reused if additional placement slots are 
	 * available. False by default.
     */
    private $isDefaultForReuse = false;
   

	/**
	 * Private constructor. 
	 * 
	 * Note: use create builder pattern instead.
	 */
    private function __construct() {
		//set the defaults
		$this->width = 300;
		$this->height = 250;
		$this->isDefaultForReuse = false;
    }

	/**
	 * Creates a new AdPlugg_Amp_Ad.
	 * @return \self
	 */
    public static function create() {
        return new self();
    }
	
	/**
     * Sets the width of your ad.
     *
     * @param int $width The width of your ad.
     *
     * @return $this
     */
    public function withWidth( $width ) {
        $this->width = $width;

        return $this;
    }

    /**
     * Sets the height of your ad.
     *
     * @param int $height The height of your ad.
     *
     * @return $this
     */
    public function withHeight( $height ) {
        $this->height = $height;

        return $this;
    }
	
	/**
     * Sets the zone for the ad.
     *
     * @param string $zone The zone for the ad.
     * @return $this
     */
    public function withZone( $zone ) {
        $this->zone = $zone;

        return $this;
    }
	
	/**
     * Gets the width of your ad.
     *
     * @return int The width of your ad.
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Gets the height of your ad.
     *
     * @return int The height of your ad.
     */
    public function getHeight()
    {
        return $this->height;
    }
	
	/**
     * Gets the zone for the ad.
     *
     * @return string The zone for the ad.
     */
    public function getZone()
    {
        return $this->zone;
    }
	
	/**
     * @return bool True if ad has been set to reusable.
     */
    public function getIsDefaultForReuse()
    {
        return $this->isDefaultForReuse;
    }

    /**
     * Structure and create the full ad in a DOMElement.
     *
     * @param \DOMDocument $document The document where this element will be
	 * appended (optional).
     * @return \DOMElement The built amp-ad tag as a DOMElement.
     */
    public function toDOMElement( $document = null ) {
        if ( ! $document ) {
            $document = new \DOMDocument();
        }

		//create the amp-ad element
        $amp_ad = $document->createElement( 'amp-ad' );
        
		//set the attributes
		$amp_ad->setAttribute( 'type', 'adplugg' );
		$amp_ad->setAttribute( 'width', $this->width );
		$amp_ad->setAttribute( 'height', $this->height );
		$amp_ad->setAttribute( 'data-access-code', AdPlugg_Options::get_active_access_code() );

        if ( $this->zone ) {
            $amp_ad->setAttribute( 'data-zone', $this->zone );
		}

        return $amp_ad;
    }
	
}

