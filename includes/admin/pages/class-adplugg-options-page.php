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
        
        $icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBmaWxsPSIjODI4NzhjIj48cGF0aCBkPSJNNTA4LjggMTA5Yy00Ni4yLTMxLjItNDIuOS03Ny4xLTYzLjUtODAuMS0xOC41LTIuOC0zNi40IDEwLjktNDUuNiAxOS4yLTIyLTEwLjYtNDkuMi0xOC04MC4xLTIxLjMtMjkuNi0zLjMtNTcuMS0yLjMtODAuOSAyLjYtNy0xMC4zLTIxLjQtMjcuNi00MC40LTI5LjMtMjAuNy0xLjktMjcuNSA0My43LTc5LjMgNjMuNy0xMS41IDQuNiA0LjMgMjIuNyAzMS4yIDI2LjMtNS41IDcuMy05LjIgMTUuNS0xMC40IDI0LjItMS4yIDExLjkgMi42IDI0LjMgOS40IDM0LjguOSA4LjIgMi42IDE2LjUgNSAyNC42LTI0LjUgNS42LTQ4LjkgMTMuMi02OS4xIDI0LjctNS41LTIuMi0xMC42LTQuNi0xNC02LjYtOC44LTUuNS0xNy4zLTE0LjUtMTcuNC0yNS44LS4xLTIxLjMgMzAuMS0zMC45IDM2LjQtOC4yIDIuMiA3LjUgMy41IDE5LjEgMTQgMTAuNCA3LjUtNiAxMC41LTE2LjQgOC4yLTI1LjgtMTAuMS0zOS45LTY3LjYtNDAuNy04OC44LTEyLjktMjQuNSAzMi4xLTcuOSA4MC42IDMyLjIgOTMuNC0xMy44IDE2LjctMjAuOSAzNy40LTIyLjkgNjIuNC0xLjQgMTYuOC0xIDM1LjUtOC42IDUwLjktMy45IDcuOC0xMC4yIDEzLjQtMTUuMSAyMC4zLTUuNSA3LjYtNi41IDE3LjgtNy41IDI2LjktMi4yIDE3LjQtMi43IDM2LjcgMiA1NCA0LjUgMTYuMSAxNy40IDIyLjcgMzMuMSAyNC45IDExLjkgMS43IDI5LjQtMS45IDMxLjctMTYuNS45LTUuOS0xLjQtMTIuMS00LjktMTYuOC0xLjktMi40LTQuMy00LjYtNi45LTYtMS42LTUuMi0yLjItMTAuNi0yLjYtMTYuMS0uNi03LjEtLjYtMTQuMiAxLjctMjEgNy4yLTEuNyAxNC4yLTMuNiAyMS4yLTYuMi40LS4xLjktLjMgMS40LS42IDIuOSAxNC44IDcuMyAzMC4yIDE1LjQgNDEuNyA3LjkgMTEuNCAyNC45IDEyLjkgMzcuNCAxMC44IDEyLjctMiAyMi45LTEyLjQgMTMuNS0yNS4yLTIuOS00LjItMTEuNC02LjYtMTMuMi0xMC40LTIuOS03LjktNS4yLTE2LjUtNC43LTI1LjIuNi0yIDkuOC03LjggMTIuOC0xMC41IDMuNi0zLjIgNy4xLTYuOSAxMC4xLTEwLjYgMTEuNSA1LjIgMjUuNSAxMS4yIDM3LjMgMTYuMS0uMSA3LjEuMSAxMi41LjEgMTQuMSAxLjkgMjIuNyA3LjEgNDUuNSAxNS41IDY2LjYgNy4zIDE4LjEgMTYuMSA0MS42IDMzLjIgNTEuOSAxMy43IDguMyA0MS40IDkuMSA0OS4yLTguNiA2LjYtMTUuMy0xMS44LTMxLjEtMjMuMy0zNy01LTIwLjctNS4zLTQzLjMtMy02NC41LjEtMi4zLjQtNC41LjctNi4yIDE4LjYuNCAzNy4xLTIuNiA1Ni0xMC41IDYuMy0yLjcgMTIuOS01LjkgMTkuMS05LjYuMyAyIC43IDMuOSAxLjIgNS45IDEuOSAxMC4xIDMgMjAgMy4zIDMwLjIuMSAxMC40LTIuNCAyMC0yLjcgMzAuMi0uNyA0Ni44IDg2IDI0LjkgNDcuNS0xMi44LTcuOS03LjgtMS0yOC4zLjctMzcuNiA0LjMtMjEuNyA5LjEtNDMuMyAxMC40LTY1LjMuMS0zLjkuNi0xMi44IDAtMjIuMiAyLjQtMTAuOSAyLjctMjIuMyAxLjktMzMuNyAzMi43LTE2LjQgNTAuOS00NC4yIDYwLTc0LjggOC44LTguNSAxNC44LTE5LjMgMTYuMS0zMS4xLjctOC4xLS45LTE2LjQtNC42LTI0LjMgMjkuNCA1LjQgNTEuNy0xMCA0MC42LTE3LjV6TTU2LjcgNDIzLjdjLS4xLS42IDAtLjIgMCAweiIvPjwvc3ZnPg==';
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
                    <li>Manage my ads at <a href="https://www.adplugg.com/apusers/login?utm_source=wpplugin&utm_campaign=opts-l1" target="_blank" title="Manage my ads at adplugg.com">adplugg.com</a>.</li>
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
            <a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=opts-l2" target="_blank" title="adplugg.com">
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
            <a href="https://www.adplugg.com/apusers/signup?utm_source=wpplugin&utm_campaign=opts-l2" target="_blank" title="AdPlugg Signup">here</a>.
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