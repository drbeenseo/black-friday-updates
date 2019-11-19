<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
global $wpdb;
$wpdb->wow_countdown_free = $wpdb->prefix . 'wow_countdown_free';
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$sql = "CREATE TABLE " . $wpdb->wow_countdown_free . " (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  title VARCHAR(200) NOT NULL,
  type TEXT,
  day TEXT,
  month TEXT,
  year TEXT,
  hour TEXT,
  minut TEXT,
  nfirst TEXT,
  nsecond TEXT,
  direction TEXT,
  cookie TEXT,
  sec_step TEXT,
  speed TEXT,
  amount_step TEXT,
  amount TEXT,
  show_title_days TEXT,
  show_title_hours TEXT,
  show_title_minutes TEXT,
  show_title_seconds TEXT,
  title_days TEXT,
  title_hours TEXT,
  title_minutes TEXT,
  title_seconds TEXT,
  type_delimiter TEXT,
  hide_days TEXT,
  hide_hours TEXT,
  hide_minutes TEXT,
  hide_seconds TEXT,
  UNIQUE KEY id (id)
) DEFAULT CHARSET=utf8;";
dbDelta($sql);
?>