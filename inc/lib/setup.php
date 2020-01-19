<?php
defined( 'ABSPATH' ) || exit;

function simple_days_sidebar_setup() {
	$sidebar = false;

	if(get_theme_mod( 'simple_days_sidebar_layout','3') != '0'  && ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-fixed' ) ) ){
		$sidebar = true;
	}

	if(is_singular()){
		$one_column_post = explode(',', get_theme_mod( 'simple_days_one_column_post',''));
		if(in_array($post->ID, $one_column_post))$sidebar = false;
	}

	define( 'SIMPLE_DAYS_SIDEBAR', $sidebar );
}
