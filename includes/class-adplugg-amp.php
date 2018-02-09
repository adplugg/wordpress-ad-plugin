<?php

/**
 * AdPlugg_Amp class.
 * The AdPlugg_Amp class controls AdPlugg's AMP intragration. This class is used
 * by both the frontend and the admin.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class AdPlugg_Amp {
	
	/**
	 * Singleton instance.
	 * @var AdPlugg_Amp 
	 */
	private static $instance;
	
	/**
	 * Constructor. Constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_action( 'widgets_init', array( &$this, 'amp_ads_widget_area_init' ) );
	}
	
	/**
	 * Add the AMP Ads Widget Area.
	 */
	public function amp_ads_widget_area_init() {
		if(self::is_amp_automatic_placement_enabled()) {
			register_sidebar( array(
					'name'			=> 'AMP Ads',
					'id'			=> 'amp_ads',
					'description'	=> 'Drag the AdPlugg Widget here to have AdPlugg Ads automatically included in your AMP pages.',
			) );
		}
	}
	
	/**
	 * Function that looks to see if AMP automatic ad placement is enabled.
	 * @return boolean Returns true if an AMP automatic ad placement is enabled,
	 * otherwise returns false.
	 */
	public static function is_amp_automatic_placement_enabled() {
		$options = get_option( ADPLUGG_AMP_OPTIONS_NAME, array() );
		$enabled = false;
		if( ! empty( $options['amp_enable_automatic_placement'] ) ) {
			$enabled = ($options['amp_enable_automatic_placement'] == 1) ? true : false;
		}

		return $enabled;
	}
	
	/**
	 * Gets the singleton instance.
	 * @return \AdPlugg_Amp Returns the singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

