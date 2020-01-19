<?php defined( 'ABSPATH' ) || exit;
/**
 * Template Name: Title and content only without sidebar
 * Template Post Type: post,page
 *
 * @package Simple Days
 *
 */
__( 'Title and content only without sidebar', 'simple-days' );
get_header();
while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/post/post','google_effect' );
	$post_title_effects = simple_days_google_post_title_effects();

	if(has_post_thumbnail()){
		get_template_part( 'template-parts/post/post','full_thum' );
		simple_days_full_width_thumbnail_page($post_title_effects);
	}

	?>


	<div class="container m_con jc_c retaina_p0">
		<main id="post-<?php the_ID(); ?>" <?php post_class('contents hp_content shadow_box'); ?> itemprop="mainContentOfPage" itemscope="itemscope" itemtype="https://schema.org/Article">

			<?php
			$type = 'post';
			if(is_page()) $type = 'page';
			$format = get_post_format();
			if($format != 'aside' && $format != 'link' && $format != 'status'){
				get_template_part( 'template-parts/post/post', 'title' );
				$vf = 'simple_days_title_' . $type;
				$vf($post_title_effects);
			}

			echo '<article id="post_body" class="post_body clearfix post_item mb_L" itemprop="articleBody">';

			the_content();


			echo '</article>';
			?>
		</main>
	</div>

<?php endwhile; ?>
<?php get_footer();
