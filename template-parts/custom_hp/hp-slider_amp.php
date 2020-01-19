<?php
/**
 *
 * @package Simple Days
 */


function simple_days_custom_hp_slider_amp( $settings , $latest_posts , $args ){
	?>

	<amp-carousel id="carousel-with-carousel-preview"
	width="400"
	height="200"
	layout="responsive"
	type="slides">
	<?php
	while( $latest_posts->have_posts() ) : $latest_posts->the_post();
		global $post;
		$thumurl = simple_days_get_thumbnail( $post->ID , $settings['image_size'] , $post);

		$this_url = get_permalink();

		if($settings['to_main_content']){
			$this_url .= '#post-'.$this_id;
		}

		?>


		<div class="slide">
			<div class="relative">
				<div class="fit_box_img_wrap sd_slider_img">
					<a href="<?php echo esc_url($this_url); ?>" rel="bookmark">
						<amp-img src="<?php echo esc_url( $thumurl[0] ); ?>"
							width="<?php echo esc_attr($thumurl[1]); ?>"
							height="<?php echo esc_attr($thumurl[2]); ?>"

							alt="<?php echo esc_attr($post ->post_title); ?>">
						</amp-img>
					</a>
				</div>
				<div class="sd_slider_info absolute z1 bottom0 left0 p20 w100 bc_shadow">
					<div class="mdn">
						<?php
						$category = get_the_category();
						if(!empty($category)){
							echo '<a href="' . esc_url(get_category_link( $category[0]->term_id )) . '" class="post_card_category non_hover relative dib">' . esc_html($category[0]->cat_name) . '</a>';
						}
						?>
					</div>
					<div>
						<a href="<?php echo esc_url($this_url); ?>" rel="bookmark">
							<h3 class="sd_slider_title of_h dib fc_fff"><?php the_title(); ?></h3>
						</a>
					</div>
					<div class='mdn fs13 p5 fc_fff'>
						<?php echo get_the_date(); ?>
					</div>
				</div>
			</div>
		</div>


		<?php
	endwhile;
	$latest_posts->rewind_posts();
	$i = 0;
	?>
</amp-carousel>
<?php
if($settings['thumbnail']):
	?>
	<amp-carousel class="carousel-preview"
	width="auto"
	height="48"
	layout="fixed-height"
	type="carousel">
	<?php
	while( $latest_posts->have_posts() ) : $latest_posts->the_post();
		global $post;
		$thumurl = simple_days_get_thumbnail( $post->ID , 'thumbnail' , $post);
		?>
		<button on="tap:carousel-with-carousel-preview.goToSlide(index=<?php echo esc_attr($i); ?>)">
			<amp-img src="<?php echo esc_url( $thumurl[0] ); ?>"
				width="<?php echo esc_attr($thumurl[1]); ?>"
				height="<?php echo esc_attr($thumurl[2]); ?>"
				layout="responsive"
				alt="<?php echo esc_attr($post ->post_title); ?>">
			</amp-img>
		</button>
		<?php
		++$i;
	endwhile;
	?>
</amp-carousel>
<?php
endif;

}


