<?php
/**
 * Template for tag archives
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */

get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
		<h1 class="page-title">Tag: <?php single_tag_title(); ?></h1>
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