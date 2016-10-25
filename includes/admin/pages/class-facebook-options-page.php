<?php

/**
 * Class for rendering the AdPlugg Facebook Options/Settings page within the WordPress
 * Administrator.
 * @package AdPlugg
 * @since 1.3.0
 */
class AdPlugg_Facebook_Options_Page {
    
    // class instance
    static $instance;
    
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
        
        $screen = get_current_screen();
        $screen_id = ( ! empty( $screen ) ? $screen->id : null );

        if( $screen_id == 'adplugg_page_adplugg_facebook_settings' ) {
            //Show notice if fb-instant-articles plugin isn't found.
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
            array( &$this,'render_facebook_instant_articles_section_text' ),
            'adplugg_facebook_instant_articles_settings'
        );
        add_settings_field(
            'ia_enable_automatic_placement',
            'Automatic Placement',
            array( &$this, 'render_ia_enable_automatic_placement_field' ),
            'adplugg_facebook_instant_articles_settings', 
            'adplugg_facebook_instant_articles_section'
        );
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
                    <input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                </p>
            </form>
        </div>
    <?php
    }
    
    /**
     * Function to render the text for the access section.
     */
    function render_facebook_instant_articles_section_text() {
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
                Go to the <a href="<?php echo admin_url( 'widgets.php' ); ?>" 
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
    function render_ia_enable_automatic_placement_field() {
        $options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
        $enable_automatic_placement = ( array_key_exists( 'ia_enable_automatic_placement', $options ) ) ? $options['ia_enable_automatic_placement'] : 0;
     ?>
        <label for="adplugg_facebook_ia_enable_automatic_placement">
            <input type="checkbox" id="adplugg_facebook_ia_enable_automatic_placement" name="adplugg_facebook_options[ia_enable_automatic_placement]" value="1" <?php echo checked( 1, $enable_automatic_placement, false ) ?> />
            Enable automatic placement of ads within your posts.
        </label>
    <?php
    }

    /**
     * Function to validate the submitted AdPlugg Facebook options field values. 
     * 
     * This function overwrites the old values instead of completely replacing 
     * them so that we don't overwrite values that weren't submitted (such as 
     * the version).
     * @param array $input The submitted values
     * @return array Returns the new options to be stored in the database.
     */
    function validate( $input ) {
        $old_options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME );
        $new_options = $old_options;  //start with the old options.
        
        $msg_type = null;
        $msg_message = null;
        
        //process the new values
        $new_options['ia_enable_automatic_placement'] = intval( $input['ia_enable_automatic_placement'] );
        if( ! preg_match('/^[01]$/', $new_options['ia_enable_automatic_placement'] ) ) {
            $msg_type = 'error';
            $msg_message = 'Invalid Enable Automatic Placement option.';
            $new_options['ia_enable_automatic_placement'] = 0;
        } else {
            $msg_type = 'updated';
            $msg_message = 'Settings saved.';
        }
        
        add_settings_error(
            'AdPluggFacebookOptionsSaveMessage',
            esc_attr('settings_updated'),
            $msg_message,
            $msg_type
        );
        
        return $new_options;
    }
    
    /*
     * Singleton instance 
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}