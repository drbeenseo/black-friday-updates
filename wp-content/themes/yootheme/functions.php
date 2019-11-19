<?php

use YOOtheme\Module\ConfigLoader;
use YOOtheme\Theme;
use YOOtheme\Theme\Wordpress\MenuWalker;

/**
 * Boostrap theme and configuration.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions
 */
add_action('after_setup_theme', function () {

    $cfg = require __DIR__.'/config.php';
    $app = require __DIR__.'/vendor/yootheme/theme/bootstrap.php';

    $app->addLoader(new ConfigLoader($cfg));
    $app->addLoader(function ($options, $next) {

        global $theme;

        $module = $next($options);

        if ($module instanceof Theme) {

            $module->id = get_current_blog_id();
            $module->default = is_main_site();
            $module->template = basename(__DIR__);

            return $theme = $module;
        }

        return $module;
    });

    $app->load('config.php', __DIR__);

    if (is_child_theme()) {
        $app->load(['config.php', 'builder/*/index.php'], STYLESHEETPATH);
    }

    $app->init();
});

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support
 */
add_action('after_setup_theme', function () {

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Enable support for Post Formats. (https://developer.wordpress.org/themes/functionality/post-formats)
    add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

    // Enable support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');

    // Enable support for prefixed Widgetkit
    add_theme_support('widgetkit-noconflict');

    // Load theme translations
    load_theme_textdomain('yootheme', get_template_directory() . '/language');
});

/**
 * Register navigation menus.
 *
 * @link https://developer.wordpress.org/themes/functionality/navigation-menus
 */
add_action('init', function () {

    global $theme;

    // Register menu locations.
    foreach ($theme->options['menus'] as $id => $name) {
        register_nav_menu($id, __($name));
    }

    // Add filter to menu arguments.
    add_filter('wp_nav_menu_args', function ($args) {
        return array_replace($args, array(
            'walker' => new MenuWalker(get_current_sidebar(), $args),
            'container' => false,
            'fallback_cb' => false,
            'items_wrap' => '%3$s',
        ));
    });

    add_filter('widget_nav_menu_args', function ($nav_menu_args, $nav_menu, $args, $instance) {
        $menu_args = array_replace($nav_menu_args, json_decode(isset($instance[$key = '_theme']) ? $instance[$key] : '{}', true));

        if (isset($args['yoo_element'])) {
            $menu_args = array_merge($menu_args, $args['yoo_element']->props);
        }

        return $menu_args;
    }, 10, 4);

});

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars
 */
add_action('widgets_init', function () {

    global $theme;

    foreach ($theme->options['positions'] as $id => $name) {
        register_sidebar(array(
            'id' => $id,
            'name' => $name,
            'before_widget' => '<content>',
            'after_widget' => '</content>',
            'before_title' => '<title>',
            'after_title' => '</title>'
        ));
    }

});

/**
 * Add theme to query vars for access in template parts.
 */
add_action('wp', function () {

    global $wp_query, $theme;

    $wp_query->query_vars['theme'] = $theme;
});

/**
 * Add theme inline css.
 */
add_action('wp_footer', function () {

    global $theme;

    if ($css = $theme->get('css')) {
        echo '<style>'.preg_replace('/[\r\n\t]+/', ' ', $css).'</style>';
    }

});

/**
 * Add comment scripts for the front end.
 */
add_action('wp_enqueue_scripts', function () {

    if (is_singular() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }

});

/**
 * Add filter to comment classes.
 */
add_filter('comment_class', function ($classes) {

    if (in_array('byuser', $classes)) {
        $classes[] = 'uk-comment-primary';
    }

    return $classes;
});

/**
 * Add filter to comment edit link.
 */
// add_filter('edit_comment_link', function ($link) {
//     return str_replace('comment-edit-link', 'uk-button uk-button-text', $link);
// });

/**
 * Add filter to comment reply link.
 */
add_filter('comment_reply_link', function ($link) {
    return str_replace('comment-reply-link', 'uk-button uk-button-text', $link);
});

/**
 * Add filter to comment cancel reply link.
 */
add_filter('cancel_comment_reply_link', function ($link) {
    return str_replace('href="', 'class="uk-link-muted" href="', $link);
});

/**
 * Add filter to comment author link.
 */
add_filter('get_comment_author_link', function ($link) {
    return str_replace("class='url'", 'class="uk-link-reset"', $link);
});

/**
 * Add filter to page links.
 */
add_filter('wp_link_pages_link', function ($link) {
    return is_numeric($link) ? "<li class=\"uk-active\"><span>{$link}</span></li>" : "<li>{$link}</li>";
});

/**
 * Register theme helper functions.
 */
function get_view() {

    global $theme;

    return call_user_func_array([$theme->view, 'render'], func_get_args());
}

function get_section() {

    global $theme;

    return call_user_func_array([$theme->view, 'section'], func_get_args());
}

function get_attrs() {

    global $theme;

    return call_user_func_array([$theme->view, 'attrs'], func_get_args());
}

function get_builder() {

    global $theme;

    return call_user_func_array([$theme->builder, 'render'], func_get_args());
}

function get_current_sidebar() {

    global $theme;

    return $theme->modules->get('yootheme/wordpress-widgets')->sidebar;
}

function get_readmore() {

    $post = get_post();
    $text = get_extended($post->post_content);

    return !empty($text['extended']) ? $text['more_text'] ?: __('Continue reading', 'yootheme') : false;
}

function get_post_date() {
    return '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>';
}

function get_post_author() {
    return '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>';
}

function get_post_columns($count, $mode = 1) {

    global $wp_query;

    $posts = $wp_query->posts;
    $count = max(1, $count);
    $columns = [];

    if ($mode == 0) {

        while ($posts) {
            $columns[] = array_splice($posts, 0, ceil(count($posts) / ($count - count($columns))));
        }

    } else {

        foreach ($posts as $i => $post) {
            $columns[$i % $count][] = $post;
        }
    }

    return $columns;
}

function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'commment' == $screen->post_type ) {
          $title = "Person's name";
     }
  
     return $title;
}
  
add_filter( 'enter_title_here', 'wpb_change_title_text' );


/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Comments', 'Post Type General Name', 'yootheme' ),
        'singular_name'       => _x( 'Comments', 'Post Type Singular Name', 'yootheme' ),
        'menu_name'           => __( 'Comments', 'yootheme' ),
        'parent_item_colon'   => __( 'Parent Comments', 'yootheme' ),
        'all_items'           => __( 'All Comments', 'yootheme' ),
        'view_item'           => __( 'View Comments', 'yootheme' ),
        'add_new_item'        => __( 'Add New Comments', 'yootheme' ),
        'add_new'             => __( 'Add New', 'yootheme' ),
        'edit_item'           => __( 'Edit Comments', 'yootheme' ),
        'update_item'         => __( 'Update Comments', 'yootheme' ),
        'search_items'        => __( 'Search Comments', 'yootheme' ),
        'not_found'           => __( 'Not Found', 'yootheme' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'yootheme' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Comments', 'yootheme' ),
        'description'         => __( 'Comments news and reviews', 'yootheme' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array('excerpt','title', 'author', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'commment', $args );
     register_post_type( 'Testimonial',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields',),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'testimonial'),
        )
    );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );
function my_page_columns($columns)
{
	$columns = array(
		'title' 	=> 'Person Name',
		'title_or_role'	=>	'Title Or Role',
		'author'	=>	'Author',
		'date'		=>	'Date',
		'display_comment_or_not' 	=> 'Display Comment On Site',
        'position_in_front_end' =>'Set Position'
	);
	return $columns;
}

function my_custom_columns($column)
{

	global $post;
	if($column == 'title_or_role'){
		echo get_field('title_or_role');
	}elseif($column == 'display_comment_or_not'){
		$checkbox_is="";
			if(get_field('display_comment_or_not')=="Yes"){
				$checkbox_is= 'checked=checked'; 
			}
			echo "<input type='checkbox' ". $checkbox_is ." name='display_comments' value='Checkbox'>";
			
		
	}elseif($column == 'position_in_front_end'){
            echo get_field('position_in_front_end');
            
        
    }
}
add_action("manage_commment_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-commment_columns", "my_page_columns");
add_action('admin_head', 'wpds_custom_admin_post_css');
function wpds_custom_admin_post_css() {

    global $post_type;

    if ($post_type == 'commment') {
        echo "<style>#edit-slug-box {display:none;}</style>";
    }
}


add_action( 'bulk_edit_custom_box', 'quick_edit_custom_box_comments', 10, 2 );
add_action( 'quick_edit_custom_box', 'quick_edit_custom_box_comments', 10, 2 );
function quick_edit_custom_box_comments( $column_name, $post_type ) {
    $slug = 'commment';
    if ( $slug !== $post_type )
        return;
    if ( ! in_array( $column_name, array( 'position_in_front_end') ) )
        return;
    static $printNonce = true;
    if ( $printNonce ) {
        $printNonce = false;
        wp_nonce_field( plugin_basename( __FILE__ ), 'comments_edit_nonce' );
    }

?>
    <fieldset class="inline-edit-col-right inline-edit-comments">
      <div class="inline-edit-col inline-edit-<?php echo $column_name ?>">
        <label class="inline-edit-group">
        <?php
    switch ( $column_name ) {
    case 'position_in_front_end':
?>
            <span class="title">Set Possition!!</span>
            <input type="number" name="position_in_front_end" value="<?php echo $_POST['position_in_front_end']; ?>"  autocomplete="off">
            <?php
        break;   
    }
?></label>
      </div>
    </fieldset>
    <?php
}
add_action( 'save_post', 'save_comments_meta' );
function save_comments_meta( $post_id ) {
    // TODO make $slug static
    $slug = 'commment';
    if ( $slug !== $_POST['post_type'] )
        return;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    if ( isset( $_REQUEST['position_in_front_end'] ) ){
        update_post_meta( $post_id, 'position_in_front_end',  $_REQUEST['position_in_front_end'] );
    }

}
add_action( 'wp_ajax_save_bulk_edit_comment', 'save_bulk_edit_comments' );
function save_bulk_edit_comments() {
    $post_ids = ( ! empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
    $position_in_front_end = ! empty( $_POST[ 'position_in_front_end' ] );
       if ( ! empty( $post_ids ) && is_array( $post_ids ) ) {
        foreach ( $post_ids as $post_id ) {
            update_post_meta( $post_id, 'position_in_front_end', $position_in_front_end );
       }
    }

    die();
}
function testimonialpost(){
    $args = array('post_type' =>'testimonial','posts_per_page'=>-1);
    $loop = new WP_Query( $args ); 
        $response_data1='<div class="row"><div class="owl-carousel owl-theme" id="testimonial_slide">';
    while ( $loop->have_posts() ) : $loop->the_post(); 
            $title = get_the_title();
            $content =get_the_content();
            $client_name =get_field('client_name');
            $thumbUrl = get_the_post_thumbnail_url();

        $response_data1=$response_data1.'<div class="item">
                
                <img src="'.$thumbUrl.'">
                <h3>'.$title.'</h3>
                 <p>'.$content.'</p>
                <h6>-'.$client_name.'</h6>

        </div>' ;
endwhile; 
  $response_data1=$response_data1.'</div></div>';
  return $response_data1;
}
add_shortcode( 'testimonials', 'testimonialpost');