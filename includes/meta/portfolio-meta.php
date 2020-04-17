<?php

add_action( 'add_meta_boxes', 'stag_metabox_portfolio' );

function stag_metabox_portfolio() {

	$meta_box = array(
		'id'          => 'stag-metabox-portfolio',
		'title'       => __( 'Portfolio Settings', 'cluster-assistant' ),
		'description' => __( 'Here you can customize project images, dates etc..', 'cluster-assistant' ),
		'page'        => 'portfolio',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'Project Date', 'cluster-assistant' ),
				'desc' => __( 'Enter the project date e.g. Feb 24, 2013', 'cluster-assistant' ),
				'id'   => '_stag_portfolio_date',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Project URL', 'cluster-assistant' ),
				'desc' => __( 'Enter the project URL.', 'cluster-assistant' ),
				'id'   => '_stag_portfolio_url',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Open link in new window?', 'cluster-assistant' ),
				'desc' => __( 'Check to open project URL in new window.', 'cluster-assistant' ),
				'id'   => '_stag_portfolio_new_window',
				'type' => 'checkbox',
				'std'  => '',
			),
			array(
				'name'     => __( 'Project Images', 'cluster-assistant' ),
				'desc'     => __( 'Choose project images, ideal size 770px x unlimited.', 'cluster-assistant' ),
				'id'       => '_stag_portfolio_images',
				'type'     => 'file',
				'std'      => '',
				'multiple' => true,
			),
		),
	);
	stag_add_meta_box( $meta_box );
}
