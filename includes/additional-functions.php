<?php
// Function to fetch Facebook Live stream embed code
function getFacebookLiveEmbedCode($accessToken, $pageId) {
    // Construct URL for Facebook Graph API
    $url = "https://graph.facebook.com/v11.0/{$pageId}/live_videos?fields=id&access_token={$accessToken}";

    // Make request to Facebook Graph API
    $response = wp_remote_get($url);

    // Check for successful response
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Check if live video data exists
        if (isset($data['data'][0]['id'])) {
            $videoId = $data['data'][0]['id'];
            return "https://www.facebook.com/watch/live/?v={$videoId}";
        }
    }

    return false;
}

// Function to generate HTML output with embedded live stream
function displayFacebookLiveStream() {
    // Facebook Access Token (Obtain one from Facebook Developer Console)
    $accessToken = get_option('facebook_access_token');
    $pageId = get_option('facebook_page_id');

    // Get Facebook Live embed code
    $facebookEmbedCode = getFacebookLiveEmbedCode($accessToken, $pageId);

    // Generate HTML output with embedded live stream
    if ($facebookEmbedCode) {
        $output = '<div class="facebook-live-stream">';
        $output .= '<h2>Facebook Live Stream</h2>';
        $output .= '<iframe src="' . $facebookEmbedCode . '" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
        $output .= '</div>';
        return $output;
    } else {
        return '<p>No live stream available at the moment.</p>';
    }
}

// Compatibility Function
function checkTikTokLiveStreamCompatibility() {
    // Check if the active theme is Hello Elementor
    $theme = wp_get_theme();
    $theme_name = $theme->get('Name');
    if ($theme_name === 'Hello Elementor') {
        // Provide guidance on using the plugin with the Hello Elementor theme
        echo '<p>For optimal performance with the Hello Elementor theme, make sure to enable the plugin settings in the theme options panel.</p>';
    }

    // Check if the Live Stream plugin is active
    if (is_plugin_active('facebook/facebook-live-stream-plugin.php')) {
        // Provide guidance on using the plugin with the Live Stream plugin
        echo '<p>For compatibility with the Live Stream plugin, ensure that the plugin settings are configured correctly in the Facebook Live Stream settings page.</p>';
    }

    // Add more compatibility checks as needed
    // Check for other themes or plugins and provide guidance accordingly
    if (is_plugin_active('another-plugin/another-plugin.php')) {
        // Provide guidance on using the plugin with another plugin
        echo '<p>For compatibility with Another Plugin, ensure that the plugin settings are configured correctly in the Another Plugin settings page.</p>';
    }

    if ($theme_name === 'Another Theme') {
        // Provide guidance on using the plugin with Another Theme
        echo '<p>For optimal performance with Another Theme, make sure to customize the plugin settings according to the theme requirements.</p>';
    }

    // Add more compatibility checks here...
}


// Security Function
function sanitizeFacebookLiveStreamData($data) {
    // Sanitize the data fetched from Facebook before displaying it
    return wp_kses_post($data);
}

// Feedback Function
function displayFacebookFeedbackForm() {
    // You can customize this function to display a feedback form using HTML or a plugin like Contact Form 7
    ob_start(); ?>
    
    <div class="facebook-feedback-form">
        <h3>Send Us Your Feedback</h3>
        <form action="#" method="post">
            <label for="feedback_name">Name:</label><br>
            <input type="text" id="feedback_name" name="feedback_name"><br><br>
            
            <label for="feedback_email">Email:</label><br>
            <input type="email" id="feedback_email" name="feedback_email"><br><br>
            
            <label for="feedback_message">Message:</label><br>
            <textarea id="feedback_message" name="feedback_message" rows="4" cols="50"></textarea><br><br>
            
            <input type="submit" value="Submit">
        </form>
    </div>
    
    <?php
    return ob_get_clean();
}

// Shortcode to display Facebook Live stream and feedback form
function facebookLiveStreamWithFeedbackShortcode() {
    $output = '<div class="livestream-container">';
    $output .= displayFacebookLiveStream();
    $output .= '</div>';
    $output .= '<div class="feedback-form-container">';
    $output .= displayFacebookFeedbackForm();
    $output .= '</div>';

    return $output;
}
add_shortcode('facebook_live_stream_with_feedback', 'facebookLiveStreamWithFeedbackShortcode');
