<?php
/**
 * Widget Custom Homepage columns layout
 *
 * @package Simple Days
 */


class simple_days_custom_hp_grid_widget extends WP_Widget {


	function __construct() {
		parent::__construct(
			'custom_hp_grid', // Base ID
			esc_html__( '[Simple Days] Category grid for Custom Homepage', 'simple-days' ), // Name
			array( 'description' => esc_html__( 'Display grid layout', 'simple-days' ), ) // Args
		);
	}

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'title'    => esc_html__( 'Category', 'simple-days' ),
			'category' => 0,
			'columns'   => 3,
			'number_post'   => 6,
			'date' => true,
			'image_size' => 'medium',
			'random' => false,
			'sticky_posts' => true,
			'include_page' => false,
			'to_main_content' => false,
		);

		return $defaults;
	}

	public function widget( $args, $instance ) {

		$settings = wp_parse_args( $instance, $this->default_settings() );

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
			echo $args['before_widget'];
			if ( ! empty($settings['title']) ) {
				echo $args['before_title']. $settings['title'] .  $args['after_title'];
			}



			echo '<div class="post_list_box"><ul class="post_list_ul m0 lsn f_box f_wrap jc_sb">';
			include_once SIMPLE_DAYS_THEME_DIR . 'template-parts/custom_hp/hp-grid.php';
			while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
				global $post;
				simple_days_custom_hp_grid( $post , $settings );
			endwhile;

			echo '</ul></div>';
			echo $args['after_widget'];
		endif;

		wp_reset_query();  

	}


	
	
	

	public function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>">
				<?php esc_html_e( 'Columns', 'simple-days' ); ?>
			</label><br />
			<select id="<?php echo esc_attr( $this->get_field_id( 'columns' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' )); ?>">
				<?php
				$columns_list = array(
					2 => esc_html__( 'two columns', 'simple-days' ),
					3 => esc_html__( 'three columns', 'simple-days' ),
					4 => esc_html__( 'four columns', 'simple-days' ),
				);
				foreach ($columns_list as $key => $value) {
					echo '<option '. selected( $settings['columns'], $key ) .' value="'.esc_attr($key).'" >'.esc_html($value).'</option>';
				}
				?>
			</select>
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
		$instance['columns'] = (int) $new_instance['columns'] ;
		$instance['number_post'] = (int) $new_instance['number_post'];
		$instance[ 'random' ] = (bool)$new_instance[ 'random' ];
		$instance[ 'date' ] = (bool)$new_instance[ 'date' ];
		$instance['image_size'] = sanitize_text_field( $new_instance['image_size'] );
		$instance[ 'sticky_posts' ] = (bool)$new_instance[ 'sticky_posts' ];
		$instance[ 'include_page' ] = (bool)$new_instance[ 'include_page' ];
		$instance[ 'to_main_content' ] = (bool)$new_instance[ 'to_main_content' ];

		return $instance;
	}

} // class simple_days_custom_hp_columns_widget
