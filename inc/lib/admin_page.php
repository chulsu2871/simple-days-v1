<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'simple_days_admin_menu' ) ) :
	function simple_days_admin_menu() {
		add_theme_page( esc_html_x( 'Color' , 'dashboard' , 'simple-days'), esc_html_x( 'Color' , 'dashboard' , 'simple-days'), 'manage_options', 'customize.php?autofocus[panel]=simple_days_custom_colors' );
		add_theme_page( esc_html__( 'Customize Homepage', 'simple-days'), esc_html__( 'Customize Homepage', 'simple-days'), 'manage_options', 'simple_days_customize_homepage_info','simple_days_customize_homepage_info' );
	}
endif;
add_action('admin_menu', 'simple_days_admin_menu');

if ( ! function_exists( 'simple_days_customize_homepage_info' ) ) :
	function simple_days_customize_homepage_info(){ ?>

		<h2>Simple Days</h2>

		<h3><?php esc_html_e( 'How to customize Homepage' , 'simple-days'); ?></h3>

		<?php
		if ( 'posts' == get_option( 'show_on_front' ) ) {

			simple_days_customize_homepage_info_select_template();

			simple_days_customize_homepage_info_select_static();

		}elseif ( 'page' == get_option( 'show_on_front' ) ) {

			$frontpage_id = get_option( 'page_on_front' );

			$frontpage_slug = get_page_template_slug( $frontpage_id );

			if ( $frontpage_slug != 'templates/homepage.php' ) {

				simple_days_customize_homepage_info_select_template();

				simple_days_customize_homepage_info_select_static();

			} else {
				?>
				<div class="updated fade">
					<p>
						<?php
						esc_html_e( 'Activated "Custom Homepage" successfully.', 'simple-days' );
						?>
					</p>
				</div>
				<p>
					<?php
					esc_html_e( 'Simple Days provide a widgets for "Custom Homepage"', 'simple-days' );
					?>
				</p>
				<p>
					<?php
					esc_html_e( 'Adding widgets to "Custom Homepage" from Widget area.', 'simple-days' );
					?>
				</p>
				<a class="button button-primary" target="_blank" href="<?php echo esc_url( admin_url( '/widgets.php' ) ); ?>"><?php esc_html_e( 'Widgets','simple-days' ); ?></a>
				<?php
			}
			?>

			<?php
		}
		?>

		<?php
	}
endif;

if ( ! function_exists( 'simple_days_customize_homepage_info_select_static' ) ) :
	function simple_days_customize_homepage_info_select_static(){ ?>
		<span style="background:#000;color:#fff;padding: 5px;"><?php esc_html_e( 'Homepage change to a static page', 'simple-days' ) ?></span>
		<ol>
			<li>
				<a target="_blank" href="<?php echo esc_url( admin_url( '/options-reading.php' ) ); ?>"><?php esc_html_e( 'Open Reading Settings' , 'simple-days'); ?></a>
			</li>
			<li>
				<?php esc_html_e( 'Select "A Static page" from "Your homepage displays"', 'simple-days' ) ?>
			</li>
			<li>
				<?php esc_html_e( 'Select page with applied a Template "Custom Homepage" from "Homepage:"', 'simple-days' ) ?>
			</li>
			<li>
				<?php esc_html_e( 'Save Changes' , 'simple-days'); ?>
			</li>
		</ol>
		<?php
	}
endif;

if ( ! function_exists( 'simple_days_customize_homepage_info_select_template' ) ) :
	function simple_days_customize_homepage_info_select_template(){ ?>
		<span style="background:#000;color:#fff;padding: 5px;"><?php esc_html_e( 'Create a page &#38; Apply a page template', 'simple-days' ) ?></span>
		<ol>
			<li>
				<a target="_blank" href="<?php echo esc_url( admin_url( '/post-new.php?post_type=page' ) ); ?>"><?php esc_html_e( 'Create a page' , 'simple-days'); ?></a>
			</li>
			<li>
				<?php esc_html_e( 'Title is anything ok. Content of articles does not reflects.' , 'simple-days'); ?>
			</li>
			<li>
				<?php esc_html_e( 'Select Template-"Custom Homepage" from "Page Attributes" dialog box' , 'simple-days'); ?>
			</li>
			<li>
				<?php esc_html_e( 'Publish' , 'simple-days'); ?>
			</li>
		</ol>
		<?php
	}
endif;

if ( ! function_exists( 'simple_days_gutenberg_editor_styles' ) ) :
	
	function simple_days_gutenberg_editor_styles() {
		wp_enqueue_style( 'simple_days_gutenberg_editor_styles', SIMPLE_DAYS_THEME_URI . 'assets/css/gutenberg-editor-style.min.css',array( 'wp-edit-blocks' ) );
		wp_enqueue_style( 'simple_days_gutenberg_front_styles', SIMPLE_DAYS_THEME_URI . 'assets/css/gutenberg-front-one-column-style.min.css',array( 'wp-edit-blocks' ) );
		wp_enqueue_style('font-awesome4', SIMPLE_DAYS_THEME_URI . 'assets/fonts/fontawesome/style.min.css', array(), null);
	}
endif;
add_action( 'enqueue_block_editor_assets', 'simple_days_gutenberg_editor_styles' );



if (function_exists('register_block_type')) {
	
}

if ( ! function_exists( 'simple_days_customizer_css' ) ) :
	
	function simple_days_customizer_css() {

		get_template_part( 'inc/customizer/customizer_css' );

	}
endif;
add_action( 'customize_controls_print_styles', 'simple_days_customizer_css' );

if ( ! function_exists( 'simple_days_customizer_script' ) ) :
	
	function simple_days_customizer_script() {

	}
endif;
add_action( 'customize_register', 'simple_days_customizer_script' );

if ( ! function_exists( 'simple_days_customize_preview' ) ) :
	function simple_days_customize_preview() {

	}
endif;
add_action( 'customize_preview_init', 'simple_days_customize_preview' );


// Displays plugin notices on admin backend
require_once SIMPLE_DAYS_THEME_DIR . 'inc/notice.php';

require_once SIMPLE_DAYS_THEME_DIR . 'inc/tgm/tgm.php';

function simple_days_tiny_mce_before_init_custom( $mceInit ) {
	if ( ! function_exists( 'use_block_editor_for_post' ) ) :
		
		$mceInit['body_class'] .= ' post_body';
	endif;
	return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'simple_days_tiny_mce_before_init_custom' );
