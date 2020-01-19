<?php defined( 'ABSPATH' ) || exit;
/**
 * Template Name: Full width
 * Template Post Type: post,page
 *
 * @package Simple Days
 *
 */
__( 'Full width', 'simple-days' );
get_header();
while ( have_posts() ) : the_post();

	require_once SIMPLE_DAYS_THEME_DIR . 'template-parts/post-sort_order.php';
	$single_sortable = simple_days_sort_order_page();

	get_template_part( 'template-parts/post/post','google_effect' );
	$post_title_effects = simple_days_google_post_title_effects();

	if(has_post_thumbnail()){
		get_template_part( 'template-parts/post/post','full_thum' );
		simple_days_full_width_thumbnail_page($post_title_effects);
	}

	?>


	<div class="container m_con jc_c retaina_p0">
		<main id="post-<?php the_ID(); ?>" <?php post_class('contents hp_content f_box f_col shadow_box'); ?> itemprop="mainContentOfPage" itemscope="itemscope" itemtype="https://schema.org/Article">

			<?php
			if ( 'post' === get_post_type() ) :
				get_template_part( 'template-parts/post','order' );
				simple_days_post_order( 'post' , $single_sortable , $post_title_effects , $post);
			else :
				get_template_part( 'template-parts/post','order' );
				simple_days_post_order( 'page' , $single_sortable , $post_title_effects , $post);
			endif; ?>
		</main>


	</div>

<?php endwhile; ?>
<?php get_footer();
