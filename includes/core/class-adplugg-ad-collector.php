<?php

/**
 * AdPlugg_Ad_Collector class. The AdPlugg_Ad_Collector class includes methods
 * that can build a AdPlugg_Ad_Collection by searching through the enabled
 * widgets.
 *
 * @package AdPlugg
 * @since 1.7.0
 * @todo Add unit testing
 */
class AdPlugg_Ad_Collector {
	
	/**
	 * Singleton instance.
	 * @var AdPlugg_Ad_Collector
	 */
	private static $instance;
	
	/**
	 * Looks in the passed Widget Area and gets all ads. Returns the ads as an
	 * AdPlugg_Ad_Collection.
	 * @param string $widget_area_id The id of the widget area (ex: "amp_ads") 
	 * @return AdPlugg_Ad_Collection Returns a collection of the Ads that
	 * were found.
	 * @global $wp_registered_widgets
	 * @todo Add unit tests
	 */
	public function get_ads( $widget_area_id ) {
		global $wp_registered_widgets;
		
		$ads = new \AdPlugg_Ad_Collection();
			
		$sidebars_widgets = wp_get_sidebars_widgets();
		
		if( array_key_exists( $widget_area_id, $sidebars_widgets ) ) {
			foreach ( (array) $sidebars_widgets[$widget_area_id] as $id ) {
				$widget = $wp_registered_widgets[$id]['callback']['0'];
				$params = $wp_registered_widgets[$id]['params']['0'];
				if( get_class( $widget) == 'AdPlugg_Widget' ) {
					$option_name = $widget->option_name;
					$number = $params['number'];
					$all_options = get_option( $option_name, array() );
					$instance = $all_options[$number];

					$width = ( isset($instance['width']) ) ? intval( $instance['width'] ) : 300;
					$height = ( isset($instance['height']) ) ? intval( $instance['height'] ) : 250;
					$default = ( isset( $instance['default'] ) && $instance['default'] == 1 ) ? 1 : 0;
					$zone = ( isset( $instance['zone'] ) ) ? $instance['zone'] : null;

					$ad = AdPlugg_Ad::create()
								->withWidth( $width )
								->withHeight( $height );

					if( $default ) {
						$ad->enableDefaultForReuse();
					}

					if( $zone != null ) {
						$ad->withZone( $zone );
					}

					$ads->add($ad);
				} //end if AdPlugg_Widget

			} //end foreach widget in the widget area
			
		} //end if widget area exists
			
		return $ads;
	} //end get ads
	
	/**
	 * Singleton instance.
	 * @return \AdPlugg_Ad_Collector Returns the AdPlugg_Ad_Collector
	 * singleton.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

