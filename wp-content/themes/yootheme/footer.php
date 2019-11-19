<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$site = $theme->get('site', []);

?>
        <?php if (!$theme->get('builder')) : ?>

                        </div>

                        <?php if (is_active_sidebar('sidebar')) : ?>
                        <?= get_view('sidebar') ?>
                        <?php endif ?>

                    </div>

                </div>
            </div>
            <?php endif ?>

            <?php dynamic_sidebar("bottom:section") ?>

            <?= get_builder($theme->get('footer.content'), 'footer') ?>

        </div>

        <?php if ($site['layout'] == 'boxed') : ?>
        </div>
        <?php endif ?>

        <?php if (strpos($theme->get('header.layout'), 'offcanvas') === 0 || $theme->get('mobile.animation') == 'offcanvas') : ?>
        </div>
        <?php endif ?>

        <?php wp_footer() ?>
        <script>
            jQuery(".el-image").hover(
                  function () {
                    jQuery('.team_text').removeClass('active');
                    jQuery(this).parent().next("div").children(".team_text").addClass('active');
                  },
                  // function () {
                  //   jQuery(this).parent().next("div").children(".team_text").hide();

                  // }
                );
              jQuery("body").hover(
                function () {
                    jQuery('.team_text').removeClass('active');
                }
                )


// jQuery(document).ready(function(){
//   jQuery(".el-image").hover(function(){
//     jQuery(this).parent().next("div").children(".team_text").show();
   
//     }, function(){
//     //jQuery(this).parent().next("div").children(".team_text").hide();
     
//   });
//  /* jQuery( ".el-image" ).mouseout(function() {
// jQuery(this).parent().next("div").children(".team_text").hide();
// });*/
// });
</script>
<link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
   <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
  <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
<script>
jQuery(document).ready(function() {
 
  jQuery("#testimonial_slide").owlCarousel({
 
    loop:true,
    nav:true,
    margin:50,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        768:{
            items:2
        },
        992:{
            items:2
        },
        1000:{
            items:2
        }
    }
    
 
  });
 
});
</script>
    </body>
</html>
