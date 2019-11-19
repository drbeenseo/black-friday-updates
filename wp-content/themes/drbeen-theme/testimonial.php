<?php /* Template Name: Testimonial Page */ ?>
 
<?php get_header(); ?>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.role_review {
    margin: 24px 0 0;
}
@media (max-width: 991px){
	.comment_div .left_div {
    width: auto;
}
.comment_div {
    float: none;
    width: 100%;
   display: inline-block;
}
}
@media (max-width: 767px){
.comment_div .content:before {
   font-size: 21px;
   left: 15px;
}
.comment_div .content {
    padding: 20px 20px 20px 40px;
}

.comment_div.odd {
    margin-right: 0;
}
}
@media (max-width: 499px){
 .container{
	padding-left: 40px;
    padding-right: 40px;
}
.comment_div .content {
    font-size: 14px;
}
.comment_div h3 {
    font-size: 14px;
}
}	

</style>
 <div class="blue_title"><?php the_title(); ?></div>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <div class="container">
<?php
 $i=1;
$args = array(
    'post_type' => 'commment',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key'     => 'display_comment_or_not',
            'value'   => 'Yes',
        ),

  ),
     
        'meta_key' => 'position_in_front_end',
        'orderby' => 'meta_value_num',     
         'order' =>'asc',

  );
 
// Custom query.
$query = new WP_Query( $args );

// Check that we have query results.
if ( $query->have_posts() ) {
 
    // Start looping over the query results.title_or_role
    while ( $query->have_posts() ) {
 
        $query->the_post();  
        if($i%2==0){
            $class="even";
            }else{
              $class="odd"; }?>
        <div class="comment_div <?php echo $class; ?>">
  <div class="content"><?php  echo get_post_meta( get_the_ID(), 'comment', true );  

  ?></div>
<div class="left_div">
  <?php if(get_post_meta( get_the_ID(), 'comment_rating', true )!=""){ ?>
<div class="star-rating"><?php  $rating= get_post_meta( get_the_ID(), 'comment_rating', true );
  $total=5;

$ratingdivide=explode(".",$rating);
$whole = $ratingdivide[0]; 
$remaining_star=$total-$whole;
$fraction = $ratingdivide[1]; 
 if($fraction!=""){ 
$remaining_star=$remaining_star-1;
}
for($j=1;$j<=$whole;$j++){ ?>
<i class="fa fa-star" aria-hidden="true"></i>
<?php  }
if($fraction!=""){ ?>
<i class="fa fa-star-half-o" aria-hidden="true"></i>
<?php } 
for($k=1;$k<=$remaining_star;$k++){ ?>
<i class="fa fa-star-o" aria-hidden="true"></i>
<?php } ?>
</div>
<?php } else { ?>
    <div class="star-rating"><i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i></div>
<?php } ?>
    <h3><?php the_title(); ?></h3>
    <p class="role"><?php  echo get_post_meta( get_the_ID(), 'title_or_role', true );  ?></p></div><!--left_div-->
<div class="right_div"><p class="role_review">Reviewed on</p>
  <?php $link=get_post_meta( get_the_ID(), 'link_to_the_comment', true );
   if(!empty($link)){
      $link_url=$link;

  }else{
    $link_url="javascript:void(0);";

  } ?>

<h4><a target="_blank" href="<?php echo $link_url; ?>"><?php echo get_post_meta( get_the_ID(), 'where_was_the_comment_waswritten', true ); ?></a></h4>
</div><!--right_div-->
       </div>
   <?php     // Contents of the queried post results go here.
 
   $i++; }
 
}
 
// Restore original post data.
wp_reset_postdata();
 
?>
</div>
        <?php
        // Start the loop.
       // while ( have_posts() ) : the_post();
 
            // Include the page content template.
            //get_template_part( 'template-parts/content', 'page' );
 
            // If comments are open or we have at least one comment, load up the comment template.
           // if ( comments_open() || get_comments_number() ) {
          //      comments_template();
         //   }
 
            // End of the loop.
        //endwhile;
        ?>
 
    </main><!-- .site-main -->
 
   
 
</div><!-- .content-area -->
<?php 

function sortArrayByKey(&$array,$key,$string = false,$asc = true){
    if($string){
        usort($array,function ($a, $b) use(&$key,&$asc)
        {
            if($asc)    return strcmp(strtolower($a{$key}), strtolower($b{$key}));
            else        return strcmp(strtolower($b{$key}), strtolower($a{$key}));
        });
    }else{
        usort($array,function ($a, $b) use(&$key,&$asc)
        {
            if($a[$key] == $b{$key}){return 0;}
            if($asc) return ($a{$key} < $b{$key}) ? -1 : 1;
            else     return ($a{$key} > $b{$key}) ? -1 : 1;

        });
    }
}


get_footer(); ?>