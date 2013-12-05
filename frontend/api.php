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
 * Functions for rendering the AdPlugg API code.
 */

/**
 * Function to add the AdPlugg api to the DOM
 */
function adplugg_add_api() {
    $options = get_option('adplugg_options', array() );
    if($options['access_code']) {
 ?>
<script>
    (function(ac) {
      var d = document, s = 'script', id = 'adplugg-adjs';
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = '//www.adplugg.com/users/serve/' + ac + '/js/1.0/ad.js';
      fjs.parentNode.insertBefore(js, fjs);
    }('<?php echo $options['access_code']; ?>'));
</script>
<?php
    } //end if
} //end adplugg_add_api
