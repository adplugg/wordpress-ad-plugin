<?php

namespace Facebook\InstantArticles\Elements;

/**
 * Mocks the Instant Articles Ad class
 *
 * @package AdPlugg
 * @since 1.6.18
 */
class Ad {

	/**
	 * Constructor.
	 */
	public function __construct() {
		//
	}
	
	/**
	 * Fake create function.
	 */
	public static function create() {
		$instance = new self();
		
		return $instance;
	}
	
	/**
	 * Fake enableDefaultForReuse method.
	 */
	public function enableDefaultForReuse() {
		return $this;
	}
	
	/**
	 * Fake withWidth method.
	 */
	public function withWidth() {
		return $this;
	}
	
	/**
	 * Fake withHeight method.
	 */
	public function withHeight() {
		return $this;
	}
	
	/**
	 * Fake withSource method.
	 */
	public function withSource() {
		//
	}
	
}
