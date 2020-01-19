<?php
defined( 'ABSPATH' ) || exit;
?>
<div id="sidebar" class="sidebar f_box f_col101 f_wrap jc_sa">
	<?php dynamic_sidebar( 'sidebar-1' );
	if( is_active_sidebar( 'sidebar-fixed' ) ) {
		echo '<div class="fix_sidebar">';
		dynamic_sidebar( 'sidebar-fixed' );
		echo '</div>';
	}
	?>
</div>

