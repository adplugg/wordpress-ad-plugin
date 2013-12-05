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
 * Functions for rendering the AdPlugg Options/Settings page within the
 * WordPress Administrator.
 */

/**
 * Function to render the AdPlugg options page.
 */
function adplugg_options_render_page() {
?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div><h2>AdPlugg Settings</h2>
        <form action="options.php" method="post">
            <?php settings_fields('adplugg_options'); ?>
            <?php do_settings_sections('adplugg'); ?>

            <p class="submit">
                <input type="submit" name="Submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
            </p>
        </form>
    </div>
<?php
}


/**
 * Function to add the options page to the settings menu.
 */
function adplugg_add_options_page_to_menu() {
    add_options_page('AdPlugg Settings', 'AdPlugg', 'manage_options', 'adplugg', 'adplugg_options_render_page');
}

/**
 * Function to render the text for the access section.
 */
function adplugg_options_render_access_section_text() {
?>
    <p>
        To use AdPlugg you will need an AdPlugg Access Code.  To get
        your AdPlugg Access Code, log in or register (it's free) at 
        <a href="http://www.adplugg.com" target="_blank">www.adplugg.com</a>
    </p>
<?php
}

/**
 * Function to render the access code field and description
 */
function adplugg_options_render_access_code() {
    $options = get_option('adplugg_options');
 ?>
    <input id="adplugg_access_code" name="adplugg_options[access_code]" size="5" type="text" value="<?php echo $options['access_code'] ?>" />
    <p class="description">Enter your AdPlugg Access Code here.  See above for more info.</p>
<?php
}

/**
 * Function to initialize the AdPlugg options page.
 */
function adplugg_options_init() {
    register_setting('adplugg_options', 'adplugg_options', 'adplugg_options_validate' );
    add_settings_section('adplugg_options_access_section', 'Access Settings', 'adplugg_options_render_access_section_text', 'adplugg');
    add_settings_field('access_code', 'Access Code', 'adplugg_options_render_access_code', 'adplugg', 'adplugg_options_access_section');
}

/**
 * Function to validate the submitted AdPlugg options field values
 * @param array $input The submitted values
 * @return string Returns the submitted values minus any that failed validation.
 */
function adplugg_options_validate($input) {
    $newinput['access_code'] = trim($input['access_code']);
    if(!preg_match('/^[a-z0-9]+$/i', $newinput['access_code'])) {
        $newinput['access_code'] = '';
    }
    return $newinput;
}