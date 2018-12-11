<?php
/**
 * Class for rendering the AdPlugg contextual help for the options page within
 * the WordPress Administrator.
 *
 * @package AdPlugg
 * @since 1.0
 */

/**
 * AdPlugg_Options_Page_Help class.
 */
class AdPlugg_Options_Page_Help {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Options_Page_Help
	 */
	private static $instance;

	/**
	 * Constructor, constructs the class and registers filters and actions.
	 */
	public function __construct() {
		add_filter( 'contextual_help', array( &$this, 'add_help' ), 10, 3 );
	}

	/**
	 * Add help for the adplugg options page into the WordPress admin help
	 * system.
	 *
	 * @param string $contextual_help The default contextual help that our
	 * function is going to replace.
	 * @param string $screen_id Used to identify the page that we are on.
	 * @param string $screen Used to access the elements of the current page.
	 * @return string The new contextual help.
	 */
	public function add_help( $contextual_help, $screen_id, $screen ) {
		global $adplugg_hook;

		// Return the contextual help unaltered if this isn't our page.
		$target_screen_id = 'toplevel_page_' . $adplugg_hook;
		if ( $screen_id !== $target_screen_id ) {
			return $contextual_help;
		}

		$overview_content = '
		<h1>AdPlugg Plugin Help</h1>
		<p>
			Need help using the adplugg plugin? Use the tabs to the left to find
			instructions for installation, use and troubleshooting.
		</p>
		<div style="overflow: hidden">
			<div class="adplugg-video-tile">
				<h2>Quick Start Video</h2>
				<figure>
					<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_qh4ytc46co popover=true popoverAnimateThumbnail=true" style="display:inline-block;height:94px;width:150px">&nbsp;</span>
					<figcaption>(3:38)</figcaption>
				</figure>
			</div>
			<div class="adplugg-video-tile">
				<h2>Really Quick Start Video</h2>
				<figure>
					<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_kjxlwvcixg popover=true popoverAnimateThumbnail=true" style="display:inline-block;height:94px;width:150px">&nbsp;</span>
					<figcaption>(0:55)</figcaption>
				</figure>
			</div>
		</div>

		';

		$installation_content = '
		<h2>Installation/Configuration</h2>
		<p>
			The AdPlugg WordPress Ad Plugin makes it super easy to put ads on your
			WordPress Site.
		</p>
		<ol>
			<li>Install the plugin.</li>
			<li>Activate the plugin.</li>
			<li>Create an account at <a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=ohelp-ic-l1" target="_blank" title="adplugg.com">adplugg.com</a> and add at least one ad.</li>
			<li>Get your AdPlugg Access Code and add it to the Access Code field on this page.</li>
			<li>Go to the <a href="' . admin_url( 'widgets.php' ) . '" title="Widgets configuration page">Widgets configuration page</a> and drag the AdPlugg Ad Widget into
				a Widget Area.
			</li>
			<li>Your ad(s) should now be viewable from your blog.</li>
		</ol>
		<h2>Additional Options</h2>
		<p>Advanced users can use the following options to customize what ads are served.</p>
		<ul>
			<li>
				Optionally add a Zone machine name into the widget to tie the
				widget to a Zone. Zones can be set up from your account
				at <a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=ohelp-ao-l1" target="_blank" title="adplugg.com">adplugg.com</a>. Zones make
				it so that you can load different ads in different areas of the
				page.
			</li>
		</ul>
		<h2>Quick Start Video</h2>
		<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_qh4ytc46co popover=true popoverAnimateThumbnail=true" style="display:inline-block;height:94px;width:150px">&nbsp;</span>
		';

		$use_content = '
		<h2>Using AdPlugg</h2>
		<p>Once you have AdPlugg set up and working, most things that can be done
		from <a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=ohelp-ua-l1" target="_blank" title="adplugg.com">adplugg.com</a>. This includes:</p>
		<ul>
			<li>Creating, modifying and deleting ads</li>
			<li>Activating and deactivating ads</li>
			<li>Scheduling ads</li>
			<li>Tracking your ads and viewing your analytics</li>
			<li>Much more</li>
		</ul>
		<p>Access my <a href="https://www.adplugg.com/apusers/login?utm_source=wpplugin&utm_campaign=ohelp-ua-l2" target="_blank" title="AdPlugg account">AdPlugg account</a></p>
		';

		$tags_content = '
		<h2>Ad Tags/Shortcodes</h2>
		<p>Once you have AdPlugg intalled, you can add AdPlugg Ad Tags to your site
		and they will be filled with any ads that you target to them from your
		account at <a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=ohelp-ats-l1" target="_blank"
		title="adplugg.com">adplugg.com</a>.
		</p>
		<p>You can add AdPlugg Ad Tags to Posts, Pages, theme files, etc.</p>
		<p>The AdPlugg Widget simply adds an Ad Tag to your Widget Area. You could
		insert the same Ad Tag by other means if you wanted (by using a text widget
		for example).
		</p>
		<p>Though they work in a similar fashion to Shortcodes, AdPlugg has chosen
		to use Ad Tags instead of shortcodes as they are more powerfull, more
		flexible, and more familiar to most users. You can read more about Ad Tags
		<a href="https://www.adplugg.com/support/help/ad-tags?utm_source=wpplugin&utm_campaign=ohelp-ats-l2"
		title="Ad Tags" target="_blank">here</a>.
		</p>';

		$troubleshooting_content = '
		<h2>Troubleshooting</h2>
		<p>If ads aren\'t displaying on your site, please check the following:</p>
		<ul>
			<li>Is The AdPlugg plugin installed and activated?</li>
			<li>Have you created an AdPlugg account at <a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=ohelp-t-l1" title="adplugg.com">www.adplugg.com</a>?</li>
			<li>Do you have at least one active ad in your AdPlugg account?</li>
			<li>Have you added the AdPlugg Ad Widget to a Widget Area? You can do this from the
			<a href="' . admin_url( 'widgets.php' ) . '" title="Widgets configuration page">Widgets configuration page</a>.</li>
		</ul>
		<p>
		Please <a href="https://www.adplugg.com/contact?utm_source=wpplugin&utm_campaign=ohelp-t-l2" target="_blank" title="contact us">contact us</a> for additional support.
		</p>
		';

		$faq_content = '
		<h2>FAQ</h2>
		<h5>Why do I need an access code?</h5>
		<p>
			AdPlugg is a service (and it\'s free!). When you register, you get your
			own high powered, cloud based ad server/ad manager system. From your
			new AdPlugg account, you can serve ads to any number of sites using
			sophisticated scheduling and rotation strategies. In addition, AdPlugg
			will track your ad\'s impressions and clicks and provide you with detailed
			analytics. All of this is much too computationally expensive to attempt
			on a typical WordPress shared hosting account. So instead, AdPlugg was
			designed to run as a service separate from your website.
		</p>
		<p>
			Once you\'ve registered, you are given an access code. You enter your
			access code into the AdPlugg WordPress Plugin settings so that your
			WordPress site can retrieve ads from your AdPlugg account.
		</p>
		<p>
			You can sign up for a free AdPlugg account and get your access code
			by going <a href="https://www.adplugg.com/apusers/signup?utm_source=wpplugin&utm_campaign=ohelp-faq-l1" target="_blank" title="AdPlugg Signup">here</a>.
		</p>
		<h5>More Questions and Answers</h5>
		<p>
			Not seeing the question/answer that you are looking for? Please see our
			<a href="https://www.adplugg.com/support/question-answer?utm_source=wpplugin&utm_campaign=ohelp-faq-l2"
			target="_blank" title="Question and Answer Forum">Question/Answer forum
			</a> for much more.
		</p>
		';

		$sidebar_content = '
		<h5>For more Information:</strong></h5>
		<a href="https://www.adplugg.com/support/help?utm_source=wpplugin&utm_campaign=ohelp-mi-l1" target="_blank" title="AdPlugg Help Center">AdPlugg Help Center</a><br/>
		<a href="https://www.adplugg.com/support/cookbook?utm_source=wpplugin&utm_campaign=ohelp-mi-l2" target="_blank" title="AdPlugg Cookbook">AdPlugg Cookbook</a><br/>
		<a href="https://www.adplugg.com/contact?utm_source=wpplugin&utm_campaign=ohelp-mi-l3" target="_blank" title="Contact AdPlugg">Contact AdPlugg</a><br/>
		';

		// Overview tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_overview',
				'title'   => 'Overview',
				'content' => $overview_content,
			)
		);
		// Installation tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_installation',
				'title'   => 'Installation',
				'content' => $installation_content,
			)
		);
		// Use tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_use',
				'title'   => 'Using AdPlugg',
				'content' => $use_content,
			)
		);
		// Tags tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_tags',
				'title'   => 'Tags/Shortcodes',
				'content' => $tags_content,
			)
		);
		// Troubleshooting tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_troubleshooting',
				'title'   => 'Troubleshooting',
				'content' => $troubleshooting_content,
			)
		);
		// FAQ tab.
		$screen->add_help_tab(
			array(
				'id'      => 'adplugg_faq',
				'title'   => 'FAQ',
				'content' => $faq_content,
			)
		);

		$screen->set_help_sidebar( $sidebar_content );

		return $contextual_help;
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return AdPlugg_Options_Page_Help Returns the singleton instance of this
	 * class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
