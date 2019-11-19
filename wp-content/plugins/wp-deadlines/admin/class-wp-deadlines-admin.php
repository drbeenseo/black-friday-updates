<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://themesgrove.com/
 * @since      1.0.0
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/admin
 * @author     themesgrove <rafiqul@themexpert.com>
 */
class WP_Deadlines_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function register_post_type()
    {

        register_post_type('tg_wp_deadline',
            [
                'labels' => [
                    'name' => esc_html__('Deadlines', 'wp-deadlines'),
                    'singular_name' => esc_html__('Deadline', 'wp-deadlines'),
                ],
                'public' => false,
                'publicly_queriable' => true,
                'show_ui' => true,
                'rewrite' => false,
                'query_var' => true,
                'supports' => array('title'),
                'menu_icon' => 'dashicons-clock',
                'show_in_rest' => true
            ]
        );
    }

    public function register_countdown_metabox()
    {
        $prefix = '_tg_deadline_countdown_';

        $cmb_options = array(
            'id' => $prefix . 'metaboxes',
            'title' => esc_html__('WP Deadline Settings', 'wp-deadlines'),
            'object_types' => array('tg_wp_deadline'), // Post type
            // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
            // 'context'    => 'normal',
            // 'priority'   => 'high',
            // 'show_names' => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
            // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
        );

        $cmb_tabs = new_cmb2_box( $cmb_options );

        $tabs_setting = array(
            'config' => $cmb_options,
            'layout' => 'vertical', // Default : horizontal
            'tabs'   => array()
        );

        $tabs_setting['tabs'][] = array(
            'id'     => $prefix . 'date',
            'title' => esc_html__('Date', 'wp-deadlines'),
            'fields' => array(
                array(
                    'name' => esc_html__('Countdown Type', 'wp-deadlines'),
                    'desc' => esc_html__('Select your desired Countdown Type.', 'wp-deadlines'),
                    'id' => $prefix . 'type',
                    'type' => 'select',
                    'show_option_none' => false,
                    'options' => array(
                        'date' => __('Deadline', 'wp-deadlines'),
                        'time' => __('Evergreen', 'wp-deadlines'),
                    ),
                ),
                array(
                    'name' => esc_html__('Select Date', 'wp-deadlines'),
                    'id' => $prefix . 'timestamp',
                    'type' => 'text_datetime_timestamp',
                    'timezone_meta_key' => $prefix . 'timezone',
                    // 'date_format' => 'l jS \of F Y',
                    'attributes' => array(
                        'required' => true, // Will be required only if visible.
                        'data-conditional-id' => $prefix . 'type',
                        'data-conditional-value' => 'date',
                    ),
                ),
                array(
                    'name' => esc_html__('Select Timezone', 'wp-deadlines'),
                    'id' => $prefix . 'timezone',
                    'type' => 'select_timezone',
                    'attributes' => array(
                        'required' => true, // Will be required only if visible.
                        'data-conditional-id' => $prefix . 'type',
                        'data-conditional-value' => 'date',
                    ),
                ),
                array(
                    'name' => esc_html__('Days', 'wp-deadlines'),
                    'id' => $prefix . 'day_count',
                    'type' => 'text_small',
                    'default' => '0',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'type',
                        'data-conditional-value' => 'time'
                    ),
                ),

                array(
                    'name' => esc_html__('Hours', 'wp-deadlines'),
                    'id' => $prefix . 'hour_count',
                    'default' => '0',
                    'type' => 'text_small',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'type',
                        'data-conditional-value' => 'time'
                    ),
                ),

                array(
                    'name' => esc_html__('Minutes', 'wp-deadlines'),
                    'id' => $prefix . 'min_count',
                    'default' => '0',
                    'type' => 'text_small',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'type',
                        'data-conditional-value' => 'time'
                    ),
                ),

                array(
                    'name' => esc_html__('Enable Cookie', 'wp-deadlines'),
                    'id' => $prefix . 'enable_cookie',
                    'default' => '',
                    'type' => 'checkbox',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'type',
                        'data-conditional-value' => 'time'
                    ),
                ),

                array(
                    'name' => esc_html__('Cookie Validity', 'wp-deadlines'),
                    'desc' => esc_html__('in days', 'wp-deadlines'),
                    'id' => $prefix . 'cookie',
                    'default' => '1',
                    'type' => 'text_small',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_cookie',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Enable Flyout', 'wp-deadlines'),
                    'id' => $prefix . 'enable_flyout',
                    'default' => '',
                    'type' => 'checkbox',
                ),

                array(
                    'name' => esc_html__('Flyout Position', 'wp-deadlines'),
                    'id' => $prefix . 'flyout',
                    'type' => 'select',
                    'options' => array(
                        'top' => esc_html__('Top', 'wp-deadlines'),
                        'bottom' => esc_html__('Bottom', 'wp-deadlines')
                    ),
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_flyout',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Enable Button in Flyout', 'wp-deadlines'),
                    'id' => $prefix . 'enable_button',
                    'default' => '',
                    'type' => 'checkbox',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_flyout',
                        'data-conditional-value' => 'on',
                    ),
                ),

            )
        );
        $tabs_setting['tabs'][] = array(
            'id'     => $prefix . 'content',
            'title' => esc_html__('Content', 'wp-deadlines'),
            'fields' => array(
                array(
                    'name' => esc_html__('Title', 'wp-deadlines'),
                    'id' => $prefix . 'title',
                    'type' => 'text',
                ),

                array(
                    'name' => esc_html__('Description', 'wp-deadlines'),
                    'id' => $prefix . 'desc',
                    'type' => 'textarea_small',
                ),

                array(
                    'name' => esc_html__('Finished Message', 'wp-deadlines'),
                    'id' => $prefix . 'message',
                    'desc' => esc_html__('Write text to display after finishing the countdown.', 'wp-deadlines'),
                    'default' => esc_html__('This offer has expired!', 'wp-deadlines'),
                    'type' => 'text',
                ),

                array(
                    'name' => esc_html__('Button Text', 'wp-deadlines'),
                    'id' => $prefix . 'button_text',
                    'type' => 'text_medium',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_button',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Button Link', 'wp-deadlines'),
                    'id' => $prefix . 'button_link',
                    'type' => 'text',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_button',
                        'data-conditional-value' => 'on',
                    ),
                ),
            )
        );

        $tabs_setting['tabs'][] = array(
            'id'     => $prefix . 'countdown',
            'title' => esc_html__('Countdown', 'wp-deadlines'),
            'fields' => array(
                array(
                    'name' => esc_html__('Hide Days?', 'wp-deadlines'),
                    'id' => $prefix . 'hide_day',
                    'type' => 'switch',
                    'default' => 'off',
                    'label' => array(
                        'on' => esc_html__('Yes', 'wp-deadlines'),
                        'off' => esc_html__('No', 'wp-deadlines')
                    )
                ),

                array(
                    'name' => esc_html__('Hide Hours?', 'wp-deadlines'),
                    'id' => $prefix . 'hide_hour',
                    'type' => 'switch',
                    'default' => 'off',
                    'label' => array(
                        'on' => esc_html__('Yes', 'wp-deadlines'),
                        'off' => esc_html__('No', 'wp-deadlines')
                    )
                ),

                array(
                    'name' => esc_html__('Hide Minutes?', 'wp-deadlines'),
                    'id' => $prefix . 'hide_min',
                    'type' => 'switch',
                    'default' => 'off',
                    'label' => array(
                        'on' => esc_html__('Yes', 'wp-deadlines'),
                        'off' => esc_html__('No', 'wp-deadlines')
                    )
                ),

                array(
                    'name' => esc_html__('Hide Seconds?', 'wp-deadlines'),
                    'id' => $prefix . 'hide_sec',
                    'type' => 'switch',
                    'default' => 'off',
                    'label' => array(
                        'on' => esc_html__('Yes', 'wp-deadlines'),
                        'off' => esc_html__('No', 'wp-deadlines')
                    )
                ),

                array(
                    'name' => esc_html__('Custom Label?', 'wp-deadlines'),
                    'id' => $prefix . 'custom_label',
                    'type' => 'switch',
                    'default' => 'off',
                    'label' => array(
                        'on' => esc_html__('Yes', 'wp-deadlines'),
                        'off' => esc_html__('No', 'wp-deadlines')
                    )
                ),

                array(
                    'name' => esc_html__('Days', 'wp-deadlines'),
                    'id' => $prefix . 'days',
                    'type' => 'text_medium',
                    'default' => 'Days',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'custom_label',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Hours', 'wp-deadlines'),
                    'id' => $prefix . 'hours',
                    'type' => 'text_medium',
                    'default' => 'Hours',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'custom_label',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Minutes', 'wp-deadlines'),
                    'id' => $prefix . 'minutes',
                    'type' => 'text_medium',
                    'default' => 'Minutes',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'custom_label',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Seconds', 'wp-deadlines'),
                    'id' => $prefix . 'seconds',
                    'type' => 'text_medium',
                    'default' => 'Seconds',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'custom_label',
                        'data-conditional-value' => 'on',
                    ),
                ),
            )
        );

        $tabs_setting['tabs'][] = array(
            'id'     => $prefix . 'style',
            'title' => esc_html__('Style', 'wp-deadlines'),
            'fields' => array(
                array(
                    'name' => esc_html__('Background Color', 'wp-deadlines'),
                    'id' => $prefix . 'bgcolor',
                    'type' => 'colorpicker',
                    'default' => '#333',
                    // 'attributes' => array(
                    // 	'data-colorpicker' => json_encode( array(
                    // 		'palettes' => array( '#3dd0cc', '#ff834c', '#4fa2c0', '#0bc991', ),
                    // 	) ),
                    // ),
                ),

                array(
                    'name' => esc_html__('Digit Color', 'wp-deadlines'),
                    'id' => $prefix . 'digit_color',
                    'desc' => esc_html__('This color will also be used as Font Color in gif image.', 'wp-deadlines'),
                    'type' => 'colorpicker',
                    'default' => '#ffffff',
                ),

                array(
                    'name' => esc_html__('Digit Font Size', 'wp-deadlines'),
                    'id' => $prefix . 'digit_font',
                    'desc' => esc_html__('Provide a unit(16px, 16pt, 1em)', 'wp-deadlines'),
                    'type' => 'text_small',
                ),


                array(
                    'name' => esc_html__('Label Color', 'wp-deadlines'),
                    'id' => $prefix . 'label_color',
                    'type' => 'colorpicker',
                    'default' => '#ffffff',
                ),

                array(
                    'name' => esc_html__('Label Font Size', 'wp-deadlines'),
                    'id' => $prefix . 'label_font',
                    'desc' => esc_html__('Provide a unit(16px, 16pt, 1em)', 'wp-deadlines'),
                    'type' => 'text_small',
                ),

                array(
                    'name' => esc_html__('Title Font Size', 'wp-deadlines'),
                    'id' => $prefix . 'title_font',
                    'desc' => esc_html__('Provide a unit(16px, 16pt, 1em)', 'wp-deadlines'),
                    'type' => 'text_small',
                ),

                array(
                    'name' => esc_html__('Title Color', 'wp-deadlines'),
                    'id' => $prefix . 'title_color',
                    'type' => 'colorpicker',
                    'default' => '#ffffff',
                ),

                array(
                    'name' => esc_html__('Desc Font Size', 'wp-deadlines'),
                    'id' => $prefix . 'desc_font',
                    'desc' => esc_html__('Provide a unit(16px, 16pt, 1em)', 'wp-deadlines'),
                    'type' => 'text_small',
                ),

                array(
                    'name' => esc_html__('Desc Color', 'wp-deadlines'),
                    'id' => $prefix . 'desc_color',
                    'type' => 'colorpicker',
                    'default' => '#ffffff',
                ),

                array(
                    'name' => esc_html__('Button Background Color', 'wp-deadlines'),
                    'id' => $prefix . 'button_bg_color',
                    'type' => 'colorpicker',
                    'default' => '#eee',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_button',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Button Background Color on Hover', 'wp-deadlines'),
                    'id' => $prefix . 'button_bg_hover_color',
                    'type' => 'colorpicker',
                    'default' => '#eee',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_button',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Button Text Color', 'wp-deadlines'),
                    'id' => $prefix . 'button_text_color',
                    'type' => 'colorpicker',
                    'default' => '#333',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_button',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Button Text Color on Hover', 'wp-deadlines'),
                    'id' => $prefix . 'button_text_hover_color',
                    'type' => 'colorpicker',
                    'default' => '#666',
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'enable_button',
                        'data-conditional-value' => 'on',
                    ),
                ),

                array(
                    'name' => esc_html__('Font Family', 'wp-deadlines'),
                    'id' => $prefix . 'font_family',
                    'type' => 'select',
                    'options' => array(
                        'default' => esc_attr('Default'),
                        'Cabin' => esc_attr('Cabin'),
                        'Dosis' => esc_attr('Dosis'),
                        'Josefin+Slab' => esc_attr('Josefin Slab'),
                        'Lato' => esc_attr('Lato'),
                        'Montserrat' => esc_attr('Montserrat'),
                        'Open+Sans' => esc_attr('Open Sans'),
                        'Play' => esc_attr('Play'),
                        'Quicksand' => esc_attr('Quicksand'),
                    ),
                ),

                array(
                    'name' => esc_html__('Font Weight', 'wp-deadlines'),
                    'id' => $prefix . 'font_weight',
                    'type' => 'select',
                    'options' => array(
                        '400' => esc_attr('Regular'),
                        '700' => esc_attr('Bold'),
                    ),
                    'attributes' => array(
                        'data-conditional-id' => $prefix . 'font_family',
                        'data-conditional-value' => wp_json_encode( array( 'Cabin', 'Dosis', 'Josefin+Slab', 'Lato', 'Montserrat', 'Open+Sans', 'Play', 'Quicksand' ) ),
                    ),
                ),
            )
        );

        $cmb_tabs->add_field( array(
            'id'   => '__wp_deadlines_metabox_tabs',
            'type' => 'tabs',
            'tabs' => $tabs_setting
        ) );

        if (isset($_GET) && isset($_GET['post'])) {
            $prev_id = get_option('_tg_deadline_current_id');
            $post_id = $_GET['post'];

            if ($post_id) {
                $current_id = get_post_meta($post_id, '_tg_deadline_countdown_id', true);
            } else {
                $current_id = $prev_id + 1;
            }

            $cmb_shortcode = new_cmb2_box(array(
                'id' => $prefix . 'display',
                'title' => esc_html__('Display Settings', 'wp-deadlines'),
                'object_types' => array('tg_wp_deadline'), // Post type
                // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
                'context' => 'side',
                'priority' => 'core',
                // 'show_names' => true, // Show field names on the left
                // 'cmb_styles' => false, // false to disable the CMB stylesheet
                // 'closed'     => true, // true to keep the metabox closed by default
                // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
                // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
            ));

            $cmb_shortcode->add_field(array(
                'name' => esc_html__('Shortcode', 'wp-deadlines'),
                'desc' => esc_html__('Copy and use this shortcode anywhere you want.', 'wp-deadlines'),
                'id' => '_tg_deadline_countdown_shortcode_field',
                'type' => 'text_medium',
                'save_field' => false, // Disables the saving of this field.
                'attributes' => array(
                    'disabled' => 'disabled',
                    'readonly' => 'readonly',
                    'value' => esc_attr('[wp-deadline id=' . $current_id . ']')
                ),
            ));

            $cmb_shortcode->add_field(array(
                'name' => esc_html__('GIF URL', 'wp-deadlines'),
                'desc' => esc_html__('Copy and use this gif url in your email template.', 'wp-deadlines'),
                'id' => '_tg_deadline_countdown_gif_url_field',
                'type' => 'text_medium',
                'save_field' => false, // Disables the saving of this field.
                'attributes' => array(
                    'disabled' => 'disabled',
                    'readonly' => 'readonly',
                    'value' => esc_attr('<img src="' . get_home_url() . '?wp_deadline=' . $current_id . '" alt="WP Deadlines"/>')
                ),
            ));
        }

    }

    public function add_custom_field_automatically($post)
    {
        if (!wp_is_post_revision($post->ID) && $post->post_type == 'tg_wp_deadline') {
            $prev_id = get_option('_tg_deadline_current_id');
            $current_id = $prev_id + 1;

            add_post_meta($post->ID, '_tg_deadline_countdown_id', $current_id, true);
            update_option('_tg_deadline_current_id', $current_id);
        }
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WP_Deadlines_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WP_Deadlines_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/css/wp-deadlines-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('cmb2-switch', plugin_dir_url(__FILE__) . 'includes/cmb2-switch/switch-metafield.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WP_Deadlines_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WP_Deadlines_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/js/wp-deadlines-admin.js', array('jquery'), $this->version, true);
        wp_enqueue_script('cmb2-switch', plugin_dir_url(__FILE__) . 'includes/cmb2-switch/switch-metafield.js', array('jquery'), $this->version, true);

    }

    public function add_buttons( $plugin_array ) {
        $plugin_array['wp_deadline'] = plugin_dir_url(__FILE__) . 'assets/js/tinymce-button.js';
        return $plugin_array;
    }
    public function register_buttons( $buttons ) {
        array_push( $buttons, 'wp_deadline_button' );
        return $buttons;
    }

    public function deadline_rest_endpoint( $data ) {
        $posts = get_posts(array(
            'post_type' => 'tg_wp_deadline',
            'posts_per_page' => -1,
            'offset' => 0
        ));

        $dealines = [];

        foreach ($posts as $post) {
            $id = get_post_meta($post->ID, '_tg_deadline_countdown_id', true);
            $dealines[$id] = $post->post_title;
        }

        return $dealines;
    }

    public function rest_route() {
        register_rest_route( 'wp-deadline/v1', '/deadlines', array(
            'methods' => 'GET',
            'callback' => array( $this, 'deadline_rest_endpoint' ),
        ) );
    }

}
