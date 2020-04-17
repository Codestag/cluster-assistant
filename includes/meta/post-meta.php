<?php

add_action( 'add_meta_boxes', 'stag_metabox_gallery' );

function stag_metabox_gallery() {

	/* Gallery Metabox -------------------------------------------*/
	$meta_box = array(
		'id'          => 'stag-metabox-gallery',
		'title'       => __( 'Gallery Settings', 'cluster-assistant' ),
		'description' => __( 'Set up your gallery', 'cluster-assistant' ),
		'page'        => 'post',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name'     => __( 'Upload Images', 'cluster-assistant' ),
				'desc'     => __( 'Upload gallery images.', 'cluster-assistant' ),
				'id'       => '_stag_gallery_images',
				'type'     => 'file',
				'std'      => '',
				'multiple' => 'true',
				'title'    => __( 'Choose Images', 'cluster-assistant' ),
			),
		),
	);
	stag_add_meta_box( $meta_box );

	/* Link Metabox -------------------------------------------*/
	$meta_box = array(
		'id'          => 'stag-metabox-link',
		'title'       => __( 'Link Settings', 'cluster-assistant' ),
		'description' => __( 'Input your link', 'cluster-assistant' ),
		'page'        => 'post',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'Link', 'cluster-assistant' ),
				'desc' => __( 'Input your link e.g. https://codestag.com', 'cluster-assistant' ),
				'id'   => '_stag_link_url',
				'type' => 'text',
				'std'  => '',
			),
		),
	);
	stag_add_meta_box( $meta_box );

	/* Quote Metabox -------------------------------------------*/
	$meta_box = array(
		'id'          => 'stag-metabox-quote',
		'title'       => __( 'Quote Settings', 'cluster-assistant' ),
		'description' => __( 'Input your quote', 'cluster-assistant' ),
		'page'        => 'post',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'Quote Source', 'cluster-assistant' ),
				'desc' => __( 'Enter the quote source/author', 'cluster-assistant' ),
				'id'   => '_stag_quote_source',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'The Quote', 'cluster-assistant' ),
				'desc' => __( 'Input your quote', 'cluster-assistant' ),
				'id'   => '_stag_quote_quote',
				'type' => 'textarea',
				'std'  => '',
			),
		),
	);
	stag_add_meta_box( $meta_box );

	/* Audio Metabox -------------------------------------------*/
	$meta_box = array(
		'id'          => 'stag-metabox-audio',
		'title'       => __( 'Audio Settings', 'cluster-assistant' ),
		'description' => __( 'This setting enables you to embed audio for this post.', 'cluster-assistant' ),
		'page'        => 'post',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'MP3 File URL', 'cluster-assistant' ),
				'desc' => __( 'Enter URL to .mp3 file.', 'cluster-assistant' ),
				'id'   => '_stag_audio_mp3',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'OGA File URL', 'cluster-assistant' ),
				'desc' => __( 'Enter URL to .oga, .ogg file.', 'cluster-assistant' ),
				'id'   => '_stag_audio_oga',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Embed Audio URL', 'cluster-assistant' ),
				'desc' => __( 'Enter URL or shortcode to embed an Audio Player', 'cluster-assistant' ),
				'id'   => '_stag_audio_embed',
				'type' => 'textarea',
				'std'  => '',
			),
		),
	);
	stag_add_meta_box( $meta_box );

	/* Video Metabox -------------------------------------------*/
	$meta_box = array(
		'id'          => 'stag-metabox-video',
		'title'       => __( 'Video Settings', 'cluster-assistant' ),
		'description' => __( 'This setting enables you to embed video for this post.', 'cluster-assistant' ),
		'page'        => 'post',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'M4V File URL', 'cluster-assistant' ),
				'desc' => __( 'Enter URL to .m4v video file.', 'cluster-assistant' ),
				'id'   => '_stag_video_m4v',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'OGV File URL', 'cluster-assistant' ),
				'desc' => __( 'Enter URL to .ogv video file.', 'cluster-assistant' ),
				'id'   => '_stag_video_ogv',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Embedded Code', 'cluster-assistant' ),
				'desc' => __( 'If you are using a video other than self-hosted such as YouTube or Vimeo, paste the embed code here.<br><br>This field will override the above.', 'cluster-assistant' ),
				'id'   => '_stag_video_embed',
				'type' => 'textarea',
				'std'  => '',
			),
		),
	);
	stag_add_meta_box( $meta_box );
}
