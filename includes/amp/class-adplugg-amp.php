<?php

/**
 * AdPlugg_AMP class.
 * The AdPlugg_AMP class controls AdPlugg's AMP integration. This class is used
 * by both the frontend and the admin.
 *
 * @package AdPlugg
 * @since 1.7.0
 */
class AdPlugg_AMP {
	
	/**
	 * Singleton instance.
	 * @var AdPlugg_AMP
	 */
	private static $instance;
	
	/** @var \AdPlugg_Ad_Tag_Collection */
	private $ad_tags;
	
	/**
	 * Constructor. Constructs the class and registers filters and actions.
	 * @param AdPlugg_Ad_Tag_Collection $ad_tags (optional) Optionally pass an
	 * ad tag collection to use on the AMP pages. This is mostly done for unit
	 * testing.
	 */
	public function __construct( AdPlugg_Ad_Tag_Collection $ad_tags = null ) {
		add_action( 'widgets_init', array( &$this, 'amp_ads_widget_area_init' ), 10, 0 );
		add_action( 'amp_post_template_css', array( &$this, 'add_additional_css_styles' ), 10, 1 );
		add_filter( 'amp_content_sanitizers', array( &$this, 'add_ad_sanitizer' ), 10, 2 );
		
		$this->ad_tags = $ad_tags;
	}
	
	/**
	 * Add the AMP Ads Widget Area.
	 */
	public function amp_ads_widget_area_init() {
		if ( self::is_amp_automatic_placement_enabled() ) {
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
		if ( self::is_amp_automatic_placement_enabled() ) {
			// Note: we require this here because it extends a class from the AMP plugin
			require_once( ADPLUGG_INCLUDES . 'amp/class-adplugg-amp-ad-injection-sanitizer.php' );
			
			//if the ad_tags haven't been set, call the collector and get them
			//from the widget area
			if ( $this->ad_tags == null ) {
				$this->ad_tags = AdPlugg_Ad_Tag_Collector::get_instance()
									->get_ad_tags( 'amp_ads' );
			}
			
			// Note: the array can be used to pass args to your sanitizer and accessed within the class via `$this->args`
			$sanitizer_classes[ 'AdPlugg_AMP_Ad_Injection_Sanitizer' ] = array('ad_tags' => $this->ad_tags); 
		}
		
		return $sanitizer_classes;
	}
	
	/**
	 * Add our additional css styles.
	 * @param AMP_Post_Template $amp_template
	 */
	public function add_additional_css_styles( $amp_template ) {
		if ( self::is_amp_automatic_placement_enabled() ) {
			
			if ( self::is_centering_enabled() ) {
			?>
amp-ad[type="adplugg"] {
	display:block;
	margin: 0 auto 1em auto;
}
			<?php
			} else { //centering not enabled
			?>
amp-ad[type="adplugg"] {
	margin-bottom: 0.5em;
}			
			<?php
			}
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
		if ( ! empty( $options['amp_enable_automatic_placement'] ) ) {
			$enabled = ($options['amp_enable_automatic_placement'] == 1) ? true : false;
		}

		return $enabled;
	}
	
	/**
	 * Function that gets the ad density setting value.
	 * @return integer Returns the ad density setting value.
	 */
	public static function get_ad_density() {
		$options = get_option( ADPLUGG_AMP_OPTIONS_NAME, array() );
		$ad_density = 250;
		if ( ! empty( $options['amp_ad_density'] ) ) {
			$ad_density = $options['amp_ad_density'];
		}

		return $ad_density;
	}
	
	/**
	 * Function that looks to see if AMP centering option is enabled.
	 * @return boolean Returns true if the centering option is enabled,
	 * otherwise returns false.
	 */
	public static function is_centering_enabled() {
		$options = get_option( ADPLUGG_AMP_OPTIONS_NAME, array() );
		$enabled = false;
		if ( ! empty( $options['amp_enable_centering'] ) ) {
			$enabled = ($options['amp_enable_centering'] == 1) ? true : false;
		}

		return $enabled;
	}
	
	/**
	 * Gets the singleton instance.
	 * @return \AdPlugg_AMP Returns the singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

