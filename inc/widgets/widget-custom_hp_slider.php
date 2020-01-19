<?php
/**
 * Widget Custom Homepage columns layout
 *
 * @package Simple Days
 */


class simple_days_custom_hp_slider_widget extends WP_Widget {


	function __construct() {

		parent::__construct(
			'custom_hp_slider', // Base ID
			esc_html__( '[Simple Days] Thumbnail carousel for Custom Homepage', 'simple-days' ), // Name
			array( 'description' => esc_html__( 'Display thumbnail carousel', 'simple-days' ), ) // Args
		);
	}

	private $settings;

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'title'    => '',
			'category' => 0,
			'number_post'   => 6,
			'date' => true,
			'image_size' => 'medium',
			'random' => false,
			'sticky_posts' => true,
			'include_page' => false,
			'thumbnail' => true,
			'to_main_content' => false,
		);

		return $defaults;
	}

	public function widget( $args, $instance ) {



		$this->settings = wp_parse_args( $instance, $this->default_settings() );
		$settings = $this->settings;
		$orderby = 'date';
		if($settings['random'])$orderby = 'rand';

		$post_type = array('post');
		if($settings['include_page']) $post_type = array('post','page');

		$latest_posts = new WP_Query(
			array(
				'post_type'             => $post_type,
				'cat'					=> $settings['category'],
				'posts_per_page'		=> $settings['number_post'],
				'post_status'			=> 'publish',
				'ignore_sticky_posts' 	=> $settings['sticky_posts'],
				'orderby'               => $orderby,
			)
		);
		if ( $latest_posts->have_posts() ) :
			$args['before_widget'] = str_replace( 'widget_custom_hp_slider','widget_custom_hp_slider fit_content',$args['before_widget']);
			$args['before_widget'] = str_replace( '">','" style="padding:0;max-width:none;">',$args['before_widget']);

			echo $args['before_widget'];

			if(function_exists('yahman_addons_amp_head')){
				//add_action('wp_enqueue_scripts', array($this, 'scripts_amp'));
				include_once SIMPLE_DAYS_THEME_DIR . 'template-parts/custom_hp/hp-slider_amp.php';
				simple_days_custom_hp_slider_amp( $settings , $latest_posts , $args );
			}else{
				add_action('wp_footer', array($this, 'scripts'));
				include_once SIMPLE_DAYS_THEME_DIR . 'template-parts/custom_hp/hp-slider.php';
				simple_days_custom_hp_slider( $settings , $latest_posts , $args );
			}



			echo $args['after_widget'];
		endif;

		wp_reset_query();  

	}


	public function form( $instance ) {

	    // Get Widget Settings.
		$this->settings = wp_parse_args( $instance, $this->default_settings() );
		$settings = $this->settings;
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'simple-days' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category&#58;', 'simple-days' ); ?></label>
			<?php // Display Category Select.
			$args = array(
				'show_option_all'    => esc_html__( 'All Categories', 'simple-days' ),
				'show_count' 		 => true,
				'hide_empty'		 => false,
				'selected'           => $settings['category'],
				'name'               => $this->get_field_name( 'category' ),
				'id'                 => $this->get_field_id( 'category' ),
				'depth'              => 1,
				'hierarchical'		 => true,
			);
			wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_post' ) ); ?>"><?php esc_html_e( 'Number of posts', 'simple-days' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_post' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo absint( $settings['number_post'] ); ?>" />
		</p>

		<p>
			<input type="checkbox" <?php checked( $settings['date'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" />
			<label for="<?php echo $this->get_field_id('date'); ?>"><?php esc_html_e( 'Display date', 'simple-days' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>">
				<?php esc_html_e( 'Original size of image', 'simple-days' ); ?>
			</label><br />
			<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_size' )); ?>">
				<?php
				$image_size = array(
					'thumbnail' => esc_html__( 'Thumbnail', 'simple-days' ),
					'medium' => esc_html__( 'Medium', 'simple-days' ),
					'large' => esc_html__( 'Large', 'simple-days' ),
					'full' => esc_html__( 'Full', 'simple-days' ),
				);
				foreach ($image_size as $key => $value) {
					echo '<option '. selected( $settings['image_size'], $key ) .' value="'.esc_attr($key).'" >'.esc_html($value).'</option>';
				}
				?>
			</select>
		</p>
		<p>
			<input type="checkbox" <?php checked( $settings['thumbnail'], true ) ?> class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumbnail' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>">
				<?php esc_html_e( 'Show thumbnail', 'simple-days' ); ?>
			</label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $settings['random'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" />
			<label for="<?php echo $this->get_field_id('random'); ?>"><?php esc_html_e( 'Display random', 'simple-days' ); ?></label>
		</p>

		<p>
			<input type="checkbox" <?php checked( $settings['sticky_posts'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('sticky_posts'); ?>" name="<?php echo $this->get_field_name('sticky_posts'); ?>" />
			<label for="<?php echo $this->get_field_id('sticky_posts'); ?>"><?php esc_html_e( 'Ignore sticky posts', 'simple-days' ); ?></label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $settings['include_page'], true ) ?> class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'include_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'include_page' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'include_page' ) ); ?>">
				<?php esc_html_e( 'include page', 'simple-days' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" <?php checked( $settings['to_main_content'], true ) ?> class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'to_main_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'to_main_content' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'to_main_content' ) ); ?>">
				<?php esc_html_e( 'link to main content', 'simple-days' ); ?>
			</label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];
		$instance['number_post'] = (int) $new_instance['number_post'];
		$instance[ 'date' ] = (bool)$new_instance[ 'date' ];
		$instance['image_size'] = sanitize_text_field( $new_instance['image_size'] );
		$instance[ 'random' ] = (bool)$new_instance[ 'random' ];
		$instance[ 'sticky_posts' ] = (bool)$new_instance[ 'sticky_posts' ];
		$instance[ 'include_page' ] = (bool)$new_instance[ 'include_page' ];
		$instance[ 'thumbnail' ] = (bool)$new_instance[ 'thumbnail' ];
		$instance[ 'to_main_content' ] = (bool)$new_instance[ 'to_main_content' ];

		return $instance;
	}

	public function scripts($hook){
		$settings = $this->settings;
		//add_action('wp_enqueue_scripts', array($this, 'scripts'));
		wp_enqueue_script('flexslider',SIMPLE_DAYS_THEME_URI . 'assets/js/flexslider/jquery.flexslider.min.js', array('jquery'), null , true );
		if($settings['thumbnail']){
			wp_add_inline_script( 'flexslider', '
				jQuery(document).ready(function() {
					jQuery(\'.sd_carousel\').flexslider({
						animation: "slide",
						controlNav: false,
						animationLoop: false,
						slideshow: true,
						itemWidth: 144,
						itemMargin: 8,
						asNavFor: ".sd_slider"
						});

						jQuery(\'.sd_slider\').flexslider({
							animation: "slide",
							controlNav: false,
							animationLoop: false,
							slideshow: true,
							sync: ".sd_carousel"
							});



							});

							');
		}else{
			wp_add_inline_script( 'flexslider', '
				jQuery(document).ready(function() {
					jQuery(\'.sd_slider\').flexslider({
						animation: "slide",
						animationLoop: false,
						slideshow: true,
						});



						});

						');
		}
		wp_enqueue_style('flexslider', SIMPLE_DAYS_THEME_URI . 'assets/css/flexslider.min.css', array(), null);

	}

	public function scripts_amp($hook){


		wp_enqueue_script('amp-carousel','https://cdn.ampproject.org/v0/amp-carousel-0.1.js', array(), null , false);
		wp_enqueue_script('amp-lightbox-gallery','https://cdn.ampproject.org/v0/amp-lightbox-gallery-0.1.js', array(), null , false);

	}

} // class simple_days_custom_hp_slider_widget
