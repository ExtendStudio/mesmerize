<?php

add_action("mesmerize_header_background_overlay_settings", "mesmerize_front_page_header_general_settings", 4, 5);

function mesmerize_front_page_header_general_settings($section, $prefix, $group, $inner, $priority)
{
    
    if ($inner) return;

    $priority = 5;
    $prefix   = "header";
    $section  = "header_background_chooser";
    $group = "";//"{$prefix}_options_group_button";

    /*
    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => "{$prefix}_options_group_button",
        'label'           => esc_html__('Header Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('General Options', 'mesmerize'),
        'settings' => "{$prefix}_general_options_separator",
        'section'  => $section,
        'priority' => $priority,
        'group' => $group
    ));*/

    mesmerize_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => __('Full Height Background', 'mesmerize'),
        'settings'  => 'full_height_header',
        'default'   => false,
        'transport' => 'postMessage',
        'section'   => $section,
        'priority'  => $priority,
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'header_overlap',
        'label'    => __('Allow content to overlap header', 'mesmerize'),
        'default'  => true,
        'section'  => $section,
        'priority' => $priority,
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'dimension',
        'settings'        => 'header_overlap_with',
        'label'           => __('Overlap with', 'mesmerize'),
        'default'         => '200px',
        'active_callback' => array(
            array(
                "setting"  => "header_overlap",
                "operator" => "==",
                "value"    => true,
            ),
        ),
        'section'         => $section,
        'priority'        => $priority,
        'group' => $group
    ));
}
