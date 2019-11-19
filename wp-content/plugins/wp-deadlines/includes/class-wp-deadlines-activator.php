<?php

/**
 * Fired during plugin activation
 *
 * @link       http://themesgrove.com/
 * @since      1.0.0
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/includes
 * @author     themesgrove <rafiqul@themexpert.com>
 */
class WP_Deadlines_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        add_option( '_tg_deadline_current_id', 0);
	}

}
