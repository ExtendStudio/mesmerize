<?php

function mesmerize_front_page_header_subtitle_options($section, $prefix, $priority)
{
    $companion = apply_filters('mesmerize_is_companion_installed', false);
    /*
    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Subtitle', 'mesmerize'),
        'section'  => $section,
        'settings' => "content_subtitle_separator",
        'priority' => $priority,
    ));*/

    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'header_content_show_subtitle',
        'label'    => __('Show subtitle', 'mesmerize'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'header_content_subtitle_group',
        'label'           => esc_html__('Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => array(
            "header_subtitle",
            "header_content_subtitle_typography",
            "header_content_subtitle_spacing",
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_show_subtitle',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'in_row_with'     => array('header_content_show_subtitle'),
    ));

    if ( ! $companion) {

    mesmerize_add_kirki_field(array(
            'type'              => 'textarea',
        'settings'          => 'header_subtitle',
        'label'             => __('Subtitle', 'mesmerize'),
        'section'           => $section,
        'default'           => "",
        'sanitize_callback' => 'wp_kses_post',
        'priority'          => $priority,

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ".header-homepage .header-subtitle",
                'function' => 'html',
            ),
        ),
    ));
    }
}


add_action("mesmerize_print_header_content", function() {
    mesmerize_print_header_subtitle();
}, 1);




function mesmerize_print_header_subtitle()
{
    $subtitle = get_theme_mod('header_subtitle', "");
    $show     = get_theme_mod('header_content_show_subtitle', true);

    if (current_user_can('edit_theme_options')) {
        if ($subtitle == "") {
            $subtitle = __('You can set this subtitle from the customizer.', 'mesmerize');
        }
    }
    if ($show) {
        printf('<p class="header-subtitle">%1$s</p>', $subtitle);
    }
}

