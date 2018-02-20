<?php

require_once( ADPLUGG_PATH . 'tests/mocks/mock-amp-base-sanitizer.php' );

require_once( ADPLUGG_INCLUDES . 'amp/class-adplugg-amp-ad-injection-sanitizer.php' );

/**
 * The Test_AdPlugg_AMP_Ad_Injection_Sanitizer class includes tests for testing
 * the AdPlugg_AMP_Ad_Injection_Sanitizer class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_AMP_Ad_Injection_Sanitizer extends WP_UnitTestCase {

	
	/**
	 * Test the sanitize function.
	 */	
	function test_sanitize() {
		//set up a mock DOM to sanitize
		$content = '<p>' . str_repeat( 'Lorem ', 251 ) . '</p>' .
					'<p>' . str_repeat( 'Lorem ', 100 ) . '</p>' ;
		$source = sprintf(
			'<html><head><meta http-equiv="content-type" content="text/html; charset=%s"></head><body>%s</body></html>',
			get_bloginfo( 'charset' ),
			$content
		);
		/* @var $dom \DOMDocument */
		$dom = new \DOMDocument();
		$dom->loadHTML( $source );
		
		//set up a mock ad collection
		$ad_tag = AdPlugg_Ad_Tag::create()
							->with_width( 300 )
							->with_height( 250 )
							->with_zone( 'test_zone' );
		$ad_tags = new \AdPlugg_Ad_Tag_Collection();
		$ad_tags->add( $ad_tag );
		
		//instantiate the class
		$sanitizer = new AdPlugg_AMP_Ad_Injection_Sanitizer( 
							$dom,
							array( 'ad_tags' => $ad_tags )
						);
		
		//call the function
		$sanitizer->sanitize();
		
		//echo $dom->saveHTML(); //dump the whole dom
		
		// ========== traverse the dom ========== //
		
		/* @var $html \DomNode */
		$html = $dom->childNodes[1];
		
		/* @var $body \DomNode */
		$body = $html->childNodes[1];
		
		/* @var $amp_ad \DomNode */
		$amp_ad = $body->childNodes[1];
		
		//var_dump($ad_tag);
		
		// ===================================== //
		
		//assert that an ad was inserted
		$this->assertEquals( 'amp-ad', $amp_ad->nodeName );
	}
	
}

