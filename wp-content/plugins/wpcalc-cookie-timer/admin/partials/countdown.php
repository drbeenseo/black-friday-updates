<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$wow = sanitize_text_field($_REQUEST["wow"]);
include_once( 'countdown/menu.php' );
if ($wow == "add"){
	include_once( 'countdown/add.php' );	
}
if ($wow == "discount"){
	include_once( 'modal/discount.php' );	
	return;
}
if ($wow == ""){
	include_once( 'countdown/list.php' );
}
?>
</div>