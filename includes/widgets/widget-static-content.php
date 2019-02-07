<?php
add_action( 'widgets_init', function() {
	return register_widget( 'stag_widget_static_content' );
} );

class stag_widget_static_content extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'static-content', 'description' => __( 'Displays content from a specific page.', 'cluster-assistant' ) );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'stag_widget_static_content' );
		parent::__construct( 'stag_widget_static_content', __( 'Section: Static Content', 'cluster-assistant' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS.
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$subtitle   = isset( $instance['subtitle'] ) ? esc_attr( $instance['subtitle'] ) : '';
		$page       = isset( $instance['page'] ) ? esc_attr( $instance['page'] ) : '';
		$bg_color   = isset( $instance['bg_color'] ) ? $instance['bg_color'] : '';
		$bg_image   = isset( $instance['bg_image'] ) ? $instance['bg_image'] : '';
		$bg_opacity = isset( $instance['bg_opacity'] ) ? $instance['bg_opacity'] : '';
		$text_color = isset( $instance['text_color'] ) ? $instance['text_color'] : '';
		$link_color = isset( $instance['link_color'] ) ? $instance['link_color'] : '';

		echo $before_widget;

		$the_page = get_page( $page );

		$query_args = array(
			'page_id' => $page,
			'post_status' => 'any',
		);

		$query = new WP_Query( $query_args );

		while ( $query->have_posts() ) : $query->the_post();

	?>

		<article <?php post_class(); ?> data-bg-color="<?php echo $bg_color; ?>" data-bg-image="<?php echo $bg_image; ?>" data-bg-opacity="<?php echo $bg_opacity; ?>" data-text-color="<?php echo $text_color; ?>" data-link-color="<?php echo $link_color; ?>">
			<?php
			if ( '' !== $title ) {
				echo $before_title . $title . $after_title;
			}
			if ( ! empty( $subtitle ) ) {
				echo "\n\t<p class='subtitle'>{$subtitle}</p>";
			}
			?>
			<div class="entry-content">
				<?php
					global $more;
					$more = false;
					the_content( __( 'Continue Reading', 'cluster-assistant' ) );
					wp_link_pages( array( 'before' => '<p><strong>' . __( 'Pages:', 'cluster-assistant' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) );
				?>
			</div>
		</article>

		<?php

		endwhile;

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML.
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['subtitle']   = strip_tags( $new_instance['subtitle'] );
		$instance['page']       = strip_tags( $new_instance['page'] );
		$instance['bg_color']   = strip_tags( $new_instance['bg_color'] );
		$instance['bg_image']   = esc_url( $new_instance['bg_image'] );
		$instance['bg_opacity'] = strip_tags( $new_instance['bg_opacity'] );
		$instance['text_color'] = strip_tags( $new_instance['text_color'] );
		$instance['link_color'] = strip_tags( $new_instance['link_color'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'title'      => '',
			'subtitle'   => '',
			'bg_image'   => '',
			'page'       => 0,
			'bg_color'   => '#2b373c',
			'bg_opacity' => 50,
			'text_color' => '#ffffff',
			'link_color' => cluster_get_thememod_value( 'style_accent_color' ),
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* HERE GOES THE FORM */
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'app-image-widget-admin', get_template_directory_uri() . '/includes/js/app-image-widget-admin.js', array( 'jquery' ), '', true );
		$id_prefix = $this->get_field_id( '' );
	?>
	<script type='text/javascript'>
		jQuery(document).ready(function($) {
			$('.colorpicker').wpColorPicker();

			$('.widget').find('.wp-picker-container').each(function(){
				var len = $(this).find('.wp-color-result').length;
				if ( len > 1){
					$(this).find('.wp-color-result').first().hide();
				}
			});
		});
	</script>

	<p>
	  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'cluster-assistant' ); ?></label>
	  <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
	  <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php esc_html_e( 'Sub Title:', 'cluster-assistant' ); ?></label>
	  <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Select Page:', 'cluster-assistant'); ?></label>

		<select id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" class="widefat">
		<?php

		$args = array(
		  'sort_order' => 'ASC',
		  'sort_column' => 'post_title',
		  );
		$pages = get_pages( $args );

		foreach ( $pages as $paged ) { ?>
			<option value="<?php echo $paged->ID; ?>" <?php if ( $instance['page'] == $paged->ID ) echo "selected"; ?>><?php echo $paged->post_title; ?></option>
		<?php }

		?>
	 </select>
	 <span class="description">This page will be used to display static content.</span>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'cluster-assistant' ); ?></label><br>
		<input type="text" data-default-color="<?php echo $defaults['bg_color'] ?>" class="colorpicker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" id="<?php echo $this->get_field_id( 'bg_color' ); ?>" value="<?php echo $instance['bg_color']; ?>" />
	</p>

	<p style="margin-top: 3px;">
		<div id="<?php echo esc_attr( $id_prefix ); ?>preview" class="stag-image-preview">
			<style type="text/css">
				.stag-image-preview img { max-width: 100%; border: 1px solid #e5e5e5; padding: 2px; margin-bottom: 5px;  }
			</style>
			<?php if ( ! empty( $instance['bg_image'] ) ) : ?>
			<img src="<?php echo esc_url( $instance['bg_image'] ); ?>" alt="">
			<?php endif; ?>
		</div>

		<input type="hidden" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'bg_image' ) ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>"value="<?php echo $instance['bg_image']; ?>" placeholder="http://" />
		<a href="#" class="button-secondary <?php echo esc_attr( $this->get_field_id( 'bg_image' ) ); ?>-add" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>', '<?php echo 'bg_image'; ?>' ); return false;"><?php esc_html_e( 'Choose Image', 'cluster-assistant' ); ?></a>
		<a href="#" style="display:inline-block;margin:5px 0 0 3px;<?php if ( empty( $instance['bg_image'] ) ) echo 'display:none;'; ?>" id="<?php echo esc_attr( $id_prefix ); ?>remove" class="button-link-delete" onclick="imageWidget.remove( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>', '<?php echo 'bg_image'; ?>' ); return false;"><?php esc_html_e( 'Remove', 'cluster-assistant' ); ?></a>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'bg_opacity' ); ?>"><?php esc_html_e( 'Background Opacity:', 'cluster-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bg_opacity' ); ?>" name="<?php echo $this->get_field_name( 'bg_opacity' ); ?>" value="<?php echo $instance['bg_opacity']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'text_color' ); ?>"><?php esc_html_e( 'Text Color:', 'cluster-assistant' ); ?></label><br>
		<input type="text" data-default-color="<?php echo $defaults['text_color'] ?>" class="colorpicker" name="<?php echo $this->get_field_name( 'text_color' ); ?>" id="<?php echo $this->get_field_id( 'text_color' ); ?>" value="<?php echo $instance['text_color']; ?>" />

	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'link_color' ); ?>"><?php esc_html_e( 'Link Color:', 'cluster-assistant' ); ?></label><br>
		<input type="text" data-default-color="<?php echo cluster_get_thememod_value( 'style_accent_color' ); ?>" class="colorpicker" name="<?php echo $this->get_field_name( 'link_color' ); ?>" id="<?php echo $this->get_field_id( 'link_color' ); ?>" value="<?php echo $instance['link_color']; ?>" />
	</p>

	<?php
	}
}

?>
