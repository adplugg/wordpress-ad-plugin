<?php
	
/**
 * The AdPlugg_AMP_Ad_Injection_Sanitizer class is used to inject AdPlugg ads
 * into AMP pages.
 * 
 * Note: this is 'included' in an amp plugin hook so that we know that the
 * AMP_Base_Sanitizer class (which this class extends) exists.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class AdPlugg_AMP_Ad_Injection_Sanitizer extends AMP_Base_Sanitizer {
	
	/** @var \AdPlugg_Ad_Collection */
	private $ads;
	
	/**
	 * Constructor.
	 * @param \DOMDocument $dom 
	 * @param array $args An array of additional arguments.
	 */
	public function __construct($dom, $args = array()) {
		$this->ads = $args['ads'];
		
		parent::__construct($dom, $args);
	}
	
	/**
	 * Sanitize the content (inject ads, etc).
	 */
	public function sanitize() {
		
		$body = $this->root_element;
		
		if( $this->ads->size() > 0 ) {
			/* @var $ad \AdPlugg_AMP_Ad */
			$ad = $this->ads->get( 0 );

			/* @var $ad_node \DOMElement */
			$amp_ad = $ad->toAMPAd( $this->dom );

			// If we have a lot of paragraphs, insert before the 4th one.
			// Otherwise, add it to the end.
			$p_nodes = $body->getElementsByTagName( 'p' );
			if ( $p_nodes->length > 6 ) {
				$p_nodes->item( 4 )->parentNode->insertBefore( $amp_ad, $p_nodes->item( 4 ));
			} else {
				$body->appendChild( $amp_ad );
			}
		}
	}
}
