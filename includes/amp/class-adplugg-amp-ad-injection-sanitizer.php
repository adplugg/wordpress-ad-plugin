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
	
	private $DEBUG = false;
	
	/** @var \AdPlugg_Ad_Tag_Collection */
	private $ad_tags;
	
	/**
	 * Constructor.
	 * @param \DOMDocument $dom 
	 * @param array $args An array of additional arguments.
	 */
	public function __construct($dom, $args = array()) {
		$this->ad_tags = $args['ad_tags'];
		
		parent::__construct($dom, $args);
	}
	
	/**
	 * Sanitize the content (inject ads, etc).
	 */
	public function sanitize() {
		
		/* @var $body \DOMElement */
		if ( isset( $this->root_element ) ) { // AMP Plugin > v0.7
			/* @var $body \DOMElement */
			$body = $this->root_element;
		} else { // AMP Plugin < v0.7
			/* @var $body \DOMElement */
			$body = $this->get_body_node();
		}
		
		if ( $this->ad_tags->size() > 0 ) {

			$this->ad_tags->reset();
			
			/* @var $p_nodes \DOMNodeList */
			$p_nodes = $body->getElementsByTagName( 'p' );
			
			$curr_word_count = 0;
			$ad_density = AdPlugg_AMP::get_ad_density();
			$p_nodes_len = $p_nodes->length;
			
			/* @var $ad_tag \AdPlugg_Ad_Tag */
			$ad_tag = $this->ad_tags->next();
			
			$num_ads_inserted = 0;
			$i = 0;
			//loop through all p tags
			while ( ( $i < $p_nodes_len ) && ( $ad_tag !== null ) ) {
				/* @var $p_node \DOMElement */
				$p_node = $p_nodes->item( $i );
				$content = $p_node->nodeValue;
				$p_word_count = str_word_count( strip_tags( $content ) );
				$curr_word_count += $p_word_count;
				
				//see if the slot is permitted by our ad density rules
				if ( $curr_word_count >= $ad_density ) {
					//insert an ad
					
					// Create the amp-ad tag
					/* @var $amp_ad \DOMElement */
					$amp_ad = $this->create_amp_ad( $ad_tag );
					
					//if there is a following paragraph, insert before it,
					//otherwise append to the body
					if ( ( $i + 1 ) < $p_nodes_len ) {
						$p_node_plus_one = $p_nodes->item( $i + 1 );
						$p_node_plus_one->parentNode->insertBefore( $amp_ad,  $p_node_plus_one );
						
						if ( $this->DEBUG ) {
							$debug_node = $this->dom->createElement( 'h4', $i . ':' . $curr_word_count );
							$p_node_plus_one->parentNode->insertBefore( $debug_node,  $p_node_plus_one );
						}
					} else {
						$body->appendChild( $amp_ad );
						
						if ( $this->DEBUG ) {
							$debug_node = $this->dom->createElement( 'h4', $i . ':' . $curr_word_count );
							$body->appendChild( $debug_node );
						}
					}
					
					//reset the curr_word_count and move to the next ad tag
					$curr_word_count = 0;
					$ad_tag = $this->ad_tags->next();
					$num_ads_inserted++;
				} // end insert
				
				$i++;
			} //end while more p tags
			
			// Low word count insert
			// If no ads have been inserted at this point (this would be due to
			// low word count), just add one to the bottom of the post.
			if ( ( $num_ads_inserted == 0 ) && ( $p_nodes_len > 0 ) ) {
				$this->ad_tags->reset();
				
				/* @var $ad_tag \AdPlugg_Ad_Tag */
				$ad_tag = $this->ad_tags->next();
				
				if ( $ad_tag !== null ) {
				
					/* @var $amp_ad \DOMElement */
					$amp_ad = $this->create_amp_ad( $ad_tag );
				
					$body->appendChild( $amp_ad );
				}
			} // end low word count insert
			
		} // end if ad tags
	}
	
	/**
	 * Creates an amp-ad
	 * @param AdPlugg_Ad_Tag $ad_tag The AdPlugg_Ad_Tag to use to create the
	 * amp_ad.
	 * @return DOMElement Returns an amp-ad DOMElement.
	 */
	private function create_amp_ad( $ad_tag) {
		//create the amp_ad
		
		/* @var $amp_ad DOMElement */
		$amp_ad = $ad_tag->to_amp_ad( $this->dom );
		
		//create a debug_node
		if ( $this->DEBUG ) {
			// Add a placeholder to show while loading
			$fallback_node = $this->dom->createElement( 'amp-img' );
			$fallback_node->setAttribute( 'placeholder', '' );
			$fallback_node->setAttribute( 'layout', 'fill' );
			$fallback_node->setAttribute( 
								'src', 
								'https://placehold.it/' . $ad_tag->get_width() . 'x' . $ad_tag->get_height() 
							);
			$amp_ad->appendChild( $fallback_node );
		}
		
		return $amp_ad;
	}
	
}
