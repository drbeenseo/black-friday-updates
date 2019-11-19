<?php /* Template Name: Minibeans */ 
 get_header();

?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
	.uk-container {
     padding-left: 0px; 
     padding-right: 0px; 
}
	.uk-section{
		padding-top: 0px 
	}
	div#footer{
		    padding-top: 70px;
    padding-bottom: 70px;
	}
	aside#tm-sidebar {
    display: none;
	}
	section.content.mini-section-new .row{
		    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
    width:100%;
    margin: 0;
	}
	section.content.mini-section-new .row .mini-beeen-box{
	    -ms-flex: 0 0 31%;
	    flex: 0 0 31%;
    max-width: 31%;
    padding: 0 15px;
	}

	section.content.mini-section-new .row .mini-beeen-box iframe{
		width: 100%;
	}
	section.content.mini-section-new .container {
    padding: 0 15px;
	}

	.blue_title {
    background: #53BBE0;
    color: #fff;
    padding: 20px 0;
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 69px;
    position: relative;
	}
	.video-block h2 {
    margin-bottom: 0px;
    font-weight: bold;
    color: #000;
    text-align: center;
    margin-left: 10px;
    margin-right: 10px;
        font-size: 16px;
        min-height: 55px;
        cursor: pointer;
        transition: 0.3s;
	}
  .video-block h2:hover {
    color: #53bbe0;
}

 .video-block {
   position: relative;
}
.top_pagination{
  margin-bottom: 20px;
}
.video-block:after {
   content: "";
   width: 150px;
   height: 1px;
   background: #53bae0;
   display: block;
   position: absolute;
   left: 0px;
   right: 0;
   margin:0 auto;
   bottom:0px;
}
.mini-beeen-box {
    margin-bottom: 35px;
}
.video-block:before {
    position: relative;
    z-index: 1;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    content: "";
}
.video-block{
	position: relative;
}

body.page-template.page-template-template-minibeans #tm-main .uk-container{
	    width: 100%;
    float: left;
    max-width: 100%;
}
.modal-body h6{

              color: #fff;
    height: auto;
    overflow: auto;
    margin-top: 5px;
    text-transform: inherit;
    letter-spacing: 0;
    font-size: 13px;
    line-height: 23px;
    font-weight: 500;
    background-color: #43434D;
    padding: 15px;
    border: 0 none;
    margin: 0 20px;
}
.modal-body iframe{
      padding: 10px 5%;
}
.vpagination{
  width: 98%;
    float: left;
    font-weight: 600;
        padding-left: 1%;
}
.vpagination .next{
  float:right;
}
.modal-body b{
font-weight: 700;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 50px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  z-index: 999;
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 0 0 30px;
  border: 0 none;
      width: 40%;
          position: relative;
}
.modal-content h2{
      padding: 0 20px;
    font-size: 17px;
    font-weight: 600;
    margin: 15px 0 8px;
}
/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    height: 0;
    position: absolute;
    top: -14px;
    bottom: 0;
    right: 6px;
}
  div#footer {
    padding-left: 15px;
    padding-right: 15px;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.modal-body p{
    font-weight: 400;
    color: #fff;
    font-size: 18px;
    background: #53BBE0;
    padding: 15px 57px 15px 20px;
    line-height: 23px;
    height: 45px;
}
span.close:before {
    content: "\f00d";
    position: absolute;
    background-color: #44a8ca;
    font-family: FontAwesome;
    font-size: 21px;
    border-radius: 0;
    color: #fff;
    right: -6px;
    top: 14px;
    font-weight: 300;
    width: 17px;
    height: 38px;
    padding: 18px 20px;
}
.playlist{
  float: left;
    width: 100%;
    padding: 0 15px;
    margin-bottom: 40px;
   
}
select::-ms-expand {
    display: none;
}
option {
  padding:5px 0;
  background:#fff;
}
option:hover{
  background:#53BBE0;
  color:#fff;
}
.youplay{
  padding: 8px;
    margin-left: 6px;
    background: #F8F8F8;
    border-radius: 8px;
}
@media(max-width: 1300px){
  .video-block h2{
    font-size: 14px;
    min-height: 48px;
    margin-top: 20px;
  }
}
@media(max-width: 1249px){
  section.content.mini-section-new .row .mini-beeen-box {
    -ms-flex: 0 0 25%;
    flex: 0 0 30.8%;
    max-width: 31.33%;
    padding: 0 15px;
}
}
@media(max-width: 1214px){
section.content.mini-section-new .row .mini-beeen-box {
    -ms-flex: 0 0 25%;
    flex: 0 0 30.6%;
    max-width: 30.6%;
    padding: 0 15px;
}
}
@media(max-width: 1127px){
section.content.mini-section-new .row .mini-beeen-box {
    -ms-flex: 0 0 30.4%;
    flex: 0 0 30.4%;
    max-width: 30.4%;
    padding: 0 15px;
}

}
@media(max-width: 1079px){
section.content.mini-section-new .row .mini-beeen-box {
    -ms-flex: 0 0 30.4%;
    flex: 0 0 30%;
    max-width: 30%;
    padding: 0 15px;
}

}
@media(max-width: 949px){
section.content.mini-section-new .row .mini-beeen-box {
    -ms-flex: 0 0 30.4%;
    flex: 0 0 29.5%;
    max-width: 29.5%;
    padding: 0 15px;
}
.modal-content{
  width: 450px;
}
.video-block h2 {
    font-size: 13px;
    min-height: 43px;
    margin-top: 15px;
    margin-left: 0;
    margin-right: 0;
}
.uk-section{
  padding-bottom: 20px;
}
  .blue_title .container {
    padding-left: 15px;
    padding-right: 15px;
}
}
@media(max-width: 830px){
  section.content.mini-section-new .row .mini-beeen-box{
        flex: 0 0 44%;
    max-width: 44%;
    padding: 0 15px;
  }
  section.content.mini-section-new .row{
    justify-content: center;
  }
}
@media(max-width: 574px){

  section.content.mini-section-new .row .mini-beeen-box {
    flex: 0 0 90%;
    max-width: 90%;
    padding: 0 15px;
}
.video-block h2 {
    font-size: 14px;
    min-height: inherit;
    margin-top: 15px;
    margin-left: 0;
    margin-right: 0;
    padding-bottom: 18px;
}
.modal-content {
    width: 270px;
}
.modal-body iframe {
    height: 190px;
}
.modal-body p {
    font-weight: bold;
    color: #000;
    font-size: 18px;
    line-height: 29px;
} 
.blue_title{
  margin-bottom: 40px;
}
}
@media(max-width: 330px){
.modal-content {
    width: 220px;
}
.modal-body iframe {
    height: 150px;
}
.modal-body p {
    font-weight: bold;
    color: #000;
    font-size: 16px;
    line-height: 22px;
}
.modal-body h6 {
    height: 228px;
    overflow: auto;
    margin-top: 5px;
    text-transform: inherit;
    letter-spacing: 0;
    font-size: 14px;
    line-height: 22px;
    font-weight: 500;
    background-color: #ececec;
    padding: 10px;
    border: 1px solid #c1c1c1;
        margin-bottom: 0;
}
}
/*the container must be positioned relative:*/
.custom-select {
  position: relative;
      width: 280px;
          font-weight: 500;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

.select-selected {
  background-color: #F8F8F8;
}

/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 10px;
  right: 10px;
  width: 0;
  height: 0;
  border: 5px solid transparent;
  border-color: #4f5260 transparent transparent transparent;
}

/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #4f5260 transparent;
  top: 7px;
}

/*style the items (options), including the selected item:*/
.select-items div {
  color: #fff;
  padding: 8px 16px;
  border: 0 none;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
  font-size: 14px;
  line-height: 20px;
}
.select-selected {
  background: #fff;
    color: #4f5260;
    padding: 8px 16px;
    border: 1px solid #53BBE0;
    /* border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent; */
    cursor: pointer;
    user-select: none;
    border-radius: 0;
    margin-top: -8px;
        line-height: 20px;
}
/*style items (options):*/
.select-items {
     position: absolute;
    background-color: #53BBE0;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 99;
    box-shadow: 0px 0px 38px #e8e8e8;
    border: 1px solid #eeeeee;
        padding: 10px 0;
            height: 355px;
    overflow-y: scroll;
}

/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
     background-color: #fff;
    color: #4f5260;
}
.playlist label{
      float: left;
    margin-right: 7px;
   color: #BDC0C3;
    font-weight: 500;

}
.custom-select{
   float: left;
}
.play-inner{
  float:right;
}
</style>

<div class="blue_title"><div class="container"><?php the_title(); ?></div></div>

<section class="content mini-section-new">
	<div class="container">
<?php 
$myApiKey="AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ"; // Provide your API Key
$myChannelID="UCrtd2wePvAl6RN_D-9jWVQQ"; // Drbeen Provide your Channel ID
$playquery="https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ&maxResults=50";
$playvideoList = file_get_contents($playquery);
$playdecoded = json_decode($playvideoList, true);
/*if((isset($_GET['next'])) && ($_GET['next']!='')){
    $nextvar=$_GET['next'];
    $myQuery = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&maxResults=48&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ&pageToken=".$nextvar;
}else if((isset($_GET['prev'])) && ($_GET['prev']!='')){
    $prevvar=$_GET['prev'];
    $myQuery = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&maxResults=48&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ&pageToken=".$prevvar;
}
 else{
$myQuery = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&maxResults=48&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ";
}*/
?>
		<div class="row">
  <div class="playlist">
  <label>Playlist : </label>
  <div class="custom-select"><select class="youplay">
   <option value="0">Select Playlist</option>
  <?php $i=1;
//echo $pitem[0]['id'];
  foreach($playdecoded['items'] as $pitem){  ?>
 <?php if($i==1){ ?><option value="<?php the_permalink(); ?>/?play=<?php echo $pitem['id']; ?>" <?php if($_GET['play']==$pitem['id']){ ?> selected="selected" <?php } ?> ><?php echo $pitem['snippet']['title']; ?></option><?php }else{ ?>
  <option value="<?php the_permalink(); ?>/?play=<?php echo $pitem['id']; ?>" <?php if($_GET['play']==$pitem['id']){ ?> selected="selected" <?php } ?> ><?php echo $pitem['snippet']['title']; ?></option><?php } ?>
  <?php if($i==1){
    $playids=$pitem['id'];
  }
  $i++; } ?>
  </select></div>
  <?php if($_GET['play']!=""){
  $playid=$_GET['play'];
}else{
  $playid=$playids;
}
$myQuery="https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=".$playid."&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ"; 
//echo $myQuery;die;
$videoList = file_get_contents($myQuery);

// Convert JSON to PHP Array
$decoded = json_decode($videoList, true);
//$nextpage= $decoded['nextPageToken'];
//$prevPage=$decoded['prevPageToken'];  ?>
  </div>
	<!--	<div class="vpagination top_pagination"><?php if($prevPage!=''){ ?>
<a href="<?php the_permalink(); ?>/?prev=<?php echo $prevPage; ?>" class="prev">PREV PAGE</a>
<?php } if($nextpage!=''){ ?>

<a href="<?php the_permalink(); ?>/?next=<?php echo $nextpage; ?>" class="next">NEXT PAGE</a>
<?php } ?>
</div>-->
  <?php 
  if($decoded['items']){
foreach($decoded['items'] as $item){
    //Embed video
    
   // if(isset($item['videoId'])){
       //$description = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=".$item['id']['videoId']."&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ");
    //$description = json_decode($description, true);
    //$description = $description['items'][0]['snippet']['description'];
        echo '<div class="mini-beeen-box"><div class="video-block youtubepopup">
                <iframe width="280" height="220px" src="https://www.youtube.com/embed/'.$item['snippet']['resourceId']['videoId'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <h2>'. $item['snippet']['title'] .'</h2>
                <h6 style="display: none;">'.$item['snippet']['description'].'<p></p></h6>
            </div></div>';
    //}
}
 ?>
  <!--<div class="vpagination"><?php if($prevPage!=''){ ?>
<a href="<?php the_permalink(); ?>/?prev=<?php echo $prevPage; ?>" class="prev">PREV PAGE</a>
<?php } if($nextpage!=''){ ?>

<a href="<?php the_permalink(); ?>/?next=<?php echo $nextpage; ?>" class="next">NEXT PAGE</a>
<?php } ?>
</div>-->
<?php  } ?> 
		</div>
	</div>
</section>
<!-- Modal -->
<script type="text/javascript">
	jQuery('.video-block').click(function () {
		jQuery('.video-block:before').css('z-index' ,'1')
		var video_url = jQuery(this).find('iframe').attr('src');
		var title = jQuery(this).find('h2').text();
		var constant = jQuery(this).find('h6').text();
    jQuery('.modal-body p').html(title);
		jQuery('.modal-body iframe').attr("src",video_url);
	
		jQuery('.modal-body h6').html(constant);
	})
</script>




<!-- The Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close"></span>
          <div class="modal-body">
            <p> </p>
      	<iframe  width="90%" height="300px" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <h2>Description</h2>
      	<h6></h6>
      </div>
  </div>

</div>
<script>
jQuery(".youtubepopup").click(function(){
	jQuery("#myModal").show();	

})
jQuery(".close").click(function(){
	jQuery("#myModal").hide();	

})
jQuery("#myModal").click(function(){
	jQuery("#myModal").hide();	
})
jQuery(function() {
  //jQuery(".chzn-select").chosen();
  jQuery(".select-items div").click( function(){
    //alert("abc");
    window.location = jQuery(".youplay").val();
  }); 


});
var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>
<?php get_footer(); ?>