<?php defined( 'ABSPATH' ) || exit;
/**
 * Template Name: Custom Homepage
 *
 * @package Simple Days
 *
 */
__( 'Custom Homepage', 'simple-days' );
get_header();

  //$single_column = ' single_post_content';
$sidebar = false;
$one_column_post = explode(',', get_theme_mod( 'simple_days_one_column_post',''));
if(SIMPLE_DAYS_SIDEBAR && !in_array($post->ID, $one_column_post) ){
  $sidebar = true;
  $single_column = '';
}
?>


<div class="container m_con jc_c retaina_p0">
  <main id="post-<?php the_ID(); ?>" <?php post_class('contents hp_content f_box f_col shadow_box'); ?>>

    <?php
    dynamic_sidebar( 'custom_homepage' );

    if ( have_posts() ) :

      while ( have_posts() ) : the_post();
        the_content();
      endwhile;

    endif; ?>

  </main>
  <?php if($sidebar) get_sidebar(); ?>

</div>

<?php get_footer();
