<?php
/**
 * The AdPlugg Notices Controller class sets up and controls the AdPlugg
 * notices.
 *
 * @package AdPlugg
 * @since 1.2
 */

/**
 * AdPlugg_Notice_Controller class.
 */
class AdPlugg_Notice_Controller {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Notice_Controller
	 */
	private static $instance;

	/**
	 * Constructor, constructs the AdPlugg_Notice_Controller and registers
	 * actions.
	 */
	public function __construct() {
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
		add_action( 'wp_ajax_adplugg_set_notice_pref', array( &$this, 'set_notice_pref_callback' ) );
	}

	/**
	 * Add Notices in the administrator. Adds both notices from the db and
	 * notices based on the current state of the plugin (see code).
	 */
	public function admin_notices() {

		$screen    = get_current_screen();
		$screen_id = ( ! empty( $screen ) ? $screen->id : null );

		// Start the notices array off with any that are queued.
		$notices = $this->pull_all_queued();

		// Add any new notices based on the current state of the plugin, etc.
		if ( ! AdPlugg_Options::is_access_code_installed() ) {
			if ( 'toplevel_page_adplugg' !== $screen_id ) {
				$notices[] = AdPlugg_Notice::create(
					'nag_configure',  // id.
					'You\'ve activated the AdPlugg Plugin, yay! Now let\'s <a title="Configure the AdPlugg Plugin!" href="' . admin_url( 'admin.php?page=adplugg' ) . '">configure</a> it!',
					'updated', // type (for styling).
					true, // dismissible.
					'+30 days', // remind when.
					'Configure AdPlugg!', // CTA text.
					admin_url( 'admin.php?page=adplugg' ) // CTA url.
				);
			}
		} else {
			if ( ! adplugg_is_widget_active() ) {
				if ( 'widgets' === $screen_id ) {
					$notices[] = AdPlugg_Notice::create(
						'nag_widget_1', // id.
						'Drag the AdPlugg Widget into a Widget Area to display ads on your site.',
						'updated', // type (for styling).
						true, // dismissible.
						'+30 days' // remind when.
					);
				} else {
					$notices[] = AdPlugg_Notice::create(
						'nag_widget_2', // id.
						'You\'re configured and ready to go. Now just drag the AdPlugg Widget into a Widget Area.',
						'updated', // type (for styling).
						true, // dismissible.
						'+30 days', // remind when.
						'Go to Widget Configuration', // CTA text.
						admin_url( 'widgets.php' ) // CTA url.
					);
				}
			}
		}

		// Print the notices.
		$out = '';
		foreach ( $notices as $notice ) {
			$out .= $notice->get_rendered();
		}
		echo $out; // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * Called via ajax to dismiss a notice. Registered in the constructor above.
	 *
	 * @throws \InvalidArgumentException Throws an InvalidArgumentException if
	 * the notice_key post variable isn't set.
	 */
	public function set_notice_pref_callback() {
		// Protect against CSRF attacks.
		check_ajax_referer( 'adplugg_set_notice_pref' );

		// Get the variables from the post request.
		$notice_key = ( isset( $_POST['notice_key'] ) ) ? sanitize_key( $_POST['notice_key'] ) : null;
		$remind_on  = ( isset( $_POST['remind_when'] ) ) ? strtotime( sanitize_text_field( wp_unslash( $_POST['remind_when'] ) ) ) : null;

		if ( null === $notice_key ) {
			throw new \InvalidArgumentException( 'Required notice_key not found.' );
		}

		// Add the dismissal to the database.
		$dismissals                = get_option( ADPLUGG_NOTICES_DISMISSED_NAME, array() );
		$dismissals[ $notice_key ] = $remind_on;
		update_option( ADPLUGG_NOTICES_DISMISSED_NAME, $dismissals );

		// Build the return array.
		$ret               = array();
		$ret['notice_key'] = $notice_key;
		$ret['status']     = 'success';

		// Return the json.
		echo wp_json_encode( $ret );
		wp_die(); // Terminate immediately and return a proper response.
	}

	/**
	 * Adds a notice to the database for display on the next refresh.
	 *
	 * @param AdPlugg_Notice $notice The notice that you want to queue.
	 */
	public function add_to_queue( AdPlugg_Notice $notice ) {
		$notices                              = get_option( ADPLUGG_NOTICES_NAME );
		$notices[ $notice->get_notice_key() ] = $notice->to_array();
		update_option( ADPLUGG_NOTICES_NAME, $notices );
	}

	/**
	 * Returns an array containing any queued notices. If there are no queued notices
	 * the function returns an empty array. After pulling the queued notices, they
	 * are deleted.
	 *
	 * @return array An array of queued AdPlugg_Notices or else an empty array.
	 */
	public function pull_all_queued() {
		$notices        = array();
		$queued_notices = get_option( ADPLUGG_NOTICES_NAME );

		if ( $queued_notices ) {
			foreach ( $queued_notices as $notice ) {
				$notices[] = AdPlugg_Notice::recreate( $notice );
			}
			delete_option( ADPLUGG_NOTICES_NAME );
		}

		return $notices;
	}

	/**
	 * Gets the singleton instance of the class.
	 *
	 * @return AdPlugg_Notice_Controller Returns the singleton instance of the
	 * class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
