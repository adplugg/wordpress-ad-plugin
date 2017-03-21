<?php
/**
 * Functions for adding the SDK to the WordPress front end.
 * @package AdPlugg
 * @since 1.0
 */

/**
 * Function that adds the AdPlugg sdk to the DOM.
 */
function adplugg_add_sdk() {
    $access_code = adplugg_get_active_access_code();
    
    //Load the sdk (if there is an access_code)
    if ( ! empty( $access_code ) ) {
 ?>
<script data-cfasync="false">
    (function(ac) {
      var d = document, s = 'script', id = 'adplugg-adjs';
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id; js.async = 1;
      js.src = '//<?php echo ADPLUGG_ADJSSERVER; ?>/serve/' + ac + '/js/1.1/ad.js';
      fjs.parentNode.insertBefore(js, fjs);
    }('<?php echo $access_code; ?>'));
</script>
<?php
        //Optionally load the QUnit tests.
        if ( ( defined( 'ADPLUGG_LOAD_QUNIT' ) ) && ( ADPLUGG_LOAD_QUNIT == true ) ) {
            require_once( ADPLUGG_PATH . 'tests/qunit.php' );
            adplugg_load_qunit( 'frontend-sdk' );
        }
        
    } //end if access_code
    
} //end adplugg_add_sdk
