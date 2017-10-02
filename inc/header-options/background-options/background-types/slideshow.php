<?php

add_action("mesmerize_background", function($bg_type, $inner, $prefix) {
	if ($bg_type == 'slideshow') {
	    $js = get_template_directory_uri() . "/assets/js/libs/jquery.backstretch.js";
	    wp_enqueue_script(mesmerize_get_text_domain() . '-backstretch', $js, array('jquery'), false, true);
	    add_action('wp_footer', "mesmerize_" . $prefix . '_slideshow_script');
	}
}, 1, 3);


function mesmerize_header_background_type_slideshow($values, $inner, $prefix) {
	$values["slideshow"] = array(
        "label"   => __("Slideshow", 'mesmerize'),
        "control" => array(
            $prefix . "_slideshow",
            $prefix . "_slideshow_speed",
            $prefix . "_slideshow_duration",
        ),
    );
    return $values;
}

add_filter("mesmerize_header_background_type", 'mesmerize_header_background_type_slideshow', 1, 3);


add_filter("mesmerize_header_background_type_settings", 'mesmerize_header_background_type_slideshow_settings', 1, 6);

function mesmerize_header_background_type_slideshow_settings($wp_customize, $section, $prefix, $group, $inner, $priority) {

    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";
    
    $group = "{$prefix}_bg_options_group_button";
    
    mesmerize_add_kirki_field(array(
        'type'      => 'repeater',
        'label'     => __('Header Slideshow Images', 'mesmerize'),
        'section'   => $section,
        'priority'  => 2,
        'row_label' => array(
            'type'  => 'text',
            'value' => esc_attr__('slideshow image', 'mesmerize'),
        ),
        'settings'  => $prefix . '_slideshow',
        'default'   => array(
            array("url" => get_template_directory_uri() . "/assets/images/home_page_header.png"),
            array("url" => get_template_directory_uri() . "/assets/images/jeremy-bishop-14593.jpg"),
        ),
        'fields'    => array(
            'url' => array(
                'type'    => 'image',
                'label'   => esc_attr__('Image', 'mesmerize'),
                'default' => get_template_directory_uri() . "/assets/images/home_page_header.png",
            ),
        ),
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'number',
        'settings'        => $prefix . '_slideshow_duration',
        'label'           => __('Slide Duration', 'mesmerize'),
        'section'         => $section,
        'priority'        => 2,
        'default'         => 5000,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'number',
        'priority'        => 2,
        'settings'        => $prefix . '_slideshow_speed',
        'label'           => __('Effect Speed', 'mesmerize'),
        'section'         => $section,
        'default'         => 1000,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
        'group' => $group
    ));
}


function mesmerize_header_slideshow_script()
{
    mesmerize_add_slideshow_scripts();
}

function mesmerize_inner_header_slideshow_script()
{
    mesmerize_add_slideshow_scripts(true);
}

function mesmerize_add_slideshow_scripts($inner = false)
{
    $prefix = $inner ? "inner_header" : "header";

    $theme      = wp_get_theme();
    $textDomain = $theme->get('TextDomain');

    $bgSlideshow = get_theme_mod($prefix . "_slideshow", array(
        array("url" => get_template_directory_uri() . "/assets/images/home_page_header.png"),
        array("url" => get_template_directory_uri() . "/assets/images/jeremy-bishop-14593.jpg"),
    ));

    $images = array();
    foreach ($bgSlideshow as $key => $value) {
        if (is_numeric($value['url'])) {
            array_push($images, wp_get_attachment_url($value['url']));
        } else {
            array_push($images, $value['url']);
        }
    }

    $bgSlideshowSpeed    = intval(get_theme_mod($prefix . "_slideshow_speed", '1000'));
    $bgSlideshowDuration = intval(get_theme_mod($prefix . "_slideshow_duration", '5000'));

    $mesmerize_jssettings = array(
        'images'             => $images,
        'duration'           => intval($bgSlideshowDuration),
        'transitionDuration' => intval($bgSlideshowSpeed),
        'animateFirst'       => false,
    );

    wp_localize_script($textDomain . '-backstretch', 'mesmerize_backstretch', $mesmerize_jssettings);
}
