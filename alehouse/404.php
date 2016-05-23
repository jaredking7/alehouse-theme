<?php
/**
 * Template to display 404 errors
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
 
get_header();
?>
	<div id="main" class="<?php echo alehouse_main_class(); ?>">
		
		<h1>404 Error - Page Not Found</h1>
		<p><?php echo esc_html( get_theme_mod( 'alehouse_404_text', 'The requested page cannot be found' ) ); ?></p>
		
	</div><!-- #main -->
	
<?php
get_sidebar(); 
get_footer();