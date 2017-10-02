<?php

//FOOTER


function mesmerize_get_footer_social_icons() {
	return array(
		array(
			'icon'  => "fa-facebook-f",
			'link'  => "https://facebook.com",
			'label' => __( 'Icon 1', 'mesmerize' ),
			'id'    => 'social_icon_0',
		),
		array(
			'icon'  => "fa-twitter",
			'link'  => "https://twitter.com",
			'label' => __( 'Icon 2', 'mesmerize' ),
			'id'    => 'social_icon_1',
		),
		array(
			'icon'  => "fa-google-plus",
			'link'  => "https://plus.google.com",
			'label' => __( 'Icon 3', 'mesmerize' ),
			'id'    => 'social_icon_2',
		),
		array(
			'icon'  => "fa-instagram",
			'link'  => "https://instagram.com",
			'label' => __( 'Icon 4', 'mesmerize' ),
			'id'    => 'social_icon_3',
		),
		array(
			'icon'  => "fa-youtube-square",
			'link'  => "https://www.youtube.com",
			'label' => __( 'Icon 5', 'mesmerize' ),
			'id'    => 'social_icon_4',
		)
	);
}


function mesmerize_footer_filter() {
	$footer_template = get_theme_mod( "footer_template", "simple" );

	$theme      = wp_get_theme();
	$textDomain = $theme->get( 'TextDomain' );

	if ( $footer_template == 'simple' ) {
		$footer_template = '';
	}

	if ( $footer_template ) {
		wp_enqueue_style( $textDomain . '-' . $footer_template . '-css', get_template_directory_uri() . "/assets/css/footer-$footer_template.css", array( $textDomain . "-style" ) );
	}

	return $footer_template;
}

add_filter( 'mesmerize_footer', 'mesmerize_footer_filter' );

function mesmerize_footer_settings() {

	mesmerize_add_kirki_field( array(
		'type'     => 'select',
		'settings' => 'footer_template',
		'label'    => esc_html__( 'Template', 'mesmerize' ),
		'section'  => 'footer_content',
		'default'  => 'simple',
		'choices'  => apply_filters("mesmerize_footer_templates", array(
			"simple"        => __( "Simple", 'mesmerize' ),
			"contact-boxes" => __( "Contact Boxes", 'mesmerize' ),
			"content-lists" => __( "Widgets Boxes", 'mesmerize' )
		)),
	) );



	mesmerize_add_kirki_field( array(
		'type'            => 'sectionseparator',
		'label'           => __( 'Box 1 Content', 'mesmerize' ),
		'section'         => 'footer_content',
		'settings'        => "footer_box1_content_separator",
		'active_callback' => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'            => 'font-awesome-icon-control',
		'settings'        => 'footer_box1_content_icon',
		'label'           => __( 'Icon', 'mesmerize' ),
		'section'         => 'footer_content',
		'default'         => "fa-map-marker",
		'active_callback' => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'              => 'textarea',
		'settings'          => 'footer_box1_content_text',
		'label'             => __( 'Text', 'mesmerize' ),
		'section'           => 'footer_content',
		'default'           => "San Francisco - Adress - 18 California Street 1100.",
		'sanitize_callback' => 'wp_kses_post',
		'active_callback'   => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'            => 'sectionseparator',
		'label'           => __( 'Box 2 Content', 'mesmerize' ),
		'section'         => 'footer_content',
		'settings'        => "footer_box2_content_separator",
		'active_callback' => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'            => 'font-awesome-icon-control',
		'settings'        => 'footer_box2_content_icon',
		'label'           => __( 'Icon', 'mesmerize' ),
		'section'         => 'footer_content',
		'default'         => "fa-envelope-o",
		'active_callback' => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'              => 'textarea',
		'settings'          => 'footer_box2_content_text',
		'label'             => __( 'Text', 'mesmerize' ),
		'section'           => 'footer_content',
		'default'           => "hello@mycoolsite.com",
		'sanitize_callback' => 'wp_kses_post',
		'active_callback'   => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'            => 'sectionseparator',
		'label'           => __( 'Box 3 Content', 'mesmerize' ),
		'section'         => 'footer_content',
		'settings'        => "footer_box3_content_separator",
		'active_callback' => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'            => 'font-awesome-icon-control',
		'settings'        => 'footer_box3_content_icon',
		'label'           => __( 'Icon', 'mesmerize' ),
		'section'         => 'footer_content',
		'default'         => "fa-phone",
		'active_callback' => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	mesmerize_add_kirki_field( array(
		'type'              => 'textarea',
		'settings'          => 'footer_box3_content_text',
		'label'             => __( 'Text', 'mesmerize' ),
		'section'           => 'footer_content',
		'default'           => "+1 (555) 345 234343",
		'sanitize_callback' => 'wp_kses_post',
		'active_callback'   => array(
			array(
				'setting'  => 'footer_template',
				'operator' => '==',
				'value'    => "contact-boxes",
			),
		),
	) );

	$footers_with_social_icons = apply_filters("mesmerize_footer_templates_with_social", array("contact-boxes", "content-lists"));
	mesmerize_add_kirki_field( array(
        'type'            => 'sectionseparator',
        'label'           => __('Social Icons', 'mesmerize'),
        'section'         => 'footer_content',
        'settings'        => "footer_content_social_icons_separator",
        'active_callback' => array(
            array(
                'setting'  => 'footer_template',
                'operator' => 'in',
                'value'    => $footers_with_social_icons,
            ),
        ),
    ));

	$mesmerize_footer_socials_icons = mesmerize_get_footer_social_icons();
	foreach ( $mesmerize_footer_socials_icons as $social ) {
		$sociallabel = $social['label'];
		$socialid    = $social['id'];
		mesmerize_add_kirki_field( array(
			'type'            => 'checkbox',
			'settings'        => 'footer_content_'.$socialid.'_enabled',
			'label'           => __( 'Show ', 'mesmerize' ) . $sociallabel,
			'section'         => 'footer_content',
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'footer_template',
					'operator' => 'in',
					'value'    => $footers_with_social_icons,
				),
			),
		) );

		mesmerize_add_kirki_field( array(
			'type'            => 'url',
			'settings'        => 'footer_content_'.$socialid.'_link',
			'label'           => $sociallabel . __( ' url', 'mesmerize' ),
			'section'         => 'footer_content',
			'default'         => "#",
			'active_callback' => array(
				array(
					'setting'  => 'footer_content_'.$socialid.'_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'footer_template',
					'operator' => 'in',
					'value'    => $footers_with_social_icons,
				),
			),
		) );

		mesmerize_add_kirki_field( array(
			'type'            => 'font-awesome-icon-control',
			'settings'        => 'footer_content_'.$socialid.'_icon',
			'label'           => $sociallabel . __( ' icon', 'mesmerize' ),
			'section'         => 'footer_content',
			'default'         => $social['icon'],
			'active_callback' => array(
				array(
					'setting'  => 'footer_content_'.$socialid.'_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'footer_template',
					'operator' => 'in',
					'value'    => $footers_with_social_icons,
				),
			),
		) );
	}

}

add_action("mesmerize_customize_register_options", function() {
mesmerize_footer_settings();
});