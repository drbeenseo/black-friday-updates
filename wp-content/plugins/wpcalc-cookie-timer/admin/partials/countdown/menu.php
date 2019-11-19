<?php
global $wpdb;
$table_wow_countdown = $wpdb->prefix . "wow_countdown_free";
$info = (isset($_REQUEST["info"])) ? sanitize_text_field($_REQUEST["info"]) : '';
if ($info == "saved") {
    echo "<div class='updated' id='message'><p><strong>".__("Record Added", "wow-marketing")."</strong>.</p></div>";
}
if ($info == "update") {
    echo "<div class='updated' id='message'><p><strong>".__("Record Updated", "wow-marketing")."</strong>.</p></div>";
}
if ($info == "del") {
    $delid = sanitize_text_field($_GET["did"]);
    $wpdb->query("delete from " . $table_wow_countdown . " where id=" . $delid);
    echo "<div class='updated' id='message'><p><strong>".__("Record Deleted", "wow-marketing").".</strong>.</p></div>";
}
$resultat = $wpdb->get_results("SELECT * FROM " . $table_wow_countdown . " order by id asc");
$count = count($resultat);
?>
<div class="wrap">
<h1><?php esc_attr_e("Countdowns", "wow-marketing") ?></h1>
<ul class="wow-admin-menu">
<li><a href='admin.php?page=wow-countdown-free'><?php esc_attr_e("List", "wow-marketing") ?></a></li>	
	<li>
	<?php if($count<2){?>
	<a href='admin.php?page=wow-countdown-free&wow=add' ><?php esc_attr_e("Add new", "wow-marketing") ?></a>
	<?php } ?>
	</li>
	<li><a href='https://wow-estore.com/downloads/wow-countdowns/'><?php esc_attr_e("Wow Version", "wow-marketing") ?></a></li>
	<li><a href='admin.php?page=wow-countdown-free&wow=discount'><?php esc_attr_e("Get Discount", "wow-marketing") ?></a></li>
</ul>
<div class="wow_admin_signup">
<div class="wow-admin-col">
<div class="wow-admin-col-6">
<h2>JOIN OUR COMMUNITY<br/>
<span>&#8212; GET HELP, ADVICE & SUPPORT &#8658;</span></h2>
<div id="mc_embed_signup">
<form action="//wow-company.us14.list-manage.com/subscribe/post?u=126700b62c4c1e00f43226607&amp;id=a832a18981" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
<div class="mc-field-group">
<input type="email" value=""  placeholder="ENTER YOUR EMAIL HERE" name="EMAIL" class="required email" id="mce-EMAIL">
<input class="wow_admin_green" name="subscribe" id="mc-embedded-subscribe" type="submit" value="Sign Up Now">


</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>   
    <div class="clear"></div>
</form>


</div>
<!--End mc_embed_signup-->
<span>If you want to know about other Wow plugins and get more attractive DISCOUNTS</span>
</div>
<div class="wow-admin-col-6">
<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fwowaffect%2F&tabs&width=500&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=365329313856232" width="500" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
</div>
</div>

</div>