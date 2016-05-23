<?php
/**
 * Template for custom alehouse gallery posts
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse
 */

get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
		<h1 class="page-title"><?php the_title(); ?></h1>
		
		<div class="alehouse-gallery clearfix">
			
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'alehouse_gallery' ); ?>
			<?php endwhile; ?>
		
		</div><!-- .alehouse-gallery -->
		
		<?php comments_template(); ?>
		
	</div><!-- #main -->

<?php
get_sidebar();
get_footer();