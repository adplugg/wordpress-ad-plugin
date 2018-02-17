<?php

/**
 * AdPlugg_Amp_Ad_Collector class. The AdPlugg_Amp_Ad_Collector class includes
 * methods that can build a AdPlugg_Amp_Ad_Collection by searching through
 * the enabled widgets.
 *
 * @package AdPlugg
 * @since 1.7.0
 * @todo Add unit testing
 */
class AdPlugg_Amp_Ad_Collector {
	
	/**
	 * Singleton instance.
	 * @var AdPlugg_Amp_Ad_Collector
	 */
	private static $instance;
	
	/**
	 * Looks in the Amp Widget Area and gets all ads. Returns the ads as an
	 * array of AdPlugg_Amp_Ad
	 * @global $wp_registered_widgets
	 * @return AdPlugg_Amp_Ad_Collection Returns a collection of the Ads that
	 * were found.
	 * @todo Add unit tests
	 */
	public function get_ads() {
		global $wp_registered_widgets;
		
		$ads = new \AdPlugg_Amp_Ad_Collection();
			
		$sidebars_widgets = wp_get_sidebars_widgets();
		
		if( array_key_exists( 'amp_ads', $sidebars_widgets ) ) {
			foreach ( (array) $sidebars_widgets['amp_ads'] as $id ) {
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

					$ad = AdPlugg_Amp_Ad::create()
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

			} //end foreach widget in amp_ads widget area
			
		} //end if amp_ads widget area exists
			
		return $ads;
	} //end get ads
	
	/**
	 * Singleton instance.
	 * @return \AdPlugg_Amp_Ad_Collector Returns the AdPlugg_Amp_Ad_Collector
	 * singleton.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

