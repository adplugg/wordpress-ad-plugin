<?php

/**
 * AdPlugg Facebook Instant Articles class.
 * The AdPlugg Facebook Instant Articles class has functions for working with
 * a site's Facebook Instant Articles feed.
 *
 * @package AdPlugg
 * @since 1.3.0
 */

use Facebook\InstantArticles\Elements\Ad;

class AdPlugg_Facebook_Instant_Articles {
    
    // singleton instance
    static $instance;
    
    private $instant_article;
    
    /**
     * Constructor, constructs the class and registers filters and actions.
     * 
     * This is private, call get_instance instead to get the singleton instnace.
     */
    private function __construct() { 
        //fb-instant-articles <0.3
        add_action( 'instant_articles_article_head', array( $this, 'head_injector' ), 10, 1 );
        add_action( 'instant_articles_article_header', array( $this, 'header_injector' ), 10, 1 );
        
        //fb-instant-articles >0.3
        add_filter( 'instant_articles_transformed_element', array( $this, 'set_instant_article' ), 10, 1 );
        add_action( 'instant_articles_after_transform_post', array( $this, 'insert_ads' ), 10, 1 );
    }
    
    /**
     * Inject additional elements into the Instant Article feed's <head></head> 
     * section.
     * 
     * (fb-instant-articles <0.3)
     * 
     * @param Instant_Articles_Post  $ia_post  The current article object.
     */
    public function head_injector( $ia_post ) {
        if(AdPlugg_Facebook::is_ia_automatic_placement_enabled()) {
            //enable automatic placement
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
     * @param Instant_Articles_Post  $ia_post  The current article object.
     */
    public function header_injector( $ia_post ) {
        $GLOBALS['adplugg_fbia_canonical_url'] = $ia_post->get_canonical_url();
        
        if ( 
             ( AdPlugg_Facebook::is_ia_automatic_placement_enabled() ) && 
             ( is_active_sidebar( 'facebook_ia_header_ads' ) )
           ) 
        {
            echo "<section class=\"op-ad-template\">\n";
            dynamic_sidebar( 'facebook_ia_header_ads' );
            echo "</section>\n";
        }
    }
    
    /**
     * Store the instant article so that we can access it in the insert_ads
     * function below.
     * @param Facebook\InstantArticles\Elements\InstantArticle  $instant_article  
     *  The current Instant Article.
     * @return Facebook\InstantArticles\Elements\InstantArticle Returns the 
     * Instant Article.
     */
    public function set_instant_article( $instant_article ) {
        $this->instant_article = $instant_article;
        
        return $instant_article;
    }
    
    /**
     * Inserts ads to the Instant Article header.
     */
    public function insert_ads( $post ) {
        global $wp_registered_widgets;
        
        $header = $this->instant_article->getHeader();
        
        $settings_ads = Instant_Articles_Option_Ads::get_option_decoded();
        $source_of_ad = isset( $settings_ads['ad_source'] ) ? $settings_ads['ad_source'] : 'none';
        
        if ( 
             ( AdPlugg_Facebook::is_ia_automatic_placement_enabled() ) && 
             ( is_active_sidebar( 'facebook_ia_header_ads' ) ) &&
             ( $source_of_ad == 'adplugg' )
           ) 
        {
            
            $sidebars_widgets = wp_get_sidebars_widgets();
            foreach ( (array) $sidebars_widgets['facebook_ia_header_ads'] as $id ) {
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
                    
                    $post_url = $post->get_canonical_url();
                    $host = urlencode( parse_url( $post_url, PHP_URL_HOST ) );
                    $path = urlencode( parse_url( $post_url, PHP_URL_PATH ) );
                    $zone_param = ( isset( $zone ) ) ? '&zn=' . urlencode( $zone ) : '';
                    $iframe_src = 'https://' . ADPLUGG_ADHTMLSERVER . '/serve/' . adplugg_get_active_access_code() . '/html/1.1/index.html?hn=' . $host . '&bu=' . $path . $zone_param;
                    $ad = Ad::create()
                            ->enableDefaultForReuse()
                            ->withWidth( $width )
                            ->withHeight( $height )
                            ->withSource( $iframe_src );
                    
                    if( $default ) {
                        $ad->enableDefaultForReuse();
                    }
                    
                    $header->addAd( $ad );
                } //end if AdPlugg_Widget
                
            } //end foreach widget
            
        } //end if enabled
        
    }
    
    /*
     * Get the singleton instance 
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}

