/**
 * QUnit tests for the AdPlugg WordPress Plugin's admin options page.
 * 
 * @package AdPlugg
 * @since 1.1.38
 */

//Custom Assertions
QUnit.assert.contains = function( needle, haystack, message ) {
    var actual = haystack.indexOf(needle) > -1;
    this.push(actual, actual, needle, message);
};

/**
* Assert that the widget was rendered (by checking for the header).
*/
QUnit.test( "Test that the AdPlugg widget is available", function( assert ) {
    var header = $("div#widget-list div.widget-title h4").html();
    assert.ok(header.indexOf("AdPlugg") !== -1, "Widget Available");
});

/**
* Assert that the AdPlugg widget help is rendered.
*/
QUnit.test( "Test that the help was rendered", function( assert ) {
    var header = $("#tab-panel-adplugg_widget h1").html();
    assert.equal(header, "AdPlugg Widget Help", "Help rendered");
});



