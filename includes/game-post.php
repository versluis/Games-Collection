<?php 
/************************************/
/*
/* CUSTOM GAME POST
/*
/************************************/

// Create a custom GAME Post Type
function guru_create_game_posttype()
{

  // create out custom post type
  register_post_type(
    'games',
    // with these options
    array(
      'labels' => array(
        'name' => __('Games'),
        'singular_name' => __('Game')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'game'),
      'show_in_rest' => true,
      'menu_icon'   => 'dashicons-album',

    )
  );

  // register our post type with tags and categories
  register_taxonomy_for_object_type('category', 'games');
  register_taxonomy_for_object_type('post_tag', 'games');
  register_taxonomy_for_object_type('platform', 'games');
}
// initialise on theme setup
add_action('init', 'guru_create_game_posttype');
