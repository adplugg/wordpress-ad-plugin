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
	protected $_post;
	
	/**
	 * The header
	 * @var Header
	 */
	protected $header;

	/**
	 * Set up data and build the content.
	 *
	 * @param Instant_Article_Post $post ID of the post.
	 */
	public function __construct( $post ) {
		$this->_post = $post;
		$this->header = new Header();
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
	 * Gets the header
	 * @return Header Returns the header.
	 */
	public function getHeader() {
		return $this->header;
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
	
	/**
	 * Hook the sidebars_widgets filter.
	 * 
	 * @wp-hook sidebars_widgets
	 * @return Returns true.
	 */
	static function fake_wp_get_sidebars_widgets() {
		$ret = array(
					'facebook_ia_header_ads' => array(
						'adplugg'
					)
				);
		
		return $ret;
	}
	
}
