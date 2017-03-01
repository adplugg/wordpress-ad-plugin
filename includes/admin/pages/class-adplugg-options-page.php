<?php

/**
 * Class for rendering the AdPlugg Options/Settings page within the WordPress
 * Administrator.
 * @package AdPlugg
 * @since 1.0
 */
class AdPlugg_Options_Page {
    
    /**
     * Constructor, constructs the options page and adds it to the Settings
     * menu.
     */
    function __construct() {
        add_action( 'admin_menu', array( &$this, 'add_to_menu' ) );
        add_action( 'admin_init', array( &$this, 'admin_init' ) );
    }
    
    /**
     * Function to add the options page to the settings menu.
     */
    function add_to_menu() {
        global $adplugg_hook;
        $adplugg_hook = 'adplugg';
        
        $icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA3MjAgNzIwIj48cGF0aCBmaWxsPSIjMDAwMDAwIiBkPSJNNTQ1LjkgNDQxLjljLjctMTMuMyAyLjgtNjcuMS0xNi4zLTY5LjMtOS42LTEuMS0yMy4yIDIxLTI5IDI3LjQtMTEuOCAxMy4yLTIzLjcgMjYuNC0zNS41IDM5LjYtMTEuOSAxMy4zLTEyLjcgMTQuMi03LjUgMzEuNiA0LjMgMTQuMSA3LjcgMjguNiAxMC40IDQzLjEgMi40IDEzLjEgNC4xIDI2LjQgNC40IDM5LjguMyAxMy41LTMuMyAyNi40LTMuNSAzOS44LS45IDYxLjYgMTEzLjIgMzIuNyA2Mi41LTE2LjctMTAuNS0xMC4yLTEuNC0zNy40IDEtNDkuNCA1LjYtMjguNSAxMi01Ni45IDEzLjUtODUuOXptLTMxNC40LTE5LjZjLTUxLjgtMTEuMS0xMTQuNiAyMS4yLTEwNi4yIDgxLjcgMy42IDI1LjcgOC44IDU3LjYgMjQgNzkuMyAxMC41IDE1IDMyLjggMTYuOSA0OS4zIDE0LjMgMTYuNi0yLjYgMzAuMS0xNi4yIDE3LjktMzMuMi0zLjktNS40LTE1LTguNy0xNy40LTEzLjYtMy45LTEwLjUtNi45LTIxLjgtNi4yLTMzLjEuNy0yLjYgMTIuOC0xMC4zIDE2LjctMTMuOCA5LjEtOC4yIDE2LjgtMTcuOSAyMy4yLTI4LjQgNi40LTEwLjUgMTEuNS0yMS45IDE1LTMzLjggNC4yLTE0LjMtNC4yLTE2LjgtMTYuMy0xOS40em0tMzguMSA5My40YzAgLjIgMCAuMiAwIDB6bS4yLS40czAtLjEuMS0uMWMtLjEgMC0uMSAwLS4xLjF6bS0xOS4yLTI5OC42Yy0xMy4yLTUyLjItODkuMS01My40LTExNi45LTE2LjgtMzMuOCA0NC41LTcuOCAxMTIuOSA1MS4zIDEyNS4zIDkuNiAyIDIzLjIgNSAzMi45IDEuOCA3LjYtMi41IDIyLjMtMjYuNyAxNC0yOS43LTExLjEtNC0yNy4xLTEwLjEtMzUuMy0xNS4zLTExLjYtNy4zLTIyLjgtMTkuMi0yMy0zNC0uMi0yOC4xIDM5LjYtNDAuOSA0Ny45LTEwLjggMi43IDkuOSA0LjYgMjUuMiAxOC40IDEzLjYgOS44LTggMTMuOC0yMS43IDEwLjctMzQuMXoiLz48cGF0aCBmaWxsPSIjMDAwMDAwIiBkPSJNNTM3LjggMzEyLjZjLTExLjEtNDAuNS01NS4zLTc1LjYtOTUuNy04MC41LTQ4LjktNS44LTEwMi44IDUuNy0xNTAuOSAxNC4yQzI0MS43IDI1NSAxODAuOSAyNjYgMTM2LjggMjkyYy00My4zIDI1LjYtNjIuNyA2Mi42LTY3IDExMy4xLTEuOSAyMi4yLTEuNCA0Ni43LTExLjUgNjctNS4xIDEwLjMtMTMuNCAxNy41LTE5LjkgMjYuNy03LjEgMTAtOC41IDIzLjMtOS45IDM1LjMtMi45IDIzLjEtMy42IDQ4LjUgMi42IDcxLjEgNS44IDIxLjMgMjMgMjkuOSA0My41IDMyLjggMTUuOCAyLjIgMzguNy0yLjQgNDEuNS0yMS44IDEuMi03LjktMS43LTE2LjEtNi41LTIyLjMtMi41LTMuMi01LjYtNi05LTgtMi02LjktMi45LTE0LjEtMy40LTIxLjItLjctOS4yLS45LTE4LjggMi4zLTI3LjYgOS40LTIuMiAxOC43LTQuOCAyNy45LTguMSAxOS42LTYuOSAzOC43LTE2LjggNTMuMy0zMiA1LjYtNS44IDEwLjQtMTIuNCAxNC4zLTE5LjYgMTEuMiA1IDc5IDM2LjEgMTAyLjUgNDMuMSA0OS4yIDE0LjcgOTUuNSAxOC44IDE0My43LTEuNiAzNy0xNS43IDc1LjQtNDIuOSA5NS4xLTc5LjUgMjAuNS0zOC41IDEyLjYtODYuMyAxLjUtMTI2Ljh6TTEwMSA1ODcuNWMtLjMtLjkgMC0uMiAwIDB6Ii8+PHBhdGggZmlsbD0iIzAwMDAwMCIgZD0iTTM3MC42IDYyNS44Yy02LjYtMjcuMi02LjktNTctMy45LTg0LjcgMS42LTE0LjggMS44LTIyLjEgNS45LTM2LjMgNC4zLTE1LjItMy4yLTE2LjUtMTAtMTUuMy0yNCA0LjMtNTUuNS04LjktNzIuMS0yNS42LTIwLjQtMjAuNS0xOSA1Ny44LTE4LjQgNjUuNiAyLjUgMzAuMSA5LjMgNTkuNyAyMC41IDg3LjggOS41IDIzLjcgMjEuMyA1NC43IDQzLjggNjguNSAxOC4xIDExLjEgNTQuNiAxMi4xIDY0LjgtMTEuNCA4LjctMjAtMTUuNS00MS0zMC42LTQ4LjZ6bS0yNC01NDhzLTIzLjgtNDUuMy01OS4yLTQ4LjNjLTI3LjMtMi4zLTM2LjIgNTcuNi0xMDQuNCA4NC4xLTI5LjggMTEuNiA3Ni44IDkxLjcgMTYzLjYtMzUuOHpNNTQ0LjUgMTAxczMzLjEtMzguOCA2OC4yLTMzLjdjMjcuMSA0IDIyLjcgNjQuNCA4My41IDEwNS43IDI2LjYgMTguMi05NC45IDcyLTE1MS43LTcyeiIvPjxwYXRoIGZpbGw9IiMwMDAwMDAiIGQ9Ik02MzYgMjI1LjFjOS4zLTg4LjctNjctMTQ3LjEtMTg4LjktMTYwLjUtMTIxLjktMTMuNC0yMTQuNyAyNi41LTIyNCAxMTUuMi05LjMgODguNyAzMy4xIDE4OC44IDE5MC40IDIwNi4xIDE2MS45IDE3LjcgMjEzLjItNzIuMSAyMjIuNS0xNjAuOHoiLz48cGF0aCBmaWxsPSIjMDAwMDAwIiBkPSJNNTA2LjUgMjEyLjFjLTMuOCAzNi41IDI3IDc1LjUgNjIuNyA3OS41IDM1LjggMy45IDc1LjQtMjYuMiA3OS4zLTYyLjggMy44LTM2LjUtMzIuOC03Ny4zLTY4LjYtODEuMi0zNS43LTQtNjkuNSAyNy45LTczLjQgNjQuNXpNMzU3LjggMTk1Yy00IDM3LjgtNDMuNSA3MC4yLTgwLjUgNjYuMi0zNy00LjEtNzAuNS00My40LTY2LjYtODEuMSA0LTM3LjggNDkuNy03MC43IDg2LjctNjYuNyAzNy4xIDQgNjQuNCA0My44IDYwLjQgODEuNnoiLz48L3N2Zz4=';
        add_menu_page( 'AdPlugg Settings', 'AdPlugg', 'manage_options', $adplugg_hook, array( &$this, 'render_page' ), $icon, '55.2' );
        add_submenu_page( $adplugg_hook, 'General', 'General', 'manage_options', $adplugg_hook );
    }
    
    /**
     * Function to render the AdPlugg options page.
     */
    function render_page() {
    ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"><br /></div><h2>AdPlugg General Settings</h2>
            <?php settings_errors(); ?>
            <form action="options.php" method="post">
                <?php settings_fields( 'adplugg_options' ); ?>
                <?php do_settings_sections( 'adplugg' ); ?>

                <p class="submit">
                    <input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
                </p>
            </form>
            <br/>
            <ul>
                <?php if ( adplugg_is_access_code_installed() ) { ?>
                    <li>Manage my ads at <a href="https://www.adplugg.com/apusers/login" target="_blank" title="Manage my ads at adplugg.com">adplugg.com</a>.</li>
                    <li>Place the AdPlugg Widget on my site from the <a href="<?php echo admin_url( 'widgets.php' ); ?>" title="Go to the Widgets Configuration Page.">WordPress Widgets Configuration Page</a>.</li>
                <?php } //end if ?>
            </ul>
            <hr/>
            <h3>Help</h3>
            <?php if ( ! adplugg_is_access_code_installed() ) { ?>
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
    function render_access_section_text() {
    ?>
        <p>
            AdPlugg is an online service for managing and serving ads to your
            website.
        </p>
        <p>
            To use AdPlugg, you will need an AdPlugg Access Code.  To get
            your AdPlugg Access Code, log in or register (it's free) at 
            <a href="https://www.adplugg.com" target="_blank" title="adplugg.com">
                adplugg.com</a>.
        </p>
    <?php 
    }

    /**
     * Function to render the access code field and description
     */
    function render_access_code() {
        $options = get_option( ADPLUGG_OPTIONS_NAME, array() );
        $access_code = ( array_key_exists( 'access_code', $options ) ) ? $options['access_code'] : '';
     ?>
        <input id="adplugg_access_code" name="adplugg_options[access_code]" size="9" type="text" value="<?php echo $access_code; ?>" />
        <p class="description">
            You must enter a valid AdPlugg Access Code here. If you need an
            Access Code, you can create one
            <a href="https://www.adplugg.com/apusers/signup" target="_blank" title="AdPlugg Signup">here</a>.
            <?php if ( ! adplugg_is_access_code_installed() ) { ?>
                <br/>
                <a href="#" onclick="
                    jQuery( '#contextual-help-link' ).trigger( 'click' );
                    jQuery( '#tab-link-adplugg_faq>a' ).trigger( 'click' ); 
                    return false;
                " title="Why do I need an access code?">Why do I need an access code?</a>
            <?php } //end if?>
        </p>
    <?php
    }
    
    /**
     * Function to initialize the AdPlugg options page.
     */
    function admin_init() {
        register_setting( 'adplugg_options', ADPLUGG_OPTIONS_NAME, array( &$this, 'validate' ) );
        add_settings_section(
            'adplugg_options_access_section',
            'Access Settings',
            array( &$this,'render_access_section_text' ),
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
     * @param array $input The submitted values
     * @return array Returns the new options to be stored in the database.
     */
    function validate( $input ) {
        $old_options = get_option( ADPLUGG_OPTIONS_NAME );
        $new_options = $old_options;  //start with the old options.
        
        $msg_type = null;
        $msg_message = null;
        
        //process the new values
        $new_options['access_code'] = trim( $input['access_code'] );
        if ( ! preg_match( '/^[a-z0-9]*$/i', $new_options['access_code'] ) ) {
            $msg_type = 'error';
            $msg_message = 'Please enter a valid Access Code.';
            $new_options['access_code'] = '';
        } else {
            $msg_type = 'updated';
            $msg_message = 'Settings saved.';
        }
        
        add_settings_error(
            'AdPluggOptionsSaveMessage',
            esc_attr('settings_updated'),
            $msg_message,
            $msg_type
        );
        
        return $new_options;
    }
}