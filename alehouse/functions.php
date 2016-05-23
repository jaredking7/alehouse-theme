<?php
/**
 * Alehouse functions and defintions
 *
 * @package WordPress
 * @subpackage Alehouse
 * @since Ale House 1.0
 */

define( 'WP_DEBUG', true );

/**
 *
 * Setup our theme
 */
function alehouse_setup() {

	if ( ! isset( $content_width ) ) {
		$content_width = 600;
	}

	// Add RSS feed links to <head> for posts and comments
	add_theme_support( 'automatic-feed-links' );

	// Register the main menu for use by wp_nav_menu()
	register_nav_menu( 'main-menu', __( 'Navigation Menu', 'alehouse' ) );

	// Add featured image support
	add_theme_support( 'post-thumbnails' );

	// Add HTML5 support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
	) );

	// Add siebars for widgets
	add_action( 'widgets_init', 'alehouse_widgets_init' );

	// Image sizes
	add_image_size( 'alehouse-content-thumb', 600, 275, true );
	add_image_size( 'alehouse-slider', 900, 350, true );
	add_image_size( 'alehouse-gallery-thumb', 290, 210, true );
	add_image_size( 'alehouse-square-thumb', 420, 350, true );


	// Filter comment form fields
	add_filter( 'comment_form_default_fields','alehouse_remove_comment_fields' );

	// filter wp_title
	add_filter( 'wp_title', 'alehouse_title', 10, 3 );

	// filter widget tag cloud sizes and units
	add_filter( 'widget_tag_cloud_args', 'alehouse_tag_cloud_args' );

	// filter to the more link
	add_filter( 'the_content_more_link', 'alehouse_more_link' );

	// Enqueue styles and scripts
	add_action( 'wp_enqueue_scripts', 'alehouse_scripts_styles' );

	// Add theme style mods
	add_action( 'wp_enqueue_scripts', 'alehouse_theme_mods_styles' );

	// output the favicon
	add_action( 'wp_head', 'alehouse_favicon' );

	add_action( 'wp_head', 'alehouse_google_analytics' );

	// add shortcode support to widget text
	add_filter( 'widget_text', 'do_shortcode' );
	add_filter( 'widget_title', 'do_shortcode' );
	add_filter( 'term_description', 'do_shortcode' );

	// add customizer options
	add_action( 'customize_register', 'alehouse_theme_customizer' );

	// add the bundled plugins
	add_action( 'tgmpa_register', 'alehouse_register_required_plugins' );

	// override posts per page for custom post type alehouse_menu_items
	add_action( 'pre_get_posts', 'alehouse_menu_items_query', 1 );

	// Customize the login form
	add_filter( 'login_headertitle', 'alehouse_login_logo_title' );
	add_filter( 'login_headerurl', 'alehouse_login_url' );
	add_action( 'login_enqueue_scripts', 'alehouse_login_css' );
}

add_action( 'after_setup_theme', 'alehouse_setup' );

/**
 *	Register and enqueue css files and javascript files
 */
function alehouse_scripts_styles() {

	// Register styles
	wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', array(), '' );
	wp_register_style( 'alehouse-styles', get_stylesheet_uri(), array(), '' );
	wp_register_style( 'nivo-slider', get_template_directory_uri() . '/css/nivo-slider.css', array(), '' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '' );
	wp_register_style( 'default-font', '//fonts.googleapis.com/css?family=' . urlencode( 'Open Sans:400italic,400,700,800' ), array(), '' );
	wp_register_style( 'nivo-lightbox', get_template_directory_uri() . '/css/nivo-lightbox.css', array(), '1.1' );

	$style = get_theme_mod( 'alehouse_skin',  'dark' );
	wp_register_style( 'alehouse-skin', get_template_directory_uri() . '/css/' . $style . '.css', array(), '' );
	wp_register_style( 'alehouse-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '' );
	wp_register_style( 'alehouse-theme-mods-font', alehouse_theme_mods_font(), array(), '' );

	// Enqueue styles
	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'default-font' );
	wp_enqueue_style( 'font-awesome' );

	// Enqueue the theme font but don't enqueue Open Sans twice
	if ( 'Open Sans' !== get_theme_mod( 'alehouse_theme_font', 'Open Sans' ) ) {
		wp_enqueue_style( 'alehouse-theme-mods-font' );
	}

	// Only enqueue nivo slider when home page template is used
	if ( is_page_template( 'template-home.php' ) ) {
		wp_enqueue_style( 'nivo-slider' );
	}

	wp_enqueue_style( 'nivo-lightbox' );
	wp_enqueue_style( 'alehouse-styles' );

	// load responsive stylesheet if activated
	if ( 1 == get_theme_mod( 'alehouse_responsive_stylesheet', 1 ) ) {
		wp_enqueue_style( 'alehouse-responsive' );
	}

	wp_enqueue_style( 'alehouse-skin' );

	// Register scripts
	wp_register_script( 'backstretch', get_template_directory_uri() . '/js/backstretch.js', array( 'jquery'), '2.0.4', true );
	wp_register_script( 'nivo-slider', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array( 'jquery' ), '3.2', true );
	wp_register_script( 'alehouse-js', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.0', true );
	wp_register_script( 'nivo-lightbox', get_template_directory_uri() . '/js/nivo-lightbox.min.js', array( 'jquery' ), '1.1', true );

	// Enqueue scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'backstretch' );
	wp_localize_script( 'backstretch', 'alehouse_background', array( 'image' => get_theme_mod( 'alehouse_background_image', '' ) ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Only enqueue nivo slider when home page template is used
	if ( is_page_template( 'template-home.php' ) ) {

		wp_enqueue_script( 'nivo-slider' );

		// Get slider theme mods to make them available to our script
		$alehouse_slider_args = array(
			'effect' => get_theme_mod( 'alehouse_slider_effect', 'fold' ),
			'slices' => get_theme_mod( 'alehouse_slider_slices', 15 ),
			'boxCols' => get_theme_mod( 'alehouse_slider_box_columns', 8 ),
			'boxRows' => get_theme_mod( 'alehouse_slider_box_rows', 4 ),
			'animSpeed' => get_theme_mod( 'alehouse_slider_animation_speed', 500 ),
			'pauseTime' => get_theme_mod( 'alehouse_slider_pause_time', 5000 ),
		);

		wp_localize_script( 'nivo-slider', 'alehouse_slider', $alehouse_slider_args );
	}

	wp_enqueue_script( 'nivo-lightbox' );
	wp_enqueue_script( 'alehouse-js' );
}

// Widgets
require get_template_directory() . '/includes/widgets.php';

// Theme options
require get_template_directory() . '/includes/customizer.php';

/**
 * Display the meta for posts including date, categories, tags and comments
 */
function alehouse_entry_meta() {

	// Date
	echo '<div class="entry-date"><i class="fa fa-calendar"></i> ' . get_the_date() . '</div>';

	// Categories
	$categories = get_the_category_list( __( ', ', 'alehouse' ) );

	if ( $categories ) {
		echo '<div class="categories-links"><i class="fa fa-folder"></i> ' . $categories . '</div>';
	}

	// Tags
	$tags = get_the_tag_list( '<i class="fa fa-tag"></i> ', __( ', ', 'alehouse') );
	if ( $tags ) {
		echo '<div class="tags-links">' . $tags . '</div>';
	}

	// Comments
	if ( comments_open() ) :
		$comments_number = get_comments_number(); ?>
		<div class="comments-number">
			<i class="fa fa-comment"></i> <a href="<?php echo esc_url( comments_link() ); ?>"> <?php echo $comments_number; ?> </a>
		</div>
	<?php endif;
	edit_post_link( __( 'Edit', 'alehouse' ), '<div class="edit-link"><i class="fa fa-pencil"></i> ', '</div>' );
}

/**
 *	Callback for comments on the ale house theme
 */
function alehouse_html5_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta clearfix">
				<div class="comment-author vcard">
					<?php
						if ( 0 != $args['avatar_size'] ) {
							echo get_avatar( $comment, $args['avatar_size'] );
						}
					?>
					<b class="fn"><?php comment_author(); ?></b>

				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s', 'date', 'alehouse' ), get_comment_date() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'alehouse' ), '<span class="edit-link">| ', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'alehouse' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<div class="reply clearfix">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- .comment-body -->
<?php
}


/**
 * Filter to remove url from comment form
 */
function alehouse_remove_comment_fields( $fields ) {
	unset( $fields['url'] );
	return $fields;
}

/**
 * Display alehouse contact information provided by theme mods
 */
function alehouse_contact() {
	// Get and display contact information if it has been set
	$alehouse_phone = get_theme_mod( 'alehouse_contact_phone' );
	$alehouse_address = get_theme_mod( 'alehouse_contact_address' );
	$alehouse_address_url = get_theme_mod( 'alehouse_contact_google_maps_url' );

	// Phone number
	if ( ! empty( $alehouse_phone ) ) : ?>
		<div class="phone"><i class="fa fa-phone"></i> <?php echo esc_html( $alehouse_phone ); ?></div>
	<?php endif;

	// Address
	if ( ! empty( $alehouse_address ) ) :
		if ( ! empty( $alehouse_address_url ) ) : ?>
			<div class="address">
				<i class="fa fa-map-marker"></i> <a href="<?php echo esc_url( $alehouse_address_url ); ?>"><?php echo esc_html( $alehouse_address ); ?></a>
			</div>
		<?php else : ?>
			<div class="address"><i class="fa fa-map-marker"></i> <?php echo esc_html( $alehouse_address ); ?></div>
		<?php endif;  // end address url

	 endif; // end address
}

/**
 * Output the class for the #main div
 */
function alehouse_main_class() {

	$main_class = 'clearfix transparent-bg';
	$sidebar_position = get_theme_mod( 'alehouse_sidebar_position', 'right' );

	if ( 'right' == $sidebar_position ) {
		$main_class .= ' main-left';
	} else {
		$main_class .= ' main-right';
	}

	return $main_class;
}

/**
 * Output the favicon if one has been uploaded
 */
function alehouse_favicon() {

	$favicon = esc_url( get_theme_mod( 'alehouse_favicon', '' ) );

	if ( ! empty( $favicon ) ) {
		echo '<link rel="shortcut icon" href="' . $favicon . '">';
	}
}

/**
 *	Add custom styles set in theme mods
 */
function alehouse_theme_mods_styles() {

	$primary_color = get_theme_mod( 'alehouse_primary_color', '#0096ff' );
	$text_transform = get_theme_mod( 'alehouse_text_transform', 'uppercase' );
	$rounded_corners = get_theme_mod( 'alehouse_rounded_corners', '' );
	$custom_css = get_theme_mod( 'alehouse_custom_css', '' );
	$background_color = get_theme_mod( 'alehouse_background_color', '#000000' );
	$font = get_theme_mod( 'alehouse_theme_font', 'Open Sans' );

	$theme_mods_css = <<<CSS
		.bypostauthor > .comment-body {
			border-left-color: {$primary_color};
		}

		body {
			background-color: {$background_color};
		}

		.team-member-email a:hover,
		.entry-meta a:hover,
		h1 a:hover,
		h2 a:hover,
		h3 a:hover,
		h4 a:hover,
		h5 a:hover,
		h6 a:hover,
		.address a:hover,
		a {
			color: {$primary_color};
		}

		.entry-title,
		.widget-title {
			border-bottom: 2px solid {$primary_color};
		}

		.highlight,
		.button,
		.paging-navigation .page-numbers:hover,
		.paging-navigation .current,
		#main-menu .menu-item > a:hover,
		.nivo-caption,
		.nivo-directionNav .nivo-prevNav:hover,
		.nivo-directionNav .nivo-nextNav:hover,
		.alehouse-gallery-item:hover,
		.search-submit,
		.tagcloud a:hover,
		#main-menu .current-menu-item > a,
		.more-link,
		.comment-reply-link,
		#submit,
		#contact-form-submit,
		.nivo-directionNav .nivo-prevNav:hover,
		.nivo-directionNav .nivo-nextNav:hover,
		.nivo-caption {
			background: {$primary_color};
		}

		.comment-reply-link,
		#contact-form-submit,
		#main-menu .menu-item a,
		.single .entry-title,
		.nivo-caption,
		.widget_calendar table caption,
		.comments-link,
		.more-link,
		.widget-title,
		.page-title {
			font-family: '{$font}', 'Helvetica Neue', helvetica, sans-serif;
			text-transform: {$text_transform};
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: '{$font}', 'Helvetica Neue', helvetica, sans-serif;
		}
CSS;

	if ( $rounded_corners == 1 ) {
		$theme_mods_css .= <<<CSS
			#slider-wrapper,
			#main,
			.sidebar .widget,
			#page-footer {
				-webkit-border-radius: 4px 4px 4px 4px;
				border-radius: 4px 4px 4px 4px;
			}
CSS;
	}

	if ( ! empty( $custom_css ) ) {
		$theme_mods_css .= $custom_css;
	}

	wp_add_inline_style( 'alehouse-skin', $theme_mods_css );
}

/**
 *	print out the images for the slider
 *
 * @param int $id the post id
 * @param str $size the size of the thumbnail
 */
function alehouse_slider( $id, $size ) {

	$args = array(
		'type' => 'image',
		'size' => $size,
	);

	$attachments = rwmb_meta( 'alehouse_slider_upload', $args, $id  );

	if ( $attachments ) : ?>
		<div id="slider-wrapper" class="transparent-bg">
			<div class="loading-spinner">
				<i class="fa fa-spin fa-spinner"></i>
			</div>
			<div id="slider" class="nivoSlider">
				<?php foreach ( $attachments as $attachment ) :
					$attr = array(
						'title' => $attachment['caption'],
					);
					echo wp_get_attachment_image( $attachment['ID'], $size, false, $attr );
					?>
				<?php endforeach; ?>
			</div><!-- #slider -->
		</div><!-- #slider-wrapper -->
	<?php endif;
}

/**
 * Filter for alehouse titles
 */
function alehouse_title( $title, $separator, $separator_location ) {

	global $wpdb, $wp_locale;

	// taxonomy
	if ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	// front page
	if ( is_front_page() ) {
		$title = get_option( 'blogname' ) . $separator .  get_option( 'blogdescription' );
	}

	return $title;
}

/**
 * Retrive logo from our theme mods and if it exists output the logo
 */
function alehouse_logo() {

	// Get and display logo if it has been set
	$logo_url = get_theme_mod( 'alehouse_logo', '' );

	if ( ! empty( $logo_url ) ) :

		// Get the image width and height
		list( $width, $height ) = getimagesize( $logo_url );
		$image_hwstring = image_hwstring( $width, $height );
		?>
		<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_option( 'blogname' ) ); ?>" <?php echo $image_hwstring; ?>>
		</a>
	<?php endif;
}

/**
 * Make the tag cloud sizes uniform and change the unit to pixels
 */
function alehouse_tag_cloud_args() {

	$args = array(
		'unit' => 'px',
		'smallest' => '14',
		'largest' => '14',
	);

	return $args;
}

/**
 * Filter to prevent page scroll on read more lnks
 */
function alehouse_more_link( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	$link = '<span class="more-link-wrapper">' . $link . '</span>';
	return $link;
}

/**
 * Display navigation to next/previous set of posts when applicable.
 */
function alehouse_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&lt; Previous', 'alehouse' ),
		'next_text' => __( 'Next &gt;', 'alehouse' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}

/**
 * For paginated post and page content
 */
function alehouse_link_pages() {

	$args = array(
		'before' => '<nav class="navigation paging-navigation" role="navigation"><div class="pagination loop-pagination">Pages:',
		'after' => '</div><!-- .pagination --></nav><!-- .navigation -->',
		'link_before' => '<span class="page-numbers">',
		'link_after' => '</span>',
	);

	wp_link_pages( $args );
}

// TMG Plugin activation
require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 */
function alehouse_register_required_plugins() {

	$plugins = array(
		array(
			'name' => 'Alehouse Addons',
			'slug' => 'alehouse-addons',
			'source' => get_stylesheet_directory() . '/plugins/alehouse-addons-plugin.zip',
			'required' => true,
			'version' => '',
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => '',
		),
	);

	$config = array(
		'domain' => 'alehouse',
		'default_path' => '',
		'parent_menu_slug' => 'themes.php',
		'parent_url_slug' => 'themes.php',
		'menu' => 'install-required-plugins',
		'has_notices' => true,
		'is_automatic' => true,
		'message' => '',
		'strings' => array(
			'page_title' => __( 'Install Required Plugins', 'alehouse' ),
			'menu_title' => __( 'Install Plugins', 'alehouse' ),
			'installing' => __( 'Installing Plugin: %s', 'alehouse' ), // %1$s = plugin name
			'oops' => __( 'Something went wrong with the plugin API.', 'alehouse' ),
			'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required' => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return' => __( 'Return to Required Plugins Installer', 'alehouse' ),
			'plugin_activated' => __( 'Plugin activated successfully.', 'alehouse' ),
			'complete' => __( 'All plugins installed and activated successfully. %s', 'alehouse' ), // %1$s = dashboard link
			'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}

/**
 *	change the login logo
 */
function alehouse_login_css() {

	$logo_url = get_theme_mod( 'alehouse_logo', '' );
	$skin = get_theme_mod( 'alehouse_skin', 'dark' );

	?>
	<style type="text/css">
		<?php if ( ! empty( $logo_url ) ) : ?>
			.login h1 a {
				background-image: url( '<?php echo $logo_url; ?>' );
				background-size: contain;
				width: auto;
			}

		<?php endif; ?>

		<?php if ( 'dark' == $skin ) : ?>
			body.login {
				background-color: #131415;
			}

			.login label,
			.login .message {
				color: #f2f2f2;
			}

			.login .message,
			.login form {
				background: #2e3133;
			}
		<?php endif; ?>
	</style>
	<?php
}

/**
 * Change the login url
 */
function alehouse_login_url() {
	return get_home_url();
}

/**
 * change title attribute on logo h1 a
 */
function alehouse_login_logo_title() {
	return get_option( 'blogname' ) . ' ' . get_option( 'blogdescription' );
}

/**
 * add google analytics to the head of the document
 */
function alehouse_google_analytics() {
	$script = get_theme_mod( 'alehouse_google_analytics', '' );

	if ( ! empty( $script ) ) {
		echo $script;
	}
}

/**
 * Override posts per page setting for our menu item category pages
 */
function alehouse_menu_items_query( $query ) {

    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_tax( 'alehouse_menu_item_category' ) ) {
        $query->set( 'posts_per_page', -1 );
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
        return;
    }
}

/**
 * Build a font url from the theme mods selected font
 */
function alehouse_theme_mods_font() {

	$font= get_theme_mod( 'alehouse_theme_font', 'Open Sans' );
	$font_url = add_query_arg( 'family', urlencode( $font . ':400,400italic,700,800' ), "//fonts.googleapis.com/css" );

	return $font_url;
}