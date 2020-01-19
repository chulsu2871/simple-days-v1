<?php
  defined( 'ABSPATH' ) || exit;
/**
 * SideBar Settings
 *
 * @package Simple Days
 */

  // Add Settings and Controls for Layout.
    $wp_customize->add_setting( 'simple_days_sidebar_layout', array(
      'default'           => '3',
      'sanitize_callback' => 'sanitize_key',
      //'transport'=>'postMessage',
    ) );
    $wp_customize->add_control( new Simple_Days_Image_Select_Control( $wp_customize, 'simple_days_sidebar_layout', array(
      'label'       => esc_html__( 'Sidebar Layout', 'simple-days' ),
      'section'     => 'simple_days_sidebar_setting',
      'choices'     => array(
        '1' => array(
          'label' => esc_html__( 'Left Sidebar', 'simple-days' ),
          'url'   => '%ssidebar_left.png'
        ),
        '3'    => array(
          'label' => esc_html__( 'Right Sidebar', 'simple-days' ),
          'url'   => '%ssidebar_right.png'
        ),
        '0'    => array(
          'label' => esc_html__( 'No Sidebar', 'simple-days' ),
          'url'   => '%ssidebar_no.png'
        ),
      ),
    )));

    $wp_customize->add_setting( 'simple_days_one_column_post', array(
      'default'           => '',
      'sanitize_callback' => 'sanitize_text_field',
    )
  );
    $wp_customize->add_control( 'simple_days_one_column_post', array(
      'label'    => esc_html__( 'to be single column when you type post id.', 'simple-days' ),
      'description' => esc_html__('Multiple id must be seperated by a comma.', 'simple-days'),
      'section'  => 'simple_days_sidebar_setting',
      'type'    => 'text',
    )
  );
