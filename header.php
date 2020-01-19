<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif;
wp_head();
?>
</head>
<body <?php body_class(); ?> ontouchstart="">
	<?php wp_body_open(); ?>
	<input id="t_menu" class="dn" type="checkbox" />
	<?php
    //over header widget
	if( is_active_sidebar( 'over_header' ))  get_template_part( 'template-parts/header/header','over' );
	?>
	<header id="h_wrap" class="f_box f_col shadow_box h_sticky">
		<div id="h_flex" class="f_box f_col110 retaina_p0">
			<div id="site_h" role="banner">
				<div class="container sh_con f_box ai_c jc_c f_col110 retaina_p0">

					<?php simple_days_menu_box(); ?>

					<div class="title_tag f_box ai_c f_col">

						<?php simple_days_site_title_display(); ?>

					</div>

					<?php $mod = get_theme_mod( 'simple_days_menu_layout','1');

					if( is_active_sidebar( 'header_widget' )){
						?>
						<div class="hw_con f_box ai_c jc_c f_wrap">
							<?php dynamic_sidebar( 'header_widget' ); ?>
						</div>
						<?php
						if(($mod == "1" || $mod == "2") && is_active_nav_menu('primary'))echo '<div class="m_box"></div>';
					} ?>
				</div>

				<?php simple_days_mobile_search(); ?>
		</div>
		<div id="nav_h" class="<?php if($mod == "3" || $mod == "4")echo 'nav_h2 '; ?>f_box">
			<?php simple_days_primary_menu(); ?>
		</div>

	</div>
</header>
<?php
if ( is_active_nav_menu('sub')) {
	simple_days_sub_menu();
}
?>




<?php




//alert box
if( get_theme_mod( 'simple_days_alert_box',false) ) get_template_part( 'template-parts/header/header','alertbox' );
//Header image
if( (is_home() || is_front_page() ) && get_header_image() ) get_template_part( 'template-parts/header/header','image' );

if( is_active_sidebar( 'under_header' )) get_template_part( 'template-parts/header/header','under' );
