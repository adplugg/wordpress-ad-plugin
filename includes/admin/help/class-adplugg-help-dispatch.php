<?php
/**
 * AdPlugg Help Dispatch.
 *
 * This class contains functions for rendering the AdPlugg contextual help
 * within the WordPress Administrator.
 *
 * @package AdPlugg
 * @since 1.1.29
 */

/**
 * AdPlugg_Help_Dispatch class.
 */
class AdPlugg_Help_Dispatch {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Help_Dispatch
	 */
	private static $instance;

	/**
	 * Constructor, constructs the AdPlugg_Notice_Controller and registers
	 * actions.
	 */
	public function __construct() {
		add_filter( 'contextual_help', array( &$this, 'dispatch' ), 10, 3 );
	}

	/**
	 * Add help for the AdPlugg plugin to the WordPress admin help system.
	 *
	 * @global type $adplugg_hook
	 * @param string $contextual_help The default contextual help that our
	 * function is going to replace.
	 * @param string $screen_id Used to identify the page that we are on.
	 * @param string $screen Used to access the elements of the current page.
	 * @return string The new contextual help.
	 */
	public function dispatch(
						$contextual_help,
						$screen_id,
						$screen
					) {
		global $adplugg_hook;

		switch ( $screen_id ) {
			case 'toplevel_page_' . $adplugg_hook:
				$contextual_help = adplugg_options_page_help( $contextual_help, $screen_id, $screen );
				break;
			case $adplugg_hook . '_page_adplugg_facebook_settings':
				$contextual_help = adplugg_facebook_options_page_help( $contextual_help, $screen_id, $screen );
				break;
			case 'widgets':
				$contextual_help = adplugg_widgets_page_help( $contextual_help, $screen_id, $screen );
				break;
		}

		return $contextual_help;
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return AdPlugg_Help_Dispatch Returns the singleton instance of this
	 * class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
