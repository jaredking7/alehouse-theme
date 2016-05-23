<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
?>
		<footer id="page-footer" class="clearfix transparent-bg">

			<?php
				$alehouse_facebook_url = get_theme_mod( 'alehouse_facebook_url' );
				$alehouse_twitter_url = get_theme_mod( 'alehouse_twitter_url' );
				$alehouse_google_plus_url = get_theme_mod( 'alehouse_google_plus_url' );
				$alehouse_pinterest_url = get_theme_mod( 'alehouse_pinterest_url' );
			?>
			
			<div id="footer-social">

				<?php if ( ! empty( $alehouse_facebook_url ) ) : ?>
				<a class="social-link facebook" href="<?php echo esc_url( $alehouse_facebook_url ); ?>">
					<i class="fa fa-facebook-square"></i>
				</a>
				<?php endif; ?>

				<?php if ( ! empty( $alehouse_twitter_url ) ) : ?>
					<a class="social-link twitter" href="<?php echo esc_url( $alehouse_twitter_url ); ?>">
					<i class="fa fa-twitter-square"></i>
				</a>
				<?php endif; ?>
				
				<?php if ( ! empty( $alehouse_google_plus_url ) ) : ?>
					<a class="social-link google-plus" href="<?php echo esc_url( $alehouse_google_plus_url ); ?>">
						<i class="fa fa-google-plus-square"></i>
					</a>
				<?php endif; ?>
				
				<?php if ( ! empty( $alehouse_pinterest_url ) ) : ?>
					<a class="social-link pinterest" href="<?php echo esc_url( $alehouse_pinterest_url ); ?>">
						<i class="fa fa-pinterest-square"></i>
					</a>
				<?php endif; ?>
				
			</div>
		
			<div id="footer-contact">
				<?php alehouse_contact(); ?>
			</div>
	
		</footer><!-- #page-footer -->
		
	</div><!-- #page -->
	
	<?php wp_footer(); ?>
	
</body>
</html>