<?php
/**
 *
 * @package Simple Days
 */


function simple_days_custom_hp_slider( $settings , $latest_posts , $args ){
	?>
	<div class="sd_featured_slider">
		<?php
		if ( ! empty($settings['title']) ) {
			echo '<h3 class="widget_title absolute z1 fc_fff dib p10 m10 bc_shadow">'. $settings['title'] .  '</h3>';
		}
		?>
		<section class="slider">


			<div class="flexslider sd_slider m0">
				<ul class="slides lsn">
					<?php
					while( $latest_posts->have_posts() ) : $latest_posts->the_post();
						global $post;
						$thumurl = simple_days_get_thumbnail( $post->ID , $settings['image_size'] , $post);
						$title = $post ->post_title;

						$this_url = get_permalink();

						if($settings['to_main_content']){
							$this_url .= '#post-'.$post->ID;
						}

						?>
						<li>
							<div class="relative">
								<div class="fit_box_img_wrap sd_slider_img">
									<a href="<?php echo esc_url($this_url); ?>" rel="bookmark">
										<img decoding="async" src="<?php echo esc_url( $thumurl[0] ); ?>" width="<?php echo esc_attr($thumurl[1]); ?>" height="<?php echo esc_attr($thumurl[2]); ?>" alt="<?php echo esc_attr($title); ?>" />
									</a>
								</div>
								<div class="sd_slider_info absolute z1 bottom0 left0 p20 w100 bc_shadow">
									<div class="mdn">
										<?php
										$category = get_the_category();
										if(!empty($category)){
											echo '<a href="' . esc_url(get_category_link( $category[0]->term_id )) . '" class="post_card_category non_hover relative dib left0" style="right:auto">' . esc_html($category[0]->cat_name) . '</a>';
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

						</li>

						<?php

					endwhile;

					?>
				</ul>
			</div><!-- .flexslider -->
		</section><!-- .slider -->

		<?php $latest_posts->rewind_posts();

		if($settings['thumbnail']):
			?>

			<div class="flexslider sd_carousel">
				<ul class="slides lsn">
					<?php
					while( $latest_posts->have_posts() ) : $latest_posts->the_post();
						global $post;
						$thumurl = simple_days_get_thumbnail( $post->ID , 'thumbnail' , $post);

						?>

						<li>
							<div class="fit_box_img_wrap"><img decoding="async" src="<?php echo esc_url( $thumurl[0] ); ?>" width="<?php echo esc_attr($thumurl[1]); ?>" height="<?php echo esc_attr($thumurl[2]); ?>" alt="<?php echo esc_attr($title); ?>" /></div>
						</li>

						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul><!-- .slides -->
			</div><!-- .sd_carousel -->
		<?php endif ?>
	</div><!-- .sd_featured_slider -->
	<?php
}


