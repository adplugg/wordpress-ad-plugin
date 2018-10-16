<?php
/**
 * Class for rendering the AdPlugg contextual help for the AMP options page
 * within the WordPress Administrator.
 *
 * @package AdPlugg
 * @since 1.7.0
 */

/**
 * AdPlugg_AMP_Options_Page_Help class.
 */
class AdPlugg_AMP_Options_Page_Help {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_AMP_Options_Page_Help
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_filter( 'contextual_help', array( &$this, 'add_help' ), 10, 3 );
	}

	/**
	 * Add help for the adplugg amp options page into the WordPress admin help
	 * system.
	 *
	 * @global $adplugg_hook
	 * @param string $contextual_help The default contextual help that our
	 * function is going to replace.
	 * @param string $screen_id Used to identify the page that we are on.
	 * @param string $screen Used to access the elements of the current page.
	 * @return string The new contextual help.
	 */
	public function add_help( $contextual_help, $screen_id, $screen ) {
		global $adplugg_hook;

		// Return the contextual help unaltered if this isn't our page.
		$target_screen_id = $adplugg_hook . '_page_adplugg_amp_settings';
		if ( $screen_id !== $target_screen_id ) {
			return $contextual_help;
		}

		$overview_content = '
			<h2>AMP Settings Help</h2>
			<p>
				These settings allow you to include AdPlugg ads in your
				AMP pages.
			</p>
			<p>
				If you are new to AdPlugg, you may find it easier to place ads
				on your regular pages first before attempting to include them in
				your AMP pages.
			';

		$requirements_content = '
			<h3>Requirements</h3>
			<p>
				For these settings to work, you will need to have the <a href="https://wordpress.org/plugins/amp/"
				target="_blank" title="AMP">
				AMP</a> plugin installed.
			</p>
			<p>
				You will also need to have an AdPlugg account with at least one Ad.
			</p>';

		$tips_content = '
			<h3>Tips</h3>
			<p>
				You may find it useful to create Zones that are specific to your AMP
				pages (for instance "AMP Zone 1"). You would then target the Ads
				that you
				want to appear in your AMP ages to the AMP specific Zone. You could
				target the ads directly or via a Placement.
			</p>';

		$widgets_content = '
			<h3>Widgets Help</h3>
			<p>
				Once you\'ve enabled automatic placement. Go to the <a href="' .
				admin_url( 'widgets.php' ) . '" title="Widgets configuration page">
				Widgets Configuration Page</a> and drag the AdPlugg Widget into the
				AMP Ads Widget Area. Configure the
				Widget including the Zone machine name, the width, the height and
				whether or not you want the Zone to be the "default" ad.
			</p>
			<p>
				The code from any Widgets in the AMP Ads Widget Area will be
				automatically distributed thoughout the post\'s content.
			</p>
			<h4>Default Ad/Widget</h4>
			<p>
				The Widget marked as the "default" will be flagged as the default ad
				for your AMP pages. This ad will be used for any remaining slots
				after all ads have been used.
			</p>
			<p>
				If you have your ads set to rotate you can use this as the only
				ad/widget and it will be automatically inserted throughout your
				page.
			<p>
				If you don\'t choose a "default" ad/widget, each widget will be
				placed once and then the plugin will stop inserting ads.
			</p>

			';

		$sidebar_content = '
			<h5>For more Information:</strong></h5>
			<a href="https://www.adplugg.com/support/help?utm_source=wpplugin&utm_campaign=amphelp-l2" target="_blank" title="AdPlugg Help Center">AdPlugg Help Center</a><br/>
			<a href="https://www.adplugg.com/support/cookbook?utm_source=wpplugin&utm_campaign=amphelp-l3" target="_blank" title="AdPlugg Cookbook">AdPlugg Cookbook</a><br/>
			<a href="https://www.adplugg.com/contact?utm_source=wpplugin&utm_campaign=amphelp-l4" target="_blank" title="Contact AdPlugg">Contact AdPlugg</a><br/>
			<br/>
			';

		// Overview tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_amp_overview',
				'title'   => 'Overview',
				'content' => $overview_content,
			)
		);

		// Requirements tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_amp_requirements',
				'title'   => 'Requirements',
				'content' => $requirements_content,
			)
		);

		// Tips tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_amp_tips',
				'title'   => 'Tips',
				'content' => $tips_content,
			)
		);

		// Widgets tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_amp_widgets',
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
	 * @return AdPlugg_AMP_Options_Page_Help Returns the singleton instance of
	 * this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
