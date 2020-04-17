<?php
/**
 * Theme Shortcode for map
 */
function stag_google_map_shortcode( $atts ) {
	extract(
		shortcode_atts(
			array(
				'url' => '',
			),
			$atts
		)
	);
	return "<iframe class='google-map' width='100%' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='{$url}&amp;output=embed'></iframe>";
}
add_shortcode( 'map', 'stag_google_map_shortcode' );
