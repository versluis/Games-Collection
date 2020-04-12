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

// set default Platform on Game Posts
// https://silentcomics.com/wordpress/automatic-default-taxonomy-for-a-custom-post-type/
function guru_set_default_platform( $post_id, $post ) {
  if ( 'publish' === $post->post_status && $post->post_type === 'games' ) {
      $defaults = array(
          'category' => array( 'not-played' )
          );
      $taxonomies = get_object_taxonomies( $post->post_type );
      foreach ( (array) $taxonomies as $taxonomy ) {
          $terms = wp_get_post_terms( $post_id, $taxonomy );
          if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
              wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
          }
      }
  }
}
add_action( 'save_post', 'guru_set_default_platform', 0, 2 );

// META DATA
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

// add game posts to regular WordPress queries
function guru_add_games_to_query( $query ) {
  if ( $query->is_archive() && $query->is_main_query() ) {
      $query->set( 'post_type', array('post', 'games') );
  }
}
add_action( 'pre_get_posts', 'guru_add_games_to_query' );

//*********************************** */
// add Status in front of categories
add_filter( 'generate_category_list_output', function() {
  $categories = apply_filters( 'generate_show_categories', true );

  $term_separator = apply_filters( 'generate_term_separator', _x( ', ', 'Used between list items, there is a space after the comma.', 'generatepress' ), 'categories' );
  $categories_list = get_the_category_list( $term_separator );

  return sprintf( '<span class="cat-links">Status: %3$s<span class="screen-reader-text">%1$s </span>%2$s</span> ', // WPCS: XSS ok, sanitization ok.
      esc_html_x( 'Categories', 'Used before category names.', 'generatepress' ),
      $categories_list,
      // strip_tags( $categories_list ),
      apply_filters( 'generate_inside_post_meta_item_output', '', 'categories' )
  );
} );

// add Genre in front of Tags
// can't be done - but this is where it should be done :-)
add_filter( 'generate_tag_list_output', function() {
  $categories = apply_filters( 'generate_show_tags', true );

  $tag_list = get_the_tag_list( 'Genre: ', ', ');

  return sprintf( '<span class="tags-links">%3$s<span class="screen-reader-text">%1$s </span>%2$s</span> ', // WPCS: XSS ok, sanitization ok.
      esc_html_x( 'Categories', 'Used before category names.', 'generatepress' ),
      $tag_list,
      // strip_tags( $categories_list ),
      apply_filters( 'generate_inside_post_meta_item_output', '', 'categories' )
  );
} );
//*********************************** */

// add Platform taxonomy to footer meta (when available)
add_filter( 'generate_category_list_output', function( $output ) {
  $terms = get_the_term_list( get_the_ID(), 'platform', '', ', ' );
  if ($terms) {
    return '<span class="terms"> &#127918; Platform: ' . $terms . '</span>' . $output;
  } else 
  return $output;
  
} );



// ********************************************************
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

// add Genre to Tag Archives, Status to Categories
add_filter( 'get_the_archive_title', function( $title ) {
  if ( is_tag() ) {
      $title = 'Genre: ' . $title;
  }

  if (is_category()) {
    $title = 'Status: ' . $title;
  }

  return $title;
}, 50 );

// show which template part is being used (debug only)
function guru_which_template() {
	if ( is_super_admin() ) {
		global $template;
    print_r( "<h1>Currently using: $template</h1>" );
	}
}
// add_action( 'wp_footer', 'guru_which_template' );