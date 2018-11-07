<?php
/**
 * Class for rendering the AdPlugg Facebook Options/Settings page within the WordPress
 * Administrator.
 *
 * @package AdPlugg
 * @since 1.3.0
 */

/**
 * AdPlugg_Facebook_Options_Page class.
 */
class AdPlugg_Facebook_Options_Page {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_Facebook_Options_Page
	 */
	private static $instance;

	/**
	 * Constructor, constructs the options page and adds it to the Settings
	 * menu.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( &$this, 'add_page_to_menu' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
	}

	/**
	 * Function to add the facebook options page to the admin menu.
	 */
	public function add_page_to_menu() {
		$adplugg_hook = 'adplugg';

		$hook = add_submenu_page(
			$adplugg_hook,
			'Facebook',
			'Facebook',
			'manage_options',
			$adplugg_hook . '_facebook_settings',
			array( &$this, 'render_page' )
		);
	}

	/**
	 * Add notices for this page.
	 */
	public function admin_notices() {

		$screen    = get_current_screen();
		$screen_id = ( ! empty( $screen ) ? $screen->id : null );

		if ( 'adplugg_page_adplugg_facebook_settings' === $screen_id ) {
			// Show notice if fb-instant-articles plugin isn't found.
			if ( ! defined( 'INSTANT_ARTICLES_SLUG' ) ) {
				$fb_instant_articles_not_found_notice =
						AdPlugg_Notice::create(
							'notify_fb_instant_articles_not_found',
							'<a href="https://wordpress.org/plugins/fb-instant-articles/" title="Get the Facebook Instant Articles for WP plugin" >Facebook Instant Articles for WP</a> plugin not found.',
							'error'
						);
				$fb_instant_articles_not_found_notice->render();
			}
		}
	}

	/**
	 * Function to initialize the AdPlugg Facebook Options page.
	 */
	public function admin_init() {

		register_setting( 'adplugg_facebook_options', ADPLUGG_FACEBOOK_OPTIONS_NAME, array( &$this, 'validate' ) );

		add_settings_section(
			'adplugg_facebook_instant_articles_section',
			'Facebook Instant Articles',
			array( &$this, 'render_facebook_instant_articles_section_text' ),
			'adplugg_facebook_instant_articles_settings'
		);
		add_settings_field(
			'ia_enable_automatic_placement',
			'Automatic Placement',
			array( &$this, 'render_ia_enable_automatic_placement_field' ),
			'adplugg_facebook_instant_articles_settings',
			'adplugg_facebook_instant_articles_section'
		);

		// This is a temp field to facilitate a judicious rollout of the new
		// adplugg.io endpoint its use may have been allowed on upgrade. If it
		// was, show the field.
		if ( AdPlugg_Facebook::temp_allow_legacy_adplugg_com_endpoint() ) {
			add_settings_field(
				'temp_use_legacy_adplugg_com_endpoint',
				'Legacy Endpoint',
				array( &$this, 'render_temp_use_legacy_adplugg_com_endpoint_field' ),
				'adplugg_facebook_instant_articles_settings',
				'adplugg_facebook_instant_articles_section'
			);
		}
	}

	/**
	 * Function to render the AdPlugg Facebook options page.
	 */
	public function render_page() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div><h2>Facebook Settings - AdPlugg</h2>
			<?php settings_errors(); ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'adplugg_facebook_options' ); ?>
				<?php do_settings_sections( 'adplugg_facebook_instant_articles_settings' ); ?>
				<p class="submit">
					<input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'adplugg' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Function to render the text for the instant articles section.
	 */
	public function render_facebook_instant_articles_section_text() {
		?>
		<p>
			To have AdPlugg ads automatically inserted into your Facebook Instant
			Articles feed, do the following:
		</p>
		<ol>
			<li>
				Ensure that you have the
				<a href="https://wordpress.org/plugins/fb-instant-articles/"
					title="Get the Facebook Instant Articles for WP plugin" >
					Facebook Instant Articles for WP</a> plugin installed.
			</li>
			<li>
				Enable automatic placement by clicking the checkbox below.
			</li>
			<li>
				Go to the <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"
				title="Widgets configuration page">Widgets Configuration Page</a>
				and drag the AdPlugg Widget into the Widget Area entitled "Facebook
				Instant Articles Ads" (note you can add multiple widgets if
				desired).
			</li>
			<li>
				If you are using version 0.3 or higher of the Facebook Instant
				Articles for WP plugin, go to its settings and select AdPlugg
				as your Ad Type.
			</li>
		</ol>
		<p>
			See the <a href="#"
				onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Get help using this plugin.">help</a>
				above for more info.
		</p>
		<?php
	}

	/**
	 * Function to render the automatic placement field and description.
	 */
	public function render_ia_enable_automatic_placement_field() {
		$options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
		$checked = ( array_key_exists( 'ia_enable_automatic_placement', $options ) ) ? $options['ia_enable_automatic_placement'] : 0;
		?>
		<label for="adplugg_facebook_ia_enable_automatic_placement">
			<input type="checkbox" id="adplugg_facebook_ia_enable_automatic_placement" name="adplugg_facebook_options[ia_enable_automatic_placement]" value="1" <?php echo checked( 1, $checked, false ); ?> />
			Enable automatic placement of ads within my posts.
		</label>
		<?php
	}

	/**
	 * Function to render the temp_use_legacy_adplugg_com_endpoint field and
	 * description.
	 *
	 * This is a temp field to facilitate a judicious rollout of the new
	 * adplugg.io endpoint.
	 *
	 * It is only added to the form in certain situations (see the admin_init
	 * function above).
	 */
	public function render_temp_use_legacy_adplugg_com_endpoint_field() {
		$options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
		$checked = ( array_key_exists( 'temp_use_legacy_adplugg_com_endpoint', $options ) ) ? $options['temp_use_legacy_adplugg_com_endpoint'] : 0;
		?>
		<label for="adplugg_facebook_temp_use_legacy_adplugg_com_endpoint">
			<input type="checkbox" id="adplugg_facebook_ia_enable_automatic_placement" name="adplugg_facebook_options[temp_use_legacy_adplugg_com_endpoint]" value="1" <?php echo checked( 1, $checked, false ); ?> />
			(LEGACY) Use "www.adplugg.com" endpoint for ad serving.
		</label>
		<br/>
		<small>Note: The new endpoint is at "www.adplugg.io".</small>
		<?php
	}

	/**
	 * Function to validate the submitted AdPlugg Facebook options field values.
	 *
	 * This function overwrites the old values instead of completely replacing
	 * them so that we don't overwrite values that weren't submitted (such as
	 * the version).
	 *
	 * @param array $input The submitted values.
	 * @return array Returns the new options to be stored in the database.
	 */
	public function validate( $input ) {
		$old_options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME );
		$new_options = $old_options;  // Start with the old options.

		$has_errors  = false;
		$msg_type    = null;
		$msg_message = null;

		// --- process the new values ----
		// ia_enable_automatic_placement.
		$new_options['ia_enable_automatic_placement'] = ( isset( $input['ia_enable_automatic_placement'] ) ) ? intval( $input['ia_enable_automatic_placement'] ) : 0;
		if ( ! preg_match( '/^[01]$/', $new_options['ia_enable_automatic_placement'] ) ) {
			$has_errors                                   = true;
			$msg_message                                  = 'Invalid Enable Automatic Placement option.';
			$new_options['ia_enable_automatic_placement'] = 0;
		}

		// temp_use_legacy_adplugg_com_endpoint.
		// This is a temp field to facilitate a judicious rollout of the new adplugg.io endpoint.
		if ( AdPlugg_Facebook::temp_allow_legacy_adplugg_com_endpoint() ) {
			$new_options['temp_use_legacy_adplugg_com_endpoint'] = ( isset( $input['temp_use_legacy_adplugg_com_endpoint'] ) ) ? intval( $input['temp_use_legacy_adplugg_com_endpoint'] ) : 0;
			if ( ! preg_match( '/^[01]$/', $new_options['temp_use_legacy_adplugg_com_endpoint'] ) ) {
				$has_errors  = true;
				$msg_message = 'Invalid Use Legacy Endpoint option.';
				$new_options['temp_use_legacy_adplugg_com_endpoint'] = 0;
			}
		}

		// --- add a message ---//
		if ( $has_errors ) {
			$msg_type = 'error';

			add_settings_error(
				'AdPluggFacebookOptionsSaveMessage',
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
	 * @return \AdPlugg_Facebook_Options_Page Returns the singleton instance of
	 * this class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
