<?php
/**
 * Template Name: Home Template
 *
 * Template for our home page includes a full width slider
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
?>

<?php get_header(); ?>

	<?php 
	$alehouse_slider_id = get_theme_mod( 'alehouse_slider_select', '' );
		if ( ! empty( $alehouse_slider_id ) ) {
			alehouse_slider( $alehouse_slider_id, 'alehouse-slider' ); 
		}
	?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">

		<?php	while( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		
	</div><!-- #main -->
	
<?php
get_sidebar();
get_footer();