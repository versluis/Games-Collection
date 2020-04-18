<?php

// create custom "Platform" taxonomy
function guru_create_platform_tax()
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x('Platforms', 'taxonomy general name', 'textdomain'),
    'singular_name' => _x('Platform', 'taxonomy singular name', 'textdomain'),
    'search_items' => __('Search Platforms', 'textdomain'),
    'all_items' => __('All Platforms', 'textdomain'),
    'parent_item' => __('Parent Platform', 'textdomain'),
    'parent_item_colon' => __('Parent Platform:', 'textdomain'),
    'edit_item' => __('Edit Platform', 'textdomain'),
    'update_item' => __('Update Platform', 'textdomain'),
    'add_new_item' => __('Add New Platform', 'textdomain'),
    'new_item_name' => __('New Platform Name', 'textdomain'),
    'menu_name' => __('Platforms', 'textdomain'),
  );

  // show_in_rest makes this thing show up in the post editor
  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'platform'),
    'show_in_rest' => true,
  );

  register_taxonomy('platform', array('games'), $args);
}
// initialise on theme setup
add_action('init', 'guru_create_platform_tax');
