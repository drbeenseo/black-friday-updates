jQuery(document).ready(function($) {
	<?php if ($val->type == 1){;?>	
	utask<?php echo $val->id;?> = new Date(<?php echo $val->year;?>, <?php echo $val->month;?>, <?php echo $val->day;?>);		
	<?php } if ($val->type == 2){;?>
	utask<?php echo $val->id;?> = (new Date()).getTime() + <?php echo $val->day;?>*86400000+<?php echo $val->hour;?>*3600000+<?php echo $val->minut;?>*60000;	
	<?php } if ($val->type == 3){;?>
	
	if(Cookies.get('wow-countdown-free-id-<?php echo $val->id; ?>')){
		utask<?php echo $val->id;?> = Cookies.get('wow-countdown-free-id-<?php echo $val->id; ?>');
	} 
	else {			
		utask<?php echo $val->id;?> = (new Date()).getTime() + <?php echo $val->day;?>*86400000+<?php echo $val->hour;?>*3600000+<?php echo $val->minut;?>*60000;		
		Cookies.set('wow-countdown-free-id-<?php echo $val->id; ?>', utask<?php echo $val->id;?>, {expires: <?php if($val->cookie == ""){echo '1';}else{echo $val->cookie;}?>});		
	}
	<?php } if ($val->type == 4){;?>
	ucountleft<?php echo $val->id;?> = <?php echo $val->nfirst;?>;
	<?php } if ($val->type == 5){;?>
	if(Cookies.get('wow-countdown-free-id-<?php echo $val->id; ?>')){
		ucountleft<?php echo $val->id;?> = Cookies.get('wow-countdown-free-id-<?php echo $val->id; ?>');
	} 
	else {			
		ucountleft<?php echo $val->id;?> = <?php echo $val->nfirst;?>;		
	}
	<?php };?>
<?php if ($val->type == 1 || $val->type == 2 || $val->type == 3){;?>
	wowcountdown<?php echo $val->id;?>();
	function wowcountdown<?php echo $val->id;?>(){	
			ucountleft<?php echo $val->id;?> = Math.floor((utask<?php echo $val->id;?> - (new Date())) / 1000);			
			if(ucountleft<?php echo $val->id;?> < 0){
				ucountleft<?php echo $val->id;?> = 0;								
				return;
			}			
			var uday = Math.floor(ucountleft<?php echo $val->id;?> / 86400);			
			if (uday < 10){
				var rday = '0'+uday;
			}
			else {
				var rday = uday;
			}
			ucountleft<?php echo $val->id;?> -= uday*86400;
			var uhour = Math.floor(ucountleft<?php echo $val->id;?> / 3600);
			if (uhour < 10){
				var rhour = '0'+uhour;
			}
			else {
				var rhour = uhour;
				}
			ucountleft<?php echo $val->id;?> -= uhour*3600;
			var uminut = Math.floor(ucountleft<?php echo $val->id;?> / 60);
			if (uminut < 10){
				var rmin = '0'+uminut;
			}
			else {
				var rmin = uminut;
			}
			ucountleft<?php echo $val->id;?> -= uminut*60;
			var usecond = ucountleft<?php echo $val->id;?>;
			if (usecond < 10){
				var rsec = '0'+usecond;
			}
			else {
				var rsec = usecond;
			}
			var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?>'>";
			<?php if ($val->hide_days == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rday +"</span> <?php if ($val->show_title_days == 'yes'){ echo "<span class='wowc-title-".$val->id."'>".$val->title_days."</span> ";} else {echo "<span class='wowc-delimiter-".$val->id."'>".$val->type_delimiter."</span> ";};?>";
			<?php };?>
			<?php if ($val->hide_hours == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rhour + "</span> <?php if ($val->show_title_hours == 'yes'){ echo "<span class='wowc-title-".$val->id."'>".$val->title_hours."</span> ";} else {echo "<span class='wowc-delimiter-".$val->id."'>".$val->type_delimiter."</span> ";};?>";
			<?php };?>
			<?php if ($val->hide_minutes == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rmin + "</span> <?php if ($val->show_title_minutes == 'yes'){ echo "<span class='wowc-title-".$val->id."'>".$val->title_minutes."</span> ";} else {echo "<span class='wowc-delimiter-".$val->id."'>".$val->type_delimiter."</span> ";};?>";
			<?php };?>
			<?php if ($val->hide_seconds == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rsec+"</span> <?php if ($val->show_title_seconds == 'yes'){ echo "<span class='wowc-title-".$val->id."'>".$val->title_seconds."</span> ";} else {};?>";
			<?php };?>
			message<?php echo $val->id;?> += "</div>";			
			$('#wow-countdown-free-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);
			setTimeout(wowcountdown<?php echo $val->id;?>, 1000);
		}	
<?php };?>
<?php if ($val->type == 4 || $val->type == 5){;?>
wowcountdown<?php echo $val->id;?>();
function wowcountdown<?php echo $val->id;?>(){
			var speed = <?php echo $val->speed;?>;
			var amount = <?php echo $val->amount;?>;
			<?php if ($val->direction == 1){;?>
			ucountleft<?php echo $val->id;?>= ucountleft<?php echo $val->id;?>-amount*1;
			if(ucountleft<?php echo $val->id;?> < <?php echo $val->nsecond;?>){				
				var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?> wowcontnumber-<?php echo $val->id;?>'><?php echo $val->nsecond;?></div>";				
				$('#wow-countdown-free-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);				
				return;
			}		
			<?php } else {;?>
			ucountleft<?php echo $val->id;?>= ucountleft<?php echo $val->id;?>+amount*1;
			if(ucountleft<?php echo $val->id;?> >= <?php echo $val->nsecond;?>){
				var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?> wowcontnumber-<?php echo $val->id;?>'><?php echo $val->nsecond;?></div>";
				$('#wow-countdown-free-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);				
				return;
			}		
			<?php };?>
			var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?> wowcontnumber-<?php echo $val->id;?>'>"+ucountleft<?php echo $val->id;?>+"</div>";		
			$('#wow-countdown-free-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);
			setTimeout(wowcountdown<?php echo $val->id;?>, speed*1000);
			<?php if ($val->type == 5){;?>
			Cookies.set('wow-countdown-free-id-<?php echo $val->id; ?>', ucountleft<?php echo $val->id;?>, {expires: <?php if($val->cookie == ""){echo '1';}else{echo $val->cookie;}?>});
			<?php };?>
		}	
<?php };?>
}); 