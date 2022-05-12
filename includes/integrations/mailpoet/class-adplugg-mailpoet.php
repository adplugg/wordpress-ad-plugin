<?php
/**
 * The AdPlugg MailPoet class controls AdPlugg's MailPoet integration. This
 * class is used by both the frontend and the admin.
 *
 * @package AdPlugg
 * @since 1.10.0
 */

/**
 * AdPlugg MailPoet class.
 */
class AdPlugg_MailPoet {

	/**
	 * Singleton instance.
	 *
	 * @var AdPlugg_MailPoet
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_filter( 'mailpoet_newsletter_shortcode', array( $this, 'render_mailpoet_shortcode' ), 10, 6 );
	}

	/**
	 * Renders the AdPlugg MailPoet shortcode.
	 *
	 * @param string $shortcode The entire shortcode string.
	 * @param type $newsletter
	 * @param type $subscriber
	 * @param type $queue
	 * @param type $newsletter_body
	 * @param array $arguments The user arguments included with the shortcode.
	 */
	public function render_mailpoet_shortcode( $shortcode, $newsletter, $subscriber, $queue, $newsletter_body, $arguments ) {
		// Quit if this isn't our shortcode.
		if ( 0 !== strpos( $shortcode, '[custom:adplugg:ad' ) ) return $shortcode;

		// Arguments.
		if ( array_key_exists('zone', $arguments) ) {
			$zone = $arguments['zone'];
		} else {
			// Zone is required, exit.
			return $shortcode;
		}

		$sidx = 0;
		if ( array_key_exists('idx', $arguments) ) {
			$sidx = $arguments['idx'];
		}

		$access_code = AdPlugg_Options::get_active_access_code();
		$rid = uniqid( 'mp_' );

		$tag =
		  '<a href="https://www.adplugg.com/track/click/' . $access_code . '/Z' . $zone . '/click' . '?hn=&amp;bu=&amp;rf=&amp;zn=' . $zone . '&amp;rid=' . $rid . '&amp;sidx=' . $sidx . '" class="adplugg-emailtag">'
			.'<img src="https://cdn1.adplugg.io/apusers/serve-adinstance/' . $access_code . '/file/Z' . $zone . '/0/' . $rid . '.jpg" />'
		  .'</a>'
		  .'<img src="https://www.adplugg.com/track/atb/' . $access_code . '/atb.gif?hn=&amp;bu=&amp;rf=&amp;et=impression&amp;tt=ad&amp;ti=&amp;zn=' . $zone . '&amp;pm=&amp;ui=&amp;rid=' . $rid . '&amp;sidx=' . $sidx . '" class="adplugg-atb" style="display: none;">';

		return $tag;
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return \AdPlugg_MailPoet Returns the singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

