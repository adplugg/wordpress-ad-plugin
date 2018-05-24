<?php
/**
 * AdPlugg Privacy class.
 * The Privacy class sets hooks the built in privacy controls in the wp-admin.
 *
 * @package AdPlugg
 * @since 1.9.0
 */
class AdPlugg_Privacy {
	
	/**
	 * Class instance.
	 * @var AdPlugg_Privacy
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_action( 'admin_init', array( &$this, 'add_privacy_message' ) );
	}
	
	/**
	 * Adds the AdPlugg privacy message suggestions to the privacy settings page
	 * in the wp-admin.
	 */
	public function add_privacy_message() {
		if ( function_exists( 'wp_add_privacy_policy_content' ) ) {
			wp_add_privacy_policy_content( 
					'AdPlugg', //plugin name
					$this->get_privacy_message() //policy text
				);
		}
	}

	/**
	 * Builds the AdPlugg privacy message.
	 * suggestions.
	 *
	 * @since 1.9.0
	 */
	public function get_privacy_message() {
		$content = '
			<div contenteditable="false">' .
				'<p class="wp-policy-help"><i>' .
					'This sample language is provided as an example of what you may want to include in your Privacy Policy regarding your use of AdPlugg. We recommend consulting with a lawyer when deciding what specific information to disclose on your privacy policy.'  .
				'</i></p>' .
				'<p class="wp-policy-help"><i>' .
					'You are required to post a Privacy Policy on your website as per the <a href="https://www.adplugg.com/legal/terms" title="AdPlugg Terms of Use" target="_blank">AdPlugg Terms of Use</a>.' .
				'</i></p>' .
			'</div>' .
			'<h2> Third Party Data Processors'  . '</h2>' .
			'<div contenteditable="false">' .
				'<p class="wp-policy-help"><i>In this subsection you should list which third party data processors you are using on your site, including AdPlugg.</i></p>' .
			'</div>' .
			'<p> We are very selective with the Third Parties that we choose to partner with and only select Third Party partners that we believe are committed to personal privacy.</p>' .
			'<h4> AdPlugg</h4>' .
			'<p>To help fund our Website, we use advertising and while you visit our site, you may be shown ads.</p>' .
			'<p>We use <a href="https://www.adplugg.com" title="AdPlugg" target="_blank">AdPlugg</a> to manage and serve ads to our readers ("Ad Audience Members").</p>' .
			'<p>AdPlugg doesn\'t collect personally identifiable information ("Personal Information") regarding Ad Audience Members. Personal Information is defined as information by which you may be personally identified, such as your name, postal address, e-mail address or telephone number ("Personal Information").</p>' .
			'<p>AdPlugg does however, collect Anonymous Information, which is information that cannot reasonably be used to personally identify you. In addition, they collect Aggregate Information, which is information about groups or categories of Ad Audience Members, this information is also anonymous and cannot reasonably be used to personally identify you.</p>' .
			'<p>AdPlugg collects this information in order to:</p>' .
			'<ol>' .
			    '<li>Provide us with ad perfomance statistics</li>' .
			    '<li>Prevent fraud</li>' .
			    '<li>Measure system usage</li>' .
			'</ol>' .
			'<p>AdPlugg collects this information via:' .
			'<ol>' .
				'<li>Single pixel gifs, also called "web beacons"</li>' .
				'<li>Browser cookies</li>' .
			'</ol>' .
			'<p>To learn more, please see the <a href="https://www.adplugg.com/legal/audience-privacy" title="AdPlugg Audience Privacy Policy" target="_blank">AdPlugg Audience Privacy Policy.</a></p>';
		
		return $content;
	}
	
	/**
	 * Gets the singleton instance.
	 * @return \AdPlugg_Privacy Returns the singleton instance of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
