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



jQuery( function ( $ ) {
    
    //var wrapper = $( '#woocommerce-product-data' );
    /*
    $( '.woocommerce_variations .tips, .woocommerce_variations .help_tip, .woocommerce_variations .woocommerce-help-tip', wrapper ).tipTip({
        'attribute': 'data-tip',
        'fadeIn':    50,
        'fadeOut':   50,
        'delay':     200
    });
    */


    //$( document.body )
    //    .on( 'init_tooltips', function() {
    function initTooltips() {
            console.log(1);
            var tiptip_args = {
                'attribute': 'data-tip',
                'fadeIn': 50,
                'fadeOut': 50,
                'delay': 200
            };

            $( '.tips, .help_tip, .woocommerce-help-tip' ).tipTip( tiptip_args );
            console.log(2);
            // Add tiptip to parent element for widefat tables
            //$( '.parent-tips' ).each( function() {
            //    $( this ).closest( 'a, th' ).attr( 'data-tip', $( this ).data( 'tip' ) ).tipTip( tiptip_args ).css( 'cursor', 'help' );
            //});
    //    })
    //;
    }
    /*
    $(document).ready(function($){
        
    }
    */
    $(document).ready(function(){
        initTooltips();
    });
    //$( document ).ready.trigger( 'init_tooltips' );
});

