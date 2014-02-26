<?php
/**
 * Class for rendering the AdPlugg Options/Settings page within the WordPress
 * Administrator.
 * @package AdPlugg
 * @since 1.0
 */

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
                Manage my ads at <a href="https://www.adplugg.com/apusers/login" target="_blank">adplugg.com</a>.<br/><br/>
                Place the AdPlugg Widget on the <a href="options-general.php?page=widget.php">WordPress Widgets Configuration Page</a><br/>
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
            To use AdPlugg you will need an AdPlugg Access Code.  To get
            your AdPlugg Access Code, log in or register (it's free) at 
            <a href="http://www.adplugg.com" target="_blank">
                www.adplugg.com
            </a>
        </p>
    <?php
    }

    /**
     * Function to render the access code field and description
     */
    function adplugg_options_render_access_code() {
        $options = get_option(ADPLUGG_OPTIONS_NAME);
     ?>
        <input id="adplugg_access_code" name="adplugg_options[access_code]" size="5" type="text" value="<?php echo $options['access_code'] ?>" />
        <p class="description">
            You must enter a valid AdPlugg Access Code here. If you need an
            Access Code, you can create one
            <a href="http://www.adplugg.com/apusers/signup" target="_blank">here</a>.
        </p>
    <?php
    }
    
    function adplugg_help($contextual_help, $screen_id, $screen) {
	global $adplugg_hook;
	if ($screen_id == $adplugg_hook) { 
            $overview_content = '
            <h1>AdPlugg Plugin Help</h1>
            <p>Need help using the adplugg plugin? Use the tabs to the left
               to find instructions for installation, use and troubleshooting.
            </p>';
            $installation_content = '
            <h2>Installation/Configuration</h2>
            <p>
                The AdPlugg WordPress Ad Plugin makes it super easy
                to put ads on your WordPress Site.
            </p>
            <ol>
                <li>Install the plugin.</li>
                <li>Activate the plugin.</li>
                <li>Create an account at <a href="http://www.adplugg.com">adplugg.com</a>.</li>
                <li>Get your AdPlugg Access Code and add it to the Access Code field on this page.</li>
                <li>Go to your widgets page and drag the AdPlugg Ad Widget to
                    wherever you want your ads to display.
                </li>
            </ol>';
            $troubleshooting_content = '
            <h2>Troubleshooting</h2>
            ';
            $use_content = '
            <h2>Using AdPlugg</h2>
            ';
            //overview tab
            $screen->add_help_tab(array(
                'id' => 'adplugg_overview',
                'title' => 'Overview',
                'content' => $overview_content
            ));
            //installation tab
            $screen->add_help_tab(array(
                'id' => 'adplugg_installation',
                'title' => 'Installation',
                'content' => $installation_content
            ));
            //use tab
            $screen->add_help_tab(array(
                'id' => 'adplugg_use',
                'title' => 'Using AdPlugg',
                'content' => $use_content
            ));
            //installation tab
            $screen->add_help_tab(array(
                'id' => 'adplugg_troubleshooting',
                'title' => 'Troubleshooting',
                'content' => $troubleshooting_content
            ));
            
        } 
        return $contextual_help;
        
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
                'access_code', 'Access Code', 
                array(&$this, 'adplugg_options_render_access_code'),
                'adplugg', 
                'adplugg_options_access_section'
        );
    }

    /**
     * Function to validate the submitted AdPlugg options field values
     * @param array $input The submitted values
     * @return string Returns the submitted values minus any that failed validation.
     */
    function adplugg_options_validate($input) {
        $newinput['access_code'] = trim($input['access_code']);
        if(!preg_match('/^[a-z0-9]+$/i', $newinput['access_code'])) {
            $newinput['access_code'] = '';
        }
        return $newinput;
    }
}