<?php

add_action("mesmerize_header_background_type_settings", 'mesmerize_header_background_type_image_settings', 1, 6);

function mesmerize_header_background_type_image_settings($wp_customize, $section, $prefix, $group, $inner, $priority) {
      $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    mesmerize_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => $prefix . '_bg_position',
        'label'           => __('Background Position', 'mesmerize'),
        'section'         => $section,
        'priority'        => 2,
        'default'         => "center center",
        'choices'         => array(
            "left top"    => "left top",
            "left center" => "left center",
            "left bottom" => "left bottom",

            "center top"    => "center top",
            "center center" => "center center",
            "center bottom" => "center bottom",

            "right top"    => "right top",
            "right center" => "right center",
            "right bottom" => "right bottom",

        ),
        "output"          => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-position',
                'suffix'   => '!important',
            ),

        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-position',
                'suffix'   => '!important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'checkbox',
        'settings'        => $prefix . '_parallax',
        'label'           => __('Enable parallax effect', 'mesmerize'),
        'section'         => $section,
        'priority'        => 3,
        'default'         => true,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
        'group' => $group
    ));

    /* image settings */
    if ( ! $inner) {
        $wp_customize->add_setting($prefix . '_front_page_image', array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => get_template_directory_uri() . "/assets/images/home_page_header.png",
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $prefix . '_front_page_image',
            array(
                'label'    => __('Header Image', 'mesmerize'),
                'section'  => $section,
                'priority' => 2,
            )));

        $wp_customize->add_setting($prefix . '_parallax_pro', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(new Mesmerize\Info_PRO_Control($wp_customize, $prefix . '_parallax_pro',
            array(
                'label'     => __('Parallax header background image available in PRO. @BTN@', 'mesmerize'),
                'section'   => $section,
                'priority'  => 2,
                'transport' => 'postMessage',
            )));
    }

    add_filter($group."_filter", function($settings) use ($prefix) {
    
        $new_settings =array(
            "_front_page_image",
            "_parallax_pro"
        );

        foreach ($new_settings as $key => $value) {
           $settings[] = $prefix.$value;
        }

        return $settings;
    });

}
