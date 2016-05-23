<?php
/**
 * The template for displaying content for galleries
 *
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Alehouse 1.0
 */
?>
<?php
	/**
	 *	Get all the image attachments for the gallery post
	 */
	$alehouse_args = array(
			'type' => 'image',
			'size' => 'full',
		);
	
	$alehouse_attachments = rwmb_meta( 'alehouse_gallery_upload', $alehouse_args, $post->ID );
	
	/**
	 * Display the gallery images with lightbox links
	 */
	if( $alehouse_attachments ) :
		foreach ( $alehouse_attachments as $alehouse_attachment ) : ?>
			<div	class="alehouse-gallery-item clearfix">
				<a class="lightbox" href="<?php echo $alehouse_attachment['url']; ?>" title="<?php echo $alehouse_attachment['caption']; ?>" data-lightbox-gallery="gallery">
					<?php echo wp_get_attachment_image( $alehouse_attachment['ID'], 'alehouse-gallery-thumb' ); ?>
				</a>
			</div>
		<?php endforeach;
	endif;