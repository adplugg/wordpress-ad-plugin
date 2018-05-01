<?php

/**
 * AdPlugg_Ad_Tag_Collector class. The AdPlugg_Ad_Tag_Collector class includes 
 * methods that can build a AdPlugg_Ad_Tag_Collection by searching through the
 * enabled widgets.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class AdPlugg_Ad_Tag_Collector {
	
	/**
	 * Singleton instance.
	 * @var AdPlugg_Ad_Tag_Collector
	 */
	private static $instance;
	
	/**
	 * Looks in the passed Widget Area and gets all ad tags. Returns the ad tags
	 * as an AdPlugg_Ad_Tag_Collection.
	 * @param string $widget_area_id The id of the widget area (ex: "amp_ads") 
	 * @return AdPlugg_Ad_Tag_Collection Returns a collection of the Ad Tags 
	 * that were found.
	 * @global $wp_registered_widgets
	 */
	public function get_ad_tags( $widget_area_id ) {
		global $wp_registered_widgets;
		
		$ad_tags = new AdPlugg_Ad_Tag_Collection();
			
		$sidebars_widgets = wp_get_sidebars_widgets();
		
		if ( array_key_exists( $widget_area_id, $sidebars_widgets ) ) {
			foreach ( (array) $sidebars_widgets[$widget_area_id] as $id ) {
				$widget = $wp_registered_widgets[$id]['callback']['0'];
				$params = $wp_registered_widgets[$id]['params']['0'];
				if ( get_class( $widget) == 'AdPlugg_Widget' ) {
					$option_name = $widget->option_name;
					$number = $params['number'];
					$all_options = get_option( $option_name, array() );
					$instance = $all_options[$number];

					$width = ( isset($instance['width']) ) ? intval( $instance['width'] ) : 300;
					$height = ( isset($instance['height']) ) ? intval( $instance['height'] ) : 250;
					$default = ( isset( $instance['default'] ) && $instance['default'] == 1 ) ? 1 : 0;
					$zone = ( isset( $instance['zone'] ) ) ? $instance['zone'] : null;

					$ad_tag = AdPlugg_Ad_Tag::create()
								->with_width( $width )
								->with_height( $height );

					if ( $default ) {
						$ad_tag->enable_default_for_reuse();
					}

					if ( $zone != null ) {
						$ad_tag->with_zone( $zone );
					}

					$ad_tags->add( $ad_tag );
				} //end if AdPlugg_Widget

			} //end foreach widget in the widget area
			
		} //end if widget area exists
			
		return $ad_tags;
	} //end get ad_tags
	
	/**
	 * Singleton instance.
	 * @return \AdPlugg_Ad_Tag_Collector Returns the AdPlugg_Ad_Tag_Collector
	 * singleton.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

