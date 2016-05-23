<?php
/**
 * The template for displaying Author archive pages
 *
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */

get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
		<h1 class="page-title">Author: <?php the_title( '' ); ?></h1>
		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php alehouse_paging_nav(); ?>
			
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #main -->

<?php
get_sidebar();
get_footer();