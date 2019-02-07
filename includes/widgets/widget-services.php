<?php
add_action( 'widgets_init', function() {
	return register_widget( 'stag_widget_services' );
} );

class stag_widget_services extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'service', 'description' => __( 'Display latest posts from blog.', 'cluster-assistant' ) );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'stag_widget_services' );
		parent::__construct( 'stag_widget_services', __( 'Services: Service Box', 'cluster-assistant' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS.
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$description = $instance['description'];
		$icon        = $instance['icon'];
		$custom_icon = $instance['customicon'];

		echo $before_widget;

	?>

		<?php if ( ! empty( $custom_icon ) ) : ?>
			<?php echo '<div class="custom-icon"><img src="' . $custom_icon . '" alt=""></div>'; ?>
		<?php else : ?>
			<i class="icon icon-<?php echo $icon; ?>"></i>
		<?php endif; ?>

		<div class="service--content">
			<?php
			echo "\n\t" . $before_title . $title . $after_title;
			if ( ! empty( $description ) ) {
				echo "\n\t<div class='service__description'>{$description}</div>";
			}
			?>
		</div>

		<?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML.
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['description'] = $new_instance['description'];
		$instance['icon']        = strip_tags( $new_instance['icon'] );
		$instance['customicon']  = strip_tags( $new_instance['customicon'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'title'       => '',
			'customicon'  => '',
			'description' => '',
			'icon'        => 'settings',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* HERE GOES THE FORM */
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'app-image-widget-admin', get_template_directory_uri() . '/includes/js/app-image-widget-admin.js', array( 'jquery' ), '', true );
		$id_prefix = $this->get_field_id( '' );
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'cluster-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php esc_html_e( 'Description:', 'cluster-assistant' ); ?></label>
		<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $instance['description']; ?></textarea>
	</p>

	<p>
	  <label for="<?php echo $this->get_field_id( 'customicon' ); ?>"><?php esc_html_e( 'Custom Icon:', 'cluster-assistant' ); ?></label>
	  <input type="hidden" class="widefat" id="<?php echo $this->get_field_id( 'customicon' ); ?>" name="<?php echo $this->get_field_name( 'customicon' ); ?>" value="<?php echo $instance['customicon']; ?>" />
	  <span class="description"><?php esc_html_e( 'Choose custom icon if you want to use your own icon or choose one below.', 'cluster-assistant' ); ?></span>
	</p>

	<p style="margin-top: 3px;">
		<div id="<?php echo esc_attr( $id_prefix ); ?>preview" class="stag-image-preview">
			<style type="text/css">
				.stag-image-preview img { max-width: 100%; border: 1px solid #e5e5e5; padding: 2px; margin-bottom: 5px;  }
			</style>
			<?php if ( ! empty( $instance['customicon'] ) ) : ?>
			<img src="<?php echo esc_url( $instance['customicon'] ); ?>" alt="">
			<?php endif; ?>
		</div>

		<a href="#" class="button-secondary <?php echo esc_attr( $this->get_field_id( 'customicon' ) ); ?>-add" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>', '<?php echo 'customicon'; ?>' ); return false;"><?php esc_html_e( 'Choose Image', 'cluster-assistant' ); ?></a>
		<a href="#" style="display:inline-block;margin:5px 0 0 3px;<?php if ( empty( $instance['customicon'] ) ) echo 'display:none;'; ?>" id="<?php echo esc_attr( $id_prefix ); ?>remove" class="button-link-delete" onclick="imageWidget.remove( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>', '<?php echo 'customicon'; ?>' ); return false;"><?php esc_html_e( 'Remove', 'cluster-assistant' ); ?></a>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php esc_html_e( 'Icon:', 'cluster-assistant' ); ?></label>
		<select name="<?php echo $this->get_field_name( 'icon' ); ?>" id="<?php echo $this->get_field_name( 'icon' ); ?>" class="widefat">
			<option value="podcast" <?php if ( 'podcast' === $instance['icon'] ) echo 'selected="selected"'; ?>>Podcast</option>
			<option value="browser" <?php if ( 'browser' === $instance['icon'] ) echo 'selected="selected"'; ?>>Browser</option>
			<option value="settings" <?php if ( 'settings' === $instance['icon'] ) echo 'selected="selected"'; ?>>Settings</option>
			<option value="lamp" <?php if ( 'lamp' === $instance['icon'] ) echo 'selected="selected"'; ?>>Lamp</option>
			<option value="user" <?php if ( 'user' === $instance['icon'] ) echo 'selected="selected"'; ?>>User</option>
			<option value="rocket" <?php if ( 'rocket' === $instance['icon'] ) echo 'selected="selected"'; ?>>Rocket</option>
		</select>
	</p>

	<?php
	}
}

?>
