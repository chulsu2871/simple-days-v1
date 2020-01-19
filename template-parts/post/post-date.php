<?php
defined( 'ABSPATH' ) || exit;
/**
 *
 * @package Simple Days
 */


function simple_days_date_post(){
  if(get_theme_mod( 'simple_days_posts_date_position','right') == 'none') return;
  $date_display = get_theme_mod( 'simple_days_posts_date_display','both');
  simple_days_date_output($date_display);
}

function simple_days_date_page(){
  if(get_theme_mod( 'simple_days_page_date_position','none') == 'none') return;
  $date_display = get_theme_mod( 'simple_days_page_date_display','both');
  simple_days_date_output($date_display);
}

function simple_days_date_output($date_display){
  echo '<div class="post_date post_item mb_L">';
  if (get_the_modified_date('Ymd') > get_the_date('Ymd') && $date_display != 'date'){
    if ($date_display == 'both'){
      echo '<i class="fa '.esc_attr(get_theme_mod( 'simple_days_posts_date_icon','fa-calendar-check-o')).'" aria-hidden="true"></i> '.get_the_date();
    }
    echo '&emsp;<span class="post_updated"><i class="fa '.esc_attr(get_theme_mod( 'simple_days_posts_up_date_icon','fa-history')).'" aria-hidden="true"></i> '.esc_html(get_the_modified_date()).'</span>';
  }else{
    echo '<i class="fa '.esc_attr(get_theme_mod( 'simple_days_posts_date_icon','fa-calendar-check-o')).'" aria-hidden="true"></i> '.get_the_date();
  }
  echo '</div>';
}


