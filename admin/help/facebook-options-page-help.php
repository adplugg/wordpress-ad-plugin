<?php
/**
 * Functions for rendering the AdPlugg contextual help for the facebook options
 * page within the WordPress Administrator.
 * @package AdPlugg
 * @since 1.3.0
 */
    
/**
 * Add help for the adplugg facebook options page into the WordPress admin help
 * system.
 * @param string $contextual_help The default contextual help that our 
 * function is going to replace.
 * @param string $screen_id Used to identify the page that we are on.
 * @param string $screen Used to access the elements of the current page.
 * @return string The new contextual help.
 */
function adplugg_facebook_options_page_help( 
                            $contextual_help, 
                            $screen_id, 
                            $screen ) 
{
    $overview_content = '
         <h2>Facebook Settings Help</h2>
         <p>
            These settings allow you to include AdPlugg ads in your 
            <a href="http://www.adplugg.com/blog/facebook-instant-articles"
            target="_blank"> Facebook Instant Articles</a> header.  Ads included
            in the header will be automatically placed by Facebook throghout the
            acticle content.
        </p>
        <p>
            If you are new to AdPlugg, you may find it easier to place ads
            on your regular site first before attempting to include them in
            your Instant Articles feed.
        ';
    
    $requirements_content = '
        <h3>Requirements</h3>
        <p>
            For these settings to work, you will need to have the <a href="https://wordpress.org/plugins/fb-instant-articles/" 
            target="_blank" title="Facebook Instant Articles for WP">
            Facebook Instant Articles for WP</a> plugin installed.
        </p>
        <p>
            You will also need to have an AdPlugg account with at least one Zone
            and at least one ad targeted to it.
        </p>';
    
    $tips_content = '
        <h3>Tips</h3>
        <p>
            It is usually best to create Zones that are specific to your Facebook
            Instant Articles Feed (for instance "Facebook Zone 1").
        </p>';
    
    $zones_field_content = '
        <h3>Zones Field Help</h3>
        <p>
            The Zones field allows you to enter a list of Zones that will be
            included in your Facebook Instant Articles header.  Facebook will
            then automatically distribute them thoughout the article\'s content.
        </p>
        <p>
            If you leave this field blank, no Zones will be added to your
            Facebook Instant Articles header.
        </p>
        <p>
            If you haven\'t configured any AdPlugg Zones yet, please go to 
            <a href="http://www.adplugg.com" target="_blank">adplugg.com</a> and
            do so now.
        </p>
        <p>
            Enter the machine name of the zones that you want included with a
            comma in between each zone machine name. You can specify a "default"
            Zone by entering an asterisk (*) after the zone\'s machine name.
        </p>
        <p>
           Here\'s an example of what your entry might look like: 
           "facebook_zone_1, facebook_zone_2*, facebook_zone_3".
        </p>
        ';

    $sidebar_content = '
    <h5>For more Information:</strong></h5>
    <a href="http://www.adplugg.com/support/help" target="_blank" title="AdPlugg Help Center">AdPlugg Help Center</a><br/>
    <a href="http://www.adplugg.com/support/cookbook" target="_blank" title="AdPlugg Cookbook">AdPlugg Cookbook</a><br/>
    <a href="http://www.adplugg.com/contact" target="_blank" title="Contact AdPlugg">Contact AdPlugg</a><br/>
    <br/>
    ';

    //overview tab
    $screen->add_help_tab( array(
        'id' => 'adplugg_facebook_overview',
        'title' => 'Overview',
        'content' => $overview_content
    ) );
    
    //requirements tab
    $screen->add_help_tab( array(
        'id' => 'adplugg_facebook_requirements',
        'title' => 'Requirements',
        'content' => $requirements_content
    ) );
    
    //tips tab
    $screen->add_help_tab( array(
        'id' => 'adplugg_facebook_tips',
        'title' => 'Tips',
        'content' => $tips_content
    ) );
    
    //Zones Field tab
    $screen->add_help_tab( array(
        'id' => 'adplugg_facebook_zones_field',
        'title' => 'Zones Field',
        'content' => $zones_field_content
    ) );

    $screen->set_help_sidebar( $sidebar_content );

    return $contextual_help;
}
