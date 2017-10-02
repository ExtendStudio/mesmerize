<?php

add_filter("mesmerize_header_background_type_settings", 'mesmerize_header_background_type_gradient_settings', 2, 6);

function mesmerize_header_background_type_gradient_settings($wp_customize, $section, $prefix, $group, $inner, $priority) {
    mesmerize_add_kirki_field(array(
        'type'      => 'web-gradients',
        'settings'  => $prefix . '_gradient',
        'label'     => esc_html__('Header Gradient', 'mesmerize'),
        'section'   => $section,
        'default'   => 'plum_plate',
        "priority"  => 2,
        'transport' => 'postMessage',
        'group' => $group
    ));
}