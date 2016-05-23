<?php 
/**
 * Widget to display hours of operation from monday - sunday
 */
class Alehouse_Hours_Widget extends WP_Widget {
	
	// set the widget options
	function __construct() {
		
		$widget_ops = array(
			'classname' => 'widget_alehouse_hours',
			'description' => __( 'Display hours of operation', 'alehouse' ),
		);
		
		parent::__construct( 'alehouse_hours_widget', __( 'Alehouse Hours', 'alehouse' ), $widget_ops );
	}
	
	// display the widget
	function widget( $args, $instance ) {
		
		extract( $args );
		extract( $instance );
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		echo $before_widget;
		
		if ( $title ) {
			
			echo $before_title . $title . $after_title;
		}
		?>
		
		<table>
			<tr>
				<td class="day"><?php _e( 'Monday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $monday; ?></td>
			</tr>
			<tr>
				<td class="day"><?php _e( 'Tuesday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $tuesday; ?></td>
			</tr>
			<tr>
				<td class="day"><?php _e( 'Wednesday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $wednesday; ?></td>
			</tr>
			<tr>
				<td class="day"><?php _e( 'Thursday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $thursday; ?></td>
			</tr>
			<tr>
				<td class="day"><?php _e( 'Friday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $friday; ?></td>
			</tr>
			<tr>
				<td class="day"><?php _e( 'Saturday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $saturday; ?></td>
			</tr>
			<tr>
				<td class="day"><?php _e( 'Sunday', 'alehouse' ); ?></td>
				<td class="hours"><?php echo $sunday; ?></td>
			</tr>
		</table>
		
		<?php 
		echo $after_widget;
	}
	
	// save the widget
	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['monday'] = strip_tags( $new_instance['monday'] );
		$instance['tuesday'] = strip_tags( $new_instance['tuesday'] );
		$instance['wednesday'] = strip_tags( $new_instance['wednesday'] );
		$instance['thursday'] = strip_tags( $new_instance['thursday'] );
		$instance['friday'] = strip_tags( $new_instance['friday'] );
		$instance['saturday'] = strip_tags( $new_instance['saturday'] );
		$instance['sunday'] = strip_tags( $new_instance['sunday'] );

		return $instance;
	}

	// widget admin form
	function form( $instance ) { 
	
		// default values
		$args = array(
			'title' => 'Hours',
			'monday' => '',
			'tuesday' => '',
			'wednesday' => '',
			'thursday' => '',
			'friday' => '',
			'saturday' => '',
			'sunday' => '',
		);
		
		$instance = ( array ) $instance;
		$instance = wp_parse_args( $instance, $args );
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['title']; ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'monday' ); ?>"><?php _e( 'Monday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['monday']; ?>" id="<?php echo $this->get_field_id( 'monday' ); ?>" name="<?php echo $this->get_field_name( 'monday' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tuesday' ); ?>"><?php _e( 'Tuesday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['tuesday']; ?>" id="<?php echo $this->get_field_id( 'tuesday' ); ?>" name="<?php echo $this->get_field_name( 'tuesday' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'wednesday' ); ?>"><?php _e( 'Wednesday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['wednesday']; ?>" id="<?php echo $this->get_field_id( 'wednesday' ); ?>" name="<?php echo $this->get_field_name( 'wednesday' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thursday' ); ?>"><?php _e( 'Thursday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['thursday']; ?>" id="<?php echo $this->get_field_id( 'thursday' ); ?>" name="<?php echo $this->get_field_name( 'thursday' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'friday' ); ?>"><?php _e( 'Friday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['friday']; ?>" id="<?php echo $this->get_field_id( 'friday' ); ?>" name="<?php echo $this->get_field_name( 'friday' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'saturday' ); ?>"><?php _e( 'Saturday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['saturday']; ?>" id="<?php echo $this->get_field_id( 'saturday' ); ?>" name="<?php echo $this->get_field_name( 'saturday' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'sunday' ); ?>"><?php _e( 'Sunday', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['sunday']; ?>" id="<?php echo $this->get_field_id( 'sunday' ); ?>" name="<?php echo $this->get_field_name( 'sunday' ); ?> ">
		</p>
		<?php	
	}
	
}

/**
 * Widget to display a special menu item
 */

class Alehouse_Special_Widget extends WP_Widget {
	
	function __construct() {
				
		$widget_ops = array(
			'classname' => 'widget_alehouse_special',
			'description' => __( 'Show a special menu item', 'alehouse' ),
		);
		
		parent::__construct( 'alehouse_special_widget', __( 'Alehouse Special', 'alehouse' ), $widget_ops );
	}
	
	// display widget
	function widget( $args, $instance ) {
		
		extract( $args );
		extract( $instance );
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		echo $before_widget;
		
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		if ( $menu_item_id ) {
		
			global $post;
			
			$post = get_post( $menu_item_id );
			$menu_item_description = get_post_meta( $post->ID, 'alehouse_menu_item_description', true );
			$menu_item_price = get_post_meta( $post->ID, 'alehouse_menu_item_price', true );
			
			setup_postdata( $post );
			
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'alehouse-square-thumb' );
			}
			?>
			<h4 class="alehouse-special-title"><?php the_title(); ?></h4>
			
			<?php if ( ! empty( $menu_item_description ) ) : ?>
				<p class="alehouse-special-description"><?php echo $menu_item_description; ?></p>
			<?php endif; ?>
			
			<?php if ( ! empty( $menu_item_price ) ) : ?>
				<div class="alehouse-special-price"><?php echo $menu_item_price; ?></div>
			<?php endif;
			
			wp_reset_postdata();
		}
		
		
		
		echo $after_widget;
	}
	
	// update widget values
	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['menu_item_id'] = (int) $new_instance['menu_item_id'];

		return $instance;
	}
	
	
	// admin form
	function form( $instance ) {
		
		$args = array(
			'title' => 'Special',
			'menu_item_id' => '',
		);
		
		$instance = ( array ) $instance;
		$instance = wp_parse_args( $instance, $args );
		
		$args = array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'alehouse_menu_item',
			'post_status' => 'publish',
		);
		
		$menu_items = get_posts( $args );
		
		// Inform the user if no  menu items exist
		if ( ! $menu_items ) {
			echo '<p>' . __( 'No menu items have been added yet.', 'alehouse' ) . '</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'alehouse' ); ?></label>
			<input type="text" class="widefat" value="<?php echo $instance['title']; ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?> ">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_item_id' ); ?>"><?php _e( 'Menu Item', 'alehouse' ); ?></label>
			<select id="<?php echo $this->get_field_id('menu_item_id'); ?>" name="<?php echo $this->get_field_name('menu_item_id'); ?>">
			<?php
				foreach ( $menu_items as $menu_item ) {
					echo '<option value="' . $menu_item->ID . '"' . selected( $instance['menu_item_id'], $menu_item->ID, false ) . '>'. $menu_item->post_title . '</option>';
				}
			?>
			</select>
		</p>
		<?php
	}
}

/**
 * Register sidebars for our theme
 */
function alehouse_widgets_init() {
	
	//Main sidebar
	register_sidebar( array(
		'name' => __( 'Main Widget Sidebar', 'alehouse'	),
		'id' => 'main-sidebar',
		'description' => __( 'Appears beside the main content', 'alehouse' ),
		'before_widget' => '<aside id="%1$s" class="widget transparent-bg %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_widget( 'Alehouse_Hours_Widget' );
	register_widget( 'Alehouse_Special_Widget' );
}