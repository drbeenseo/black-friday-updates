<?php

/**
 * @link              http://themesgrove.com/
 * @since             1.0.0
 * @package           WP_Deadlines
 *
 * @wordpress-plugin
 * Plugin Name:       WP Deadlines
 * Plugin URI:        http://themesgrove.com/plugins/wp-deadlines
 * Description:       Finally, A countdown timer to increase your sales and email conversions by creating a urgency to your buyer.
 * Version:           1.0.0
 * Author:            themesgrove
 * Author URI:        http://themesgrove.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-deadlines
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Adding Gif Generator
 */
require plugin_dir_path( __FILE__ ) . 'lib/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-deadlines-activator.php
 */
function activate_wp_deadlines() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-deadlines-activator.php';
	WP_Deadlines_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-deadlines-deactivator.php
 */
function deactivate_wp_deadlines() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-deadlines-deactivator.php';
	WP_Deadlines_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_deadlines' );
register_deactivation_hook( __FILE__, 'deactivate_wp_deadlines' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-deadlines.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_deadlines() {

	$plugin = new WP_Deadlines();
	$plugin->run();

}
run_wp_deadlines();
