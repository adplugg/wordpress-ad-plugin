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
 * This file contains general functions for use by the AdPlugg Plugin.
 * @package AdPlugg
 * @since 1.0
 */
    
/**
 * Function that looks to see if an adplugg access key has been installed
 * @return boolean Returns true if an access key is installed, otherwise
 * returns false.
 */
function adplugg_is_access_key_installed() {
    $options = get_option(ADPLUGG_OPTIONS_NAME, array() );
    if($options['access_code']) {
        return true;
    } else {
        return false;
    }
}



