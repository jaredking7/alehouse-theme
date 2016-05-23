<?php
/**
 * Template Name: Gallery Template
 *
 * Display a list of gallery posts
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
		
		<div class="alehouse-gallery">
			<?php 
				/**
				 * Setup the args to find all gallery posts sorted by date and retrieve them
				 */
				$alehouse_gallery_args = array(
					'numberposts' => -1,
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'post_type' => 'alehouse_gallery',
					'post_status' => 'publish',
				);
				
				$alehouse_gallery_posts = get_posts( $alehouse_gallery_args );
				
				/**
				 *	Loop through the gallery posts and display them
				 */
				foreach( $alehouse_gallery_posts as $post ) : 
					setup_postdata( $post ); ?>
					
					<div class="alehouse-gallery-item">
						<a href="<?php the_permalink(); ?>">
						<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'alehouse-gallery-thumb' );
							}
						?>
							<h2 class="alehouse-gallery-title"><?php the_title(); ?></h2>
						</a>
						
					</div>
				<?php endforeach;
			
				wp_reset_postdata();
			?>
		</div><!-- .alehouse-gallery -->
	</div><!-- #main -->
	
<?php
get_sidebar();
get_footer();