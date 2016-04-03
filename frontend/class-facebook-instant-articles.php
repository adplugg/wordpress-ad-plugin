<?php

/**
 * AdPlugg Facebook Instant Articles class.
 * The AdPlugg Facebook Instant Articles class has functions for working with
 * a site's Facebook Instant Articles feed.
 *
 * @package AdPlugg
 * @since 1.3.0
 */
class AdPlugg_Facebook_Instant_Articles {
    
    // singleton instance
    static $instance;
    
    /**
     * Constructor, constructs the class and registers filters and actions.
     * 
     * This is private, call get_instance instead to get the singleton instnace.
     */
    private function __construct() { 
        add_action( 'instant_articles_article_head', array( $this, 'head_injector' ), 10, 1 );
        add_action( 'instant_articles_article_header', array( $this, 'header_injector' ), 10, 1 );
    }
    
    /**
     * Inject additional elements into the Instant Article feed's <head></head> 
     * section.
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
     * @param Instant_Articles_Post  $ia_post  The current article object.
     */
    public function header_injector( $ia_post ) {
        
        if ( 
             ( AdPlugg_Facebook::is_ia_automatic_placement_enabled() ) && 
             ( is_active_sidebar( 'facebook_ia_header' ) )
           ) 
        {
            echo "<section class=\"op-ad-template\">\n";
            dynamic_sidebar( 'facebook_ia_header' );
            echo "</section>\n";
        }
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

