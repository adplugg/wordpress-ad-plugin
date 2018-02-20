<?php

/**
 * The Test_AdPlugg_Ad_Tag_Collector class includes tests for testing the
 * AdPlugg_Ad_Tag_Collector class.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class Test_AdPlugg_Ad_Tag_Collector extends WP_UnitTestCase {
	
	/**
	 * Hook the is_active_sidebar filter to always return true.
	 * 
	 * @wp-hook is_active_sidebar
	 * @return Returns true.
	 */
	static function fake_is_active_sidebar() {
		return true;
	}
	
	/**
	 * Hook the sidebars_widgets filter.
	 * 
	 * @wp-hook sidebars_widgets
	 * @return Returns true.
	 */
	static function fake_wp_get_sidebars_widgets() {
		$ret = array(
					'amp_ads' => array(
						'adplugg'
					)
				);
		
		return $ret;
	}
	
	/**
	 * Test the get_ad_tags function.
	 * @global $wp_registered_widgets
	 */	
	public function test_get_ad_tags() {
		global $wp_registered_widgets;
		
		//get the singleton instance
		$collector = AdPlugg_Ad_Tag_Collector::get_instance();
		
		//Install an access code
		$options = array( 'access_code' => 'test' );
		update_option( ADPLUGG_OPTIONS_NAME, $options );
		
		//Filter the 'sidebars_widgets' response
		add_filter( 'sidebars_widgets', array( &$this, 'fake_wp_get_sidebars_widgets' ), 10, 0 );
		
		//Filter the 'is_active_sidebar' response so that it returns true
		add_filter( 'is_active_sidebar', array(  &$this, 'fake_is_active_sidebar' ), 10, 0 );
		
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
		
		//call the method
		/* @var $ad_tags \AdPlugg_Ad_Tag_Collection */
		$ad_tags = $collector->get_ad_tags( 'amp_ads' );
		
		//Assert that an AdPlugg_Ad_Tag_Collection was returned as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag_Collection', get_class( $ad_tags ) );
		
		//Assert that an AdPlugg_Ad_Tag was set as expected
		$this->assertEquals( 'AdPlugg_Ad_Tag', get_class( $ad_tags->get( 0 ) ) );
	}
	
}

