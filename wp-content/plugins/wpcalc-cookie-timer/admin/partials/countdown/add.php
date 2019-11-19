<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php include ('include/data.php'); ?>
<div class="metabox-holder" id="poststuff">
<div class="meta-box-sortables">
<h3><?php esc_attr_e("Countdown", "marketing-wp") ?> <span><?php esc_attr_e("Shortcode", "marketing-wp") ?>: <?php echo "[Countdown id=$id]"; ?></span></h3>
<form action="admin.php?page=wow-countdown-free" method="post">
<div class="postbox">
<div class="inside wow-admin" style="display: block;">	
<div class="wow-admin-col">
<div class="wow-admin-col-12">
<b><?php esc_attr_e("Name", "marketing-wp") ?>:</b> <input  placeholder="Name is used only for admin purposes" type='text' name='title' value="<?php echo $title; ?>" />
</div>
</div>
</div>
</div>
<div class="postbox">
<h3 class=""><?php esc_attr_e("Countdown settings", "marketing-wp") ?></h3>
<div class="inside wow-admin" style="display: block;">	
<div class="wow-admin-col">
<div class="wow-admin-col-3"><?php esc_attr_e("Countdown type", "marketing-wp") ?>:<br/>
<select name='type' onchange="changetype();" id="type">        
        <option value="1" <?php if($type=='1') { echo 'selected="selected"'; } ?>><?php esc_attr_e("To date", "marketing-wp") ?></option>
		<option value="2" <?php if($type=='2') { echo 'selected="selected"'; } ?>><?php esc_attr_e("Time", "marketing-wp") ?></option>
		<option value="3" <?php if($type=='3') { echo 'selected="selected"'; } ?>><?php esc_attr_e("Time with cookies", "marketing-wp") ?></option> 
		<option value="4" <?php if($type=='4') { echo 'selected="selected"'; } ?>><?php esc_attr_e("Amount", "marketing-wp") ?></option>
		<option value="5" <?php if($type=='5') { echo 'selected="selected"'; } ?>><?php esc_attr_e("Amount with cookies", "marketing-wp") ?></option>		
    </select>
</div>
<div class="wow-admin-col-3" id="day"><span id="days"><?php esc_attr_e("Day", "marketing-wp") ?></span>:<br/>
<input  placeholder="1" type='text' name='day' value="<?php echo $day;?>"/>
</div>
<div class="wow-admin-col-3" id="month"><?php esc_attr_e("Month", "marketing-wp") ?>:<br/>
<select name='month'>
<?php for ($i = 0; $i <=11; $i++){
	$imonth = $i+1;
	$monthname = date('F', mktime(12,0,0,$imonth,1,2016));
	if ($i == $month){
		echo "<option selected value=\"$i\">$monthname</option>";
	}
	else {
		echo "<option value=\"$i\">$monthname</option>";
	}
};?>
</select>
</div>
<div class="wow-admin-col-3" id="year"><?php esc_attr_e("Year", "marketing-wp") ?>:<br/>
<select name='year'>
<?php for ($i = date("Y"); $i <=2050; $i++){
	if ($i == $year){
		echo "<option selected value=\"$i\">$i</option>";
	}
	else {
		echo "<option value=\"$i\">$i</option>";
	}
};?>
</select>
</div>
<div class="wow-admin-col-3" id="hour"><?php esc_attr_e("Hours", "marketing-wp") ?>:<br/>
<input  placeholder="1" type='text' name='hour' value="<?php echo $hour;?>"/>
</div>
<div class="wow-admin-col-3" id="minut"><?php esc_attr_e("Minutes", "marketing-wp") ?>:<br/>
<input  placeholder="1" type='text' name='minut' value="<?php echo $minut;?>"/>
</div>
<div class="wow-admin-col-3" id="nfirst"><?php esc_attr_e("Starting number", "marketing-wp") ?>:<br/>
<input  placeholder="399" type='text' name='nfirst' value="<?php echo $nfirst;?>"/>
</div>
<div class="wow-admin-col-3" id="nsecond"><?php esc_attr_e("End number", "marketing-wp") ?>:<br/>
<input  placeholder="155" type='text' name='nsecond' value="<?php echo $nsecond;?>"/>
</div>
<div class="wow-admin-col-3" id="direction"><?php esc_attr_e("Direction", "marketing-wp") ?>:<br/>
<select name='direction'>        
        <option value="1" <?php if($direction=='1') { echo 'selected="selected"'; } ?>><?php esc_attr_e("down", "marketing-wp") ?></option>
		<option value="2" <?php if($direction=='2') { echo 'selected="selected"'; } ?>><?php esc_attr_e("up", "marketing-wp") ?></option>
    </select>
</div>
<div class="wow-admin-col-3" id="cookie"><?php esc_attr_e("Reset in", "marketing-wp") ?>:<br/>
<input  placeholder="1" type='text' name='cookie' value="<?php echo $cookie;?>"/> <?php esc_attr_e("days", "marketing-wp") ?>
</div>
</div>
<div id="speed">
<div class="wow-admin-col">
<div class="wow-admin-col-3"><?php esc_attr_e("Time increment mode", "marketing-wp") ?>:<br/>
<select name='sec_step' onchange="steps();">        
        <option value="stable" <?php if($sec_step=='stable') { echo 'selected="selected"'; } ?>><?php esc_attr_e("stable", "marketing-wp") ?></option>		
    </select>
</div>
<div class="wow-admin-col-3 stable_step"><?php esc_attr_e("Increment every", "marketing-wp") ?>:<br/>
<input type='text' name='speed' value="<?php echo $speed;?>"/> <?php esc_attr_e("sec", "marketing-wp") ?>
</div>
</div>
<div class="wow-admin-col">
<div class="wow-admin-col-3"><?php esc_attr_e("Amount increment mode", "marketing-wp") ?>:<br/>
<select name='amount_step' onchange="amountstep();">        
        <option value="stable" <?php if($amount_step=='stable') { echo 'selected="selected"'; } ?>><?php esc_attr_e("stable", "marketing-wp") ?></option>		
    </select>
</div>
<div class="wow-admin-col-3 stable_amount"><?php esc_attr_e("Amount", "marketing-wp") ?>:<br/>
<input type='text' name='amount' value="<?php echo $amount;?>"/>
</div>
</div>
</div>
<div id="titles">
<div class="wow-admin-col">
<div class="wow-admin-col-3"><?php esc_attr_e("Show title for Days", "marketing-wp") ?>:<br/>
<select name='show_title_days' onchange="titledays();">        
        <option value="no" <?php if($show_title_days=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>
		<option value="yes" <?php if($show_title_days=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>
    </select>
</div>
<div class="wow-admin-col-3"><?php esc_attr_e("Show title for Hours", "marketing-wp") ?>:<br/>
<select name='show_title_hours' onchange="titlehours();">        
        <option value="no" <?php if($show_title_hours=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>
		<option value="yes" <?php if($show_title_hours=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>
    </select>
</div>
<div class="wow-admin-col-3"><?php esc_attr_e("Show title for Minutes", "marketing-wp") ?>:<br/>
<select name='show_title_minutes' onchange="titleminutes();">        
        <option value="no" <?php if($show_title_minutes=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>
		<option value="yes" <?php if($show_title_minutes=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>
    </select>
</div>
<div class="wow-admin-col-3"><?php esc_attr_e("Show title for Seconds", "marketing-wp") ?>:<br/>
<select name='show_title_seconds' onchange="titleseconds();">        
        <option value="no" <?php if($show_title_seconds=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>
		<option value="yes" <?php if($show_title_seconds=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>				
    </select>
</div>
</div>
<div class="wow-admin-col">
<div class="wow-admin-col-3"><span id="title_days"><?php esc_attr_e("Title for Days", "marketing-wp") ?>:<br/>
<input type='text' name='title_days' value="<?php echo $title_days; ?>"/></span>
</div>
<div class="wow-admin-col-3"><span id="title_hours"><?php esc_attr_e("Title for Hours", "marketing-wp") ?>:<br/>
<input type='text' name='title_hours' value="<?php echo $title_hours; ?>"/></span>
</div>
<div class="wow-admin-col-3"><span id="title_minutes"><?php esc_attr_e("Title for Minutes", "marketing-wp") ?>:<br/>
<input type='text' name='title_minutes' value="<?php echo $title_minutes; ?>"/></span>
</div>
<div class="wow-admin-col-3"><span id="title_seconds"><?php esc_attr_e("Title for Seconds", "marketing-wp") ?>:<br/>
<input type='text' name='title_seconds' value="<?php echo $title_seconds; ?>"/></span>
</div>
</div>
</div>
</div>
</div>
<div class="postbox" id="style">
<h3 class=""><?php esc_attr_e("Style settings", "marketing-wp") ?></h3>
<div class="inside wow-admin" style="display: block;">	
<div class="wow-admin-col" id="fordate">
<div class="wow-admin-col-3"><?php esc_attr_e("Hide days", "marketing-wp") ?>:<br/>
<select name='hide_days'> 
        <option value="no" <?php if($hide_days=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>       
        <option value="yes" <?php if($hide_days=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>        	
    </select>
</div>
<div class="wow-admin-col-3"><?php esc_attr_e("Hide hours", "marketing-wp") ?>:<br/>
<select name='hide_hours'> 
        <option value="no" <?php if($hide_hours=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>       
        <option value="yes" <?php if($hide_hours=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>        	
    </select>
</div>
<div class="wow-admin-col-3"><?php esc_attr_e("Hide minutes", "marketing-wp") ?>:<br/>
<select name='hide_minutes'> 
        <option value="no" <?php if($hide_minutes=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>       
        <option value="yes" <?php if($hide_minutes=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>        	
    </select>
</div>
<div class="wow-admin-col-3"><?php esc_attr_e("Hide seconds", "marketing-wp") ?>:<br/>
<select name='hide_seconds'> 
        <option value="no" <?php if($hide_seconds=='no') { echo 'selected="selected"'; } ?>><?php esc_attr_e("no", "marketing-wp") ?></option>       
        <option value="yes" <?php if($hide_seconds=='yes') { echo 'selected="selected"'; } ?>><?php esc_attr_e("yes", "marketing-wp") ?></option>        	
    </select>
</div>
</div>
<div class="wow-admin-col">
<div class="wow-admin-col-3"><?php esc_attr_e("Type of delimeter", "marketing-wp") ?>:<br/>
<select name='type_delimiter'>        
        <option value=":" <?php if($type_delimiter==':') { echo 'selected="selected"'; } ?>>:</option>
		<option value="." <?php if($type_delimiter=='.') { echo 'selected="selected"'; } ?>>.</option>
		<option value="-" <?php if($type_delimiter=='-') { echo 'selected="selected"'; } ?>>-</option>        
        <option value="|" <?php if($type_delimiter=='|') { echo 'selected="selected"'; } ?>>|</option>
		<option value="/" <?php if($type_delimiter=='/') { echo 'selected="selected"'; } ?>>/</option>		
    </select>
</div>
</div>
</div>
</div>
	<?php submit_button($btn); ?>
    <input type="hidden" name="addwow" value="<?php echo $hidval; ?>" />    
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="wowpage" value="<?php echo $wowpage; ?>" />
	<input type="hidden" name="wowtable" value="<?php echo $table_wow_countdown; ?>" />
	<input type="hidden" name="plugdir" value="<?php echo WOW_COUNTDOWNS_FREE_PLUGIN_BASENAME; ?>" />	
	<?php wp_nonce_field('wow_action','wow_nonce_field'); ?>	
  </form>
</div>
</div>