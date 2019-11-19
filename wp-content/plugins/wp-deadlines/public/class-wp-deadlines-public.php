<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://themesgrove.com/
 * @since      1.0.0
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/public
 * @author     themesgrove <rafiqul@themexpert.com>
 */
class WP_Deadlines_Public
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
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function get_flyout_countdown()
    {
        $args = array(
            'post_type' => 'tg_wp_deadline',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_tg_deadline_countdown_enable_flyout',
                    'value' => 'on',
                )
            )
        );

        return get_posts($args);
    }

    public function inline_style()
    {
        ob_start();
        $deadline = $this->get_flyout_countdown();
        if ($deadline):
            $countdown = $deadline[0];
            $bg_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_bgcolor', true);
            $digit_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_digit_color', true);
            $label_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_label_color', true);
            $digit_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_digit_font', true);
            $label_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_label_font', true);
            $button_bg_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_button_bg_color', true);
            $button_bg_hover_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_button_bg_hover_color', true);
            $button_text_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_button_text_color', true);
            $button_text_hover_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_button_text_hover_color', true);
            $font_family = get_post_meta($countdown->ID, '_tg_deadline_countdown_font_family', true);
            $font_weight = get_post_meta($countdown->ID, '_tg_deadline_countdown_font_weight', true);
            $font_family_sanitized = preg_replace('/\+/', ' ', $font_family);

            ?>

            .wp-deadline-flyout {
                background-color: <?php echo $bg_color; ?>;
            }
            .wp-deadline-flyout .count-item .count-digit {
                font-family: <?php echo $font_family_sanitized == 'default' ? 'inherit' : '"'.$font_family_sanitized.'"'; ?>;
                font-size: <?php echo $digit_font_size; ?>;
                font-weight: <?php echo $font_weight; ?>;
                color: <?php echo $digit_color; ?>;
            }
            .wp-deadline-flyout .count-item .count-label {
                font-family: <?php echo $font_family_sanitized == 'default' ? 'inherit' : '"'.$font_family_sanitized.'"'; ?>;
                font-size: <?php echo $label_font_size; ?>;
                font-weight: <?php echo $font_weight; ?>;
                color: <?php echo $label_color; ?>;
            }
            .wp-deadline-flyout .wp-deadline-flyout-btn {
                background-color: <?php echo $button_bg_color; ?>;
                color: <?php echo $button_text_color; ?>;
                transition: all 0.3s;
            }
            .wp-deadline-flyout .wp-deadline-flyout-btn:hover {
                background-color: <?php echo $button_bg_hover_color; ?>;
                color: <?php echo $button_text_hover_color; ?>;
                transition: all 0.3s;
            }

        <?php endif; ?>
        <?php return ob_get_clean();
    }

    public function hex_to_rgb($hex) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['red'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['green'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['blue'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

        return $rgb;
    }

    public function process_gif_url() {

        if(isset($_GET['wp_deadline'])) {
            $id = $_GET['wp_deadline'];
            $args = array(
                'post_type' => 'tg_wp_deadline',
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => '_tg_deadline_countdown_id',
                        'value' => (int)$id,
                    )
                )
            );
            $deadline = get_posts($args);
            $countdown = $deadline[0];

            $type = get_post_meta($countdown->ID, '_tg_deadline_countdown_type', true);
            $date = get_post_meta($countdown->ID, '_tg_deadline_countdown_timestamp', true);
            $timezone = get_post_meta($countdown->ID, '_tg_deadline_countdown_timezone', true);
            $day_count = get_post_meta($countdown->ID, '_tg_deadline_countdown_day_count', true);
            $hour_count = get_post_meta($countdown->ID, '_tg_deadline_countdown_hour_count', true);
            $min_count = get_post_meta($countdown->ID, '_tg_deadline_countdown_min_count', true);
//            $enable_cookie = get_post_meta($countdown->ID, '_tg_deadline_countdown_enable_cookie', true);
//            $cookie = get_post_meta($countdown->ID, '_tg_deadline_countdown_cookie', true);

            $bg_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_bgcolor', true);
            $digit_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_digit_color', true);
//            $label_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_label_color', true);
//            $digit_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_digit_font', true);
//            $label_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_label_font', true);

            $slug = sanitize_title($countdown->post_title);
            $file_name = $slug . '-' . $countdown->ID;

            if($type == 'date') {
                $countdown = new \Countdown\Countdown(
                    $file_name,
                    date('Y-m-d H:i:s', $date),
                    $bg_color,
                    [
                        'size' => 80,
                        'font-color' => $this->hex_to_rgb($digit_color),
                        'file' => 'Dosis-Bold.ttf' // this font stored in the storage/fonts directory
                        // don't forget to store all required fonts file in the storage/fonts directory
                    ],
                    $timezone,
                    false // if you will need evergreen countdown, changed it to true. Default value is false
                );
            } else {
                $time = time() + ($day_count * 86400) + ($hour_count * 3600) + ($min_count * 60);

                $countdown = new \Countdown\Countdown(
                    $file_name,
                    date('Y-m-d H:i:s', $time),
                    $bg_color,
                    [
                        'size' => 80,
                        'font-color' => $this->hex_to_rgb($digit_color),
                        'file' => 'Dosis-Bold.ttf' // this font stored in the storage/fonts directory
                        // don't forget to store all required fonts file in the storage/fonts directory
                    ],
                    date_default_timezone_get(),
                    false // if you will need evergreen countdown, changed it to true. Default value is false
                );
            }

            $countdown->getGif();
        }
    }

    /*
    * Register Fonts
    */
    public function google_fonts_url()
    {
        $font_url = '';
        $family = '';

        $deadlines = get_posts(array(
            'post_type' => 'tg_wp_deadline',
            'posts_per_page' => -1,
            'offset' => 0
        ));
        $counter = 1;
        foreach ($deadlines as $deadline) {
            $font_family = get_post_meta($deadline->ID, '_tg_deadline_countdown_font_family', true);
            $font_weight = get_post_meta($deadline->ID, '_tg_deadline_countdown_font_weight', true);
            if($font_family != 'default' && $font_weight) {
                $counter ++;
                $pipe = $counter > 1 ? '|' : '';
                $family .= $font_family . ':' . $font_weight . $pipe;
            }
        }

        if($family) {
            $font_url = add_query_arg('family', $family, "https://fonts.googleapis.com/css");
        }

        return $font_url;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name.'-google-fonts', $this->google_fonts_url(), array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/css/wp-deadlines-public.css', array(), $this->version, 'all');
        wp_add_inline_style( $this->plugin_name, $this->inline_style() );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script('js.cookie', plugin_dir_url(__FILE__) . 'assets/js/js.cookie.js', array(), $this->version, false);
        wp_enqueue_script('moment.js', plugin_dir_url(__FILE__) . 'assets/js/moment.min.js', array(), $this->version, false);
        wp_enqueue_script('jquery.countdown', plugin_dir_url(__FILE__) . 'assets/js/jquery.countdown.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/js/wp-deadlines-public.js', array('jquery'), $this->version, true);

    }


    public function enable_flyout()
    {

        $deadline = $this->get_flyout_countdown();
        if ($deadline) {
            $countdown = $deadline[0];
            $id = get_post_meta($countdown->ID, '_tg_deadline_countdown_id', true);
            $position = get_post_meta($countdown->ID, '_tg_deadline_countdown_flyout', true);
            $enable_button = get_post_meta($countdown->ID, '_tg_deadline_countdown_enable_button', true);
            $button_text = get_post_meta($countdown->ID, '_tg_deadline_countdown_button_text', true);
            $button_link = get_post_meta($countdown->ID, '_tg_deadline_countdown_button_link', true);
            $class = $position == 'top' ? 'flyout-top' : 'flyout-bottom';
            echo '<div class="wp-deadline-flyout ' . $class . '">';
            echo '<span class="tg-close-btn">&times;</span>';
            echo do_shortcode('[wp-deadline id=' . $id . ']');
            if($enable_button) {
                echo '<a href="'.$button_link.'" class="wp-deadline-flyout-btn">'.$button_text.'</a>';
            }
            echo '</div>';
        }

    }

}
