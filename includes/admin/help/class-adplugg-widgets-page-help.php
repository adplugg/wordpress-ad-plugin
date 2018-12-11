<?php
/**
 * Functions for rendering the AdPlugg contextual help for the widgets page
 * within the WordPress Administrator.
 *
 * @package AdPlugg
 * @since 1.1.29
 */

/**
 * AdPlugg_Widgets_Page_Help class.
 */
class AdPlugg_Widgets_Page_Help {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Widgets_Page_Help
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_filter( 'contextual_help', array( &$this, 'add_help' ), 10, 3 );
	}

	/**
	 * Add help for the AdPlugg widget into the WordPress admin help system.
	 *
	 * @param string $contextual_help The default contextual help that our
	 * function is going to replace.
	 * @param string $screen_id Used to identify the page that we are on.
	 * @param string $screen Used to access the elements of the current page.
	 * @return string The new contextual help.
	 */
	public function add_help( $contextual_help, $screen_id, $screen ) {

		// Return the contextual help unaltered if this isn't our page.
		if ( 'widgets' !== $screen_id ) {
			return $contextual_help;
		}

		$content = '
		<h1>AdPlugg Widget Help</h1>
		<p>Using the AdPlugg Widget is easy! Just drag it from the list of available
		widgets into any of your widget areas.
		</p>
		<h2>Optional Settings</h2>
		<p>The AdPlugg Widget has several optional settings that allow you to do
		more things with your ads.</p>
		<ul>
			<li><strong>Title:</strong> Though it may depend on your theme, the
				text that you enter into the Title field typically displays just
				above the widget. For example, you could enter "Sponsors" to have
				the word "Sponsors" display above your ads. Don\'t want a title?
				Just leave this field blank.
			</li>
			<li><strong>Zone:</strong> If you\'ve added zones to your
				<a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=whelp-os-l1" target="_blank" title="adplugg.com">
				adplugg.com</a> configuration, you can use this field to tie a zone
				to the widget. Enter the zone\'s machine name into this field. Once
				the widget is tied to a zone, you can control what displays in the
				widget by modifying your zone settings and zone targeting at <a
				href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=whelp-os-l2" target="_blank" title="adplugg.com">
				adplugg.com</a>.
			</li>
		</ul>
		<h2>Facebook Instant Article Ads</h2>
		<p>You can insert the AdPlugg Widget into your Facebook Instant Article
		Ads.</p>
		<h4>Instructions</h4>
		<ul>
			<li>If you haven\'t already done so, follow the instructions on the
				<a href="admin.php?page=adplugg_facebook_settings">AdPlugg Facebook
				settings page</a> to install the Facebook Instant Articles for WP
				plugin, enable automatic placement and configure AdPlugg as your Ad
				Type.
			</li>
			<li>You should now see a "Facebook Instant Articles Ads" widget area
				below.
			</li>
			<li>Drag the AdPlugg Widget into the "Facebook Instant Articles Ads"
				widget area.
			</li>
			<li>Enter the zone machine name of the AdPlugg Zone that you want to
			appear in your Instant Articles.</li>
			<li>Give the Zone a Width and a Height (ex: 300 wide and 250 high).
			</li>
			<li>Optionally check the "Default" checkbox. This will make the
				Widget/Zone the default for Instant Articles (see below).
			</li>
		</ul>
		<p>Add as many widgets as you like into the Facebook Instant Articles Ads
			widget area. They will be automatically inserted within the Instant
			Articles content in the order in which they appear in the widget area.
		</p>
		<h4>The Default Widget</h4>
		<p>
			As mentioned above, you can drag multiple widgets into the Facebook
			Instant Articles Ads widget area. The widgets (or the ads that they
			produce) will be automatically inserted thoughout the Instant Article in
			the order that they are shown in the widget area. After all ads/widgets
			have been inserted, if there is still more content, the "Default" widget
			will be inserted again.
		</p>
		<p>A common configuration is to use a single widget, set it to be the
		default and then use AdPlugg\'s ad rotation features to rotate the ads that
		appear.</p>
		';

		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_widget',
				'title'   => 'AdPlugg Widget',
				'content' => $content,
			)
		);

		return $contextual_help;
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return AdPlugg_Widgets_Page_Help Returns the singleton instance of this
	 * class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

