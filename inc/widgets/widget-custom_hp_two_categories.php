<?php
/**
 * Widget Custom Homepage Two categories
 *
 * @package Simple Days
 */


class simple_days_custom_hp_two_categories_widget extends WP_Widget {


	function __construct() {
		parent::__construct(
			'custom_hp_two_categories', // Base ID
			esc_html__( '[Simple Days] Two columns of categories for Custom Homepage', 'simple-days' ), // Name
			array( 'description' => esc_html__( 'Display two columns of categories', 'simple-days' ), ) // Args
		);
	}

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'title_left'    => esc_html__( 'Category', 'simple-days' ),
			'category_left' => 0,
			'title_right'    => esc_html__( 'Category', 'simple-days' ),
			'category_right' => 0,
			'number_post'   => 4,
			'date' => true,
			'image_size' => 'thumbnail',
			'heading_image_size' => 'medium',
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

		include_once SIMPLE_DAYS_THEME_DIR . 'template-parts/custom_hp/hp-category_heading.php';
		include_once SIMPLE_DAYS_THEME_DIR . 'template-parts/custom_hp/hp-category_from_2nd.php';
		$angle = array('left','right');
		$grid_margin = array('left' => 'ch_sep','right' => '');
		echo $args['before_widget'];

		echo '<div class="f_box f_wrap jc_sb">';
		foreach ($angle as $angle_value) {
			$latest_posts = new WP_Query(
				array(
					'post_type'             => $post_type,
					'cat'					=> $settings['category_'.$angle_value],
					'posts_per_page'		=> $settings['number_post'],
					'post_status'			=> 'publish',
					'ignore_sticky_posts' 	=> $settings['sticky_posts'],
					'orderby'               => $orderby,
				)
			);
			if ( $latest_posts->have_posts() ) :
				$i=0;




				echo '<div class="f_grid2 '.$grid_margin[$angle_value].'">';

				if ( ! empty($settings['title_'.$angle_value]) ) {
					echo $args['before_title']. $settings['title_'.$angle_value] .  $args['after_title'];
				}

				echo '<div class="m0 f_box f_col f_wrap">';


				while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
					global $post;
					if($i === 0){
						simple_days_custom_hp_category_heading($post,$settings);
					}else{
						simple_days_custom_hp_category_from_2nd($post,$settings);
					}
					++$i;
				endwhile;

				echo '</div></div>';

			endif;

		}

		wp_reset_query();  

		echo '</div>';
		echo $args['after_widget'];

	}






	public function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>
		<div style="margin-top: 10px;border:1px solid #000;">
			<div style="background:#000;color:#fff;padding: 7px;font-size: 16px;"><?php esc_html_e( 'Left side', 'simple-days' ); ?></div>
			<p style="margin: 1em;">
				<label for="<?php echo $this->get_field_id( 'title_left' ); ?>">
					<?php esc_html_e( 'Title:', 'simple-days' ); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title_left' ); ?>" name="<?php echo $this->get_field_name( 'title_left' ); ?>" type="text" value="<?php echo esc_attr( $settings['title_left'] ); ?>" />

			</p>

			<p style="margin: 1em;">
				<label for="<?php echo $this->get_field_id( 'category_left' ); ?>"><?php esc_html_e( 'Category&#58;', 'simple-days' ); ?></label>
				<?php
			        // Display Category Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'simple-days' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_left'],
					'name'               => $this->get_field_name( 'category_left' ),
					'id'                 => $this->get_field_id( 'category_left' ),
					'depth'              => 1,
					'hierarchical'		 => true,
				);
				wp_dropdown_categories( $args );
				?>
			</p>
		</div>
		<div style="margin-top: 10px;border:1px solid #000;">
			<div style="background:#000;color:#fff;padding: 7px;font-size: 16px;"><?php esc_html_e( 'Right side', 'simple-days' ); ?></div>
			<p style="margin: 1em;">
				<label for="<?php echo $this->get_field_id( 'title_right' ); ?>">
					<?php esc_html_e( 'Title:', 'simple-days' ); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title_right' ); ?>" name="<?php echo $this->get_field_name( 'title_right' ); ?>" type="text" value="<?php echo esc_attr( $settings['title_right'] ); ?>" />

			</p>

			<p style="margin: 1em;">
				<label for="<?php echo $this->get_field_id( 'category_right' ); ?>"><?php esc_html_e( 'Category&#58;', 'simple-days' ); ?></label>
			<?php // Display Category Select.
			$args = array(
				'show_option_all'    => esc_html__( 'All Categories', 'simple-days' ),
				'show_count' 		 => true,
				'hide_empty'		 => false,
				'selected'           => $settings['category_right'],
				'name'               => $this->get_field_name( 'category_right' ),
				'id'                 => $this->get_field_id( 'category_right' ),
				'depth'              => 1,
				'hierarchical'		 => true,
			);
			wp_dropdown_categories( $args );
			?>
		</p>
	</div>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'number_post' ) ); ?>"><?php esc_html_e( 'Number of posts', 'simple-days' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_post' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo absint( $settings['number_post'] ); ?>" />
	</p>

	<p>
		<input type="checkbox" <?php checked( $settings['date'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" />
		<label for="<?php echo $this->get_field_id('date'); ?>"><?php esc_html_e( 'Display date', 'simple-days' ); ?></label>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'heading_image_size' ) ); ?>">
			<?php esc_html_e( 'Original size of heading thumbnail', 'simple-days' ); ?>
		</label><br />
		<select id="<?php echo esc_attr( $this->get_field_id( 'heading_image_size' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading_image_size' )); ?>">
			<?php
			$image_size = array(
				'thumbnail' => esc_html__( 'Thumbnail', 'simple-days' ),
				'medium' => esc_html__( 'Medium', 'simple-days' ),
				'large' => esc_html__( 'Large', 'simple-days' ),
				'full' => esc_html__( 'Full', 'simple-days' ),
			);
			foreach ($image_size as $key => $value) {
				echo '<option '. selected( $settings['heading_image_size'], $key ) .' value="'.esc_attr($key).'" >'.esc_html($value).'</option>';
			}
			?>
		</select>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>">
			<?php esc_html_e( 'Original size of thumbnail', 'simple-days' ); ?>
		</label><br />
		<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_size' )); ?>">
			<?php
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
	$instance['title_left'] = sanitize_text_field( $new_instance['title_left'] );
	$instance['category_left'] = (int) $new_instance['category_left'];
	$instance['title_right'] = sanitize_text_field( $new_instance['title_right'] );
	$instance['category_right'] = (int) $new_instance['category_right'];
	$instance['number_post'] = (int) $new_instance['number_post'];
	$instance[ 'random' ] = (bool)$new_instance[ 'random' ];
	$instance[ 'date' ] = (bool)$new_instance[ 'date' ];
	$instance['image_size'] = sanitize_text_field( $new_instance['image_size'] );
	$instance['heading_image_size'] = sanitize_text_field( $new_instance['heading_image_size'] );
	$instance[ 'sticky_posts' ] = (bool)$new_instance[ 'sticky_posts' ];
	$instance[ 'include_page' ] = (bool)$new_instance[ 'include_page' ];
	$instance[ 'to_main_content' ] = (bool)$new_instance[ 'to_main_content' ];

	return $instance;
}

} // class simple_days_custom_hp_two_categories_widget
