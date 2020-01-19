<?php get_header();
$layout =get_theme_mod( 'simple_days_index_layout_list','list');
if($layout == 'list' ){
  $layout = ' flat_list';
}elseif($layout == 'grid3' ){
  $layout = ' grid_3';
}elseif($layout == 'grid2' ){
  $layout = ' grid_2';
}else{
  $layout = '';
}
?>
<main>
  <div class="container m_con retaina_p0">
    <div class="contents index_contents f_box f_wrap<?php echo esc_attr($layout); ?>">
      <header class="archive_header shadow_box">
        <?php
        the_archive_title( '<h1 class="archive_title fs18">', '</h1>' );
        the_archive_description( '<div class="archive_description">', '</div>' );
        ?>
      </header>
      <?php
      if(have_posts()):
        //get_template_part( 'inc/breadcrumbs' );
        get_template_part( 'template-parts/index/post_card');
        simple_days_index_post_card();

      else:
        get_template_part( 'template-parts/index/content', 'none' );
      endif;

      
      get_template_part( 'template-parts/index/pagination' );

      ?>
    </div>

    <?php if(SIMPLE_DAYS_SIDEBAR)get_sidebar(); ?>

  </div>
</main>
<?php get_footer();
