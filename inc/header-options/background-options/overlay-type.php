<?php 

require_once get_template_directory() . "/inc/header-options/background-options/overlay-types/color-overlay.php";
require_once get_template_directory() . "/inc/header-options/background-options/overlay-types/gradient-overlay.php";
require_once get_template_directory() . "/inc/header-options/background-options/overlay-types/shapes-overlay.php";

function mesmerize_header_overlay_options($section, $prefix, $group, $inner, $priority)
{
    $prefix   = $inner ? "inner_header" : "header";
    $section  = $inner ? "header_image" : "header_background_chooser";
    $priority = 3;

    $group = "{$prefix}_overlay_options_group_button";

    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => $prefix . '_show_overlay',
        'label'    => __('Show overlay', 'mesmerize'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Overlay Options', 'mesmerize'),
        'section'  => $section,
        'settings' => $prefix . '_overlay_header',
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => $prefix . '_overlay_type',
        'label'           => esc_html__('Overlay Type', 'mesmerize'),
        'section'         => $section,
        'choices'         => apply_filters('mesmerize_overlay_types', array(
            'none'     => __('None', 'mesmerize'),
            'color'    => __('Color', 'mesmerize')
            
        )),
        'default'         => 'none',
        'group' => $group
    ));

    
    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        =>  $group,
        'label'           => esc_html__('Options', 'mesmerize'),
        'section'         => $section,
        'in_row_with' => array($prefix . '_show_overlay'),
        'priority' => $priority,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    do_action("mesmerize_header_background_overlay_settings", $section, $prefix, $group, $inner, $priority);
}


add_action("mesmerize_header_background_settings", function($section, $prefix, $group, $inner, $priority) {
    mesmerize_header_overlay_options($section, $prefix, $group, $inner, $priority);
}, 2, 5);