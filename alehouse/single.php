<?php
/**
 * The template for single posts
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */

get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
	
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php comments_template(); ?>
		
	</div><!-- #main -->

<?php
get_sidebar();
get_footer();