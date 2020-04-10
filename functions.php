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

// make meta data show up on game posts
add_filter( 'generate_entry_meta_post_types', function( $types ) {
  $types[] = 'games';
  return $types;
} );

add_filter( 'generate_footer_meta_post_types', function( $types ) {
  // $types[] = 'my-post-type';
  $types[] = 'games';
  return $types;
} );

// add Platform taxonomy to footer meta (when available)
add_filter( 'generate_category_list_output', function( $output ) {
  $terms = get_the_term_list( get_the_ID(), 'platform', '', ', ' );
  if ($terms) {
    return '<span class="terms"> &#127918; ' . $terms . '</span>' . $output;
  } else 
  return $output;
  
} );

// redefine footer content
remove_action( 'generate_credits', 'generate_add_footer_info' );

if ( ! function_exists( 'generate_add_footer_info' ) ) {
	add_action( 'generate_credits', 'generate_add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 * @since 0.1
	 */
	function generate_add_footer_info() {
    $copyright = sprintf( '<span class="copyright">&copy; %1$s %2$s</span> &bull; %4$s <a href="%3$s" itemprop="url">%5$s</a> &bull; <a href="https://github.com/versluis/Games-Collection" target="_blank">Fork Me</a>',
			date( 'Y' ),
			'<a href="https://wpguru.tv">The WP Guru</a>',
			esc_url( 'https://generatepress.com' ),
			_x( 'Powered by', 'GeneratePress', 'generatepress' ),
			__( 'GeneratePress', 'generatepress' )
		);

		echo apply_filters( 'generate_copyright', $copyright ); // WPCS: XSS ok.
	}
}