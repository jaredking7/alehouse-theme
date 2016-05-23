<?php
/**
 * Add theme options to the wp theme customizer
 */
function alehouse_theme_customizer( $wp_customize ) {

	/**
	 * add a textarea control for our customizer options panel
	 */
	class Alehouse_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}


	// Images Settings section
	$wp_customize->add_section( 'alehouse_images', array(
		'title' => 'Images',
		'description' => 'Customize the background image, logo, and favicion',
	) );

	// Logo
	$wp_customize->add_setting( 'alehouse_logo', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'alehouse_logo',
			array(
				'label' => 'Logo',
				'section' => 'alehouse_images',
			)
		)
	);

	// Background image
	$wp_customize->add_setting( 'alehouse_background_image', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'alehouse_background_image',
			array(
				'label' => 'Background Image',
				'section' => 'alehouse_images',
			)
		)
	);

	// Favicon
	$wp_customize->add_setting( 'alehouse_favicon', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'alehouse_favicon',
			array(
				'label' => 'Favicon',
				'section' => 'alehouse_images',
			)
		)
	);

	// General section
	$wp_customize->add_section( 'alehouse_general', array(
		'title' => 'General',
		'description' => 'Change 404 text, add custom css or add google analytics snippet',
	) );

	// 404 text
	$wp_customize->add_setting( 'alehouse_404_text', array(
		'default' => 'The requested page cannot be found.',
	) );

	$wp_customize->add_control( 'alehouse_404_text' , array(
		'section' => 'alehouse_general',
		'label' => '404 Page Text',
		'type' => 'text'
	) );

	// Custom CSS
	$wp_customize->add_setting( 'alehouse_custom_css', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control(
		new Alehouse_Customize_Textarea_Control(
			$wp_customize,
			'alehouse_custom_css',
			array(
				'label' => 'Custom CSS',
				'section' => 'alehouse_general',
				'type' => 'textarea',
			)
		)
	);

	// Custom JS
	$wp_customize->add_setting( 'alehouse_google_analytics', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new Alehouse_Customize_Textarea_Control(
			$wp_customize,
			'alehouse_google_analytics',
			array(
				'label' => 'Google Analytics',
				'section' => 'alehouse_general',
				'type' => 'textarea',
			)
		)
	);

	// Style section
	$wp_customize->add_section( 'alehouse_style', array(
		'title' => 'Style',
		'description' => 'Change theme colors, skin, sidebar position and other appearance related settings',
	) );

	// Primary Color
	$wp_customize->add_setting( 'alehouse_primary_color', array(
		'default' => '#0096ff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'alehouse_primary_color',
			array(
				'label' => 'Primary Color',
				'section' => 'alehouse_style',
			)
		)
	);

	// Background Color
	$wp_customize->add_setting( 'alehouse_background_color', array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'alehouse_background_color',
			array(
				'label' => 'Background Color',
				'section' => 'alehouse_style',
			)
		)
	);

	// Skin color scheme
	$wp_customize->add_setting( 'alehouse_skin', array(
		'default' => 'dark',
		'sanitize_callback' => 'alehouse_sanitize_choices',
	) );

	$wp_customize->add_control( 'alehouse_skin',array(
		'label' => 'Skin',
		'section' => 'alehouse_style',
		'type' => 'radio',
		'choices' => array(
			'dark' => 'Dark',
			'light' => 'Light',
		),
	) );

	// Sidebar Position
	$wp_customize->add_setting( 'alehouse_sidebar_position', array(
		'default' => 'right',
		'sanitize_callback' => 'alehouse_sanitize_choices',
	) );

	$wp_customize->add_control( 'alehouse_sidebar_position', array(
		'label' => 'Sidebar Position',
		'section' => 'alehouse_style',
		'type' => 'radio',
		'choices' => array(
			'right' => 'Right',
			'left' => 'Left'
		),
	) );

	// Rounded corners
	$wp_customize->add_setting( 'alehouse_rounded_corners', array(
		'default' => '',
		'sanitize_callback' => 'alehouse_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'alehouse_rounded_corners', array(
		'label' => 'Rounded Corners',
		'section' => 'alehouse_style',
		'type' => 'checkbox',
	) );

	// Rounded corners
	$wp_customize->add_setting( 'alehouse_responsive_stylesheet', array(
		'default' => 1,
		'sanitize_callback' => 'alehouse_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'alehouse_responsive_stylesheet', array(
		'label' => 'Load Responsive Stylesheet',
		'section' => 'alehouse_style',
		'type' => 'checkbox',
	) );

	// Social Settings
	$wp_customize->add_section( 'alehouse_social',array(
		'title' => 'Social',
		'description' => 'Add URLs for your social profiles',
	) );

	//Facebook
	$wp_customize->add_setting( 'alehouse_facebook_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'alehouse_facebook_url', array(
		'section' => 'alehouse_social',
		'label' => 'Facebook URL',
		'type' => 'text',
	) );

	//Twitter
	$wp_customize->add_setting( 'alehouse_twitter_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'alehouse_twitter_url', array(
		'section' => 'alehouse_social',
		'label' => 'Twitter URL',
		'type' => 'text',
	) );

	// Google Plus
	$wp_customize->add_setting( 'alehouse_google_plus_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'alehouse_google_plus_url', array(
		'section' => 'alehouse_social',
		'label' => 'Google+ URL',
		'type' => 'text',
	) );

	// Pinterest
	$wp_customize->add_setting( 'alehouse_pinterest_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'alehouse_pinterest_url', array(
		'section' => 'alehouse_social',
		'label' => 'Pinterest URL',
		'type' => 'text',
	) );

	// Slider settings
	$wp_customize->add_section( 'alehouse_slider', array(
		'title' => 'Slider',
		'description' => 'Customize slider options.  Slide Animation Speed and Slide Pause Time are in milliseconds.  Slices only applies to slice animations.  Box Columns and Box Rows only apply to box animations.',
	) );

	// Select Slider
	$wp_customize->add_setting( 'alehouse_slider_select', array(
		'default' => '',
		'sanitize_callback' => 'alehouse_sanitize_choices',
	) );

	$wp_customize->add_control( 'alehouse_slider_select', array(
		'section' => 'alehouse_slider',
		'label' => 'Set Slider',
		'type' => 'select',
		'choices' => alehouse_get_slider_choices(),
	) );

	// Slider effect
	$wp_customize->add_setting( 'alehouse_slider_effect', array(
		'default' => 'fold',
		'sanitize_callback' => 'alehouse_sanitize_choices',
	) );

	$wp_customize->add_control( 'alehouse_slider_effect', array(
		'section' => 'alehouse_slider',
		'label' => 'Effect',
		'type' => 'select',
		'choices' => array(
			'fold' => 'Fold',
			'fade' => 'Fade',
			'slideInLeft' => 'Slide In Left',
			'slideInRight' => 'Slide In Right',
			'sliceUp' => 'Slice Up',
			'sliceUpLeft' => 'Slice Up Left',
			'sliceDown' => 'Slice Down',
			'sliceDownLeft' => 'Slice Down Left',
			'sliceUpDown' => 'Slice Up Down',
			'sliceUpDownLeft' => 'Slice Up Down Left',
			'random' =>'Random',
			'boxRandom' => 'Box Random',
			'boxRain' => 'Box Rain',
			'boxRainReverse' => 'Box Rain Reverse',
			'boxRainGrow' => 'Box Rain Grow',
			'boxRainGrowReverse' => 'Box Rain Grow Reverse',
		),
	) );

	// Slider animation speed
	$wp_customize->add_setting( 'alehouse_slider_animation_speed', array(
		'default' => 500,
		'sanitize_callback' => 'alehouse_sanitize_integer',
	) );

	$wp_customize->add_control( 'alehouse_slider_animation_speed', array(
		'section' => 'alehouse_slider',
		'label' => 'Slide Animation Speed',
		'description' => 'testing description',
		'type' => 'text',
	) );

	// Slider pause time
	$wp_customize->add_setting( 'alehouse_slider_pause_time', array(
		'default' => 5000,
		'sanitize_callback' => 'alehouse_sanitize_integer',
	) );

	$wp_customize->add_control( 'alehouse_slider_pause_time', array(
		'section' => 'alehouse_slider',
		'label' => 'Slide Pause Time',
		'type' => 'text',
	) );

	// Slider slices
	$wp_customize->add_setting( 'alehouse_slider_slices', array(
		'default' => 15,
		'sanitize_callback' => 'alehouse_sanitize_integer',
	) );

	$wp_customize->add_control( 'alehouse_slider_slices', array(
		'section' => 'alehouse_slider',
		'label' => 'Slices',
		'type' => 'text',
	) );

	// Slider box columns
	$wp_customize->add_setting( 'alehouse_slider_box_columns', array(
		'default' => 8,
		'sanitize_callback' => 'alehouse_sanitize_integer',
	) );

	$wp_customize->add_control( 'alehouse_slider_box_columns', array (
		'section' => 'alehouse_slider',
		'label' => 'Box Columns',
		'type' => 'text',
	) );

	// Slider box rows
	$wp_customize->add_setting( 'alehouse_slider_box_rows', array(
		'default' => 4,
		'sanitize_callback' => 'alehouse_sanitize_integer',
	) );

	$wp_customize->add_control( 'alehouse_slider_box_rows', array(
		'label' => 'Box Rows',
		'section' => 'alehouse_slider',
		'type' => 'text',
	) );

	// Contact section
	$wp_customize->add_section( 'alehouse_contact', array(
		'title' => 'Contact',
		'description' => 'Setup contact form and contact information in the header and the footer.',
	) );

	// Contact to address
	$wp_customize->add_setting( 'alehouse_contact_to_address', array(
		'default' => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
	) );

	$wp_customize->add_control( 'alehouse_contact_to_address', array(
		'label' => 'Receiving Email Address',
		'section' => 'alehouse_contact',
		'type' => 'text',
	) );

	// Contact subject
	$wp_customize->add_setting( 'alehouse_contact_subject', array(
		'default' => 'Website Inquiry',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'alehouse_contact_subject', array(
		'label' => 'Subject',
		'section' => 'alehouse_contact',
		'type' => 'text',
	) );

	// Address
	$wp_customize->add_setting( 'alehouse_contact_address', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'alehouse_contact_address', array(
		'label' => 'Address',
		'section' => 'alehouse_contact',
		'type' => 'text',
	) );

	// Phone number
	$wp_customize->add_setting( 'alehouse_contact_phone', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'alehouse_contact_phone', array(
		'label' => 'Phone Number',
		'section' => 'alehouse_contact',
		'type' => 'text',
	) );

	// Google maps URL
	$wp_customize->add_setting( 'alehouse_contact_google_maps_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'alehouse_contact_google_maps_url', array(
		'label' => 'Google Maps URL',
		'section' => 'alehouse_contact',
		'type' => 'text',
	) );

	// Typography section
	$wp_customize->add_section( 'alehouse_typography', array(
		'title' => 'Typography',
		'description' => 'Change the font settings for titles, buttons, and menu items.',
	) );

	// Font family
	$wp_customize->add_setting( 'alehouse_theme_font', array(
		'default' => 'Open Sans',
		'sanitize_callback' => 'alehouse_sanitize_choices',
	) );

	$wp_customize->add_control( 'alehouse_theme_font', array(
		'label' => 'Theme Fonts',
		'section' => 'alehouse_typography',
		'type' => 'select',
		'choices' => array(
			'Abril Fatface' => 'Abril Fatface',
			'Advent Pro' => 'Advent Pro',
			'Bitter' => 'Bitter',
			'Bree Serif' => 'Bree Serif',
			'Droid Serif'=> 'Droid Serif',
			'Josefin Slab' => 'Josefin Slab',
			'Lato' => 'Lato',
			'Lobster' => 'Lobster',
			'Montserrat' => 'Montserrat',
			'Open Sans' => 'Open Sans',
			'PT Mono' => 'PT Mono',
			'Ubuntu' => 'Ubuntu',
		),
	) );

	// Text transform
	$wp_customize->add_setting( 'alehouse_text_transform', array(
		'default' => 'uppercase',
		'sanitize_callback' => 'alehouse_sanitize_choices',
	) );

	$wp_customize->add_control( 'alehouse_text_transform', array(
		'label' => 'Text Transform',
		'section' => 'shiny-section',
		'type' => 'select',
		'choices' => array(
			'uppercase' => 'Uppercase',
			'lowercase' => 'Lowercase',
			'capitalize' => 'Capitalize',
			'none' => 'None',
		),
	) );
}

/**
 * Callback for validating integer values
 *
 * Returns a sanitized integer or the setting default when an non integer is given
 */
function alehouse_sanitize_integer( $input, $setting ) {

	if ( intval( $input ) ) {
		return absint( $input );
	} else {
		return $setting->default;
	}

}

/**
 * Callback for sanitizing checkboxes
 *
 * Returns 1 on checked and a blank string on unchecked
 *
 * @param string $input The input to be checked
 * @return string The sanitized input
 */
function alehouse_sanitize_checkbox( $input ) {

	if ( $input == 1 ) {
		return $input;
	} else {
		return '';
	}

}

/**
 * Santize callback for select controls
 *
 * Grabs the choices from the control to be used in a validation check
 * Returns default if input is not valid
 *
 * @param string $input The input control to be sanitized
 * @param object $setting The setting associated with the input control
 */
function alehouse_sanitize_choices( $input, $setting ) {

	global $wp_customize;

	$control = $wp_customize->get_control( $setting->id );

	if ( array_key_exists( $input, $control->choices ) ) {
		return $input;
	} else {
		return $setting->default;
	}

}

/**
 *	Build an array of choices from slider custom post types
 */
function alehouse_get_slider_choices() {

	// Set the default choice
	$choices = array(
		'' => 'Select slider',
	);

	// Get all slider posts if there is any
	$args = array(
		'post_type' => 'alehouse_slider',
		'post_status' => 'publish',
	);

	$sliders = get_posts( $args );
	if ( $sliders ) {
		foreach ( $sliders as $slider ) {
			$choices[ $slider->ID ] = $slider->post_title;
		}
	}

	return $choices;
}


function forgoodmeasure_customize_register( $wp_customize ) {

	// add a panel
	$wp_customize->add_panel( 'shiny-panel', array(
		'title'       => __( 'Shiny Panel' ),
		'description' => __( 'I put what I want here.' ),
	) );

	// add a section to our panel
	$wp_customize->add_section( 'shiny-section', array(
		'title' => 'Shiny Section',
		'description' => 'This is a section of my panel',
		'panel' => 'shiny-panel',
	) );

	// add a setting because it won't show up without settings
	$wp_customize->add_setting( 'color_scheme', array(
	    'default'        => 'value1',
	    'type'           => 'theme_mod',
	) );

	$wp_customize->add_control( 'color_scheme', array(
	    'label'   => 'Select A Color Scheme:',
	    'section' => 'shiny-section',
	    'type'    => 'select',
	    'choices'    => array(
	        'light' => 'Light',
	        'dark' => 'Dark',
	        'neon' => 'Neon',
	        ),
	) );
}

add_action( 'customize_register', 'forgoodmeasure_customize_register' );