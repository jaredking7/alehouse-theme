<?php
/**
 * Template for custom alehouse team member posts
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse
 */

get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
	
			<?php while ( have_posts() ) : the_post(); ?>
								
				<div class="alehouse-team-member">
					
					<?php
						// Get team member data
						$alehouse_team_member_position = get_post_meta( $post->ID, 'alehouse_team_member_position', true );
						$alehouse_team_member_email = get_post_meta( $post->ID, 'alehouse_team_member_email', true );
						$alehouse_team_member_about = get_post_meta( $post->ID, 'alehouse_team_member_about', true );
						
						// Team member photo
						if ( has_post_thumbnail() ) : ?>
							<div class="team-member-thumb">
								<?php the_post_thumbnail( 'alehouse-square-thumb' ); ?>
							</div>
					<?php endif; ?>
						<h1 class="team-member-name"><?php the_title(); ?></h1>
						
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
				
			<?php endwhile; ?>
		
		
		<?php comments_template(); ?>
		
	</div><!-- #main -->

<?php
get_sidebar();
get_footer();