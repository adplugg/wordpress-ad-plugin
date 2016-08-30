<?php

/**
 * AdPlugg Admin class.
 * The AdPlugg Admin class sets up and controls the AdPlugg Plugin administrator
 * interace.
 *
 * @package AdPlugg
 * @since 1.0
 */
class AdPlugg_Admin {
    
    /**
     * Constructor, constructs the class and registers filters and actions.
     */
    function __construct() {
        add_filter( 'plugin_action_links_' . ADPLUGG_BASENAME, array( &$this, 'add_settings_link_to_plugin_listing' ) );
        add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
        
        add_action( 'admin_init', array( &$this, 'admin_init' ) );
        add_action( 'wp_ajax_adplugg_rated', array( &$this, 'rated_callback' ) );
    }
    
    /**
     * Add settings link on plugin page listing.
     * @param array $links An array of existing links for the plugin
     * @return array The new array of links
     */
    function add_settings_link_to_plugin_listing( $links ) { 
        $settings_link = '<a href="admin.php?page=adplugg">Settings</a>'; 
        array_unshift( $links, $settings_link ); 
        return $links;
    }

    /**
     * Init the adplugg admin
     */
    function admin_init() {
        $options = get_option( ADPLUGG_OPTIONS_NAME, array() );
        $data_version = ( array_key_exists( 'version', $options ) ) ? $options['version'] : null;
        if ( $data_version != ADPLUGG_VERSION ) {
            $options['version'] = ADPLUGG_VERSION;
            update_option( ADPLUGG_OPTIONS_NAME, $options );
            if ( ! is_null( $data_version ) ) {  //skip if not an upgrade
                //do any necessary version data upgrades here
                $upgrade_notice = AdPlugg_Notice::create( 'notify_upgrade', 'Upgraded version from ' . $data_version . ' to ' . ADPLUGG_VERSION . '.' );
                adplugg_notice_add_to_queue( $upgrade_notice );
            }
        }
        
        //Add the AdPlugg admin stylesheet to the WP admin head
        wp_register_style( 'adPluggAdminStylesheet', plugins_url( '../css/admin.css', __FILE__ ) );
        wp_enqueue_style( 'adPluggAdminStylesheet' );
        
        //Add the AdPlugg admin JavaScript page to the WP admin head
        wp_register_script( 'adPluggAdminJavaScriptPage', plugins_url( '../js/admin.js', __FILE__ ) );
        wp_enqueue_script( 'adPluggAdminJavaScriptPage' );
    }
    
    /**
     * Change the admin footer text on AdPlugg admin pages.
     *
     * @param  string $footer_text
     * @return string
     */
    public function admin_footer_text( $footer_text ) {
        $screen = get_current_screen();
        $screen_id = ( ! empty( $screen ) ? $screen->id : null );

        // only do on the adplugg settings page and if the user has already added an access code.
        if ( ( $screen_id == 'settings_page_adplugg' ) && ( adplugg_is_access_code_installed() ) ) {
            //if not already clicked/rated
            if ( ! get_option( ADPLUGG_RATED_NAME ) ) {
                
                //NOTE: the click action for the link is defined in admin.js
                $footer_text = 'If you like <strong>AdPlugg</strong>, please leave us a ' .
                                '<a ' .
                                  'href="https://wordpress.org/support/view/plugin-reviews/adplugg?filter=5#postform" ' .
                                  'target="_blank" class="adplugg-rating-link" data-rated="Thanks :)">' . 
                                    '&#9733;&#9733;&#9733;&#9733;&#9733;' . 
                                '</a> rating. A huge thank you in advance from the AdPlugg Team!';
            } else {
                //show when rating link already clicked
                $footer_text = 'Thank you for using AdPlugg.';
            }
        }

        return $footer_text;
    }
    
    /**
     * Called via ajax to when the rate link is clicked.
     */
    function rated_callback() {
        update_option( ADPLUGG_RATED_NAME, 1 );
	wp_die(); //terminate immediately and return a proper response
    }
    
    /**
     * Called when the plugin is activated.
     */
    static function activate() {
        //
    }

    /**
     * Called when the plugin is deactivated.
     */
    static function deactivate() {
        //
    }
    
    /**
     * Called when plugin is uninstalled.
     */
    static function uninstall() {
        delete_option( ADPLUGG_OPTIONS_NAME );
        delete_option( ADPLUGG_FACEBOOK_OPTIONS_NAME );
        delete_option( ADPLUGG_NOTICES_NAME );
        delete_option( ADPLUGG_NOTICES_DISMISSED_NAME );
        delete_option( ADPLUGG_WIDGET_OPTIONS_NAME );
    }

}

