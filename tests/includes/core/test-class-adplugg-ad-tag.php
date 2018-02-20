<?php

/**
 * The Test_AdPlugg_Ad_Tag class includes tests for testing the AdPlugg_Ad_Tag
 * class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_Ad_Tag extends WP_UnitTestCase {

	/**
	 * Test the create function as well as the getters and setters.
	 */	
	public function test_create_and_getters_and_setters() {
		$width = 300;
		$height = 250;
		$zone = 'test_zone';
		
		//run the setters
		$adplugg_ad_tag = AdPlugg_Ad_Tag::create()
							->with_width( $width )
							->with_height( $height )
							->with_zone( $zone )
							->enable_default_for_reuse();
		
		//Assert that the AdPlugg_Ad_Tag was created
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $adplugg_ad_tag ) );
		
		//Test that the setters and getters work
		$this->assertEquals( $width, $adplugg_ad_tag->get_width() );
		$this->assertEquals( $height, $adplugg_ad_tag->get_height() );
		$this->assertEquals( $zone, $adplugg_ad_tag->get_zone() );
		$this->assertTrue( $adplugg_ad_tag->is_default_for_reuse() );
	}
	
	/**
	 * Test the to_amp_ad function.
	 */	
	public function test_to_amp_ad() {
		$width = 300;
		$height = 250;
		$zone = 'test_zone';
		$access_code = 'test';
		
		//Install the access_code
		$options = array();
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		$options['access_code'] = $access_code;
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//create the AdPlugg_Ad_Tag
		$adplugg_ad_tag = AdPlugg_Ad_Tag::create()
							->with_width( $width )
							->with_height( $height )
							->with_zone( $zone )
							->enable_default_for_reuse();
		
		//call the function
		/* @var $amp_ad \DOMElement */
		$amp_ad = $adplugg_ad_tag->to_amp_ad();
		
		//Assert that the amp_ad was created as expected
		$this->assertEquals( 'DOMElement', get_class( $amp_ad ) );
		$this->assertEquals( 'amp-ad', $amp_ad->nodeName );
		
		/* @var $amp_ad_attributes \DOMNamedNodeMap */
		$amp_ad_attributes = $amp_ad->attributes;
		
		//assert that the amp-ad has the expected attributes
		$this->assertEquals( 'adplugg', $amp_ad_attributes->getNamedItem( 'type' )->textContent );
		$this->assertEquals( $width, $amp_ad_attributes->getNamedItem( 'width' )->textContent );
		$this->assertEquals( $height, $amp_ad_attributes->getNamedItem( 'height' )->textContent );
		$this->assertEquals( $zone, $amp_ad_attributes->getNamedItem( 'data-zone' )->textContent );
		$this->assertEquals( $access_code, $amp_ad_attributes->getNamedItem( 'data-access-code' )->textContent );
		
	}
	
}

