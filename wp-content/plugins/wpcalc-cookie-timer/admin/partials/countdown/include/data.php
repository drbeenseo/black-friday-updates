<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
global $wpdb;
$table_wow_countdown = $wpdb->prefix . "wow_countdown_free";
$wowpage = 'wow-countdown-free';
$act = (isset($_REQUEST["act"])) ? sanitize_text_field($_REQUEST["act"]) : '';
$recid = sanitize_text_field($_REQUEST["id"]);
$result = $wpdb->get_row("SELECT * FROM $table_wow_countdown WHERE id=$recid");
if ($act == "update") {    
    if ($result){
        $id = $result->id;
        $title = $result->title;
		$type = $result->type;
		$day = $result->day;
		$month = $result->month;
		$year = $result->year;
		$hour = $result->hour;
		$minut = $result->minut;
		$nfirst = $result->nfirst;
		$nsecond = $result->nsecond;
		$direction = $result->direction;
		$cookie = $result->cookie;
		$sec_step = $result->sec_step;
		$speed = $result->speed;		
		$amount_step = $result->amount_step;
		$amount = $result->amount;		
		$show_title_days = $result->show_title_days;
		$show_title_hours = $result->show_title_hours;
		$show_title_minutes = $result->show_title_minutes;
		$show_title_seconds = $result->show_title_seconds;
		$title_days = $result->title_days;
		$title_hours = $result->title_hours;
		$title_minutes = $result->title_minutes;
		$title_seconds = $result->title_seconds;
		$type_delimiter = $result->type_delimiter;
		$hide_days = $result->hide_days;
		$hide_hours = $result->hide_hours;
		$hide_minutes = $result->hide_minutes;
		$hide_seconds = $result->hide_seconds;
		$btn = __("Update", "wow-marketing");
        $hidval = 2;
    }
}
else if ($act == "duplicate") { 
   if ($result){   
        $id = "";
        $title = "";
		$type = $result->type;
		$day = $result->day;
		$month = $result->month;
		$year = $result->year;
		$hour = $result->hour;
		$minut = $result->minut;
		$nfirst = $result->nfirst;
		$nsecond = $result->nsecond;
		$direction = $result->direction;
		$cookie = $result->cookie;
		$sec_step = $result->sec_step;
		$speed = $result->speed;		
		$amount_step = $result->amount_step;
		$amount = $result->amount;		
		$show_title_days = $result->show_title_days;
		$show_title_hours = $result->show_title_hours;
		$show_title_minutes = $result->show_title_minutes;
		$show_title_seconds = $result->show_title_seconds;
		$title_days = $result->title_days;
		$title_hours = $result->title_hours;
		$title_minutes = $result->title_minutes;
		$title_seconds = $result->title_seconds;
		$type_delimiter = $result->type_delimiter;
		$hide_days = $result->hide_days;
		$hide_hours = $result->hide_hours;
		$hide_minutes = $result->hide_minutes;
		$hide_seconds = $result->hide_seconds;
		$btn = __("Save", "wow-marketing");
        $hidval = 1;
    }
}
 else {
        $btn = __("Save", "wow-marketing");
        $id = "";
        $title = "";
		$type = "";
		$day = "1";
		$month = "11";
		$year = date ('Y');
		$hour = "1";
		$minut = "1";
		$nfirst = "399";
		$nsecond = "150";
		$direction = "";
		$cookie = "";
		$sec_step = "";
		$speed = "5";		
		$amount_step = "";
		$amount = "1";		
		$show_title_days = "";
		$show_title_hours = "";
		$show_title_minutes = "";
		$show_title_seconds = "";
		$title_days = "Days";
		$title_hours = "Hours";
		$title_minutes = "Minutes";
		$title_seconds = "Seconds";
		$hide_days = "";
		$hide_hours = "";
		$hide_minutes = "";
		$hide_seconds = "";
		$type_delimiter = "";
        $hidval = 1;	
}
?>