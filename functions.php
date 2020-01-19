<?php
defined( 'ABSPATH' ) || exit;

define( 'SIMPLE_DAYS_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'SIMPLE_DAYS_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );
define( 'SIMPLE_DAYS_VERSION', wp_get_theme(get_template())->Version );


require_once SIMPLE_DAYS_THEME_DIR . 'inc/lib/setup.php';
simple_days_sidebar_setup();

require_once SIMPLE_DAYS_THEME_DIR . 'inc/template-tags.php';





if ( ! function_exists( 'simple_days_setup' ) ) :
  function simple_days_setup() {
    
    require_once SIMPLE_DAYS_THEME_DIR . 'inc/lib/after_setup_theme.php';
  }
endif;
add_action( 'after_setup_theme', 'simple_days_setup' );


if ( ! function_exists( 'simple_days_content_width' ) ) :
  function simple_days_content_width() {
    //if(SIMPLE_DAYS_SIDEBAR){
      //$GLOBALS['content_width'] = apply_filters( 'simple_days_content_width', 678 );
   // }else{
    $GLOBALS['content_width'] = apply_filters( 'simple_days_content_width', 856 );
    //}
  }
endif;
add_action( 'template_redirect', 'simple_days_content_width', 0 );





if ( ! function_exists( 'simple_days_get_the_archive_title' ) ) :
  
  function simple_days_get_the_archive_title($title) {
    if ( is_category() ) {
      $title = single_cat_title( '<i class="fa fa-folder-open-o" aria-hidden="true"></i> ', false );
    }elseif ( is_tag() ) {
      $title = single_tag_title( '<i class="fa fa-tag" aria-hidden="true"></i> ', false );
    } elseif ( is_author() ) {
      $title = '<i class="fa fa-user" aria-hidden="true"></i> '. get_the_author();

    } elseif ( is_year() || is_month() || is_day() ) {
     $title = '<i class="fa fa-calendar-check-o" aria-hidden="true"></i> '. $title;
   }
   return $title;
 }
endif;
add_filter( 'get_the_archive_title', 'simple_days_get_the_archive_title');

if ( ! function_exists( 'simple_days_load_stylesheets' ) ) :
  function simple_days_load_stylesheets(){
    if (!function_exists('yahman_addons_amp_head')){
      require_once SIMPLE_DAYS_THEME_DIR . 'inc/lib/required_stylesheets.php' ;
      simple_days_required_stylesheets();
    }
  }
endif;

add_action('wp_enqueue_scripts','simple_days_load_stylesheets');


if ( ! function_exists( 'simple_days_footer_stylesheets' ) ) :
  function simple_days_footer_stylesheets() {
    if (!function_exists('yahman_addons_amp_head')){
      get_template_part( 'inc/lib/footer_stylesheets' );
      
      get_template_part( 'inc/lib/customize_fonts' );
      simple_days_customize_fonts_enqueue();


    }
  }
endif;

add_action( 'wp_footer', 'simple_days_footer_stylesheets' );



if ( ! function_exists( 'simple_days_comment_author_anchor' ) ) :
  function simple_days_comment_author_anchor( $author_link ){
    return str_replace( "<a", "<a target='_blank'", $author_link );
  }
endif;
add_filter( "get_comment_author_link", "simple_days_comment_author_anchor" );


if ( ! function_exists( 'simple_days_gutenberg_front_styles' ) ) :
  function simple_days_gutenberg_front_styles() {

    if ( function_exists( 'has_block' ) ){

      if( has_blocks() ){
        $one_column_post = explode(',', get_theme_mod( 'simple_days_one_column_post',''));


        if(!SIMPLE_DAYS_SIDEBAR || is_page_template( 'templates/fullwidth.php' )){
          wp_enqueue_style( 'simple_days_gutenberg_front_styles', SIMPLE_DAYS_THEME_URI . 'assets/css/gutenberg-front-one-column-style.min.css',array( 'simple_days_style' ) );
        }else{
          wp_enqueue_style( 'simple_days_gutenberg_front_styles', SIMPLE_DAYS_THEME_URI . 'assets/css/gutenberg-front-style.min.css',array( 'simple_days_style' ) );
        }

        if (  has_block( 'core-embed/vimeo' ) || has_block( 'core-embed/youtube') || has_block( 'video' ) ) {
          
          wp_enqueue_script( 'fitvids',SIMPLE_DAYS_THEME_URI . 'assets/js/gutenberg/jquery.fitvids.js', array('jquery'), null, true);
          wp_add_inline_script( 'fitvids',  'jQuery(document).ready(function() {
            jQuery(".wp-block-embed-vimeo").fitVids();
          });');
        }
      }
    }
  }
endif;

add_action( 'enqueue_block_assets', 'simple_days_gutenberg_front_styles' );

if ( ! function_exists( 'simple_days_menus' ) ) :
  function simple_days_menus() {

    $locations = array(
      'primary'  => esc_html__( 'Header Menu', 'simple-days' ),
      'secondary' => esc_html__( 'Header Menu', 'simple-days' ),
      'sub'   => esc_html__( 'Header Sub Menu', 'simple-days' ),
    );
    register_nav_menus( $locations );
  }
endif;
add_action( 'init', 'simple_days_menus' );


if ( ! function_exists( 'simple_days_widgets_init' ) ) :
  
  function simple_days_widgets_init() {
    get_template_part( 'inc/widgets' );
  }
endif;
add_action( 'widgets_init', 'simple_days_widgets_init' );


if ( ! function_exists( 'simple_days_delete_cache' ) ) :
  function simple_days_delete_cache() {
    get_template_part( 'inc/lib/delete_cache' );
  }
endif;
add_action('switch_theme', 'simple_days_delete_cache');



if ( is_admin() ){

  require_once SIMPLE_DAYS_THEME_DIR . 'inc/lib/admin_page.php' ;

}else{

  require_once SIMPLE_DAYS_THEME_DIR . 'inc/extra-content.php';

}



if( is_customize_preview() ) {

    // Setup the Theme Customizer settings and controls...
  require_once SIMPLE_DAYS_THEME_DIR . 'inc/customizer/customizer.php';

  require_once SIMPLE_DAYS_THEME_DIR . 'inc/starter_content.php';
  add_theme_support( 'starter-content', simple_days_get_starter_content() );
}

