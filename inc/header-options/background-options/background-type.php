<?php


require_once get_template_directory() . "/inc/header-options/background-options/background-types/image.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/slideshow.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/video.php";
require_once get_template_directory() . "/inc/header-options/background-options/background-types/gradient.php";

function mesmerize_header_background_type($wp_customize, $inner)
{
    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    $priority = 2;
    
    /* background type dropdown */
    $wp_customize->add_setting($prefix . '_background_type', array(
        'default'           => "gradient",
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new Mesmerize\BackgroundTypesControl($wp_customize, $prefix . '_background_type', array(
        'label'    => __('Background Type', 'mesmerize'),
        'section'  => $section,
        "choices"  => apply_filters(
            'mesmerize_header_background_type',
            array(
                "image"     => array(
                    "label"   => __("Image", 'mesmerize'),
                    "control" => array(
                        $inner ? "header_image" : "header_front_page_image",
                        $prefix . "_parallax_pro",
                    ),
                ),
                "gradient"  => array(
                    "label"   => __("Gradient", 'mesmerize'),
                    "control" => array(
                        $prefix . "_gradient",
                        $prefix . "_gradient_pro_info",
                    ),
                )
            ),
            $inner,
            $prefix
        ),
        'priority' => $priority
    )));


    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        'description' => esc_html__('Options', 'mesmerize'),
        'in_row_with' => array($prefix . '_background_type')
    ));


    do_action("mesmerize_header_background_type_settings", $wp_customize, $section, $prefix, $group, $inner, $priority);
}

add_action('mesmerize_customize_register', function ($wp_customize) {

    mesmerize_header_background_type($wp_customize, $inner = true);
    mesmerize_header_background_type($wp_customize, $inner = false);

    $wp_customize->get_control('header_image')->priority = 3;

}, 1, 1);
