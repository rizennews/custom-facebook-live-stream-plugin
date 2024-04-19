<?php
/*
Plugin Name: Facebook Live Stream Plugin
Plugin URI: https://github.com/rizennews/custom-facebook-live-stream-plugin
Description: Embed Facebook Live streams on your WordPress website.
Version: 1.0
Author: Padmore Aning
Author URI: https://github.com/rizennews
*/

// Include plugin settings page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Include plugin functions
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Include plugin widget
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';

// Include plugin additional functions
require_once plugin_dir_path(__FILE__) . 'includes/additional-functions.php';
