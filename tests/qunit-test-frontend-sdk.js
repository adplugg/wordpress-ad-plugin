/**
 * QUnit tests for the AdPlugg plugin SDK.
 * 
 * Note: that you will need to use the 'mock' access code in order for these
 * to pass.
 * 
 * @package AdPlugg
 * @since 1.1.16
 */

/**
* Assert that the ad images were loaded.
*/
QUnit.test( "Test images loaded", function( assert ) {
    var imgTags = $(".adplugg-tag").find("img");
    assert.equal(imgTags.length, 3, "Images were loaded");
});

/**
* Assert that the ad links were loaded.
*/
QUnit.test( "Test links loaded", function( assert ) {
    var aTags = $(".adplugg-tag").find("a");
    assert.equal(aTags.length, 1, "Links were loaded");
});

/**
* Assert that the trackback images were loaded.
*/
QUnit.test( "Test track back images loaded", function( assert ) {
    var atbs = $(".adplugg-atb");
    assert.equal(atbs.length, 3, "Track back images were loaded");
});


