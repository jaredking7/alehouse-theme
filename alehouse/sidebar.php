<?php
/**
 * Display the sidebar for the site if it has widgets
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
?>
<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
	<div class="sidebar widget-area" id="main-sidebar">
		<?php dynamic_sidebar( 'main-sidebar' );	 ?>
	</div>
<?php endif;