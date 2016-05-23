<?php
/**
 * The default template for displaying all pages
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
 ?>
<?php get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
	
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php	while( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		
	</div><!-- #main -->
	
	<?php 
get_sidebar();
get_footer();