<?php

/**
 * AdPlugg_Ad_Tag class. The AdPlugg_Ad_Tag class represents an AdPlugg Ad Tag.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class AdPlugg_Ad_Tag {
	
	/**
     * @var int The width of the ad tag.
     */
    private $width;
	
	/**
     * @var int The height of the ad tag.
     */
    private $height;
	
	/**
     * @var string (optional) The zone for the ad tag.
     */
    private $zone;
	
	/**
     * @var boolean Ad will be reused if additional placement slots are 
	 * available. False by default.
     */
    private $is_default_for_reuse = false;
   

	/**
	 * Private constructor. 
	 * 
	 * Note: use create builder pattern instead.
	 */
    private function __construct() {
		//set the defaults
		$this->width = 300;
		$this->height = 250;
		$this->is_default_for_reuse = false;
    }

	/**
	 * Creates a new AdPlugg_Ad_Tag.
	 * @return \self
	 */
    public static function create() {
        return new self();
    }
	
	/**
     * Sets the width of your ad tag.
     *
     * @param int $width The width of your ad tag.
     *
     * @return $this
     */
    public function with_width( $width ) {
        $this->width = $width;

        return $this;
    }

    /**
     * Sets the height of your ad tag.
     *
     * @param int $height The height of your ad tag.
     *
     * @return $this
     */
    public function with_height( $height ) {
        $this->height = $height;

        return $this;
    }
	
	/**
     * Sets the zone for the ad tag.
     *
     * @param string $zone The zone for the ad tag.
     * @return $this
     */
    public function with_zone( $zone ) {
        $this->zone = $zone;

        return $this;
    }
	
	/**
     * Gets the width of your ad tag.
     *
     * @return int The width of your ad tag.
     */
    public function get_width() {
        return $this->width;
    }

    /**
     * Gets the height of your ad tag.
     *
     * @return int The height of your ad tag.
     */
    public function get_height() {
        return $this->height;
    }
	
	/**
     * Gets the zone for the ad tag.
     *
     * @return string The zone for the ad tag.
     */
    public function get_zone() {
        return $this->zone;
    }
	
	/**
	 * Enable is_default_for_reuse.
     * @return $this
     */
    public function enable_default_for_reuse() {
        $this->is_default_for_reuse = true;
		
		return $this;
    }
	
	/**
	 * Disable is_default_for_reuse.
     * @return $this
     */
    public function disable_default_for_reuse() {
        $this->is_default_for_reuse = false;
		
		return $this;
    }
	
	/**
	 * Get whether or not this ad tag has been set to be the default for reuse.
     * @return bool True if ad tag has been set to default. Otherwise, returns
	 * false.
     */
    public function is_default_for_reuse() {
        return $this->is_default_for_reuse;
    }

    /**
     * Structure and create the ad tag in an amp-ad DOMElement.
     *
     * @param \DOMDocument $document The document where this element will be
	 * appended (optional).
     * @return \DOMElement The built amp-ad tag as a DOMElement.
     */
    public function to_amp_ad( $document = null ) {
        if ( ! $document ) {
            $document = new DOMDocument();
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

