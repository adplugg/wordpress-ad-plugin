<?php

/**
 * AdPlugg_Block class.
 *
 * The AdPlugg_Block class has functions for registering the AdPlugg Gutenberg
 * block.
 *
 * @package AdPlugg
 * @since 1.11.0
 */
class AdPlugg_Block {

	/**
	 * Singleton instance of the class.
	 *
	 * @var AdPlugg_Block
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Registers all block assets so that they can be enqueued through Gutenberg
	 * in the corresponding context.
	 */
	function register_block() {

		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}

		// __DIR__ is the current directory where block.json file is stored.
		register_block_type( __DIR__ );
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return \AdPlugg_Block Returns the singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
