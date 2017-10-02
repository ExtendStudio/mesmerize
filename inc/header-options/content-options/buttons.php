<?php

function mesmerize_front_page_header_buttons_options($section, $prefix, $priority)
{
    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'header_content_show_buttons',
        'label'    => __('Show buttons', 'mesmerize'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'header_content_buttons_group',
        'label'           => esc_html__('Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => array(
            "header_content_buttons",
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_show_buttons',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'in_row_with'     => array('header_content_show_buttons'),
    ));

    $companion = apply_filters('mesmerize_is_companion_installed', false);
    mesmerize_add_kirki_field(
        array(
            'type'      => 'repeater',
            'settings'  => "header_content_buttons",
            'label'     => esc_html__('Buttons', 'mesmerize'),
            'section'   => $section,
            "priority"  => $priority,
            "default"   => array(
                array(
                    'label'  => 'Action Button 1',
                    'url'    => '#',
                    'target' => '_self',
                    'class'  => 'button big color3 round',
                ),
                array(
                    'label'  => 'Action Button 2',
                    'url'    => '#',
                    'target' => '_self',
                    'class'  => 'button big white round outline',
                ),
            ),
            'choices'   => array(
               'limit' => $companion ? 10 : 2,
            ),
            'row_label' => array(
                'type'  => 'text',
                'value' => __('Button', 'mesmerize'),
            ),
            "fields"    => apply_filters('mesmerize_navigation_custom_area_buttons_fields', array(
                "label" => array(
                    'type'    => $companion ? 'hidden' : 'text',
                    'label'   => esc_attr__('Label', 'mesmerize'),
                    'default' => 'Action Button',
                ),
                "url"   => array(
                    'type'    => $companion ? 'hidden' : 'text',
                    'label'   => esc_attr__('Link', 'mesmerize'),
                    'default' => '#',
                ),

                "target" => array(
                    'type'    => 'hidden',
                    'label'   => esc_attr__('Target', 'mesmerize'),
                    'default' => '_self',
                ),

                "class" => array(
                    'type'    => 'hidden',
                    'label'   => esc_attr__('Class', 'mesmerize'),
                    'default' => 'button big ',
                ),
            )),
        )
    );
}


add_action("mesmerize_print_header_content", function() {
    $enabled = get_theme_mod("header_content_show_buttons", true);
    
    if ($enabled) {
        echo '<div class="header-buttons-wrapper">';
        
        $default = array(
            array(
                'label'  => 'Action Button 1',
                'url'    => '#',
                'target' => '_self',
                'class'  => 'button big color3 round',
            ),
            array(
                'label'  => 'Action Button 2',
                'url'    => '#',
                'target' => '_self',
                'class'  => 'button big white round outline',
            ),
        );

        if (!current_user_can('edit_theme_options')) {
            $default = array();
        }

        mesmerize_print_buttons_list("header_content_buttons", $default);
        echo '</div>';
    }

}, 1);



/*
    template functions
*/

    
function mesmerize_buttons_list_item_mods_attr($index, $setting)
{
    $item_mods = mesmerize_buttons_list_item_mods($index, $setting);
    $result    = "data-theme='{$item_mods['mod']}'";

    foreach ($item_mods['atts'] as $key => $value) {
        $result .= " data-theme-{$key}='{$value}'";
    }

    $result .= " data-dynamic-mod='true'";

    return $result;
}

function mesmerize_print_buttons_list($setting, $default = array())
{
    $buttons = get_theme_mod($setting, $default);

    foreach ($buttons as $index => $button) {
        $button = apply_filters('mesmerize_print_buttons_list_button', $button, $setting, $index);

        $title  = $button['label'];
        $url    = $button['url'];
        $target = $button['target'];
        $class  = $button['class'];

        if (current_user_can('edit_theme_options')) {
            if (empty($title)) {
                $title = __('Action button 1', 'mesmerize');
            }
        }

        if (is_customize_preview()) {
            $mod_attr   = mesmerize_buttons_list_item_mods_attr($index, $setting);
            $btn_string = '<a class="%4$s" target="%3$s" href="%1$s" ' . $mod_attr . ' >%2$s</a>';
            printf($btn_string, esc_url($url), wp_kses_post($title), $target, $class);
        } else {
            printf('<a class="%4$s" target="%3$s" href="%1$s">%2$s</a>', esc_url($url), wp_kses_post($title), $target, $class);
        }
    }
}

function mesmerize_buttons_list_item_mods($index, $setting)
{
    $result = array(
        "type" => 'data-theme',
        "mod"  => "{$setting}|$index|label",
        "atts" => array(
            "href"   => "{$setting}|{$index}|url",
            "target" => "{$setting}|{$index}|target",
            "class"  => "{$setting}|{$index}|class",
        ),
    );

    return $result;
}

add_filter('mesmerize_print_buttons_list_button', function ($button, $setting, $index) {
    if ($setting === "header_content_buttons") {
        $companion = apply_filters('mesmerize_is_companion_installed', false);

        if ( ! $companion) {
            if ($index === 0) {
                $button['class'] = 'button big color3 round';
            }

            if ($index === 1) {
                $button['class'] = 'button big white round outline';
            }
        }
    }

    return $button;

}, 10, 3);