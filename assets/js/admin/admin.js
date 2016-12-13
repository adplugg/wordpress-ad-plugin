/**
 * Style for AdPlugg in the administrator.
 * @package AdPlugg
 * @since 1.2.0
 */

/**
 * Function that is called when a notice button is clicked.
 * @param {object} buttonObj The button calling the function.
 * @param {string} noticeKey The noticeKey of the notice.
 * @param {string} remindWhen When to remind (ex. '+30 days'), or null to never
 * remind again.
 * @returns {boolean} Retruns false;
 */
function adpluggPostNoticePref(buttonObj, noticeKey, remindWhen) {
    var data = {
        'action': 'adplugg_set_notice_pref',
        'notice_key': noticeKey,
        'remind_when': remindWhen
    };

    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajaxurl, data, function(response) {
        var data = jQuery.parseJSON(response);
        //alert('Got this from the server: ' + data.notice_key);
        jQuery('#' + data.notice_key).fadeOut();
    });
    
    return false;
}

/**
 * Set the rating link click action
 * @param {type} param
 */
jQuery(document).ready(function() {
    jQuery( 'a.adplugg-rating-link' ).click( function() {
        jQuery.post( ajaxurl, { action: 'adplugg_rated' } );
        jQuery( this ).parent().text( jQuery( this ).data( 'rated' ) );
    });
});
