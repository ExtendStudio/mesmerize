<?php

function mesmerize_get_column_width_kirki_output($selector, $args = array(), $js_vars = false)
{

    $result = array();
    $base   = array_merge(array(
        "element"     => $selector,
        "property"    => null,
        "units"       => "%",
        "media_query" => null,
    ), $args);

    $props = array(
        "-webkit-flex-basis",
        "-moz-flex-basis",
        "-ms-flex-preferred-size",
        "flex-basis",
        "max-width",
        "width",
    );


    if ($js_vars) {
        $propData = array_merge($base,
            array(
                'property' => implode(',', $props),
                'function' => 'style',
            )
        );

        $result[] = $propData;
    } else {

        foreach ($props as $prop) {
            $propData = array_merge($base,
                array(
                    "property" => $prop,
                ));


            $result[] = $propData;
        }
    }

    return $result;
}

function mesmerize_front_page_header_media_box_options()
{

    $priority = 5;

    $prefix  = "header";
    $section = "header_background_chooser";


    $group = "header_media_box_settings";

    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Media box settings', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'contains',
                'value'    => 'media',
            ),
        ),
    ));

    mesmerize_add_kirki_field(array(
        'type'      => 'select',
        'settings'  => 'header_media_box_vertical_align',
        'label'     => __('Media Vertical Align', 'mesmerize'),
        'section'   => $section,
        'default'   => 'middle-sm',
        'transport' => 'postMessage',
        'choices'   => array(
            'top-sm'    => __('Top', 'mesmerize'),
            'middle-sm' => __('Middle', 'mesmerize'),
            'bottom-sm' => __('Bottom', 'mesmerize'),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'contains',
                'value'    => 'media-on-',
            ),
        ),

        "group" => $group,
    ));

    add_filter('mesmerize-hero-media-vertical-align', function ($align) {
        return get_theme_mod('header_media_box_vertical_align', $align);
    });

    mesmerize_add_kirki_field(array(
        'type'            => 'image',
        'settings'        => 'header_content_image',
        'label'           => __('Image', 'mesmerize'),
        'section'         => $section,
        'default'         => get_template_directory_uri() . "/assets/images/iMac.png",
        'active_callback' => array(
            array(
                'setting'  => 'header_content_media',
                'operator' => 'in',
                'value'    => array('image'),
            ),
        ),
        "group"           => $group,
    ));

    mesmerize_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => __('Image width', 'mesmerize'),
        'section'  => $section,
        'settings' => 'header_column_width',

        'choices' => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default' => 37,

        'transport' => 'postMessage',

        "output" => array_merge(
            mesmerize_get_column_width_kirki_output(".header-hero-media",
                array(
                    "media_query" => "@media only screen and (min-width: 768px)",
                )
            ),
            mesmerize_get_column_width_kirki_output(".header-hero-content",
                array(
                    'prefix'      => 'calc(100% - ',
                    'suffix'      => ')!important',
                    "media_query" => "@media only screen and (min-width: 768px)",
                )
            )
        ),

        "js_vars"         => array_merge(
            mesmerize_get_column_width_kirki_output(".header-hero-media",
                array(
                    "media_query" => "@media only screen and (min-width: 768px)",
                ),
                true
            ),
            mesmerize_get_column_width_kirki_output(".header-hero-content",
                array(
                    'prefix'      => 'calc(100% - ',
                    'suffix'      => ')!important',
                    "media_query" => "@media only screen and (min-width: 768px)",
                ),
                true
            )
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('image-on-left', 'image-on-right'),
            ),
        ),
        "group"           => $group,
    ));


    mesmerize_add_kirki_field(array(
        'type'      => 'spacing',
        'settings'  => 'header_content_media_spacing',
        'label'     => __('Media Box Spacing', 'mesmerize'),
        'section'   => $section,
        'default'   => array(
            'top'    => '0px',
            'bottom' => '0px',
        ),
        'transport' => 'postMessage',
        'output'    => array(
            array(
                'element'  => '.header-description-bottom.media, .header-description-top.media',
                'property' => 'margin',
            ),
        ),
        'js_vars'   => array(
            array(
                'element'  => '.header-description-bottom.media, .header-description-top.media',
                'function' => 'style',
                'property' => 'margin',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-top', 'media-on-bottom'),
            ),
        ),

        "group" => $group,
    ));
}

function mesmerize_front_page_header_text_options()
{

    $priority = 5;

    $prefix  = "header";
    $section = "header_background_chooser";

    $group = "header_text_box_settings";

    mesmerize_add_kirki_field(array(
        'type'     => 'sidebar-button-group',
        'settings' => $group,
        'label'    => esc_html__('Text box settings', 'mesmerize'),
        'section'  => $section,
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'     => 'radio-buttonset',
        'label'    => __('Text Align', 'mesmerize'),
        'section'  => $section,
        'settings' => 'header_text_box_text_align',
        'default'  => "left",
        'priority' => $priority,
        "choices"  => array(
            "left"   => __("Left", "mesmerize"),
            "center" => __("Center", "mesmerize"),
            "right"  => __("Right", "mesmerize"),
        ),

        "output" => array(
//            array(
//                "element"     => ".header-content .align-holder",
//                "property"    => "text-align",
//                "suffix"      => "!important",
//                "media_query" => "@media only screen and (min-width: 768px)",
//            ),

        ),

        'transport' => 'postMessage',

        'js_vars' => array(
//            array(
//                'element'     => ".header-content .align-holder",
//                'function'    => 'style',
//                "suffix"      => "!important",
//                'property'    => 'text-align',
//                "media_query" => "@media only screen and (min-width: 768px)",
//            ),
        ),

        'group' => $group,
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'slider',
        'label'    => __('Text Width', 'mesmerize'),
        'section'  => $section,
        'settings' => 'header_text_box_text_width',
        'priority' => $priority,
        'choices'  => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default'   => 100,
        'transport' => 'postMessage',

        "js_vars" => array(
            array(
                "element"  => ".header-content .align-holder",
                "function" => "css",
                "property" => "width",
                'suffix'   => '!important',
                "units"    => "%",
            ),
        ),

        "output" => array(
            array(
                "element"     => ".header-content .align-holder",
                "property"    => "width",
                'suffix'      => '!important',
                "units"       => "%",
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
        ),

        'group' => $group,
    ));

    mesmerize_add_kirki_field(array(
        'type'      => 'select',
        'settings'  => 'header_text_box_text_vertical_align',
        'label'     => __('Text Vertical Align', 'mesmerize'),
        'section'   => $section,
        'default'   => 'middle-sm',
        'transport' => 'postMessage',
        'priority'  => $priority,
        'choices'   => array(
            'top-sm'    => __('Top', 'mesmerize'),
            'middle-sm' => __('Middle', 'mesmerize'),
            'bottom-sm' => __('Bottom', 'mesmerize'),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'in',
                'value'    => array('media-on-left', 'media-on-right'),
            ),
        ),

        'group' => $group,
    ));
}

function mesmerize_front_page_header_content_options($section, $prefix, $priority)
{

    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Content Options', 'mesmerize'),
        'section'  => $section,
        'settings' => "header_content_separator",
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'     => 'select',
        'settings' => 'header_content_partial',
        'label'    => esc_html__('Content layout', 'mesmerize'),
        'section'  => $section,
        'default'  => 'media-on-right',
        'choices'  => apply_filters('mesmerize_header_content_partial', array(
            "content-on-center" => __("Text on center", "mesmerize"),
            "content-on-right"  => __("Text on right", "mesmerize"),
            "content-on-left"   => __("Text on left", "mesmerize"),
            "media-on-left"     => __("Text with media on left", "mesmerize"),
            "media-on-right"    => __("Text with media on right", "mesmerize"),
        )),
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => 'header_content_media',
        'label'           => esc_html__('Media Type', 'mesmerize'),
        'section'         => $section,
        'default'         => 'image',
        'choices'         => apply_filters('mesmerize_media_type_choices', array(
            "image" => __("Image", "mesmerize"),
        )),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_partial',
                'operator' => 'contains',
                'value'    => 'media-on-',
            ),
        ),
        'priority'        => $priority,
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'spacing',
        'label'    => __('Content Spacing', 'mesmerize'),
        'section'  => $section,
        'settings' => 'header_spacing',

        'default' => array(
            "top"    => "17%",
            "bottom" => "12%",
        ),

        "output" => array(
            array(
                "element"  => ".header-homepage .header-description-row",
                "property" => "padding",
                'suffix'   => ' !important',
            ),
        ),

        'transport' => 'postMessage',

        'js_vars'  => array(
            array(
                'element'  => '.header-homepage .header-description-row',
                'function' => 'css',
                'property' => 'padding',
                'suffix'   => ' !important',
            ),
        ),
        'priority' => $priority,
    ));


    add_filter('mesmerize-hero-content-vertical-align', function ($align_class) {
        return get_theme_mod('header_text_box_text_vertical_align', $align_class);
    });


    mesmerize_front_page_header_text_options();
    mesmerize_front_page_header_media_box_options();
}