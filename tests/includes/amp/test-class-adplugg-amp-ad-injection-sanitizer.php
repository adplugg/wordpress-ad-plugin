<?php

require_once( ADPLUGG_PATH . 'tests/mocks/mock-amp-base-sanitizer.php' );

require_once( ADPLUGG_INCLUDES . 'amp/class-adplugg-amp-ad-injection-sanitizer.php' );

/**
 * The Test_AdPlugg_Amp_Ad_Injection_Sanitizer class includes tests for testing
 * the AdPlugg_Amp_Ad_Injection_Sanitizer class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_Amp_Ad_Injection_Sanitizer extends WP_UnitTestCase {

	
	/**
	 * Test the sanitize function.
	 */	
	function test_sanitize() {
		//set up a mock DOM to sanitize
		$content = '<p>Hello World!</p>';
		$source = sprintf(
			'<html><head><meta http-equiv="content-type" content="text/html; charset=%s"></head><body>%s</body></html>',
			get_bloginfo( 'charset' ),
			$content
		);
		/* @var $dom \DOMDocument */
		$dom = new \DOMDocument();
		$dom->loadHTML( $source );
		
		//set up a mock ad collection
		$ad = AdPlugg_Amp_Ad::create()
							->withWidth( 300 )
							->withHeight( 250 )
							->withZone( 'testzone' );
		$ads = new \AdPlugg_Amp_Ad_Collection();
		$ads->add( $ad );
		
		//instantiate the class
		$sanitizer = new AdPlugg_Amp_Ad_Injection_Sanitizer( 
							$dom,
							array( 'ads' => $ads )
						);
		
		//call the function
		$sanitizer->sanitize();
		
		//echo $dom->saveHTML(); //dump the whole dom
		
		// ========== traverse the dom ========== //
		
		/* @var $html \DomNode */
		$html = $dom->childNodes[1];
		
		/* @var $body \DomNode */
		$body = $html->childNodes[1];
		
		/* @var $ad \DomNode */
		$ad = $body->childNodes[1];
		
		//var_dump($ad);
		
		// ===================================== //
		
		//assert that an ad was inserted
		$this->assertEquals( 'amp-ad', $ad->nodeName );
		
		//get the ad attributes
		/* @var $ad_attributes \DOMNamedNodeMap */
		$ad_attributes = $ad->attributes;
		$ad_attributes->getNamedItem($content);
		
		//assert that the ad has the expected attributes
		$this->assertEquals( 'adplugg', $ad_attributes->getNamedItem( 'type' )->textContent );
		$this->assertEquals( '300', $ad_attributes->getNamedItem( 'width' )->textContent );
		$this->assertEquals( '250', $ad_attributes->getNamedItem( 'height' )->textContent );
		//TODO: get these working
		//$this->assertEquals( 'some_access_code', $ad_attributes->getNamedItem( 'data-access-code' )->textContent );
		//$this->assertEquals( 'some_zone', $ad_attributes->getNamedItem( 'data-zone' )->textContent );
		
	}
	
}

