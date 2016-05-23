<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehousen 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>
		

			<div class="entry-meta clearfix">
				<?php alehouse_entry_meta(); ?>
			</div><!-- .entry-meta -->

	</header>
	
	
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail( 'alehouse-content-thumb' ); ?>
		</div>
	<?php endif; ?>
	
	<div class="entry-content">
		<?php 
			if ( ! is_search() ) {
				the_content( 'Read More' );
				alehouse_link_pages();
			} else {
				the_excerpt(); 
			}
		?>
	</div>
	
</article>
