<?php
add_action( 'widgets_init', function() {
	return register_widget( 'stag_widget_clients' );
} );

class stag_widget_clients extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'section-clients', 'description' => __( 'Displays multiple images as a showcase.', 'cluster-assistant' ) );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'stag_widget_clients' );
		parent::__construct( 'stag_widget_clients', __( 'Section: Clients', 'cluster-assistant' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS.
		$title    = apply_filters( 'widget_title', $instance['title'] );
		$subtitle = $instance['subtitle'];
		$urls     = $instance['urls'];

		echo $before_widget;

		if ( '' !== $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( ! empty( $subtitle ) ) {
			echo "\n\t<p class='subtitle'>{$subtitle}</p>";
		}

		$urls = explode( "\n", $urls );
	?>

	  <div class="grids">
	  	<?php foreach ( $urls as $url ) : ?>
			<figure class="grid-3">
				<img src="<?php echo esc_url( $url ); ?>" alt="">
			</figure>
	  	<?php endforeach; ?>
	  </div>

		<?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML.
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
		$instance['urls']     = strip_tags( $new_instance['urls'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'title'    => '',
			'subtitle' => '',
			'page'     => 0,
			'urls'     => '',
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
	  <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php esc_html_e( 'Sub Title:', 'cluster-assistant' ); ?></label>
	  <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
	</p>

	<p>
	  <label for="<?php echo $this->get_field_id( 'urls' ); ?>"><?php esc_html_e( 'Image URLs:', 'cluster-assistant' ); ?></label>
		<textarea rows="16" cols="20" class="widefat" id="<?php echo $this->get_field_id( 'urls' ); ?>" name="<?php echo $this->get_field_name( 'urls' ); ?>" style="display:none;"><?php echo $instance['urls']; ?></textarea>
	</p>

	<p style="margin-top: 3px;">

		<div id="<?php echo esc_attr( $id_prefix ); ?>preview" class="stag-image-preview stag-multi-preview">
			<style type="text/css">
				.stag-image-preview img { max-width: 100%; border: 1px solid #e5e5e5; padding: 2px; margin-bottom: 5px; }
				.stag-multi-preview img { max-width: 28% !important; margin-right: 5px; }
			</style>
			<?php if ( ! empty( $instance['urls'] ) ) : ?>
				<?php
				$urls = explode( "\n", $instance['urls'] );
				foreach ( $urls as $url ) : ?>
					<img src="<?php echo esc_url( $url ); ?>" alt="">
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<a href="#" class="button-secondary <?php echo esc_attr( $this->get_field_id( 'urls' ) ); ?>-add" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>', '<?php echo 'urls'; ?>', true ); return false;"><?php esc_html_e( 'Choose Image(s)', 'cluster-assistant' ); ?></a>
		<a href="#" style="display:inline-block;margin:5px 0 0 3px;<?php if ( empty( $instance['urls'] ) ) echo 'display:none;'; ?>" id="<?php echo esc_attr( $id_prefix ); ?>remove" class="button-link-delete" onclick="imageWidget.remove( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>', '<?php echo 'urls'; ?>' ); return false;"><?php esc_html_e( 'Remove', 'cluster-assistant' ); ?></a>
	</p>

	<?php
	}
}

?>
