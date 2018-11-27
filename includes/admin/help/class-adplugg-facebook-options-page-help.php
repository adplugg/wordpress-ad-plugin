<?php
/**
 * Class for rendering the AdPlugg contextual help for the Facebook options page
 * within the WordPress Administrator.
 *
 * @package AdPlugg
 * @since 1.3.0
 */

/**
 * AdPlugg_Facebook_Options_Page_Help class.
 */
class AdPlugg_Facebook_Options_Page_Help {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Facebook_Options_Page_Help
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_filter( 'contextual_help', array( &$this, 'add_help' ), 10, 3 );
	}

	/**
	 * Add help for the adplugg facebook options page into the WordPress admin help
	 * system.
	 *
	 * @global $adplugg_hook
	 * @param string $contextual_help The default contextual help that our
	 * function is going to replace.
	 * @param string $screen_id Used to identify the page that we are on.
	 * @param string $screen Used to access the elements of the current page.
	 * @return string The new contextual help.
	 */
	public function add_help(
								$contextual_help,
								$screen_id,
								$screen ) {
		global $adplugg_hook;

		// Return the contextual help unaltered if this isn't our page.
		$target_screen_id = $adplugg_hook . '_page_adplugg_facebook_settings';
		if ( $screen_id !== $target_screen_id ) {
			return $contextual_help;
		}

		$overview_content = '
			<h2>Facebook Settings Help</h2>
			<p>
				These settings allow you to include AdPlugg ads in your
				<a href="https://www.adplugg.com/blog/facebook-instant-articles?utm_source=wpplugin&utm_campaign=fbhelp-l1"
				target="_blank"> Facebook Instant Articles</a> header. Ads included
				in the header will be automatically placed by Facebook throughout the
				content of the article.
			</p>
			<p>
				If you are new to AdPlugg, you may find it easier to place ads
				on your regular site first before attempting to include them in
				your Instant Articles feed.
			';

		$requirements_content = '
			<h3>Requirements</h3>
			<p>
				For these settings to work, you will need to have the <a href="https://wordpress.org/plugins/fb-instant-articles/"
				target="_blank" title="Facebook Instant Articles for WP">
				Facebook Instant Articles for WP</a> plugin installed.
			</p>
			<p>
				You will also need to have an AdPlugg account with at least one Zone
				and at least one ad targeted to it.
			</p>';

		$tips_content = '
			<h3>Tips</h3>
			<p>
				It is usually best to create Zones that are specific to your Facebook
				Instant Articles Feed (for instance "Facebook Zone 1").
			</p>';

		$widgets_content = '
			<h3>Widgets Help</h3>
			<p>
				Once you\'ve enabled automatic placement. Go to the <a href="' .
				admin_url( 'widgets.php' ) . '" title="Widgets configuration page">
				Widgets Configuration Page</a> and drag the AdPlugg Widget into the
				Facebook Instant Articles Ads Widget Area. Configure the
				Widget including the Zone machine name, the width, the height and
				whether or not you want the Zone to be the "default" ad.
			</p>
			<p>
				The code from any Widgets in the Facebook Instant Articles Widget
				Area will be automatically included in the header of each post in
				your Instant Articles feed. Facebook will then automatically
				distribute them thoughout the article\'s content.
			</p>
			<p>
				The Widget marked as the default will be flagged as the default ad
				in your Instant Articles feed. This ad will be used for any remaining
				slots after all ads have been used.
			</p>

			';

		$sidebar_content = '
			<h5>For more Information:</strong></h5>
			<a href="https://www.adplugg.com/support/help?utm_source=wpplugin&utm_campaign=fbhelp-l2" target="_blank" title="AdPlugg Help Center">AdPlugg Help Center</a><br/>
			<a href="https://www.adplugg.com/support/cookbook?utm_source=wpplugin&utm_campaign=fbhelp-l3" target="_blank" title="AdPlugg Cookbook">AdPlugg Cookbook</a><br/>
			<a href="https://www.adplugg.com/contact?utm_source=wpplugin&utm_campaign=fbhelp-l4" target="_blank" title="Contact AdPlugg">Contact AdPlugg</a><br/>
			<br/>
			';

		// Overview tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_facebook_overview',
				'title'   => 'Overview',
				'content' => $overview_content,
			)
		);

		// Requirements tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_facebook_requirements',
				'title'   => 'Requirements',
				'content' => $requirements_content,
			)
		);

		// Tips tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_facebook_tips',
				'title'   => 'Tips',
				'content' => $tips_content,
			)
		);

		// Widgets tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_facebook_widgets',
				'title'   => 'Widgets',
				'content' => $widgets_content,
			)
		);

		$screen->set_help_sidebar( $sidebar_content );

		return $contextual_help;
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return AdPlugg_Facebook_Options_Page_Help Returns the singleton instance
	 * of this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

