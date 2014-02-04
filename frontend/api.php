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
    $options = get_option(ADPLUGG_OPTIONS_NAME, array() );
    if($options['access_code']) {
 ?>
<script>
    (function(ac) {
      var d = document, s = 'script', id = 'adplugg-adjs';
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = '//www.adplugg.com/users/serve/' + ac + '/js/1.1/ad.js';
      fjs.parentNode.insertBefore(js, fjs);
    }('<?php echo $options['access_code']; ?>'));
</script>
<?php
    } //end if
} //end adplugg_add_api
