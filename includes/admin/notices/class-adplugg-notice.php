<?php
/**
 * The AdPlugg Notice class represents an AdPlugg notice.
 *
 * @package AdPlugg
 * @since 1.2
 */

/**
 * AdPlugg Notice class.
 */
class AdPlugg_Notice {

	/**
	 * The notice_key is a key such as "nag_widget".
	 *
	 * @var string
	 */
	private $notice_key;

	/**
	 * A nonce for the notice.
	 *
	 * @var string
	 */
	private $nonce;

	/**
	 * The message that you want to display to the user.
	 *
	 * @var string
	 */
	private $message;

	/**
	 * The notice type ('error', 'updated', or 'update-nag') See:
	 * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
	 *
	 * @var string The type of notice this is.
	 */
	private $type;

	/**
	 * Whether or not the message is dismissible.
	 *
	 * @var boolean
	 */
	private $dismissible;

	/**
	 * A string (such as '+30 days') for use in php's strtotime function.
	 *
	 * @var string
	 */
	private $remind_when;

	/**
	 * A string (such as 'Configure Now') for use in a CTA button to be included
	 * in the Notice.
	 *
	 * @var string
	 */
	private $cta_text;

	/**
	 * The url for the CTA button.
	 *
	 * @var string
	 */
	private $cta_url;

	/**
	 * Constructor.
	 */
	public function __construct() {
	}

	/**
	 * Static function to create a new Notice. Call using
	 * AdPlugg_Notice::create('nag_widget', 'some message', true/false );
	 *
	 * @param string      $notice_key The notice_key is a key such as
	 * "nag_widget".
	 * @param string      $message The message that you want to display to the
	 * user.
	 * @param string      $type (optional) The notice type ('error', 'updated',
	 * or 'update-nag').
	 * @param boolean     $dismissible (optional) Whether or not the message is
	 * dismissible.
	 * @param string      $remind_when A string (such as '+30 days') for use in
	 * PHP's strtotime function.
	 * @param string|null $cta_text (optional) A string (such as 'Configure
	 * Now') for use in a CTA button to be included in the Notice. Leave off or
	 * null for no CTA button.
	 * @param string|null $cta_url (optional) The url for the CTA button.
	 * @return \self Works like a constructor.
	 */
	public static function create(
								$notice_key,
								$message,
								$type = 'updated',
								$dismissible = false,
								$remind_when = null,
								$cta_text = null,
								$cta_url = null
							) {
		$instance = new self();

		$instance->notice_key  = $notice_key;
		$instance->message     = $message;
		$instance->type        = $type;
		$instance->dismissible = $dismissible;
		$instance->remind_when = $remind_when;
		$instance->cta_text    = $cta_text;
		$instance->cta_url     = $cta_url;

		$instance->nonce = wp_create_nonce( 'adplugg_set_notice_pref' );

		return $instance;
	}

	/**
	 * Static function to recreate a Notice. Call using
	 * AdPlugg_Notice::recreate( $data_array );
	 *
	 * See the to_array function below for the expected array structure.
	 *
	 * @param array $array An array containing the Notice data.
	 * @return \self Works like a constructor.
	 */
	public static function recreate( $array ) {
		$instance = new self();

		$instance->notice_key  = $array['notice_key'];
		$instance->message     = $array['message'];
		$instance->type        = $array['type'];
		$instance->dismissible = $array['dismissible'];
		if ( isset( $array['remind_when'] ) ) {
			$instance->remind_when = $array['remind_when'];
		}
		if ( isset( $array['cta_text'] ) ) {
			$instance->cta_text = $array['cta_text'];
		}
		if ( isset( $array['cta_url'] ) ) {
			$instance->cta_url = $array['cta_url'];
		}

		$instance->nonce = wp_create_nonce( 'adplugg_set_notice_pref' );

		return $instance;
	}

	/**
	 * Gets the html for the notice.
	 *
	 * @return string Returns a string of html for rendering the notice.
	 */
	public function get_rendered() {
		$html = '';

		if ( ! $this->is_dismissed() ) {
			$buttons = '';
			$html   .= '<div id="' . $this->notice_key . '" class="' . $this->type . ' notice notice-' . $this->type . ' is-dismissible adplugg-notice">';
			$html   .= '<p>' .
							'<strong>AdPlugg:</strong> ' .
							$this->message .
					'</p>';
			if ( $this->dismissible ) {
				$buttons =
							'<button type="button" class="button button-small adplugg-subtle-button" onclick="adpluggPostNoticePref(this, \'' . $this->nonce . '\', \'' . $this->notice_key . '\', \'+30 days\');">Remind Me Later</button>' .
							'<button type="button" class="button button-small adplugg-subtle-button" onclick="adpluggPostNoticePref(this, \'' . $this->nonce . '\', \'' . $this->notice_key . '\', null);">Don\'t Remind Me Again</button>';
			}
			if ( null !== $this->cta_text ) {
				$buttons .= '<button type="button" class="button button-primary button-small" onclick="window.location.href=\'' . $this->cta_url . '\'; return true;">' . $this->cta_text . '</button>';
			}

			if ( ! empty( $buttons ) ) {
				$html .= '<p class="adplugg-notice-buttons">' . $buttons . '</p>';
			}

			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Renders the html for the notice.
	 */
	public function render() {
		echo $this->get_rendered(); // phpcs:ignore
	}

	/**
	 * Gets the value of notice_key.
	 *
	 * @return string Returns the notice_key.
	 */
	public function get_notice_key() {
		return $this->notice_key;
	}

	/**
	 * Gets the nonce for the Notice. This is used for testing.
	 *
	 * @return string Returns the nonce.
	 */
	public function get_nonce() {
		return $this->nonce;
	}

	/**
	 * Gets the value of message.
	 *
	 * @return string Returns the Notice message.
	 */
	public function get_message() {
		return $this->message;
	}

	/**
	 * Gets the value of type.
	 *
	 * @return string Returns the Notice type.
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Gets the value of dismissible.
	 *
	 * @return string Returns whether or not the Notice is dismissible.
	 */
	public function is_dismissible() {
		return $this->dismissible;
	}

	/**
	 * Converts the class into an array for inserting into a WordPress option.
	 *
	 * @returns array Returns an array representation of the object.
	 */
	public function to_array() {
		$data_array = array(
			'notice_key'  => $this->notice_key,
			'message'     => $this->message,
			'type'        => $this->type,
			'dismissible' => $this->dismissible,
			'remind_when' => $this->remind_when,
			'cta_text'    => $this->cta_text,
			'cta_url'     => $this->cta_url,
		);

		return $data_array;
	}

	/**
	 * Returns whether or not the notice is dismissed.
	 *
	 * @return boolean Whether or not the notice is dismissed.
	 */
	public function is_dismissed() {
		$ret        = false;
		$dismissals = get_option( ADPLUGG_NOTICES_DISMISSED_NAME, array() );
		if ( array_key_exists( $this->notice_key, $dismissals ) ) {
			$remind_on = $dismissals[ $this->notice_key ];
			if ( null !== $remind_on ) {
				if ( $remind_on > time() ) {
					$ret = true;
				}
			} else {
				$ret = true;
			}
		}

		return $ret;
	}

}
