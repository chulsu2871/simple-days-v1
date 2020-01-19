<?php
defined( 'ABSPATH' ) || exit;

delete_option('simple_days_external_cache');

delete_option('simple_days_theme_version');

$dir = WP_CONTENT_DIR.'/uploads/simple_days_cache/';
if ( file_exists($dir) ) {
  require_once ABSPATH . 'wp-admin/includes/file.php';
  global $wp_filesystem;
  if ( WP_Filesystem() ) {
    if ( $wp_filesystem->is_dir($dir) ) {
      $wp_filesystem->delete($dir,true);
    }
  }
}

$allposts = get_posts( 'numberposts=-1&post_type=any&post_status=any' );
$period_name = array('all','yearly','monthly','weekly','daily');
foreach( $allposts as $postinfo ) {
  delete_post_meta( $postinfo->ID, '_simple_days_popular_posts_count');
  delete_post_meta( $postinfo->ID, '_simple_days_popular_posts_period');
  foreach ($period_name as $key) {
   delete_post_meta( $postinfo->ID, '_simple_days_popular_posts_count_'.$key);
   delete_post_meta( $postinfo->ID, '_simple_days_popular_posts_period_'.$key);
 }
}
