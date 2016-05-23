<?php
/**
 * Template Name: Team Template
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

		<?php 
			/**
			 * Setup the args to find all gallery posts sorted by date and retrieve them
			 */
			$alehouse_team_args = array(
				'numberposts' => -1,
				'order' => 'ASC',
				'orderby' => 'menu_order',
				'post_type' => 'alehouse_team_member',
				'post_status' => 'publish',
			);
			
			$alehouse_team_members = get_posts( $alehouse_team_args );
			
			/**
			 *	Loop through the gallery posts and display them
			 */
			foreach( $alehouse_team_members as $post ) : 
				setup_postdata( $post ); 
				
				// Get team member data
				$alehouse_team_member_position = get_post_meta( $post->ID, 'alehouse_team_member_position', true );
				$alehouse_team_member_email = get_post_meta( $post->ID, 'alehouse_team_member_email', true );
				$alehouse_team_member_about = get_post_meta( $post->ID, 'alehouse_team_member_about', true );
				?>
				
				<div class="alehouse-team-member">
					
					<?php
						// Team member photo
						if ( has_post_thumbnail() ) : ?>
							<div class="team-member-thumb">
								<?php the_post_thumbnail( 'alehouse-square-thumb' ); ?>
							</div>
					<?php endif; ?>
						<h2 class="team-member-name"><?php the_title(); ?></h2>
						
						<?php if ( ! empty( $alehouse_team_member_position ) ) : ?>
							<div class="team-member-position"><i class="fa fa-user"></i> <?php echo $alehouse_team_member_position; ?></div>
						<?php endif; ?>
						
						<?php if ( ! empty( $alehouse_team_member_email ) ) : ?>
							<div class="team-member-email">
								<i class="fa fa-envelope"></i> <a href="mailto:<?php echo antispambot( $alehouse_team_member_email, 1 ); ?>"><?php echo antispambot( $alehouse_team_member_email ); ?></a>
							</div>
						<?php endif; ?>
						
						<div class="clear"></div>
						
						<?php if ( ! empty( $alehouse_team_member_about ) ) : ?>
							<div class="team-member-about">
								<?php echo $alehouse_team_member_about; ?>
							</div>
						<?php endif; ?>
				</div>
			<?php endforeach;
		
			wp_reset_postdata();
		?>
	</div><!-- #main -->
	
	<?php get_sidebar(); ?>
	
<?php get_footer();