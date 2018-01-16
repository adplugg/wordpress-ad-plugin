<?php

require_once( ADPLUGG_INCLUDES . 'frontend/class-adplugg-feed.php' );
require_once( ADPLUGG_PATH . 'tests/mocks/mock-instant-articles-post.php' );
require_once( ADPLUGG_PATH . 'tests/mocks/mock-instant-articles-option-ads.php' );
require_once( ADPLUGG_PATH . 'tests/mocks/mock-instant-articles-ad.php' );
require_once( ADPLUGG_PATH . 'tests/mocks/mock-instant-articles-header.php' );

/**
 * The Test_AdPlugg_Facebook_Instant_Articles class includes tests for testing
 * the AdPlugg_Facebook_Instant_Articles class.
 *
 * @package AdPlugg
 * @since 1.6.6
 */
class Test_AdPlugg_Facebook_Instant_Articles extends WP_UnitTestCase {
	
	/**
	 * Test the get_instance function.
	 */	
	public function test_get_instance() {
		//get the singleton instance
		$adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
		
		//assert that the instance is returned and is the expected class.
		$this->assertEquals( 'AdPlugg_Facebook_Instant_Articles', get_class( $adplugg_fbia ) );
	}
	
	/**
	 * Test the head_injector function.
	 */	
	public function test_head_injector() {
		//get the singleton instance
		$adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
		
		//Enable the AdPlugg IA placement option
		$options = array(
						'ia_enable_automatic_placement' => 1
					);
		update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );
		
		//mock some data
		$ia_post = new \stdClass();
		
		//call the function
		ob_start();
		$adplugg_fbia->head_injector( $ia_post );
		$output = ob_get_contents();
		ob_end_clean();
		
		//assert that the output was as expected
		$this->assertContains( '<meta property="fb:use_automatic_ad_placement" content="true">', $output );
	}
	
	/**
	 * Test the header_injector function.
	 */	
	public function test_header_injector() {
		//get the singleton instance
		$adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
		
		//Enable the AdPlugg IA placement option
		$options = array(
						'ia_enable_automatic_placement' => 1
					);
		update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );
		
		//Filter the 'is_active_sidebar' response so that it returns true
		add_filter( 'is_active_sidebar', array( 'Instant_Articles_Post', 'fake_is_active_sidebar' ), 10, 2 );
		
		//mock an Instant_Articles_Post
		$post_vars = new stdClass();
		$post_vars->ID = 1;
		$post = new WP_Post( $post_vars );
		$ia_post = new Instant_Articles_Post( $post );
		
		//call the function
		ob_start();
		$adplugg_fbia->header_injector( $ia_post );
		$output = ob_get_contents();
		ob_end_clean();
		
		//assert that the output was as expected
		$this->assertContains( '<section class="op-ad-template">', $output );
	}
	
	/**
	 * Test the insert_ads function.
	 */	
	public function test_insert_ads() {
		global $wp_registered_widgets;
		
		//get the singleton instance
		$adplugg_fbia = AdPlugg_Facebook_Instant_Articles::get_instance();
		
		//Install an access code
		$options = array( 'access_code' => 'test' );
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//Enable the AdPlugg IA placement option
		$options = array( 'ia_enable_automatic_placement' => 1 );
		update_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, $options );
		
		//Filter the 'is_active_sidebar' response so that it returns true
		add_filter( 'is_active_sidebar', array( 'Instant_Articles_Post', 'fake_is_active_sidebar' ), 10, 2 );
		
		//Filter the 'sidebars_widgets' response
		add_filter( 'sidebars_widgets', array( 'Instant_Articles_Post', 'fake_wp_get_sidebars_widgets' ), 10, 2 );
		
		//Fake that the widget is active
		$fake_id = 'adplugg';
		$wp_registered_widgets[$fake_id] = array(
			'callback' => array(
				'0' => new AdPlugg_Widget()
			),
			'params' => array(
				'0' => array(
					'number' => 0
				)
			)
		);
		
		//Add the widget options
		$options = array( 0 => null );
		update_option( 'widget_adplugg', $options );
		
		//mock an Instant_Articles_Post
		$post_vars = new stdClass();
		$post_vars->ID = 1;
		$post = new WP_Post( $post_vars );
		$ia_post = new Instant_Articles_Post( $post );
		
		//set the Instant_Articles_Post on our singleton instance
		$adplugg_fbia->set_instant_article( $ia_post );
		
		/* @var $header Header */
		$header = $ia_post->getHeader();
		
		//assert that there aren't any ads in the header yet
		$this->assertNull($header->getAds());
		
		//call the function
		$adplugg_fbia->insert_ads( $ia_post );
		
		//assert that our ad was added to the header
		$this->assertEquals(1, sizeof($header->getAds()));
	}
	
}

