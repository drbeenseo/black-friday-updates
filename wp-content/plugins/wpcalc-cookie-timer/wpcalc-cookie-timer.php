<?php
/**
 * Plugin Name:       Wpcalc Cookie Timer
 * Plugin URI:        https://wordpress.org/plugins/wpcalc-cookie-timer
 * Description:       Increase conversion by limiting your offer with an amount or time-based countdown
 * Version:           2.0
 * Author:            Wow Company
 * Author URI:        http://wow-company.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wow-marketing
  */
if ( ! defined( 'WPINC' ) ) {die;}
define( 'WOW_COUNTDOWNS_FREE_PLUGIN_BASENAME', dirname(plugin_basename(__FILE__)) );
load_plugin_textdomain('wow-marketing', false, dirname(plugin_basename(__FILE__)) . '/languages/');

function activate_wow_free_countdown() {
	require_once plugin_dir_path( __FILE__ ) . 'include/activator.php';	
	}	
register_activation_hook( __FILE__, 'activate_wow_free_countdown' );
if( !class_exists( 'WOWWPClass' )) {
	require_once plugin_dir_path( __FILE__ ) . 'include/wowclass.php';
}
if( !class_exists( 'JavaScriptPacker' )) {
	require_once plugin_dir_path( __FILE__ ) . 'include/class.JavaScriptPacker.php';
}
function deactivate_wow_free_countdown() {	
	require_once plugin_dir_path( __FILE__ ) . 'include/deactivator.php';
}
register_deactivation_hook( __FILE__, 'deactivate_wow_free_countdown' );
require_once plugin_dir_path( __FILE__ ) . 'admin/admin.php';
require_once plugin_dir_path( __FILE__ ) . 'public/public.php';

function wow_free_countdown_row_meta( $meta, $plugin_file ){
	if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $meta;

	$meta[] = 'Support: <a href="https://www.facebook.com/wowaffect/" target="_blank">Facebook</a>';
	return $meta; 
}
add_filter( 'plugin_row_meta', 'wow_free_countdown_row_meta', 10, 4 );

function wow_free_countdown_action_links( $actions, $plugin_file ){
	if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $actions;

	$settings_link = '<a href="admin.php?page=wow-countdown-free' .'">Settings</a>'; 
	array_unshift( $actions, $settings_link ); 
	return $actions; 
}
add_filter( 'plugin_action_links', 'wow_free_countdown_action_links', 10, 2 );