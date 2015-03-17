/**
 * QUnit tests for the AdPlugg WordPress Plugin's admin options page.
 * 
 * @package AdPlugg
 * @since 1.1.37
 */


/**
* Assert that the page was rendered (by checking for the header).
*/
QUnit.test( "Test that the page was rendered", function( assert ) {
    var header = $("#wpbody-content .wrap h2").html();
    assert.equal(header, "AdPlugg Settings", "Settings page rendered");
});

/**
* Assert that the help is rendered.
*/
QUnit.test( "Test that the help was rendered", function( assert ) {
    var header = $("#tab-panel-adplugg_overview h1").html();
    assert.equal(header, "AdPlugg Plugin Help", "Help rendered");
});


