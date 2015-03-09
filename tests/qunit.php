<?php
/**
 * Functions for testing the AdPlugg plugin using QUnit.
 * @package AdPlugg
 * @since 1.1.16
 */

/**
 * Loads QUnit and the tests for the passed test suite.
 * @param string $test_suite The test suite that you want to load.
 */
function load_qunit($test_suite) {
    ?>
        <link rel="stylesheet" href="//code.jquery.com/qunit/qunit-1.15.0.css">
        <div id="qunit"></div>
        <div id="qunit-fixture"></div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
        <script src="//code.jquery.com/qunit/qunit-1.15.0.js"></script>
        <script src="<?php echo plugins_url('qunit-test-' . $test_suite . '.js', __FILE__); ?>"></script>
    <?php
}

