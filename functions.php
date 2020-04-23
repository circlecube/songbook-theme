<?php
/**
 * songbook functions and definitions
 *
 * @package songbook
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'songbook_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function songbook_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on songbook, use a find and replace
	 * to change 'songbook' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'songbook', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'songbook' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	// add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'songbook_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // songbook_setup
add_action( 'after_setup_theme', 'songbook_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function songbook_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'songbook' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'songbook_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function songbook_scripts() {
	wp_enqueue_style( 'songbook-style', get_stylesheet_uri() );
	wp_register_style('mmenu', get_template_directory_uri() . '/js/mmenu-4.0.3/source/jquery.mmenu.all.css');
    wp_enqueue_style( 'mmenu');

    wp_enqueue_script( 'mmenu', get_template_directory_uri() . '/js/mmenu-4.0.3/source/jquery.mmenu.min.all.js', array(), '20131108', true );

    wp_enqueue_script( 'songbook-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '20130723', true );

	wp_enqueue_script( 'vextab', get_template_directory_uri() . '/js/vextab-div.prod.js', array( 'scripts' ), '3.0.6', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'songbook-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

}
add_action( 'wp_enqueue_scripts', 'songbook_scripts' );


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


function string_starts_with($haystack, $needle) {
    return !strncmp($haystack, $needle, strlen($needle));
}

add_action( 'save_post', 'add_chord_terms' );
function add_chord_terms( $post_id ) {
    $post = get_post( $post_id ); // get post object
    $chords = [];
    if (get_field('chordpro', $post_id)){
    	$chords = array_merge( $chords, extract_chords( $chords, get_field('chordpro', $post_id) ) );
	}
	//add for flexible content
	if ( get_field('song_part', $post_id) ) {
		while ( have_rows('song_part', $post_id) ){
			the_row();
			if( get_row_layout() == 'song_part' ){
    			$chords = array_merge( $chords, extract_chords( $chords, get_sub_field('song_part_content') ) );
			}
		}
	}
    if ($chords) {
		//_log($chords);
	    wp_set_object_terms( $post_id, $chords, 'chord', false );
	}
}
function extract_chords($chords, $chordpro){

    if ($chordpro) {
    	if ( !string_starts_with($chordpro, '[') ){
    		$chordpro = '[]' . $chordpro;
    	}
	    $chordpro_array = explode('[', $chordpro);
	    for ( $i = 0; $i < count($chordpro_array); $i++){
	    	$chordpro_o = explode(']', $chordpro_array[$i]);
	    	if ( !in_array($chordpro_o[0], $chords) ){
	    		array_push( $chords, $chordpro_o[0] );
	    	}
	    }
		//_log($chords);
	}

	return $chords;
}

if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}

function get_all_posts_action( $wp_query ) {
    if ( !is_admin() ) {
        set_query_var( 'posts_per_page', -1 );
        set_query_var( 'orderby', 'title' );
        set_query_var( 'order', 'ASC' );
    } // end if
}
add_action( 'pre_get_posts', 'get_all_posts_action' );

function print_chordpro($chordpro){

	$chords = [];
			//$chordpro = get_field('chordpro');
			//echo $chordpro;
			$chordpro_lines = explode('
', $chordpro);
			//print_r($chordpro_lines);

			$chordpro_html = '';
			for ( $j = 0; $j < count($chordpro_lines); $j++) {
				$chordpro_html .= '<div class="lyrics-line">';
				if ( !string_starts_with($chordpro_lines[$j], '[') ){
					$chordpro_lines[$j] = '[&nbsp;]' . $chordpro_lines[$j];
				}
				//filter chordpro data
				$chordpro_array = explode('[', $chordpro_lines[$j]);
				//echo count($chordpro_array);
				//print_r($chordpro_array);

				for ( $i = 0; $i < count($chordpro_array); $i++){
				//foreach ($chord as $chordpro_array) {
					//echo '<br />'.$i.', ' . $chordpro_array[$i];
					$chordpro_o = explode(']', $chordpro_array[$i]);
					//print_r($chordpro_o);
					$chordpro_html .= '<div class="chord-section"><div class="chord">';
					if ( !in_array($chordpro_o[0], $chords) ){
						array_push( $chords, $chordpro_o[0] );
					}
					$chordpro_html .= $chordpro_o[0];
					$chordpro_html .= '</div><div class="lyrics">';
					$chordpro_html .= $chordpro_o[1];
					$chordpro_html .= '</div></div>';
				}
				$chordpro_html .= '</div>';
			}
			//print song
			//echo $chordpro_html;

	return $chordpro_html;
}

// api call for full list of songs alphabetized
// http://music.circlecube.com/wp-json/posts?type=song&filter[posts_per_page]=-1&filter[orderby]=title&filter[order]=ASC

//https://github.com/WP-API/WP-API/issues/433
function json_api_prepare_post( $post_response, $post, $context ) {
  if( get_fields($post['ID']) ){
    $post_response['acf'] = get_fields($post['ID']);
    return $post_response;
  }
}
add_filter( 'json_prepare_post', 'json_api_prepare_post', 10, 3 );

