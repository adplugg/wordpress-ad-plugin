<?php

/**
 * AdPlugg SDK class.
 * The AdPlugg SDK class has functions for adding the SDK to the WordPress 
 * front end.
 *
 * @package AdPlugg
 * @since 1.0
 */
class AdPlugg_Sdk {

    /**
     * Singleton instance of the class.
     * @var AdPlugg_Sdk
     */
    private static $instance;
    
    /**
     * Constructor, constructs the class and registers filters and actions.
     */
    public function __construct() {
        add_filter( 'wp_head', array( $this, 'render_sdk' ), 0 );
    }
    
    /**
     * Function that adds/renders the AdPlugg SDK to the head of the page.
     */
    public function render_sdk() {
        $access_code = adplugg_get_active_access_code();

        //Load the sdk (if there is an access_code)
        if ( ! empty( $access_code ) ) {
     ?>

    <!-- Ads managed and served by AdPlugg - AdPlugg WordPress Ad Plugin v<?php echo ADPLUGG_VERSION; ?> - https://www.adplugg.com -->
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
    <!-- / AdPlugg -->

    <?php
            //Optionally load the QUnit tests.
            if ( ( defined( 'ADPLUGG_LOAD_QUNIT' ) ) && ( ADPLUGG_LOAD_QUNIT == true ) ) {
                require_once( ADPLUGG_PATH . 'tests/qunit.php' );
                adplugg_load_qunit( 'frontend-sdk' );
            }

        } //end if access_code

    }
    
    /*
     * Get the singleton instance 
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
