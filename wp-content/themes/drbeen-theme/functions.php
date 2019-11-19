<?php

// Functions in here

add_action( 'init', 'create_video_posttype' );
function create_video_posttype(){
  register_post_type( 'video',
    array(
      'labels' => array(
        'name' => __( 'Video' ),
        'singular_name' => __( 'Video' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => false,
      'exclude_from_search' => false,
        'publicly_queryable'  => false,
      'supports' => array('title','thumbnail','editor','page-attributes','excerpt'),
    )
  );
}
function youtubevideo(){
$myApiKey="AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ"; // Provide your API Key
$myChannelID="UCrtd2wePvAl6RN_D-9jWVQQ"; // Drbeen Provide your Channel ID

if((isset($_GET['next'])) && ($_GET['next']!='')){
    $nextvar=$_GET['next'];
    $myQuery = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&maxResults=50&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ&pageToken=".$nextvar;
}else if((isset($_GET['prev'])) && ($_GET['prev']!='')){
    $prevvar=$_GET['prev'];
    $myQuery = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&maxResults=50&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ&pageToken=".$prevvar;
}
 else{
$myQuery = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCrtd2wePvAl6RN_D-9jWVQQ&maxResults=50&key=AIzaSyDulgoRXxOm1E4DyVWrOx4Q5gXHga4K1hQ";
}

$videoList = file_get_contents($myQuery);
// Convert JSON to PHP Array
$decoded = json_decode($videoList, true);
//echo "<pre>";print_r($decoded);//die;
$nextpage= $decoded['nextPageToken'];
$prevPage=$decoded['prevPageToken']; ?>
<div class="youtubedata">
<?php 
foreach($decoded['items'] as $item){
    //Embed video
    
    if(isset($item['id']['videoId'])){

      

        echo '<div class="mini-beeen-box"><div class="video-block youtubepopup">
                <iframe width="280" height="195px" src="https://www.youtube.com/embed/'.$item['id']['videoId'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <h2>'. $item['snippet']['title'] .'</h2>
                <h6 style="display: none;">'.$item['snippet']['description'].'<p></p></h6>
            </div></div>';
    }
}

 ?>
 <?php if($prevPage!=''){ ?>
<a href="<?php bloginfo('url'); ?>/videos/?prev=<?php echo $prevPage; ?>" class="">PREV</a>
<?php } if($nextpage!=''){ ?>

<a href="<?php bloginfo('url'); ?>/videos/?next=<?php echo $nextpage; ?>" class="">NEXT</a>
<?php } ?>
 </div>
<?php }
add_shortcode('youtube_video' , 'youtubevideo');
?>