<?php
/**
 * Class for rendering the AdPlugg AMP Options/Settings page within the WordPress
 * Administrator.
 *
 * @package AdPlugg
 * @since 1.7.0
 */

/**
 * AdPlugg_AMP_Options_Page class.
 */
class AdPlugg_AMP_Options_Page {

	/**
	 * Class instance.
	 *
	 * @var AdPlugg_AMP_Options_Page
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
	 * Function to add the AMP options page to the admin menu.
	 */
	public function add_page_to_menu() {
		$adplugg_hook = 'adplugg';

		$hook = add_submenu_page(
			$adplugg_hook,
			'AMP',
			'AMP',
			'manage_options',
			$adplugg_hook . '_amp_settings',
			array( &$this, 'render_page' )
		);
	}

	/**
	 * Add notices for this page.
	 */
	public function admin_notices() {
		$screen    = get_current_screen();
		$screen_id = ( ! empty( $screen ) ? $screen->id : null );

		if ( 'adplugg_page_adplugg_amp_settings' === $screen_id ) {
			// Show notice if amp plugin isn't found.
			if ( ! defined( 'AMP__VERSION' ) ) {
				$amp_not_found_notice =
						AdPlugg_Notice::create(
							'notify_amp_not_found',
							'<a href="https://wordpress.org/plugins/amp/" title="Get the AMP plugin" target="_blank" >AMP</a> plugin not found.',
							'error'
						);
				$amp_not_found_notice->render();
			}
		}
	}

	/**
	 * Function to initialize the AdPlugg AMP Options page.
	 */
	public function admin_init() {

		register_setting( 'adplugg_amp_options', ADPLUGG_AMP_OPTIONS_NAME, array( &$this, 'validate' ) );

		// ------------- GENERAL AMP SETTINGS ------------ //
		add_settings_section(
			'adplugg_amp_general_section',
			'General Settings',
			array( &$this, 'render_amp_general_section_text' ),
			'adplugg_amp_general_settings'
		);
		add_settings_field(
			'amp_enable_automatic_placement',
			'Automatic Placement',
			array( &$this, 'render_amp_enable_automatic_placement_field' ),
			'adplugg_amp_general_settings',
			'adplugg_amp_general_section'
		);
		add_settings_field(
			'amp_ad_density',
			'Ad Density',
			array( &$this, 'render_amp_ad_density_field' ),
			'adplugg_amp_general_settings',
			'adplugg_amp_general_section'
		);

		// ------------- AMP STYLE SETTINGS ------------ //
		add_settings_section(
			'adplugg_amp_style_section',
			'Style Settings',
			array( &$this, 'render_amp_style_section_text' ),
			'adplugg_amp_style_settings'
		);
		add_settings_field(
			'amp_style_enable_centering',
			'Center',
			array( &$this, 'render_amp_enable_centering_field' ),
			'adplugg_amp_style_settings',
			'adplugg_amp_style_section'
		);

	}

	/**
	 * Function to render the AdPlugg AMP options page.
	 */
	public function render_page() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
			<h2>AMP Settings - AdPlugg</h2>
			<h2>Help</h2>
			<p>
				To have AdPlugg ads automatically inserted into your AMP pages, do
				the following:
			</p>
			<ol>
				<li>
					Ensure that you have the
					<a href="https://wordpress.org/plugins/amp/"
						title="Get the AMP plugin" target="_blank">
						AMP</a> plugin installed.
				</li>
				<li>
					Enable automatic placement by clicking the checkbox below.
				</li>
				<li>
					Go to the <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"
					title="Widgets configuration page">Widgets Configuration Page</a>
					and drag the AdPlugg Widget into the Widget Area entitled
					"AMP Ads" (note you can add multiple widgets if desired).
				</li>
			</ol>
			<p>
				See the <a href="#"
					onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Get help using this plugin.">help</a>
					above for more info.
			</p>
			<?php settings_errors(); ?>
			<form action="options.php" method="post">
				<?php settings_fields( 'adplugg_amp_options' ); ?>
				<?php do_settings_sections( 'adplugg_amp_general_settings' ); ?>
				<?php do_settings_sections( 'adplugg_amp_style_settings' ); ?>
				<p class="submit">
					<input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'adplugg' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Function to render the text for the general settings section.
	 */
	public function render_amp_general_section_text() {
		// Do nothing (for now).
	}

	/**
	 * Function to render the automatic placement field and description.
	 */
	public function render_amp_enable_automatic_placement_field() {
		$options = get_option( ADPLUGG_AMP_OPTIONS_NAME, array() );
		$checked = ( array_key_exists( 'amp_enable_automatic_placement', $options ) ) ? $options['amp_enable_automatic_placement'] : 0;
		?>
		<label for="adplugg_amp_enable_automatic_placement">
			<input type="checkbox" id="adplugg_amp_enable_automatic_placement" name="adplugg_amp_options[amp_enable_automatic_placement]" value="1" <?php echo checked( 1, $checked, false ); ?> />
			Enable automatic placement of ads within my AMP pages.
		</label>
		<?php
	}

	/**
	 * Function to render the ad density field and description.
	 */
	public function render_amp_ad_density_field() {
		$options    = get_option( ADPLUGG_AMP_OPTIONS_NAME, array() );
		$ad_density = ( array_key_exists( 'amp_ad_density', $options ) ) ? $options['amp_ad_density'] : 250;
		?>
		<select name="adplugg_amp_options[amp_ad_density]" id="adplugg_amp_ad_density">
			<option label="High - Every 250 words (default)" value="250" <?php echo ( 250 === $ad_density ) ? 'selected' : ''; ?>>High - Every 250 words (default)</option>
			<option label="Medium - Every 350 words" value="350" <?php echo ( 350 === $ad_density ) ? 'selected' : ''; ?>>Medium - Every 350 words</option>
			<option label="Low - Every 500 words" value="500" <?php echo ( 500 === $ad_density ) ? 'selected' : ''; ?>>Low - Every 500 words</option>
		</select>
		<p>
			The ad density is how many words appear in between ads.
		</p>
		<?php
	}

	/**
	 * Function to render the text for the style settings section.
	 */
	public function render_amp_style_section_text() {
		?>
		<p>
			These settings control how your ads will display on the AMP pages.
		</p>
		<?php
	}

	/**
	 * Function to render the enable centering field and description.
	 */
	public function render_amp_enable_centering_field() {
		$options = get_option( ADPLUGG_AMP_OPTIONS_NAME, array() );
		$checked = ( array_key_exists( 'amp_enable_centering', $options ) ) ? $options['amp_enable_centering'] : 0;
		?>
		<label for="adplugg_amp_enable_centering">
			<input type="checkbox" id="adplugg_amp_enable_centering" name="adplugg_amp_options[amp_enable_centering]" value="1" <?php echo checked( 1, $checked, false ); ?> />
			Center the ads within my AMP pages.
		</label>
		<?php
	}



	/**
	 * Function to validate the submitted AdPlugg AMP options field values.
	 *
	 * This function overwrites the old values instead of completely replacing
	 * them so that we don't overwrite values that weren't submitted.
	 *
	 * @param array $input The submitted values.
	 * @return array Returns the new options to be stored in the database.
	 */
	public function validate( $input ) {
		$old_options = get_option( ADPLUGG_AMP_OPTIONS_NAME );
		$new_options = $old_options;  // Start with the old options.

		$has_errors  = false;
		$msg_type    = null;
		$msg_message = null;

		// --- process the new values ----
		// amp_enable_automatic_placement.
		$new_options['amp_enable_automatic_placement'] = ( isset( $input['amp_enable_automatic_placement'] ) ) ? intval( $input['amp_enable_automatic_placement'] ) : 0;
		if ( ! preg_match( '/^[01]$/', $new_options['amp_enable_automatic_placement'] ) ) {
			$has_errors                                    = true;
			$msg_message                                   = 'Invalid Enable Automatic Placement option.';
			$new_options['amp_enable_automatic_placement'] = 0;
		}

		// amp_ad_density.
		$new_options['amp_ad_density'] = intval( $input['amp_ad_density'] );
		if ( ! preg_match( '/^[\d]{3}$/', $new_options['amp_ad_density'] ) ) {
			$has_errors                    = true;
			$msg_message                   = 'Invalid Ad Density option.';
			$new_options['amp_ad_density'] = 250;
		}

		// amp_center.
		$new_options['amp_enable_centering'] = ( isset( $input['amp_enable_centering'] ) ) ? intval( $input['amp_enable_centering'] ) : 0;
		if ( ! preg_match( '/^[01]$/', $new_options['amp_enable_centering'] ) ) {
			$has_errors                          = true;
			$msg_message                         = 'Invalid input for Center field.';
			$new_options['amp_enable_centering'] = 0;
		}

		// --- add a message --- //
		if ( $has_errors ) {
			$msg_type = 'error';

			add_settings_error(
				'AdPluggAMPOptionsSaveMessage',
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
	 * @return \AdPlugg_AMP_Options_Page Returns the singleton instance of this
	 * class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
