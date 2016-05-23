<?php
/**
 * Template Name: Contact Template
 *
 * Displays a contact form underneath the contact and sends mail
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
?>
<?php
	$alehouse_contact_name = '';
	$alehouse_contact_email = '';
	$alehouse_contact_message = '';
	$alehouse_contact_error = false;
	$alehouse_mail_sent = false;
	
	if ( isset( $_POST['contact-submitted'] ) ) {
	
		// sanitize post variables
		$alehouse_contact_name = sanitize_text_field( $_POST['contact-name'] );
		$alehouse_contact_email = sanitize_text_field( $_POST['contact-email'] );
		$alehouse_contact_message = sanitize_text_field( $_POST['contact-message'] );
		
		// check the name field and set error if empty
		if ( empty( $alehouse_contact_name ) ) {
			$alehouse_name_error = 'Please enter a name.';
			$alehouse_contact_error = true;
		}
		
		// check email field for empty and valid and set appropriate error
		if ( empty( $alehouse_contact_email ) ) {
			$alehouse_email_error = 'Please enter an email address';
			$alehouse_contact_error = true;
		} else {
			if ( ! is_email( $alehouse_contact_email ) ) {
				$alehouse_email_error = 'Please enter a valid email address';
				$alehouse_contact_error = true;
			} 
		}
		
		// check message
		if ( empty( $alehouse_contact_message ) ) {
			$alehouse_message_error = 'Please enter a message';
			$alehouse_contact_error = true;
		}
		
		// if there are no errors send our email
		if ( ! $alehouse_contact_error ) {
		
			$alehouse_to = get_theme_mod( 'alehouse_contact_to', get_option( 'admin_email' ) );
			$alehouse_subject = get_theme_mod( 'alehouse_contact_subject', 'Website Inquiry' );
			$alehouse_headers[] = 'From: ' . $alehouse_contact_name . ' <' . $alehouse_contact_email . '>';
			
			$alehouse_mail_sent = wp_mail( $alehouse_to, $alehouse_subject, $alehouse_contact_message, $alehouse_headers );
			
		}
	}
?>



<?php get_header(); ?>

	<div id="main" class="<?php echo alehouse_main_class(); ?>">
		
		<h1 class="page-title"><?php the_title(); ?></h1>
		
		<?php	while( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		
		<?php if ( $alehouse_mail_sent ) : ?>
			<p>Thanks, your email was sent successfully.</p>
		<?php else : ?>
		<form id="contact-form" action="<?php the_permalink(); ?>" method="post">
			<p class="contact-form-name">
				<label for="contact-name">Name</label>
				<?php if ( isset( $alehouse_name_error ) ) : ?>
						<span class="error"><?php echo $alehouse_name_error; ?></span>
					<?php endif; ?>
				<input type="text" name="contact-name" id="contact-name" value="<?php echo esc_attr( $alehouse_contact_name ); ?>">
				
			</p>
			<p class="contact-form-email">
				<label for="contact-email">Email</label>
				<?php if( isset( $alehouse_email_error ) ) : ?>
					<span class="error"><?php echo $alehouse_email_error; ?></span>
				<?php endif; ?>
				<input type="text" name="contact-email" id="contact-email" value="<?php echo esc_attr( $alehouse_contact_email ); ?>">
			</p>
			<p class="contact-form-message">
				<label for="contact-message">Message</label>
				<?php if ( isset( $alehouse_message_error ) ) : ?>
					<span class="error"><?php echo $alehouse_message_error; ?></span>
				<?php endif; ?>
				<textarea name="contact-message" id="contact-message"><?php echo esc_textarea( $alehouse_contact_message ); ?></textarea>
			</p>
			<p class="contact-form-submit">
				<input type="submit" name="contact-form-submit" id="contact-form-submit" value="SEND">
			</p>
			<input type="hidden" name="contact-submitted" value="true">
		</form>
		<?php endif; ?>
		
	</div><!-- #main -->
	
<?php
get_sidebar();
get_footer();