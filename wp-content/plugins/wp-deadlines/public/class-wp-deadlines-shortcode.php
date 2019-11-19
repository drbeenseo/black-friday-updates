<?php

/**
 *
 * WP Deadlines Shortcode
 *
 */
class WP_Deadlines_Shortcode
{


    /**
     *
     * Shortcode Name
     *
     * @var string
     */

    private $name = 'wp-deadline';


    /**
     * Instance of class
     */
    private static $instance;

    /**
     * Initialization
     */
    public static function init()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    private function __construct()
    {

        add_shortcode($this->name, array($this, 'create_deadline_shortcode'));
    }


    /**
     * Shortcode Function
     *
     * @param $atts
     *
     * @return string
     */

    public function create_deadline_shortcode($atts)
    {

        ob_start();

        $data = shortcode_atts(array(
            'id' => '',
        ), $atts);


        $args = array(
            'post_type' => 'tg_wp_deadline',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_tg_deadline_countdown_id',
                    'value' => (int)$data['id'],
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
        $enable_cookie = get_post_meta($countdown->ID, '_tg_deadline_countdown_enable_cookie', true);
        $cookie = get_post_meta($countdown->ID, '_tg_deadline_countdown_cookie', true);

        $title = get_post_meta($countdown->ID, '_tg_deadline_countdown_title', true);
        $desc = get_post_meta($countdown->ID, '_tg_deadline_countdown_desc', true);
        $message = get_post_meta($countdown->ID, '_tg_deadline_countdown_message', true);

        $show_days = 'off' == get_post_meta($countdown->ID, '_tg_deadline_countdown_hide_day', true) ? true : false;
        $show_hours = 'off' == get_post_meta($countdown->ID, '_tg_deadline_countdown_hide_hour', true) ? true : false;
        $show_minutes = 'off' == get_post_meta($countdown->ID, '_tg_deadline_countdown_hide_min', true) ? true : false;
        $show_seconds = 'off' == get_post_meta($countdown->ID, '_tg_deadline_countdown_hide_sec', true) ? true : false;

        $custom_label = 'on' == get_post_meta($countdown->ID, '_tg_deadline_countdown_custom_label', true) ? true : false;
        $label_day = get_post_meta($countdown->ID, '_tg_deadline_countdown_days', true);
        $label_hour = get_post_meta($countdown->ID, '_tg_deadline_countdown_hours', true);
        $label_min = get_post_meta($countdown->ID, '_tg_deadline_countdown_minutes', true);
        $label_sec = get_post_meta($countdown->ID, '_tg_deadline_countdown_seconds', true);

        $bg_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_bgcolor', true);
        $digit_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_digit_color', true);
        $label_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_label_color', true);
        $title_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_title_color', true);
        $desc_color = get_post_meta($countdown->ID, '_tg_deadline_countdown_desc_color', true);
        $digit_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_digit_font', true);
        $label_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_label_font', true);
        $title_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_title_font', true);
        $desc_font_size = get_post_meta($countdown->ID, '_tg_deadline_countdown_desc_font', true);

        $font_family = get_post_meta($countdown->ID, '_tg_deadline_countdown_font_family', true);
        $font_weight = get_post_meta($countdown->ID, '_tg_deadline_countdown_font_weight', true);
        $font_family_sanitized = preg_replace('/\+/', ' ', $font_family);

        ?>
        <style>
            #wp-deadline-countdown-<?php echo esc_attr($data['id']); ?> .count-item .count-digit {
                font-family: <?php echo $font_family_sanitized == 'default' ? 'inherit' : '"'.$font_family_sanitized.'"'; ?>;
                font-weight: <?php echo $font_weight; ?>;
                font-size: <?php echo $digit_font_size ?>;
                color: <?php echo $digit_color; ?>;
            }
            #wp-deadline-countdown-<?php echo esc_attr($data['id']); ?> .count-item .count-label {
                font-family: <?php echo $font_family_sanitized == 'default' ? 'inherit' : '"'.$font_family_sanitized.'"'; ?>;
                font-weight: <?php echo $font_weight; ?>;
                font-size: <?php echo $label_font_size ?>;
                color: <?php echo $label_color; ?>;
            }
            <?php if(WP_Deadlines::deadline_pro_active()):
            $container_style = get_post_meta($countdown->ID, '_tg_deadline_countdown_pro', true);
            ?>

            <?php endif; ?>
        </style>
        <div class="wp-deadlines" style="background-color: <?php echo $bg_color; ?>;">
            <?php if($title || $desc): ?>
            <div class="wp-deadline-content">
                <?php if($title): ?><h3 class="wp-deadline-title" style='font-size: <?php echo $title_font_size; ?>; color: <?php echo $title_color; ?>;'><?php echo esc_html($title); ?></h3><?php endif; ?>
                <?php if($desc): ?><p class="wp-deadline-desc" style='font-size: <?php echo $desc_font_size; ?>; color: <?php echo $desc_color; ?>;'><?php echo esc_html($desc); ?></p><?php endif; ?>
            </div>
            <?php endif; ?>
            <div id="wp-deadline-countdown-<?php echo esc_attr($data['id']); ?>"></div>
        </div>
        <?php if ($type == 'date'): ?>
        <script>
            var nextYear = moment.tz("<?php echo date('Y-m-d H:i:s', $date); ?>", "<?php echo $timezone; ?>");

            jQuery('#wp-deadline-countdown-<?php echo esc_attr($data['id']); ?>').countdown(nextYear.toDate(), function (event) {
                jQuery(this).html(event.strftime(''
                    <?php if($show_days): ?> + '<div class="days count-item"><span class="count-digit" >%-D</span> <span class="count-label"> <?php echo $custom_label ? $label_day : esc_html__('Days', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                    <?php if($show_hours): ?> + '<div class="hours count-item"><span class="count-digit">%H</span> <span class="count-label"> <?php echo $custom_label ? $label_hour : esc_html__('Hours', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                    <?php if($show_minutes): ?> + '<div class="minutes count-item"><span class="count-digit">%M</span> <span class="count-label"> <?php echo $custom_label ? $label_min : esc_html__('Minutes', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                    <?php if($show_seconds): ?> + '<div class="seconds count-item"><span class="count-digit">%S</span> <span class="count-label"> <?php echo $custom_label ? $label_sec : esc_html__('Seconds', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                ));
                jQuery(this).on('finish.countdown', function (event) {
                    jQuery(this).parent()
                        .addClass('disabled')
                        .html('<?php echo '<p class="countdown-finished-message">'.esc_html($message).'</p>'; ?>');
                    jQuery('body').addClass('wp-deadline-countdown-finished');
                });
            });
        </script>

    <?php elseif ($type == 'time' && $enable_cookie): ?>

        <script>
            var $clockCookie_<?php echo $data['id']; ?> = jQuery('#wp-deadline-countdown-<?php echo esc_attr($data['id']); ?>')
                .on('update.countdown', function (event) {
                    var format = <?php if($show_hours): ?> '<div class="hours count-item"><span class="count-digit">%H</span> <span class="count-label"> <?php echo $custom_label ? $label_hour : esc_html__('Hours', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                        <?php if($show_minutes): ?> + '<div class="minutes count-item"><span class="count-digit">%M</span> <span class="count-label"> <?php echo $custom_label ? $label_min : esc_html__('Minutes', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                        <?php if($show_seconds): ?> + '<div class="seconds count-item"><span class="count-digit">%S</span> <span class="count-label"> <?php echo $custom_label ? $label_sec : esc_html__('Seconds', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>;
                    if (event.offset.totalDays > 0) {
                        format = <?php if($show_days): ?> '<div class="days count-item"><span class="count-digit" >%-D</span> <span class="count-label"> <?php echo $custom_label ? $label_day : esc_html__('Days', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?> + format;
                    }
                    jQuery(this).html(event.strftime(format));
                })
                .on('finish.countdown', function (event) {
                    jQuery(this).parent()
                        .addClass('disabled')
                        .html('<?php echo '<p class="countdown-finished-message">'.esc_html($message).'</p>'; ?>');
                    jQuery('body').addClass('wp-deadline-countdown-finished');
                });
            if (Cookies.get('wp-deadline-cookie-id-<?php echo $data['id']; ?>')) {
                var $valCookie_<?php echo $data['id'];?> = Cookies.get('wp-deadline-cookie-id-<?php echo $data['id']; ?>');
            }
            else {
                var $valCookie_<?php echo $data['id'];?> = (new Date()).getTime() + (<?php echo $day_count;?> * 86400000) + (<?php echo $hour_count;?> * 3600000) + (<?php echo $min_count;?> * 60000);
                Cookies.set('wp-deadline-cookie-id-<?php echo $data['id']; ?>', $valCookie_<?php echo $data['id'];?>, {
                    expires: <?php if ($cookie == "") {
                    echo '1';
                } else {
                    echo $cookie;
                }?>});
            }
            $clockCookie_<?php echo $data['id']; ?>.countdown($valCookie_<?php echo $data['id']; ?>.toString());
        </script>

    <?php elseif ($type == 'time'): ?>

        <script>
            var $clockTime_<?php echo $data['id']; ?> = jQuery('#wp-deadline-countdown-<?php echo esc_attr($data['id']); ?>')
                .on('update.countdown', function (event) {
                    var format = <?php if($show_hours): ?> '<div class="hours count-item"><span class="count-digit">%H</span> <span class="count-label"> <?php echo $custom_label ? $label_hour : esc_html__('Hours', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                        <?php if($show_minutes): ?> + '<div class="minutes count-item"><span class="count-digit">%M</span> <span class="count-label"> <?php echo $custom_label ? $label_min : esc_html__('Minutes', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>
                        <?php if($show_seconds): ?> + '<div class="seconds count-item"><span class="count-digit">%S</span> <span class="count-label"> <?php echo $custom_label ? $label_sec : esc_html__('Seconds', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?>;
                    if (event.offset.totalDays > 0) {
                        format = <?php if($show_days): ?> '<div class="days count-item"><span class="count-digit" >%-D</span> <span class="count-label"> <?php echo $custom_label ? $label_day : esc_html__('Days', 'wp-deadlines'); ?> </span> </div> ' <?php endif; ?> + format;
                    }
                    jQuery(this).html(event.strftime(format));
                })
                .on('finish.countdown', function (event) {
                    jQuery(this).parent()
                        .addClass('disabled')
                        .html('<?php echo '<p class="countdown-finished-message">'.esc_html($message).'</p>'; ?>');
                    jQuery('body').addClass('wp-deadline-countdown-finished');
                });

            var $valTime_<?php echo $data['id']; ?> = (new Date()).getTime() + (<?php echo $day_count;?> * 86400000) + (<?php echo $hour_count;?> * 3600000) + (<?php echo $min_count;?> * 60000);
            $clockTime_<?php echo $data['id']; ?>.countdown($valTime_<?php echo $data['id']; ?>.toString());

        </script>

    <?php endif;
        $output = ob_get_clean();

        return $output;

    }

}
