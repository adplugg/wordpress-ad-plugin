<?php

/**
 * AdPlugg Facebook class.
 * The AdPlugg Facebook class controls AdPlugg's Facebook intragration. This
 * class is used by both the frontend and the admin.
 *
 * @package AdPlugg
 * @since 1.3.0
 */
class AdPlugg_Facebook {
	
	/**
	 * Singleton instance.
	 * @var AdPlugg_Facebook 
	 */
	static $instance;
	
	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	function __construct() {
		add_action( 'widgets_init', array( &$this, 'facebook_instant_articles_header_widget_area_init' ) );
		add_action( 'instant_articles_compat_registry_ads', array( $this, 'add_to_registry' ), 10, 1 );
	}
	
	/**
	 * Add the Facebook Instant Articles Header widget area.
	 */
	function facebook_instant_articles_header_widget_area_init() {
		if(self::is_ia_automatic_placement_enabled()) {
			register_sidebar( array(
					'name'			=> 'Facebook Instant Articles Ads',
					'id'			=> 'facebook_ia_header_ads',
					'description'	=> 'Drag the AdPlugg Widget here to have AdPlugg Ads automatically included in your Facebook Instant Articles.',
			) );
		}
	}
	
	/**
	 * Function that looks to see if Facebook Instant Articles automatic ad
	 * placement is enabled.
	 * @return boolean Returns true if an Facebook Instant Articles automatic ad
	 * placement is enabled, otherwise returns false.
	 */
	static function is_ia_automatic_placement_enabled() {
		$options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
		$enabled = false;
		if( ! empty( $options['ia_enable_automatic_placement'] ) ) {
			$enabled = ($options['ia_enable_automatic_placement'] == 1) ? true : false;
		}

		return $enabled;
	}
	
	/**
	 * Function that looks to see if the temporary Use Legacy adplugg.com 
	 * Endpoint setting is turned on.
	 * @return boolean Returns true if the temporary Use Legacy adplugg.com 
	 * Endpoint setting is turned on, otherwise returns false.
	 */
	static function temp_use_legacy_adplugg_com_endpoint() {
		$options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
		$enabled = false;
		if( ! empty( $options['temp_use_legacy_adplugg_com_endpoint'] ) ) {
			$enabled = ($options['temp_use_legacy_adplugg_com_endpoint'] == 1) ? true : false;
		}

		return $enabled;
	}
	
	/**
	 * Function that looks to see if the temporary Allow Legacy adplugg.com 
	 * Endpoint setting is turned on.
	 * @return boolean Returns true if the temporary Allow Legacy adplugg.com 
	 * Endpoint setting is turned on, otherwise returns false.
	 */
	static function temp_allow_legacy_adplugg_com_endpoint() {
		$options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
		$enabled = false;
		if( ! empty( $options['temp_allow_legacy_adplugg_com_endpoint'] ) ) {
			$enabled = ($options['temp_allow_legacy_adplugg_com_endpoint'] == 1) ? true : false;
		}

		return $enabled;
	}
	
	/**
	 * Add AdPlugg to the Facebook Instant Articles plugin ad registry.
	 * (fb-instant-articles 0.3+)
	 *
	 * @param array $registry Reference param. The registry where it will be stored.
	 */
	function add_to_registry( &$registry ) {

		$display_name = 'AdPlugg';
		$identifier = 'adplugg';

		$registry[ $identifier ] = array(
				'name' => $display_name,
		);
	}
	
	/**
	 * Singleton instance 
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

