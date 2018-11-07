<?php
/**
 * Class for rendering the AdPlugg Options/Settings page within the WordPress
 * Administrator.
 *
 * @package AdPlugg
 * @since 1.0
 */

/**
 * AdPlugg_Options_Page class.
 */
class AdPlugg_Options_Page {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Options_Page
	 */
	private static $instance;

	/**
	 * Constructor, constructs the options page and adds it to the Settings
	 * menu.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( &$this, 'add_to_menu' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
	}

	/**
	 * Function to add the options page to the settings menu.
	 *
	 * @global $adplugg_hook
	 */
	public function add_to_menu() {
		global $adplugg_hook;
		$adplugg_hook = 'adplugg';

		add_menu_page( 'AdPlugg Settings', 'AdPlugg', 'manage_options', $adplugg_hook, array( &$this, 'render_page' ), null, '55.2' );
		add_submenu_page( $adplugg_hook, 'General', 'General', 'manage_options', $adplugg_hook );
	}

	/**
	 * Function to render the AdPlugg options page.
	 */
	public function render_page() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div><h2>AdPlugg General Settings</h2>
			<?php settings_errors(); ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'adplugg_options' ); ?>
				<?php do_settings_sections( 'adplugg' ); ?>

				<p class="submit">
					<input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'adplugg' ); ?>" />
				</p>
			</form>
			<br/>
			<ul>
				<?php if ( AdPlugg_Options::is_access_code_installed() ) { ?>
					<li>Manage my ads at <a href="https://www.adplugg.com/apusers/login?utm_source=wpplugin&utm_campaign=opts-l1" target="_blank" title="Manage my ads at adplugg.com">adplugg.com</a>.</li>
					<li>Place the AdPlugg Widget on my site from the <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" title="Go to the Widgets Configuration Page.">WordPress Widgets Configuration Page</a>.</li>
				<?php } //end if ?>
			</ul>
			<hr/>
			<h3>Help</h3>
			<?php if ( ! AdPlugg_Options::is_access_code_installed() ) { ?>
				<div class="adplugg-videos">
					<div class="adplugg-video-tile">
						<figure>
							<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_qh4ytc46co popover=true popoverAnimateThumbnail=true" style="display:inline-block;height:94px;width:150px">&nbsp;</span>
							<figcaption>Quick Start Video<br/>(3:38)</figcaption>
						</figure>
					</div>
					<div class="adplugg-video-tile">
						<figure>
							<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_kjxlwvcixg popover=true popoverAnimateThumbnail=true" style="display:inline-block;height:94px;width:150px">&nbsp;</span>
							<figcaption><i>Really</i> Quick Start Video<br/>(0:55)</figcaption>
						</figure>
					</div>
				</div>
			<?php } //end if ?>
			<p>
				Get <a href="#" onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Get help using this plugin.">help</a> using this plugin.
			</p>
		</div>
		<?php
	}

	/**
	 * Function to render the text for the access section.
	 */
	public function render_access_section_text() {
		?>
		<p>
			AdPlugg is an online service for managing and serving ads to your
			website.
		</p>
		<?php if ( ! AdPlugg_Options::is_access_code_installed() ) { ?>
			<p>
				To use AdPlugg, you will need an AdPlugg Access Code. Your AdPlugg
				Access Code ties your WordPress site to your AdPlugg account (and
				hosted AdPlugg ad server). To get your AdPlugg Access Code, log in
				or register (it's free) at
				<a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=opts-l2" target="_blank" title="adplugg.com">
					adplugg.com</a>.
			</p>
			<?php
		} // phpcs:ignore
	}

	/**
	 * Function to render the access code field and description
	 */
	public function render_access_code() {
		$options     = get_option( ADPLUGG_OPTIONS_NAME, array() );
		$access_code = ( array_key_exists( 'access_code', $options ) ) ? $options['access_code'] : '';
		?>
		<input id="adplugg_access_code" name="adplugg_options[access_code]" size="9" type="text" value="<?php echo esc_attr( $access_code ); ?>" />
		<p class="description">
			You must enter a valid AdPlugg Access Code here. If you need an
			Access Code, you can create one
			<a href="https://www.adplugg.com/apusers/signup?utm_source=wpplugin&utm_campaign=opts-l2" target="_blank" title="AdPlugg Signup">here</a>.
			<?php if ( ! AdPlugg_Options::is_access_code_installed() ) { ?>
				<br/>
				<a href="#" onclick="
					jQuery( '#contextual-help-link' ).trigger( 'click' );
					jQuery( '#tab-link-adplugg_faq>a' ).trigger( 'click' );
					return false;
				" title="Why do I need an access code?">Why do I need an access code?</a>
			<?php } // end if. ?>
		</p>
		<?php
	}

	/**
	 * Function to initialize the AdPlugg options page.
	 */
	public function admin_init() {
		register_setting( 'adplugg_options', ADPLUGG_OPTIONS_NAME, array( &$this, 'validate' ) );
		add_settings_section(
			'adplugg_options_access_section',
			'Access Settings',
			array( &$this, 'render_access_section_text' ),
			'adplugg'
		);
		add_settings_field(
			'access_code',
			'Access Code',
			array( &$this, 'render_access_code' ),
			'adplugg',
			'adplugg_options_access_section'
		);
	}

	/**
	 * Function to validate the submitted AdPlugg options field values.
	 *
	 * This function overwrites the old values instead of completely replacing
	 * them so that we don't overwrite values that weren't submitted (such as
	 * the version).
	 *
	 * @param array $input The submitted values.
	 * @return array Returns the new options to be stored in the database.
	 */
	public function validate( $input ) {
		$old_options = get_option( ADPLUGG_OPTIONS_NAME );
		$new_options = $old_options;  // Start with the old options.

		$has_errors  = false;
		$msg_type    = null;
		$msg_message = null;

		// Process the new values.
		$new_options['access_code'] = trim( $input['access_code'] );
		if ( ! preg_match( '/^[a-z0-9]*$/i', $new_options['access_code'] ) ) {
			$has_errors                 = true;
			$msg_message                = 'Please enter a valid Access Code.';
			$new_options['access_code'] = '';
		}

		if ( $has_errors ) {
			$msg_type = 'error';
			add_settings_error(
				'AdPluggOptionsSaveMessage',
				esc_attr( 'settings_updated' ),
				$msg_message,
				$msg_type
			);
		}

		return $new_options;
	}

	/**
	 * Gets the singleton instance.
	 *
	 * @return \AdPlugg_Options_Page Returns the singleton instance of this
	 * class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
