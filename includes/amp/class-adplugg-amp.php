<?php

/**
 * AdPlugg_Amp class.
 * The AdPlugg_Amp class controls AdPlugg's AMP integration. This class is used
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
	
	/** @var \AdPlugg_Ad_Collection */
	private $ads;
	
	/**
	 * Constructor. Constructs the class and registers filters and actions.
	 * @param \AdPlugg_Ad_Collection $ads (optional) Optionally pass an ad
	 * collection to use on the AMP pages. If none is passed the collector will
	 * try to collect some.
	 */
	public function __construct( \AdPlugg_Ad_Collection $ads = null ) {
		add_action( 'widgets_init', array( &$this, 'amp_ads_widget_area_init' ), 10, 0 );
		add_filter( 'amp_content_sanitizers', array( &$this, 'add_ad_sanitizer' ), 10, 2 );
		
		if( $ads !== null ) {
			$this->ads = $ads;
		} else {
			$this->ads = AdPlugg_Ad_Collector::get_instance()->get_ads( 'amp_ads', 'AdPlugg_Amp_Ad' );
		}
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
	 * Register the AdPlugg AMP Ad Injector Sanitizer Ads Widget Area.
	 * 
	 * Docs: https://github.com/Automattic/amp-wp/wiki/Handling-Media#step-2-load-the-sanitizer
	 * @param array $sanitizer_classes An array of sanitizers as 
	 * CLASS_NAME => ARGUMENTS
	 * @param type $post
	 * @returns array Returns an array of sanitizers  as 
	 * CLASS_NAME => ARGUMENTS
	 */
	public function add_ad_sanitizer( $sanitizer_classes, $post ) {
		if(self::is_amp_automatic_placement_enabled()) {
			// Note: we require this here because it extends a class from the AMP plugin
			require_once( ADPLUGG_INCLUDES . 'amp/class-adplugg-amp-ad-injection-sanitizer.php' );
			// Note: the array can be used to pass args to your sanitizer and accessed within the class via `$this->args`
			$sanitizer_classes[ 'AdPlugg_Amp_Ad_Injection_Sanitizer' ] = array('ads' => $this->ads); 
		}
		
		return $sanitizer_classes;
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

