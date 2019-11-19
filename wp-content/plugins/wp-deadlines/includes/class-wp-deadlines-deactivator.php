<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://themesgrove.com/
 * @since      1.0.0
 *
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WP_Deadlines
 * @subpackage WP_Deadlines/includes
 * @author     themesgrove <rafiqul@themexpert.com>
 */
class WP_Deadlines_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        delete_option( '_tg_deadline_current_id' );
	}

}
