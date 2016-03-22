<?php

require_once(ADPLUGG_PATH . 'frontend/class-feed.php');

/**
 * The FeedTest class includes tests for testing the AdPlugg_Feed class.
 *
 * @package AdPlugg
 * @since 1.2.48
 */
class FeedTest extends WP_UnitTestCase {
    
    /**
     * Test the get_instance function.
     */    
    public function test_get_instance() {
        //get the singleton instance
        $feed = AdPlugg_Feed::get_instance();
        
        //assert that the instance is returned and is the expected class.
        $this->assertEquals( 'AdPlugg_Feed', get_class( $feed ) );
    }
    
    /**
     * Test that the filter_feed function leaves simple text content (without
     * adplugg ads) unchanged.
     */   
    public function test_filter_feed_doesnt_modify_simple_text_content() {
        //set up the test data
        $content = 'Some simple content';
        
        //get the singleton instance
        $feed = AdPlugg_Feed::get_instance();
        
        //call the function
        $filtered_content = $feed->filter_feed( $content );
        
        //assert that the content is unmodified;
        $this->assertEquals( $content, $filtered_content );
    }
    
    /**
     * Test that the filter_feed function leaves simple html content (without
     * adplugg ads) unchanged.
     */
    public function test_filter_feed_doesnt_modify_simple_html_content() {
        //set up the test data
        $content = '<p>Some <strong>simple</strong> html content</p>';
        
        //get the singleton instance
        $feed = AdPlugg_Feed::get_instance();
        
        //call the function
        $filtered_content = $feed->filter_feed( $content );
        
        //assert that the content is unmodified;
        $this->assertEquals( $content, $filtered_content );
    }
    
    /**
     * Test that the filter_feed function removes an adplugg ad tag.
     */
    public function test_filter_feed_removes_adplugg_ad_tag() {
        //set up the test data
        $content                   = '<p>html content with an ad tag <div class="adplugg-tag" data-adplugg-zone="incontent"></div></p>';
        $expected_filtered_content = '<p>html content with an ad tag</p>';
        
        //get the singleton instance
        $feed = AdPlugg_Feed::get_instance();
        
        //call the function
        $filtered_content = $feed->filter_feed( $content );
        
        //assert that the content is unmodified;
        $this->assertEquals( $expected_filtered_content, $filtered_content );
    }
    
    /**
     * Test that the filter_feed function removes an adplugg ad tag properly
     * when nested.
     */
    public function test_filter_feed_removes_adplugg_ad_tag_when_nested() {
        //set up the test data
        $content                   = '<div><div>html content with an ad tag <div class="adplugg-tag" data-adplugg-zone="incontent"></div>.</div></div>';
        $expected_filtered_content = '<div><div>html content with an ad tag.</div></div>';
        
        //get the singleton instance
        $feed = AdPlugg_Feed::get_instance();
        
        //call the function
        $filtered_content = $feed->filter_feed( $content );
        
        //assert that the content is unmodified;
        $this->assertEquals( $expected_filtered_content, $filtered_content );
    }
    
    
}

