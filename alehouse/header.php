<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php wp_title( ' ' ); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<div id="header-wrapper">
		<header id="page-header" class="clearfix">
			<?php alehouse_logo(); ?>
			
			<div id="header-contact">
				<?php alehouse_contact(); ?>				
			</div>
			
		</header><!-- #page-header -->
	</div><!-- #header-wrapper -->
	<div id="page" class="clearfix">
		<div id="mobile-menu-button" class="transparent-bg">
			<i class="fa fa-bars"></i> Navigation
		</div>
		<?php
		$alehouse_menu_args = array(
			'container' => 'nav',
			'container_id' => 'main-menu',
			'container_class' => 'clearfix transparent-bg',
			'theme_location' => 'main-menu',
		);
		
		wp_nav_menu( $alehouse_menu_args );
		?>