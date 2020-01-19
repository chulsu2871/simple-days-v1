<?php
/**
 *
 * @package Simple Days
 */

function simple_days_index_post_card(){
	

	global $post;

	$mod_value = array(
		'layout' => get_theme_mod( 'simple_days_index_layout_list','list'),
		'date_format' => get_theme_mod( 'simple_days_top_date_format','1'),
		'more_link_class' => get_theme_mod( 'simple_days_read_more_position','right'),
		'date_position' => get_theme_mod( 'simple_days_index_date_position','left'),
		'thumbnail_position' => get_theme_mod( 'simple_days_index_thumbnail','left'),
		'thumbnail_size' => get_theme_mod( 'simple_days_index_thumbnail_size','medium'),
		'category_position' => get_theme_mod( 'simple_days_index_category_position','right'),
		'author_position' => get_theme_mod( 'simple_days_index_author_position','none'),
		'excerpt_length' => get_theme_mod( 'simple_days_excerpt_length_customize',150),
		'excerpt_ellipsis' => get_theme_mod( 'simple_days_excerpt_ellipsis','&hellip;'),
		'excerpt_type' => get_theme_mod( 'simple_days_excerpt_type','characters'),

		'typical' => get_theme_mod( 'simple_days_index_typical','original'),
		'sidebar' => get_theme_mod( 'simple_days_sidebar_layout','3'),
		'index_list_position' => get_theme_mod( 'simple_days_index_list_widget_position','after'),
		'index_list_num' => get_theme_mod( 'simple_days_index_list_widget_number',3),
		'index_title_excerpt_length' => get_theme_mod( 'simple_days_index_title_excerpt_length',50),
	);

	$pc_list = $col = $list_card = '';
	$i = 1;


	if($mod_value['layout'] === 'list' ){
		
		$mod_value['layout'] = ' flat_list';
		$pc_list = ' pc_list';
		$col = '110';
		$list_card = ' list_card';

	}elseif($mod_value['layout'] === 'grid3' ){
		
		$mod_value['layout'] = ' grid_3';

	}elseif($mod_value['layout'] === 'grid2' ){
		
		$mod_value['layout'] = ' grid_2';

	}else{

		$mod_value['layout'] = '';

	}


	while(have_posts()): the_post();
		$index_title = strip_tags( get_the_title() );
		?>

		<article <?php post_class('post_card f_box f_col'.$col.$list_card.' shadow_box' ); ?>>

			<?php 
			if($mod_value['thumbnail_position'] !== 'none'): ?>
				<div class="post_card_thum<?php echo esc_attr($pc_list); ?>">
					<a href="<?php the_permalink(); ?>" class="fit_box_img_wrap post_card_thum_img">
						<?php

						$thumurl = simple_days_get_thumbnail( '' , $mod_value['thumbnail_size'] , $post);

						echo '<img decoding="async" src="'.esc_url($thumurl[0]).'"  width="'.esc_attr($thumurl[1]).'" height="'.esc_attr($thumurl[2]).'" class="scale_13 trans_10" alt="'.esc_attr($index_title).'" title="'.esc_attr($index_title).'" />';
						?>
					</a>
					<?php
					if($mod_value['typical'] === 'original'){
						simple_days_index_category($mod_value['category_position']);
						simple_days_index_date($mod_value['date_position'],$mod_value['date_format']);
					}
					?>
				</div>
			<?php endif;
			

			
			?>

			<div class="post_card_meta w100 f_box f_col jc_sa">
				<h2 class="post_card_title"><?php if(is_sticky()) echo '<span class="sticky_icon"><i class="fa fa-thumb-tack" aria-hidden="true"></i> </span>'; ?><a href="<?php the_permalink(); ?>" class="entry_title" title="<?php echo esc_attr($index_title); ?>"><?php echo mb_strimwidth($index_title, 0, $mod_value['index_title_excerpt_length'] ,'&hellip;', 'utf-8'); ?></a></h2>
				<?php
				
				if($mod_value['typical'] === 'typical'){
					?>
					<div class="typical mt10 mb10"><?php simple_days_index_date_typical($mod_value['date_position']); ?> <?php simple_days_index_category_typical($mod_value['category_position']); ?></div>
					<?php
				}
				
				if($mod_value['author_position'] != 'none'){

					$author_position = '';
					if($mod_value['author_position'] === 'right')$author_position = ' ta_r';
					if($mod_value['author_position'] === 'center')$author_position = ' ta_c';

					echo '<div class="index_author mt10 mb10'.$author_position.'">';
					if( get_theme_mod( 'simple_days_index_author_icon_avatar',false) ){
						echo '<div class="dib"><img decoding="async" src="' . esc_url( get_avatar_url( get_the_author_meta( 'ID' ) , array("size"=>32 )) ) . '" width="32" height="32" class="vam br50" alt="'.get_the_author_meta( 'nickname' ).'" /></div>';
					}else{
						echo '<i class="fa '.esc_attr( get_theme_mod( 'simple_days_index_author_icon','fa-user') ).'" aria-hidden="true"></i>';
					}

					echo '&nbsp;<a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'">'. get_the_author() .'</a>';
					echo '</div>';

				}

				?>

				<div class="summary">
					<?php
					
					$pe = get_post_field('post_excerpt', $post->ID);



					if($pe === ''){

						if($mod_value['excerpt_type'] === 'characters'){
							echo mb_substr(  wp_strip_all_tags(strip_shortcodes(get_the_content()), true), 0 , absint( $mod_value['excerpt_length'] ) , 'UTF-8' ) .$mod_value['excerpt_ellipsis'];
						//mb_strimwidth( wp_strip_all_tags(strip_shortcodes(get_the_content()), true), 0 , absint( $mod_value['excerpt_length'] ), , 'UTF-8');
						}else{

							$excerpt = explode(' ', wp_strip_all_tags( strip_shortcodes ( get_the_content() ), true ), absint( $mod_value['excerpt_length'] ) );
							if (count($excerpt) >= $mod_value['excerpt_length']) {
								array_pop($excerpt);
								$excerpt = implode(" ",$excerpt).$mod_value['excerpt_ellipsis'];
							} else {
								$excerpt = implode(" ",$excerpt);
							}
							echo preg_replace('{[[^]]*]}','',$excerpt);

						}



					}else{
						$allowed_html = array(
							'br' => array(),
						);
						echo wp_kses( nl2br($pe), $allowed_html);
					}

					?>

				</div>

				<?php
				
				if($mod_value['more_link_class'] !== 'none'){ ?>
					<div class="more_read_box">
						<a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"  class="more_read fs14 dib non_hover trans_10"><?php echo esc_html__( 'Read More', 'simple-days' ); ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
					</div>
					<?php
				}
				
				if($mod_value['thumbnail_position'] === 'none' && $mod_value['typical'] === 'original'){
					simple_days_index_category($mod_value['category_position']);
					simple_days_index_date($mod_value['date_position'],$mod_value['date_format']);
				}
				?>

			</div>

		</article>
		<?php
		
		if ( is_active_sidebar( 'index_list' ) ){
			if( ($mod_value['index_list_num'] === $i && $mod_value['index_list_position'] === 'after') || ( $i % $mod_value['index_list_num'] === 0 && $mod_value['index_list_position'] === 'every') ){ ?>
				<article class="in_feed post_card f_box f_col<?php echo esc_attr($list_card); ?> shadow_box">
					<?php dynamic_sidebar( 'index_list' ); ?>
				</article>
				<?php
			}
		}

		++$i;
	endwhile;

}


function simple_days_index_category($category_position){
	if($category_position == 'none') return;
	$category = get_the_category();
	if(!empty($category)){
		echo '<a href="' . esc_url(get_category_link( $category[0]->term_id )) . '" class="post_card_category dib absolute non_hover">' . esc_html($category[0]->cat_name) . '</a>';
	}
}

function simple_days_index_date($date_position,$date_format){
	if($date_position == 'none' || is_sticky()) return; ?>

	<div class="post_date_circle fs16 absolute ta_c">
		<?php if($date_format == "1" ){ ?>
			<span class="day db fs15"><?php echo esc_html(get_the_time('j').get_theme_mod( 'simple_days_index_date_after_day')); ?></span>
			<span class="month db fs14"><?php echo esc_html( get_the_time('M') ); ?></span>
		<?php }else{ ?>
			<span class="month db fs15"><?php echo esc_html(get_the_time('M')); ?></span>
			<span class="day db fs14"><?php echo esc_html(get_the_time('j').get_theme_mod( 'simple_days_index_date_after_day')); ?></span>
		<?php } ?>
		<span class="year db fs10"><?php echo esc_html(get_the_time('Y')); ?></span>
	</div>

	<?php
}

function simple_days_index_category_typical($category_position){
	if($category_position == 'none') return;
	$category = get_the_category();
	if(!empty($category)){
		echo '<span><i class="fa fa-folder-o" aria-hidden="true"></i> <a href="' . esc_url(get_category_link( $category[0]->term_id )) . '">' . esc_html($category[0]->cat_name) . '</a></span>';
	}
}

function simple_days_index_date_typical($date_position){
	if($date_position == 'none') return;

	echo '<span><i class="fa fa-calendar-check-o" aria-hidden="true"></i> '.get_the_date().'</span>';

}