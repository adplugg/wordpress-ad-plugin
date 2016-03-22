<?php

/**
 * AdPlugg Feed class.
 * The AdPlugg Feed class has functions for working with WordPress feeds.
 *
 * @package AdPlugg
 * @since 1.2.48
 */
class AdPlugg_Feed {
    
    // singleton instance
    static $instance;
    
    /**
     * Constructor, constructs the class and registers filters and actions.
     * 
     * This is private, call get_instance instead to get the singleton instnace.
     */
    private function __construct() {
        add_filter( 'the_content_feed', array( $this, 'filter_feed' ), 1 );
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
    
    /**
     * Filter out AdPlugg in content ad tags from the feed (feed ads aren't
     * currently supported and the AdPlugg ad tag's use of HTML5 data attributes
     * breaks some feed validators).
     * 
     * Ref: https://codex.wordpress.org/Plugin_API/Filter_Reference/the_content_feed
     * 
     * @param  $content Content of feed (post)
     * @return string The feed with any AdPlugg Ad Tags removed.
     */
    public function filter_feed( $content ) {

        //ex: "<div class="adplugg-tag" data-adplugg-zone="incontent"></div>"
        $adtag_regex = '/[\s]*<div[^>]*?class\=["\']adplugg-tag["\'][^>]*?><\/div>[\s]*/i';
        
        $filtered_content = preg_replace( $adtag_regex, '', $content );
        
        return $filtered_content;
    }

}

