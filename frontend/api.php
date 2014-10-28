<?php
/**
 * Functions for adding the API to the WordPress front end.
 * @package AdPlugg
 * @since 1.0
 */

/**
 * Function that adds the AdPlugg api to the DOM.
 */
function adplugg_add_api() {
    $access_code = adplugg_get_active_access_code();
    
    //Load the api (if there is an access_code)
    if(!empty($access_code)) {
 ?>
<script>
    (function(ac) {
      var d = document, s = 'script', id = 'adplugg-adjs';
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = '//<?php echo ADPLUGG_ADSERVER; ?>/serve/' + ac + '/js/1.1/ad.js';
      fjs.parentNode.insertBefore(js, fjs);
    }('<?php echo $access_code; ?>'));
</script>
<?php
        //Optionally load the QUnit tests.
        if( (defined('ADPLUGG_LOAD_QUNIT')) && (ADPLUGG_LOAD_QUNIT == true) ) {
            require_once(ADPLUGG_PATH . 'tests/qunit.php');
            load_qunit();
        }
        
    } //end if access_code
    
} //end adplugg_add_api
