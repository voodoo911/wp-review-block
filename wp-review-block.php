<?php
/*
Plugin Name: wp-review-block
Plugin URI: http://voodoopress.net
Description: Some description.
Version: 1.1
Author: Evgen "EvgenDob" Dobrzhanskiy
Author URI: http://voodoopress.net
Stable tag: 1.1
*/
 
// shortcodes processing
include('modules/shortcodes.php');

// settings processing
include('modules/settings.php');

// metaboxes processings
include('modules/meta_box.php');

// widgets processing
include('modules/widgets.php');

 
// main scripts processing - addition of css and js
include('modules/scripts.php');
 
?>