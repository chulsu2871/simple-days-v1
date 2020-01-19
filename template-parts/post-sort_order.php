<?php
/**
 *
 * @package Simple Days
 */

function simple_days_sort_order_post() {
  if(function_exists('yahman_addons_textdomain_load')){
    $sort_order_list['base'] =array(
     'breadcrumbs','title','date','author','pv','thumbnail','content','page_link','cta','share','author_profile','related','category','tag','pagenation','comment','widget_1','widget_2','widget_3','widget_4','widget_5',
   );
  }else{
    $sort_order_list['base'] =array(
     'breadcrumbs','title','date','author','thumbnail','content','page_link','share','author_profile','category','tag','pagenation','comment','widget_1','widget_2','widget_3','widget_4','widget_5',
   );
  }
  $sort_order_list['custom'] = get_theme_mod( 'simple_days_posts_sortable',$sort_order_list['base']);

  return simple_days_sort_order_output($sort_order_list);
}

function simple_days_sort_order_page() {
  if(function_exists('yahman_addons_textdomain_load')){
    $sort_order_list['base'] =array(
     'breadcrumbs','title','date','author','pv','thumbnail','content','page_link','cta','share','author_profile','related','category','tag','comment','widget_1','widget_2','widget_3','widget_4','widget_5',
   );
  }else{
    $sort_order_list['base'] =array(
     'breadcrumbs','title','date','author','thumbnail','content','page_link','share','author_profile','category','tag','comment','widget_1','widget_2','widget_3','widget_4','widget_5',
   );
  }
  $sort_order_list['custom'] = get_theme_mod( 'simple_days_page_sortable',$sort_order_list['base']);

  return simple_days_sort_order_output($sort_order_list);
}

function simple_days_sort_order_output($sort_order_list) {
	
  $sort_order_list['custom'] = array_values(array_intersect($sort_order_list['custom'],$sort_order_list['base']));
  
  $sort_order_list['custom'] += array_diff($sort_order_list['base'],$sort_order_list['custom']);

  return $sort_order_list['custom'];
}


