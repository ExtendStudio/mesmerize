<?php


    add_action("mesmerize_header_background_overlay_settings", function($section, $prefix, $group, $inner, $priority) {  
        $header_class = $inner ? ".header" : ".header-homepage";

        mesmerize_add_kirki_field(array(
            'type'    => 'color',
            'label'   => __('Overlay Color', 'mesmerize'),
            'section' => $section,

            'settings'  => $prefix . '_overlay_color',
            'default'   => "#ffffff",
            'transport' => 'postMessage',
            'priority'  => $priority,
            'choices'   => array(
                'alpha' => false,
            ),

            "output" => array(
                array(
                    'element'  => $header_class . '.color-overlay:before',
                    'property' => 'background',
                ),
            ),

            'js_vars'         => array(
                array(
                    'element'  => $header_class . ".color-overlay:before",
                    'function' => 'css',
                    'property' => 'background',
                    'suffix'   => ' !important',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => $prefix . '_show_overlay',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => $prefix . '_overlay_type',
                    'operator' => '==',
                    'value'    => 'color',
                ),
            ),
            'group' => $group
        ));


        mesmerize_add_kirki_field(array(
            'type'      => 'slider',
            'label'     => __('Overlay Opacity', 'mesmerize'),
            'section'   => $section,
            'priority'  => $priority,
            'settings'  => $prefix . '_overlay_opacity',
            'default'   => 0,
            'transport' => 'postMessage',
            'choices'   => array(
                'min'  => '0',
                'max'  => '1',
                'step' => '0.01',
            ),

            "output" => array(
                array(
                    'element'  => $header_class . '.color-overlay:before',
                    'property' => 'opacity',
                ),
            ),

            'js_vars'         => array(
                array(
                    'element'  => $header_class . '.color-overlay:before',
                    'function' => 'css',
                    'property' => 'opacity',
                    'suffix'   => ' !important',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => $prefix . '_show_overlay',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => $prefix . '_overlay_type',
                    'operator' => 'in',
                    'value'    => array('color', 'gradient'),
                ),
            ),
            'group' => $group
        ));
    }, 1, 5);

    