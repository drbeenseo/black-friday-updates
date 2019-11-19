jQuery(document).ready(function($) {	
	changetype();	
	titledays();
	titlehours();
	titleminutes();
	titleseconds();
	steps();
	amountstep();
});
function changetype(){
	jQuery('#year').css('display', 'none');
	jQuery('#month').css('display', 'none');
	jQuery('#day').css('display', 'none');
	jQuery('#hour').css('display', 'none');
	jQuery('#minut').css('display', 'none');
	jQuery('#nfirst').css('display', 'none');
	jQuery('#nsecond').css('display', 'none');
	jQuery('#speed').css('display', 'none');
	jQuery('#direction').css('display', 'none');
	jQuery('#cookie').css('display', 'none');
	jQuery('#fordate').css('display', 'none');
	jQuery('#titles	').css('display', 'none');
	jQuery('#style').css('display', 'none');
	var type = jQuery('#type').val();
	if (type == 1){
		jQuery('#days').text('Day');
		jQuery('#year').css('display', '');
		jQuery('#month').css('display', '');
		jQuery('#day').css('display', '');
		jQuery('#fordate').css('display', '');
		jQuery('#titles	').css('display', '');
		jQuery('#style').css('display', '');
	}
	if (type == 2){		
		jQuery('#days').text('Days');
		jQuery('#day').css('display', '');
		jQuery('#hour').css('display', '');
		jQuery('#minut').css('display', '');
		jQuery('#fordate').css('display', '');
		jQuery('#titles	').css('display', '');
		jQuery('#style').css('display', '');
	}
	if (type == 3){
		jQuery('#days').text('Days');
		jQuery('#day').css('display', '');
		jQuery('#hour').css('display', '');
		jQuery('#minut').css('display', '');
		jQuery('#cookie').css('display', '');
		jQuery('#fordate').css('display', '');
		jQuery('#titles	').css('display', '');
		jQuery('#style').css('display', '');		
	}
	if (type == 4){
		jQuery('#nfirst').css('display', '');
		jQuery('#nsecond').css('display', '');
		jQuery('#speed').css('display', '');
		jQuery('#direction').css('display', '');		
	}
	if (type == 5){
		jQuery('#nfirst').css('display', '');
		jQuery('#nsecond').css('display', '');
		jQuery('#speed').css('display', '');
		jQuery('#direction').css('display', '');
		jQuery('#cookie').css('display', '');		
	}
}
function titledays(){
	var show = jQuery('[name=show_title_days]').val();	
	if (show == 'yes'){
		jQuery('#title_days').css('display', '');
	}
	else {
		jQuery('#title_days').css('display', 'none');
	}
}
function titleseconds(){
	var show = jQuery('[name=show_title_seconds]').val();	
	if (show == 'yes'){
		jQuery('#title_seconds').css('display', '');
	}
	else {
		jQuery('#title_seconds').css('display', 'none');
	}
}
function titleminutes(){
	var show = jQuery('[name=show_title_minutes]').val();	
	if (show == 'yes'){
		jQuery('#title_minutes').css('display', '');
	}
	else {
		jQuery('#title_minutes').css('display', 'none');
	}
}
function titlehours(){
	var show = jQuery('[name=show_title_hours]').val();	
	if (show == 'yes'){
		jQuery('#title_hours').css('display', '');
	}
	else {
		jQuery('#title_hours').css('display', 'none');
	}
}
function steps(){
	var show = jQuery('[name=sec_step]').val();	
	if (show == 'stable'){
		jQuery('.stable_step').css('display', '');
		jQuery('.random_step').css('display', 'none');
	}
	else {
		jQuery('.stable_step').css('display', 'none');
		jQuery('.random_step').css('display', '');
	}
}
function amountstep(){
	var show = jQuery('[name=amount_step]').val();		
	if (show == 'stable'){
		jQuery('.stable_amount').css('display', '');
		jQuery('.random_amount').css('display', 'none');
	}
	else {
		jQuery('.stable_amount').css('display', 'none');
		jQuery('.random_amount').css('display', '');
	}
}