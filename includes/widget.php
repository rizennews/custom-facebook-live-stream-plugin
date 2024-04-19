<?php
// Widget class
class Facebook_Live_Stream_Widget extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'facebook_live_stream_widget',
            __('Facebook Live Stream Widget', 'text_domain'),
            array(
                'description' => __('Display Facebook live stream and feedback form.', 'text_domain'),
            )
        );
    }

    // Widget form creation
    public function form($instance) {
        // Check values
        if ($instance) {
            $accessToken = esc_attr($instance['access_token']);
            $pageId = esc_attr($instance['page_id']);
        } else {
            $accessToken = '';
            $pageId = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Access Token:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo $accessToken; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page ID:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>" type="text" value="<?php echo $pageId; ?>" />
        </p>
        <?php
    }

    // Update widget
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['access_token'] = strip_tags($new_instance['access_token']);
        $instance['page_id'] = strip_tags($new_instance['page_id']);

        return $instance;
    }

    // Widget display
    public function widget($args, $instance) {
        $accessToken = isset($instance['access_token']) ? $instance['access_token'] : '';
        $pageId = isset($instance['page_id']) ? $instance['page_id'] : '';

        // Widget output
        echo $args['before_widget'];
        if (!empty($accessToken) && !empty($pageId)) {
            echo '<div class="livestream-container">';
            echo '<h2>Facebook Live Stream</h2>';
            echo '<iframe src="https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/' . $pageId . '/videos/&show_text=false&appId=123456789" width="560" height="315" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>';
            echo '</div>';
            echo '<div class="feedback-form-container">';
            echo displayFacebookFeedbackForm();
            echo '</div>';
        } else {
            echo '<p>Please enter Facebook Access Token and Page ID in the widget settings.</p>';
        }
        echo $args['after_widget'];
    }
}

// Register and load the widget
function facebook_live_stream_load_widget() {
    register_widget('Facebook_Live_Stream_Widget');
}
add_action('widgets_init', 'facebook_live_stream_load_widget');
