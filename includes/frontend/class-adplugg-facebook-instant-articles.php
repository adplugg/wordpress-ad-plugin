<?php

use Facebook\InstantArticles\Elements\Ad;

/**
 * AdPlugg Facebook Instant Articles class.
 * The AdPlugg Facebook Instant Articles class has functions for working with
 * a site's Facebook Instant Articles feed.
 *
 * @package AdPlugg
 * @since 1.3.0
 */
class AdPlugg_Facebook_Instant_Articles {

	/**
	 * Singleton instance.
	 *
	 * @var AdPlugg_Facebook_Instant_Articles
	 */
	private static $instance;

	/** @var Facebook\InstantArticles\Elements\InstantArticle */
	private $instant_article;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 *
	 * This is private, call get_instance instead to get the singleton instance.
	 */
	private function __construct() {
		// fb-instant-articles <0.3
		add_action( 'instant_articles_article_head', array( $this, 'head_injector' ), 10, 1 );
		add_action( 'instant_articles_article_header', array( $this, 'header_injector' ), 10, 1 );

		// fb-instant-articles >0.3
		add_filter( 'instant_articles_transformed_element', array( $this, 'set_instant_article' ), 10, 1 );
		add_action( 'instant_articles_after_transform_post', array( $this, 'insert_ads' ), 10, 1 );
	}

	/**
	 * Inject additional elements into the Instant Article feed's <head></head>
	 * section.
	 *
	 * (fb-instant-articles <0.3)
	 *
	 * @param Instant_Articles_Post $ia_post The current article object.
	 */
	public function head_injector( $ia_post ) {
		if ( AdPlugg_Facebook::is_ia_automatic_placement_enabled() ) {
			// enable automatic placement
			?>

				<!-- enable automatic ad placement -->
				<meta property="fb:use_automatic_ad_placement" content="true">

			<?php
		}
	}

	/**
	 * Inject additional elements into the <header></header> section of each
	 * post in the Instant Articles feed.
	 *
	 * (fb-instant-articles <0.3)
	 *
	 * @param Instant_Articles_Post $ia_post The current article object.
	 * @todo Add unit tests
	 */
	public function header_injector( $ia_post ) {
		$GLOBALS['adplugg_fbia_canonical_url'] = $ia_post->get_canonical_url();

		if (
			 ( AdPlugg_Facebook::is_ia_automatic_placement_enabled() ) &&
			 ( is_active_sidebar( 'facebook_ia_header_ads' ) )
			) {
			echo "<section class=\"op-ad-template\">\n";
			dynamic_sidebar( 'facebook_ia_header_ads' );
			echo "</section>\n";
		}
	}

	/**
	 * Store the instant article so that we can access it in the insert_ads
	 * function below.
	 *
	 * @param Facebook\InstantArticles\Elements\InstantArticle $instant_article
	 * The current Instant Article.
	 * @return Facebook\InstantArticles\Elements\InstantArticle Returns the
	 * Instant Article.
	 * @todo Add unit tests
	 */
	public function set_instant_article( $instant_article ) {
		$this->instant_article = $instant_article;

		return $instant_article;
	}

	/**
	 * Inserts ads into the Instant Article header.
	 *
	 * @todo Add unit tests
	 */
	public function insert_ads( $post ) {
		/** @var $header Facebook\InstantArticles\Elements\Header */
		$header = $this->instant_article->getHeader();

		$settings_ads = Instant_Articles_Option_Ads::get_option_decoded();
		$source_of_ad = isset( $settings_ads['ad_source'] ) ? $settings_ads['ad_source'] : 'none';

		if (
			 ( AdPlugg_Options::is_access_code_installed() ) &&
			 ( AdPlugg_Facebook::is_ia_automatic_placement_enabled() ) &&
			 ( is_active_sidebar( 'facebook_ia_header_ads' ) ) &&
			 ( $source_of_ad == 'adplugg' )
			) {
			$ad_tags = AdPlugg_Ad_Tag_Collector::get_instance()
								->get_ad_tags( 'facebook_ia_header_ads' );

			/* @var $ad_tag \AdPlugg_Ad_Tag */
			foreach ( $ad_tags->to_array() as $ad_tag ) {

				// ------ Compute iframe src ------ //
				$post_url   = $post->get_canonical_url();
				$host       = urlencode( parse_url( $post_url, PHP_URL_HOST ) );
				$path       = urlencode( parse_url( $post_url, PHP_URL_PATH ) );
				$zone_param = ( $ad_tag->get_zone() != null ) ? '&zn=' . urlencode( $ad_tag->get_zone() ) : '';

				$adplugg_adhtmlserver = ADPLUGG_ADHTMLSERVER;
				// Temporarily allow serving from www.adplugg.com. Here to
				// facilitate a judicious rollout of the new adplugg.io endpoint.
				if ( AdPlugg_Facebook::temp_use_legacy_adplugg_com_endpoint() ) {
					$adplugg_adhtmlserver = 'www.adplugg.com';
				}
				$iframe_src = 'https://' . $adplugg_adhtmlserver . '/serve/' . AdPlugg_Options::get_active_access_code() . '/html/1.1/index.html?hn=' . $host . '&bu=' . $path . $zone_param;
				// ------------------------------- //
				$ad = Ad::create()
						->enableDefaultForReuse()
						->withWidth( $ad_tag->get_width() )
						->withHeight( $ad_tag->get_height() )
						->withSource( $iframe_src );

				$header->addAd( $ad );
			} //end foreach ad_tag
		} //end if enabled

	}

	/**
	 * Get the singleton instance.
	 *
	 * @return \AdPlugg_Facebook_Instant_Articles Returns the singleton instance
	 * of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

