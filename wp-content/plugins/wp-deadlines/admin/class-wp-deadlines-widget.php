<?php

class WP_Deadlines_Widget extends WP_Widget
{
    /**
     * Sets up the widgets name etc
     *
     * @link https://developer.wordpress.org/reference/classes/wp_widget/__construct/
     * @see  https://developer.wordpress.org/reference/functions/wp_register_sidebar_widget/
     *
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'wp_deadlines_widget',
            'description' => esc_html__('Widget for displaying WP Deadline countdown', 'wp-deadlines'),
        );
        parent::__construct('wp_deadlines_widget', esc_html('WP Deadlines'), $widget_ops);
    }

    /**
     * Outputs the content of the widget on front-end
     *
     * @param array $args Widget arguments
     * @param array $instance
     *
     * @link https://developer.wordpress.org/reference/classes/wp_widget/widget/
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if (!empty($instance['deadline'])) {
            $deadline = get_post($instance['deadline']);
            $deadline_id = get_post_meta($deadline->ID, '_tg_deadline_countdown_id', true);

            echo do_shortcode('[wp-deadline id=' . $deadline_id . ']');

        } else {
            echo esc_html__('No posts selected!', 'wp-deadlines');
        }
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     *
     * @link https://developer.wordpress.org/reference/classes/wp_widget/form/
     * @return string|void
     */
    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Title', 'wp-deadlines');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'wp-deadlines'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <?php

        $posts = get_posts(array(
            'post_type' => 'tg_wp_deadline',
            'posts_per_page' => -1,
            'offset' => 0
        ));
        $selected_deadline = !empty($instance['deadline']) ? $instance['deadline'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('deadline')); ?>"><?php esc_attr_e('Select Deadline:', 'wp-deadlines'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('deadline')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('deadline')); ?>">
                <?php foreach ($posts as $post) { ?>
                <option value="<?php echo $post->ID; ?>" <?php selected($post->ID == $selected_deadline ? $post->ID : '', $post->ID); ?>><?php echo get_the_title($post->ID); ?>
                    <?php } ?>
            </select>
        </p>
        <?php

    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @link https://developer.wordpress.org/reference/classes/wp_widget/update/
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        $selected_deadline = (!empty ($new_instance['deadline'])) ? $new_instance['deadline'] : '';
        $instance['deadline'] = sanitize_text_field($selected_deadline);
        return $instance;
    }
}

// Register the widget.
function register_wp_deadlines_widget()
{
    register_widget('WP_Deadlines_Widget');
}

add_action('widgets_init', 'register_wp_deadlines_widget');

