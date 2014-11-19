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
        add_action('admin_menu', array( &$this, 'adplugg_add_options_page_to_menu' ));
        add_action('admin_init', array( &$this, 'adplugg_options_init' ));
    }
    
    
    /**
     * Function to render the AdPlugg options page.
     */
    function adplugg_options_render_page() {
    ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"><br /></div><h2>AdPlugg Settings</h2>
            <form action="options.php" method="post">
                <?php settings_fields('adplugg_options'); ?>
                <?php do_settings_sections('adplugg'); ?>

                <p class="submit">
                    <input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                </p>
            </form>
            <?php if(adplugg_is_access_code_installed()) { ?>
                <br/>
                <ul>
                    <li>Manage my ads at <a href="https://www.adplugg.com/apusers/login" target="_blank">adplugg.com</a>.</li>
                    <li>Place the AdPlugg Widget on my site from the <a href="<?php echo admin_url( 'widgets.php' )?>">WordPress Widgets Configuration Page</a>.</li>
                    <li>Get <a href="#" onclick="jQuery('a#contextual-help-link').trigger('click');">help</a> using this plugin.</li>
                </ul>
            <?php } //end if ?>
        </div>
    <?php
    }

    /**
     * Function to add the options page to the settings menu.
     */
    function adplugg_add_options_page_to_menu() {
        global $adplugg_hook;
        $adplugg_hook = add_options_page('AdPlugg Settings', 'AdPlugg', 'manage_options', 'adplugg', array( &$this, 'adplugg_options_render_page') );
    }

    /**
     * Function to render the text for the access section.
     */
    function adplugg_options_render_access_section_text() {
    ?>
        <p>
            To use AdPlugg, you will need an AdPlugg Access Code.  To get
            your AdPlugg Access Code, log in or register (it's free) at 
            <a href="http://www.adplugg.com" target="_blank">adplugg.com</a>.
        </p>
    <?php
    }

    /**
     * Function to render the access code field and description
     */
    function adplugg_options_render_access_code() {
        $options = get_option(ADPLUGG_OPTIONS_NAME, array());
        $access_code = (array_key_exists('access_code', $options)) ? $options['access_code'] : "";
     ?>
        <input id="adplugg_access_code" name="adplugg_options[access_code]" size="5" type="text" value="<?php echo $access_code ?>" />
        <p class="description">
            You must enter a valid AdPlugg Access Code here. If you need an
            Access Code, you can create one
            <a href="https://www.adplugg.com/apusers/signup" target="_blank">here</a>.
        </p>
    <?php
    }
    
    /**
     * Function to initialize the AdPlugg options page.
     */
    function adplugg_options_init() {
        register_setting('adplugg_options', ADPLUGG_OPTIONS_NAME, array( &$this, 'adplugg_options_validate' ) );
        add_settings_section(
                'adplugg_options_access_section',
                'Access Settings',
                array( &$this,'adplugg_options_render_access_section_text'),
                'adplugg'
        );
        add_settings_field(
                'access_code', 
                'Access Code', 
                array(&$this, 'adplugg_options_render_access_code'),
                'adplugg', 
                'adplugg_options_access_section'
        );
    }

    /**
     * Function to validate the submitted AdPlugg options field values. 
     * 
     * This function overrites the old values instead of completely replacing them so
     * that we don't overwrite values that weren't submitted (such as the 
     * version).
     * @param array $input The submitted values
     * @return array Returns the new options to be stored in the database.
     */
    function adplugg_options_validate($input) {
        $old_options = get_option(ADPLUGG_OPTIONS_NAME);
        $new_options = $old_options;  //start with the old options.
        
        $msg_type = null;
        $msg_message = null;
        
        //process the new values
        $new_options['access_code'] = trim($input['access_code']);
        if(!preg_match('/^[a-z0-9]*$/i', $new_options['access_code'])) {
            $msg_type = 'error';
            $msg_message = 'Please enter a valid Access Code.';
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