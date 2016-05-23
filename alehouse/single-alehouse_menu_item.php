<?php
/**
 * Template for custom alehouse menu items
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse
 */

get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
					
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="alehouse-menu-item clearfix">
					<?php
					$alehouse_menu_item_description = get_post_meta( $post->ID, 'alehouse_menu_item_description', true );
					$alehouse_menu_item_price = get_post_meta( $post->ID, 'alehouse_menu_item_price', true );
					?>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" class="lightbox" title="<?php echo esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ); ?>">
							<?php the_post_thumbnail( 'alehouse-square-thumb' ); ?>
						</a>
					<?php endif; ?>
					
					<h1 class="alehouse-menu-item-title"><?php the_title(); ?></h1>
					
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