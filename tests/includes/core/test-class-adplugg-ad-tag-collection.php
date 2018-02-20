<?php

/**
 * The Test_AdPlugg_Ad_Tag_Collection class includes tests for testing the
 * AdPlugg_Ad_Tag_Collection class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_Ad_Tag_Collection extends WP_UnitTestCase {

	/**
	 * Test the constructor.
	 */	
	public function test_constructor() {
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//Assert that the AdPlugg_Ad_Tag_Collection was created as expected.
		$this->assertEquals( 'AdPlugg_Ad_Tag_Collection', get_class( $ad_tags ) );
	}
	
	/**
	 * Test the add function.
	 */	
	public function test_add() {
		//Create an AdPlugg_Ad_Tag to test with
		$ad_tag = AdPlugg_Ad_Tag::create();

		//Instantiate the class
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//call the method
		$ad_tags->add( $ad_tag );
		
		//Assert that the AdPlugg_Ad_Tag was added as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $ad_tags->get( 0 ) ) );
	}
	
	/**
	 * Test the get function.
	 */	
	public function test_get() {

		//Instantiate the class
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//Add an ad tag to the collection
		$ad_tags->add( AdPlugg_Ad_Tag::create() );
		
		//call the method
		/* @var $ad_tag \AdPlugg_Ad_Tag */
		$ad_tag = $ad_tags->get( 0 );
		
		//Assert that the AdPlugg_Ad_Tag was returned as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $ad_tag ) );
	}
	
	/**
	 * Test the size function.
	 */	
	public function test_size() {

		//Instantiate the class
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//Add an ad tag to the collection
		$ad_tags->add( AdPlugg_Ad_Tag::create() );
		
		//Call the method
		$size = $ad_tags->size();
		
		//Assert that the AdPlugg_Ad_Tag was returned as expected
		$this->assertEquals( 1, $size );
	}
	
	/**
	 * Test the next function when there is no default ad.
	 */	
	public function test_next_with_no_default() {

		//Instantiate the class
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//Add an ad tag to the collection
		$ad_tags->add( AdPlugg_Ad_Tag::create() );
		
		//Call the method
		/* @var $ad_tag \AdPlugg_Ad_Tag */
		$ad_tag = $ad_tags->next();
		
		//Assert that the AdPlugg_Ad_Tag was returned as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $ad_tag ) );
		
		//Call the method again
		/* @var $ad_tag \AdPlugg_Ad_Tag */
		$ad_tag = $ad_tags->next();
		
		//Assert that null was returned as expected
		$this->assertNull( $ad_tag );
	}
	
	/**
	 * Test the next function with a default ad.
	 */	
	public function test_next_default() {

		//Instantiate the class
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//Add a regular ad tag to the collection
		$ad_tags->add( AdPlugg_Ad_Tag::create() );
		
		//Add a default ad tag to the collection
		$ad_tags->add( AdPlugg_Ad_Tag::create()->enable_default_for_reuse() );
		
		//Call the method
		/* @var $ad_tag \AdPlugg_Ad_Tag */
		$ad_tag = $ad_tags->next();
		
		//Assert that the AdPlugg_Ad_Tag was returned as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $ad_tag ) );
		$this->assertFalse( $ad_tag->is_default_for_reuse() );
		
		//Call the method again
		/* @var $ad_tag \AdPlugg_Ad_Tag */
		$ad_tag = $ad_tags->next();
		
		//Assert that default AdPlugg_Ad_Tag was returned as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $ad_tag ) );
		$this->assertTrue( $ad_tag->is_default_for_reuse() );
	}
	
	/**
	 * Test the to_array function.
	 */	
	public function test_to_array() {

		//Instantiate the class
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
		
		//Add an ad tag to the collection
		$ad_tags->add( AdPlugg_Ad_Tag::create() );
		
		//Call the method
		$ad_tag_array = $ad_tags->to_array();
		
		//Assert that an array was returned as expected
		$this->assertTrue( is_array( $ad_tag_array ) );
	}
	
}

