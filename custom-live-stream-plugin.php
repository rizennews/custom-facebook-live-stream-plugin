<?php
/**
 * Plugin Name: Custom Facebook Live Stream Plugin
 * Plugin URI: https://github.com/rizennews/custom-facebook-live-stream-plugin
 * Description: Custom Plugin to embed Facebook Live streams.
 * Version: 1.0
 * Author: Designolabs Studio
 * Author URI: https://github.com/rizennews/
**/

// Function to fetch Facebook Live stream embed code
function getFacebookLiveEmbedCode($accessToken, $pageId) {
    // Construct URL for Facebook Graph API
    $url = "https://graph.facebook.com/v13.0/{$pageId}?fields=live_videos.limit(1){embed_html}&access_token={$accessToken}";

    // Make request to Facebook Graph API
    $response = file_get_contents($url);

    // Decode JSON response
    $data = json_decode($response, true);

    // Check if live video data exists
    if (isset($data['live_videos']['data'][0]['embed_html'])) {
        return $data['live_videos']['data'][0]['embed_html'];
    } else {
        return false;
    }
}

// Function to generate HTML output with embedded live stream
function displayFacebookLiveStream() {
    // Get user-defined Facebook Access Token and Page ID
    $accessToken = get_option('custom_facebook_access_token');
    $pageId = get_option('custom_facebook_page_id');

    // Check if both access token and page ID are set
    if (empty($accessToken) || empty($pageId)) {
        return '<p>Error: Please configure your Facebook Access Token and Page ID in the plugin settings.</p>';
    }

    // Get Facebook Live embed code
    $facebookEmbedCode = getFacebookLiveEmbedCode($accessToken, $pageId);

    // Generate HTML output with embedded live stream
    if ($facebookEmbedCode) {
        $output = '<div class="facebook-live-stream">';
        $output .= '<h2>Facebook Live Stream</h2>';
        $output .= $facebookEmbedCode;
        $output .= '</div>';
        return $output;
    } else {
        return '<p>No live stream available at the moment.</p>';
    }
}

// Shortcode to display Facebook Live stream
function facebookLiveStreamShortcode() {
    return displayFacebookLiveStream();
}
add_shortcode('facebook_live_stream', 'facebookLiveStreamShortcode');

// Add plugin settings page
function custom_facebook_plugin_settings_page() {
    add_options_page(
        'Custom Facebook Live Stream Plugin Settings',
        'Facebook Live Settings',
        'manage_options',
        'custom-facebook-live-stream-plugin',
        'custom_facebook_plugin_settings_page_content'
    );
}
add_action('admin_menu', 'custom_facebook_plugin_settings_page');

// Render plugin settings page content
function custom_facebook_plugin_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>Custom Facebook Live Stream Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('custom_facebook_settings_group'); ?>
            <?php do_settings_sections('custom-facebook-live-stream-plugin'); ?>
            <?php submit_button('Save Settings'); ?>
        </form>
        <p>To display the Facebook Live stream on your website, use the following shortcode on any page or post:</p>
        <pre>[facebook_live_stream]</pre>
        <p>Make sure to configure your Facebook Access Token and Page ID below.</p>
        <p>If you find this plugin helpful, consider buying us a coffee!</p>
        <a href="https://www.buymeacoffee.com/designolabs" target="_blank"><img src="https://img.buymeacoffee.com/button-api/?text=Buy%20us%20a%20coffee&emoji=&slug=designolabs&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff"></a>
        <p>This plugin was developed by <a href="https://github.com/rizennews/" target="_blank">Designolabs Studio</a>.</p>
    </div>
    <?php
}

// Initialize plugin settings
function custom_facebook_plugin_initialize_settings() {
    register_setting(
        'custom_facebook_settings_group',
        'custom_facebook_access_token'
    );
    register_setting(
        'custom_facebook_settings_group',
        'custom_facebook_page_id'
    );

    add_settings_section(
        'custom_facebook_settings_section',
        'Facebook Live Stream Settings',
        'custom_facebook_settings_section_callback',
        'custom-facebook-live-stream-plugin'
    );

    add_settings_field(
        'custom_facebook_access_token_field',
        'Facebook Access Token',
        'custom_facebook_access_token_field_callback',
        'custom-facebook-live-stream-plugin',
        'custom_facebook_settings_section'
    );
    add_settings_field(
        'custom_facebook_page_id_field',
        'Facebook Page ID',
        'custom_facebook_page_id_field_callback',
        'custom-facebook-live-stream-plugin',
        'custom_facebook_settings_section'
    );
}
add_action('admin_init', 'custom_facebook_plugin_initialize_settings');

// Callback function to render Facebook Access Token field
function custom_facebook_access_token_field_callback() {
    $accessToken = get_option('custom_facebook_access_token');
    echo '<input type="text" name="custom_facebook_access_token" value="' . esc_attr($accessToken) . '" />';
}

// Callback function to render Facebook Page ID field
function custom_facebook_page_id_field_callback() {
    $pageId = get_option('custom_facebook_page_id');
    echo '<input type="text" name="custom_facebook_page_id" value="' . esc_attr($pageId) . '" />';
}

// Callback function to render Facebook Live Stream Settings section
function custom_facebook_settings_section_callback() {
    echo '<p>Enter your Facebook Access Token and Page ID below. You can obtain an access token from the Facebook Developer Console and find your Page ID in the URL of your Facebook page.</p>';
}
