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
     * Function to initialize the AdPlugg Facebook Options page.
     */
    public function admin_init() {
        
        register_setting( 'adplugg_facebook_options', ADPLUGG_FACEBOOK_OPTIONS_NAME, array( &$this, 'validate' ) );
        
        add_settings_section(
            'adplugg_facebook_instant_articles_section',
            'Instant Articles Settings',
            array( &$this,'render_facebook_instant_articles_section_text' ),
            'adplugg_facebook_instant_articles_settings'
        );
        add_settings_field(
            'zones',
            'Zones',
            array( &$this, 'render_zones_field' ),
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
                <br/>
                <ul>
                    <li>Manage my Ads and Zones at <a href="https://www.adplugg.com/apusers/login" target="_blank" title="Manage my Ads and Zones at adplugg.com">adplugg.com</a>.</li>
                    <li>Get <a href="#" onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Get help using this feature.">help</a> using AdPlugg's Facebook Instant Articles feature.</li>
                </ul>
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
            Configure which AdPlugg Ad Zones will be automatically included in your 
            Facebook Instant Articles. See the <a href="#" onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Get help using this plugin.">help</a>
            above for more info.
        </p>
    <?php
    }
    
    /**
     * Function to render the access code field and description
     */
    function render_zones_field() {
        $options = get_option( ADPLUGG_FACEBOOK_OPTIONS_NAME, array() );
        $zones = ( array_key_exists( 'zones', $options ) ) ? $options['zones'] : '';
     ?>
        <input id="adplugg_zones" name="adplugg_facebook_options[zones]" size="60" type="text" value="<?php echo $zones; ?>" />
        <p class="description">
            Enter the machine names of the Zones that you want to have 
            automatically placed within your Instant Articles. Leave blank for
            none. Add an asterisk to the end of the default zone
            (ex: fb_zone1, fb_zone2*, fb_zone3). See the <a href="#" onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Get help using this plugin.">help</a> 
            for more info.
        </p>
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
        $new_options['zones'] = trim( $input['zones'] );
        if ( ! preg_match( '/^[a-z0-9\_\,\*\s]*$/i', $new_options['zones'] ) ) {
            $msg_type = 'error';
            $msg_message = 'Please enter a valid list of Zones.';
            $new_options['zones'] = '';
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