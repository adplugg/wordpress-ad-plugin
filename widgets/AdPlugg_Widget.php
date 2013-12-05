<?php
/*
 * Copyright (c) 2013 AdPlugg <legal@adplugg.com>. All rights reserved.
 * 
 * This file is part of the Adplugg Ad Plugin.
 *
 * Permission is hereby granted, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to use and modify the
 * Software for commercial, personal, educational or governmental purposes, 
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * The Software may not be distributed without the express permission of
 * AdPlugg.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */

/**
 * Class to create the adplugg widget
 */
class AdPlugg_Widget extends WP_Widget {

    /**
     * Constructor
     */
    function AdPlugg_Widget() {
        $widget_options = array( 'classname' => 'adplugg', 'description' => __('A widget for displaying ads ', 'adplugg') );  
        parent::__construct('adplugg', $name = __('AdPlugg', 'adplugg'), $widget_options);
    }

    /**
     * Widget form creation
     */
    function form($instance) {
        //
    }

    /**
     * Widget update
     */
    function update($new_instance, $old_instance) {
        //
    }

    /**
     * Widget display
     */
    function widget($args, $instance) {
        extract($args);

        echo $before_widget;

        // Display the widget
        echo '<div class="adplugg-placement"></div>';

        echo $after_widget;
    }
}