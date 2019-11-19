<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
function show_wow_countdown_free($atts) {
    extract(shortcode_atts(array('id' => ""), $atts));	
    global $wpdb;
    $table_wow_countdown = $wpdb->prefix . "wow_countdown_free";   
    $SQL = $wpdb->prepare("select * from $table_wow_countdown WHERE id = %d", $id);
    $result = $wpdb->get_results($SQL); 
    if (count($result) > 0) {
        foreach ($result as $key => $val) {
			ob_start();
			include ('partials/public.php');						
			if ($val->type == 3 || $val->type == 5 ){
				wp_enqueue_script( 'wow-countdown-cookie-free-', plugin_dir_url( __FILE__ ) . 'js/jquery.cookie.js', array( 'jquery' ) );
			}	
			wp_enqueue_script( 'wow-countdown-script-free-'.$val->id, plugin_dir_url( __FILE__ ) . 'js/wowscript-'.$val->id.'.js', array( 'jquery' ) );			
			$output_count=ob_get_contents();
			ob_end_clean(); 			
        }
    } else {		
		$output_count = "<p><strong>No Records</strong></p>";        
    } 		
	return $output_count;
}
add_shortcode('Countdown', 'show_wow_countdown_free');