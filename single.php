<?php get_header(); ?>
<?php while ( have_posts() ) : the_post();

  require_once SIMPLE_DAYS_THEME_DIR . 'template-parts/post-sort_order.php';
  $single_sortable = simple_days_sort_order_post();

  get_template_part( 'template-parts/post/post','google_effect' );
  $post_title_effects = simple_days_google_post_title_effects();

  if(has_post_thumbnail()){
    get_template_part( 'template-parts/post/post','full_thum' );
    simple_days_full_width_thumbnail_post($post_title_effects);
  }

  $single_column = ' single_post_content';
  $sidebar = false;

  if(SIMPLE_DAYS_SIDEBAR){
    $sidebar = true;
    $single_column = '';
  }
  ?>


  <div class="container m_con jc_c retaina_p0">
    <main id="post-<?php the_ID(); ?>" <?php post_class('contents post_content shadow_box'.$single_column); ?>>

      <?php

      get_template_part( 'template-parts/post','order' );
      simple_days_post_order( 'post' , $single_sortable , $post_title_effects , $post);
      ?>

    </main>
    <?php if($sidebar) get_sidebar(); ?>

  </div>

<?php endwhile; ?>
<?php get_footer();
