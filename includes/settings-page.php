<?php
// Add plugin settings page
function facebook_live_stream_plugin_settings_page() {
    add_options_page(
        'Facebook Live Stream Plugin Settings',
        'Facebook Live Settings',
        'manage_options',
        'facebook-live-stream-plugin-settings',
        'facebook_live_stream_plugin_settings_page_content'
    );
}
add_action('admin_menu', 'facebook_live_stream_plugin_settings_page');

// Render plugin settings page content
function facebook_live_stream_plugin_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>Facebook Live Stream Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('facebook_live_stream_settings_group'); ?>
            <?php do_settings_sections('facebook-live-stream-plugin-settings'); ?>
            <?php submit_button('Save Settings'); ?>
        </form>
        <p>To display the Facebook Live stream on your website, use the following shortcode on any page or post:</p>
        <pre>[facebook_live_stream]</pre>
        <p>To display the Facebook Live stream and feedback form on your website, use the following shortcode on any page or post:</p>
        <pre>[facebook_live_stream_with_feedback]</pre>
        <p>Make sure to configure your Facebook Access Token and Page ID below.</p>
        <p>If you find this plugin helpful, consider buying us a coffee!</p>
        <a href="https://www.buymeacoffee.com/yourusername" target="_blank"><img src="https://img.buymeacoffee.com/button-api/?text=Buy%20us%20a%20coffee&emoji=&slug=yourusername&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff"></a>
        <p>This plugin was developed by <a href="https://github.com/rizennews/" target="_blank">Designolabs Studio</a>.</p>
    </div>
    <?php
}

// Initialize plugin settings
function facebook_live_stream_plugin_initialize_settings() {
    register_setting(
        'facebook_live_stream_settings_group',
        'facebook_access_token'
    );
    register_setting(
        'facebook_live_stream_settings_group',
        'facebook_page_id'
    );

    add_settings_section(
        'facebook_live_stream_settings_section',
        'Facebook Live Stream Settings',
        'facebook_live_stream_settings_section_callback',
        'facebook-live-stream-plugin-settings'
    );

    add_settings_field(
        'facebook_access_token_field',
        'Facebook Access Token',
        'facebook_access_token_field_callback',
        'facebook-live-stream-plugin-settings',
        'facebook_live_stream_settings_section'
    );
    add_settings_field(
        'facebook_page_id_field',
        'Facebook Page ID',
        'facebook_page_id_field_callback',
        'facebook-live-stream-plugin-settings',
        'facebook_live_stream_settings_section'
    );
}
add_action('admin_init', 'facebook_live_stream_plugin_initialize_settings');

// Callback function to render Facebook Access Token field
function facebook_access_token_field_callback() {
    $accessToken = get_option('facebook_access_token');
    echo '<input type="text" name="facebook_access_token" value="' . esc_attr($accessToken) . '" />';
}

// Callback function to render Facebook Page ID field
function facebook_page_id_field_callback() {
    $pageId = get_option('facebook_page_id');
    echo '<input type="text" name="facebook_page_id" value="' . esc_attr($pageId) . '" />';
}

// Callback function to render Facebook Live Stream Settings section
function facebook_live_stream_settings_section_callback() {
    echo '<p>Enter your Facebook Access Token and Page ID below. You can obtain an Access Token and Page ID from the Facebook Developer Console.</p>';
}
