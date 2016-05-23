<?php
/**
 * Template for display alehouse custom menu item categories
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
?>
<?php get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
		<h1 class="page-title"><?php single_cat_title(); ?></h1>

		<?php echo category_description(); ?>
		
		<?php	while( have_posts() ) : the_post(); ?>
			<?php
				$alehouse_menu_item_description = get_post_meta( $post->ID, 'alehouse_menu_item_description', true );
				$alehouse_menu_item_price = get_post_meta( $post->ID, 'alehouse_menu_item_price', true );
			?>
			<div class="alehouse-menu-item clearfix">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" class="lightbox" title="<?php echo esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ); ?>">
						<?php the_post_thumbnail( 'alehouse-square-thumb' ); ?>
					</a>
				<?php endif; ?>
				
				<h2 class="alehouse-menu-item-title"><?php the_title(); ?></h2>
				
				<?php if ( ! empty( $alehouse_menu_item_description ) ) : ?>
					<p class="alehouse-menu-item-description"><?php echo $alehouse_menu_item_description; ?></p>
				<?php endif; ?>
				
				<?php if ( ! empty( $alehouse_menu_item_price ) ) : ?>
					<div class="alehouse-menu-item-price"><?php echo $alehouse_menu_item_price; ?></div>
				<?php endif; ?>
			</div>
		
		<?php endwhile; ?>
		
	</div><!-- #main -->
	
	<?php
get_sidebar();
get_footer();