<?php

add_action("mesmerize_header_background_settings", function($section, $prefix, $group, $inner, $priority) {
    mesmerize_header_separator_options($section, $prefix, $group, $inner, $priority);
}, 3, 5);


function mesmerize_header_separator_options($section, $prefix, $group, $inner, $priority)
{

    $priority = 4;
    $group = "{$prefix}_options_separator_group_button";

    /*
    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Bottom Separator', 'mesmerize'),
        'section'  => $section,
        'settings' => $prefix . '_separator_header_separator',
        'priority' => $priority
    ));*/


    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'label'    => __('Enable Bottom Separator', 'mesmerize'),
        'section'  => $section,
        'settings' => $prefix . '_show_separator',
        'default'  => true,
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => $group,
        'label'           => esc_html__('Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        'in_row_with' => array($prefix . '_show_separator')
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Bottom Separator Options', 'mesmerize'),
        'section'  => $section,
        'settings' => $prefix . '_separator_header_separator_2',
        'priority' => $priority,
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'select',
        'settings'        => $prefix . '_separator',
        'label'           => esc_html__('Type', 'mesmerize'),
        'section'         => $section,
        'default'         => 'default',
        'choices'         => mesmerize_get_separators_list(),
        'priority'        => $priority,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'color',
        'settings' => "{$prefix}_separator_color",
        'label'    => esc_attr__('Color', 'mesmerize'),
        'section'  => $section,
        'priority' => $priority,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => "#ffffff",
        'output'   => array(
            array(
                'element'  => $inner ? "body .header path.svg-white-bg" : ".header-homepage + .header-separator path.svg-white-bg",
                'property' => 'fill',
                'suffix'   => '!important',
            ),


        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => $inner ? "body .header path.svg-white-bg" : ".header-homepage + .header-separator path.svg-white-bg",
                'property' => 'fill',
                'suffix'   => '!important',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),

        'group' => $group
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'color',
        'settings' => "{$prefix}_separator_color_accent",
        'label'    => esc_attr__('Accent Color', 'mesmerize'),
        'section'  => $section,
        'priority' => $priority,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => mesmerize_get_theme_colors('color2'),
        'output'   => array(
            array(
                'element'  => $inner ? "body.page .header .svg-accent" : ".header-homepage + .header-separator path.svg-accent",
                'property' => 'stroke',
                'suffix'   => '!important',
            ),


        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => $inner ? "body.page .header path.svg-accent" : ".header-homepage + .header-separator path.svg-accent",
                'property' => 'stroke',
                'suffix'   => '!important',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),

            array(
                'setting'  => $prefix . '_separator',
                'operator' => 'in',
                'value'    => mesmerize_get_2_colors_separators(array(), true),
            ),
        ),
        'group' => $group
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'slider',
        'label'           => __('Height', 'mesmerize'),
        'section'         => $section,
        'settings'        => $prefix . '_separator_height',
        'default'         => 154,
        'transport'       => 'postMessage',
        'priority'        => $priority,
        'choices'         => array(
            'min'  => '0',
            'max'  => '400',
            'step' => '1',
        ),
        "output"          => array(
            array(
                "element"  => $inner ? ".header-separator svg" : ".header-homepage + .header-separator svg",
                'property' => 'height',
                'suffix'   => '!important',
                'units'    => 'px',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => $inner ? ".header-separator svg" : ".header-homepage + .header-separator svg",
                'function' => 'css',
                'property' => 'height',
                'units'    => "px",
                'suffix'   => '!important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'group' => $group
    ));
}



function mesmerize_get_2_colors_separators($separators = array(), $onlyIDs = false)
{
    $separators = array_merge(
        $separators,
        array(
            'mesmerize/1.wave-and-line'          => __('Wave and line', 'mesmerize'),
            'mesmerize/1.wave-and-line-negative' => __('Wave and line Negative', 'mesmerize'),
        )
    );

    if ($onlyIDs) {
        return array_keys($separators);

    }

    return $separators;
}

add_filter('mesmerize_separators_list_prepend', 'mesmerize_get_2_colors_separators');


function mesmerize_get_separators_list()
{

    $separators = array(
        'default'                                     => __('Default', 'mesmerize'),
        'mesmerize/2.middle-waves'                    => __('Middle Waves', 'mesmerize'),
        'mesmerize/2.middle-waves-horizontal-flipped' => __('Middle Waves Flipped', 'mesmerize'),
        'mesmerize/2a.middle-waves'                   => __('Middle Waves 2', 'mesmerize'),
        'mesmerize/2a.middle-waves-negative'          => __('Middle Waves 2 Negative', 'mesmerize'),
        'mesmerize/3.waves-noCentric'                 => __('Wave no centric', 'mesmerize'),
        'mesmerize/3.waves-noCentric-negative'        => __('Wave no centric Negative', 'mesmerize'),
        'mesmerize/4.clouds'                          => __('Clouds 2', 'mesmerize'),
        'mesmerize/5.triple-waves-3'                  => __('Triple Waves 1', 'mesmerize'),
        'mesmerize/5.triple-waves-3-negative'         => __('Triple Waves 1 Negative', 'mesmerize'),
        'mesmerize/6.triple-waves-2'                  => __('Triple Waves 2', 'mesmerize'),
        'mesmerize/6.triple-waves-2-negative'         => __('Triple Waves 2 Negative', 'mesmerize'),
        'mesmerize/7.stright-angles-1'                => __('Stright Angles 1', 'mesmerize'),
        'mesmerize/7.stright-angles-1-negative'       => __('Stright Angles 1 Negative', 'mesmerize'),
        'mesmerize/8.stright-angles-2'                => __('Triple Waves 2', 'mesmerize'),
        'mesmerize/8.stright-angles-2-negative'       => __('Triple Waves 2 Negative', 'mesmerize'),

        'tilt'                           => __('Tilt', 'mesmerize'),
        'tilt-flipped'                   => __('Tilt Flipped', 'mesmerize'),
        'opacity-tilt'                   => __('Tilt Opacity', 'mesmerize'),
        'triangle'                       => __('Triangle', 'mesmerize'),
        'triangle-negative'              => __('Triangle Negative', 'mesmerize'),
        'triangle-asymmetrical'          => __('Triangle Asymmetrical', 'mesmerize'),
        'triangle-asymmetrical-negative' => __('Triangle Asymmetrical Negative', 'mesmerize'),
        'opacity-fan'                    => __('Fan Opacity', 'mesmerize'),
        'mountains'                      => __('Mountains', 'mesmerize'),
        'pyramids'                       => __('Pyramids', 'mesmerize'),
        'pyramids-negative'              => __('Pyramids Negative', 'mesmerize'),
        'waves'                          => __('Waves', 'mesmerize'),
        'waves-negative'                 => __('Waves Negative', 'mesmerize'),
        'wave-brush'                     => __('Waves Brush', 'mesmerize'),
        'waves-pattern'                  => __('Waves Pattern', 'mesmerize'),
        'clouds'                         => __('Clouds', 'mesmerize'),
        'clouds-negative'                => __('Clouds Negative', 'mesmerize'),
        'curve'                          => __('Curve', 'mesmerize'),
        'curve-negative'                 => __('Curve Negative', 'mesmerize'),
        'curve-asymmetrical'             => __('Curve Asymmetrical', 'mesmerize'),
        'curve-asymmetrical-negative'    => __('Curve Asymmetrical Negative', 'mesmerize'),
        'drops'                          => __('Drops', 'mesmerize'),
        'drops-negative'                 => __('Drops Negative', 'mesmerize'),
        'arrow'                          => __('Arrow', 'mesmerize'),
        'arrow-negative'                 => __('Arrow Negative', 'mesmerize'),
        'book'                           => __('Book', 'mesmerize'),
        'book-negative'                  => __('Book Negative', 'mesmerize'),
        'split'                          => __('Split', 'mesmerize'),
        'split-negative'                 => __('Split Negative', 'mesmerize'),
        'zigzag'                         => __('Zigzag', 'mesmerize'),
    );


    $prepend_separators = apply_filters('mesmerize_separators_list_prepend', array());
    $append_separators  = apply_filters('mesmerize_separators_list_append', array());

    $separators = array_merge($prepend_separators, $separators, $append_separators);

    return $separators;
}



function mesmerize_print_header_separator()
{
    $inner  = mesmerize_is_inner();
    $prefix = $inner ? "inner_header" : "header";
    $show   = get_theme_mod($prefix . '_show_separator', true);
    if ($show) {

        $separator = get_theme_mod($prefix . '_separator', 'default');

        $reverse = "";

        if (strpos($separator, "mesmerize/") !== false) {
            $reverse = strpos($separator, "-negative") === false ? "" : "header-separator-reverse";
        } else {
            $reverse = strpos($separator, "-negative") === false ? "header-separator-reverse" : "";
        }

        echo '<div class="header-separator header-separator-bottom ' . $reverse . '">';
        ob_start();

        // local svg as template ( ensure it will work with filters in child theme )
        locate_template("/assets/separators/" . $separator . ".svg", true, true);

        $content = ob_get_clean();
        echo $content;
        echo '</div>';

    }
}