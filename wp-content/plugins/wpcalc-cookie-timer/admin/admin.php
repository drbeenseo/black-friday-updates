<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
function wow_free_countdown_admin_menu() {
	add_menu_page('Countdowns', __( "Countdowns", "wow-marketing"), 'edit_pages', 'wow-countdown-free', 'wow_free_countdown_free', 'dashicons-clock', null); 		
}
add_action('admin_menu', 'wow_free_countdown_admin_menu');
function wow_free_countdown_free() {
	global $wow_plugin;
	$wow_plugin = 'countdown';
	include_once( 'partials/countdown.php' );	
	wp_enqueue_script( 'wow-countdown', plugin_dir_url(__FILE__) . 'js/countdown.js', array( 'jquery' ));
	wp_enqueue_style('wow-countdown-free-style', plugin_dir_url(__FILE__) . 'css/style.css');	 	
	wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
	wp_enqueue_script( 'wp-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.js', array( 'wp-color-picker' ));	
}


if ( ! function_exists ( 'wow_nonce_chek' ) ) {
function wow_nonce_chek() 
{
	if ( !empty($_POST) && wp_verify_nonce($_POST['wow_nonce_field'],'wow_action') && current_user_can('manage_options'))
	{
		wow_run_wowwpclass();
	}	
}
add_action( 'plugins_loaded', 'wow_nonce_chek' );

function wow_run_wowwpclass(){
$objItem = new WOWWPClass();
$addwow = (isset($_REQUEST["addwow"])) ? sanitize_text_field($_REQUEST["addwow"]) : '';
$table_name = sanitize_text_field($_REQUEST["wowtable"]);
$wowpage = sanitize_text_field($_REQUEST["wowpage"]);
$id = sanitize_text_field($_POST['id']);
/*  Save and update Record on button submission */
if (isset($_POST["submit"])) {
    if (sanitize_text_field($_POST["addwow"]) == "1") {
        $objItem->addNewItem($table_name, $_POST);			
        header("Location:admin.php?page=".$wowpage."&info=saved");
		exit;		
    } else if (sanitize_text_field($_POST["addwow"]) == "2") {
        $objItem->updItem($table_name, $_POST);				
        header("Location:admin.php?page=".$wowpage."&wow=add&act=update&id=".$id."&info=update");		
       exit;
    }
}
}
}

function wow_free_countdown_admin_rate_us( $footer_text ) {
	global $wow_plugin;	
	if ( $wow_plugin == 'countdown' ) {
		$rate_text = sprintf( '<span id="footer-thankyou">Countdowns developed by <a href="http://wow-company.com/" target="_blank">Wow Company</a> | <a href="https://wordpress.org/plugins/countdowns/" target="_blank">Visit plugin site</a> | Support: <a href="https://www.facebook.com/wowaffect/" target="_blank">Facebook</a> </span>'
		);
		return str_replace( '</span>', '', $footer_text ) . ' | ' . $rate_text . '</span>';
	}
	else {
		return $footer_text;
	}	
}
add_filter( 'admin_footer_text', 'wow_free_countdown_admin_rate_us' );