<?php /*

  This file is part of a child theme called Games Collection.
  Functions in this file will be loaded before the parent theme's functions.
  For more information, please read
  https://developer.wordpress.org/themes/advanced-topics/child-themes/

*/

// this code loads the parent's stylesheet (leave it in place unless you know what you're doing)

function your_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, 
      get_template_directory_uri() . '/style.css'); 

    wp_enqueue_style( 'child-style', 
      get_stylesheet_directory_uri() . '/style.css', 
      array($parent_style), 
      wp_get_theme()->get('Version') 
    );
}
add_action('wp_enqueue_scripts', 'your_theme_enqueue_styles');

/*  Add your own functions below this line.
  ======================================== */ 

// includes
include plugin_dir_path(__FILE__).'includes/game-post.php';
include plugin_dir_path(__FILE__).'includes/platform-tax.php';
include plugin_dir_path(__FILE__).'includes/default-platform.php';
include plugin_dir_path(__FILE__).'includes/debug.php';
include plugin_dir_path(__FILE__).'includes/meta.php';
include plugin_dir_path(__FILE__).'includes/footer-tweak.php';
include plugin_dir_path(__FILE__).'includes/custom-fields.php';
include plugin_dir_path(__FILE__).'includes/steam-widget.php';
include plugin_dir_path(__FILE__).'includes/page-queries.php';


// add game posts to regular WordPress queries
function guru_add_games_to_query( $query ) {
  if ( $query->is_archive() && $query->is_main_query() ) {
      $query->set( 'post_type', array('post', 'games') );
  }
}
if (!is_admin()) {
  add_action( 'pre_get_posts', 'guru_add_games_to_query' );
}

// make links in the content clickable
function guru_clickable_content ($content){
  $content = make_clickable($content);
  return $content;
}
add_filter ('the_content', 'guru_clickable_content');

