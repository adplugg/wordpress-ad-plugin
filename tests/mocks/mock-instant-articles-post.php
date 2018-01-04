<?php

/**
 * Mocks the Instant_Articles_Post class
 *
 * @package AdPlugg
 * @since 1.6.17
 */
class Instant_Articles_Post {
    
    /**
     * The post
     *
     * @var $_post
     */
    protected $_post = null;

    /**
     * Set up data and build the content.
     *
     * @param Instant_Article_Post $post ID of the post.
     */
    public function __construct( $post ) {
        $this->_post = $post;
    }
    
    /**
     * Fake get_canonical_url method.
     * @return string Returns a url for testing.
     */
    public function get_canonical_url() {
        $url = get_permalink( $this->_post );
        
        return $url;
    }
    
    /**
     * Hook the is_active_sidebar filter to always return true.
     * 
     * @wp-hook is_active_sidebar
     * @return Returns true.
     */
   static function fake_is_active_sidebar() {
        return true;
   }
    
}
