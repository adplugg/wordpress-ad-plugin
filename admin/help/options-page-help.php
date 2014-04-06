<?php
/**
 * Functions for rendering the AdPlugg contextual help for the options page 
 * within the WordPress Administrator.
 * @package AdPlugg
 * @since 1.0
 */
    
/**
 * Add help for the adplugg options page into the WordPress admin help system.
 * @global type $adplugg_hook
 * @param string $contextual_help The default contextual help that our 
 * function is going to replace.
 * @param string $screen_id Used to identify the page that we are on.
 * @param string $screen Used to access the elements of the current page.
 * @return string The new contextual help.
 */
function adplugg_options_page_help($contextual_help, $screen_id, $screen) {
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
            <li>Create an account at <a href="http://www.adplugg.com" target="_blank">adplugg.com</a> and add at least one ad.</li>
            <li>Get your AdPlugg Access Code and add it to the Access Code field on this page.</li>
            <li>Go to the <a href="' . admin_url('widgets.php') . '">Widgets configuration page</a> and drag the AdPlugg Ad Widget into
                a Widget Area.
            </li>
            <li>Your ad(s) should now be viewable from your blog.
        </ol>
        <h2>Additional Options</h2>
        <p>Advanced users can use the following options to customize what ads are served.</p>
        <ul>
            <li>
                Optionally add a Zone machine name into the widget to tie the
                widget to a Zone.  Zones can be set up from your account
                at <a href="http://www.adplugg.com" target="_blank">adplugg.com</a>.  Zones make
                it so that you can load different ads in different areas of the
                page.
            </li>
        </ul>';
        
        $use_content = '
        <h2>Using AdPlugg</h2>
        <p>Once you have AdPlugg set up and working, most things that can be done
        from <a href="http://www.adplugg.com" target="_blank">adplugg.com</a>. This includes:</p>
        <ul>
          <li>Creating, modifying and deleting ads</li>
          <li>Activating and deactivating ads</li>
          <li>Scheduling ads</li>
          <li>Tracking your ads and viewing your analytics</li>
          <li>Much more</li>
        </ul>
        <p>Access my <a href="https://www.adplugg.com/apusers/login" target="_blank">AdPlugg account</a></p>
        ';
        
        $troubleshooting_content = '
        <h2>Troubleshooting</h2>
        <p>If ads aren\'t displaying on your site, please check the following:</p>
        <ul>
          <li>Is The AdPlugg plugin installed and activated?</li>
          <li>Have you created an AdPlugg account at <a href="http://www.adplugg.com">www.adplugg.com</a>?</li>
          <li>Do you have at least one active ad in your AdPlugg account?</li>
          <li>Have you added the AdPlugg Ad Widget to a Widget Area? You can do this from the 
          <a href="' . admin_url('widgets.php') . '">Widgets configuration page</a>.</li>
        </ul>
        <p>
        Please <a href="http://www.adplugg.com/contact" target="_blank">contact us</a> for additional support.
        </p>
        ';
        
        $sidebar_content = '
        <h5>For more Information:</strong></h5>
        <a href="http://www.adplugg.com/support/help" target="_blank">AdPlugg Help Center</a><br/>
        <a href="http://www.adplugg.com/support/cookbook" target="_blank">AdPlugg Cookbook</a><br/>
        <a href="http://www.adplugg.com/contact" target="_blank">Contact AdPlugg</a><br/>
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
        
        $screen->set_help_sidebar($sidebar_content);

    } 
    return $contextual_help;

}
