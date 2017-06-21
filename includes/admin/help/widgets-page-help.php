<?php
/**
 * Functions for rendering the AdPlugg contextual help for the widgets page 
 * within the WordPress Administrator.
 * @package AdPlugg
 * @since 1.1.29
 */
    
/**
 * Add help for the AdPlugg widget into the WordPress admin help system.
 * @param string $contextual_help The default contextual help that our 
 * function is going to replace.
 * @param string $screen_id Used to identify the page that we are on.
 * @param string $screen Used to access the elements of the current page.
 * @return string The new contextual help.
 */
function adplugg_widgets_page_help( $contextual_help, $screen_id, $screen ) {
    
    $content = '
    <h1>AdPlugg Widget Help</h1>
    <p>Using the AdPlugg Widget is easy! Just drag it from the list of available
    widgets into any of your widget areas.
    </p>
    <h2>Optional Settings</h2>
    <p>The AdPlugg Widget has several optional settings that allow you to do
    more things with your ads.</p>
    <ul>
      <li><strong>Title:</strong> Though it may depend on your theme, the
        text that you enter into the Title field typically displays just above
        the widget.  For example, you could enter "Sponsors" to have the word
        "Sponsors" display above your ads. Don\'t want a title? Just leave this
        field blank.
      </li>
      <li><strong>Zone:</strong> If you\'ve added zones to your <a 
        href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=whelp-os-l1" target="_blank" title="adplugg.com">
        adplugg.com</a> configuration, you can use this field to tie a zone to
        the widget. Enter the zone\'s machine name into this field. Once the
        widget is tied to a zone, you can control what displays in the widget
        by modifying your zone settings and zone targeting at <a 
        href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=whelp-os-l2" target="_blank" title="adplugg.com">
        adplugg.com</a>.
      </li>
    </ul>';
    
    $screen->add_help_tab( array(
        'id' => 'adplugg_widget',
        'title' => 'AdPlugg Widget',
        'content' => $content
    ) );
    
    return $contextual_help;

}
