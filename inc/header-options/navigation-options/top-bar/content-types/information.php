<?php


add_filter("mesmerize_get_content_types", function($types) {
    $types['info'] = __("Information Fields", 'mesmerize');
    return $types;
});

add_filter("mesmerize_get_content_types_options", function($options) {
    $options['info'] = "mesmerize_top_bar_information_fields_options";
    return $options;
});

function mesmerize_top_bar_information_fields_options($area, $section, $priority, $prefix)
{

    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Information fields icons', 'mesmerize'),
        'section'  => $section,
        'priority' => $priority,
        'settings' => "{$prefix}_info_fields_icons_separator",
    ));

    
    $mesmerize_top_bar_fields_defaults = array(
        array(
            "icon" => "fa-map-marker",
            "text" => __("Location,TX 75035,USA", 'mesmerize'),
        ),

        array(
            "icon" => "fa-phone",
            "text" => __("+1234567890", 'mesmerize'),
        ),

        array(
            "icon" => "fa-envelope",
            "text" => __("info@yourmail.com", 'mesmerize')
        ),
    );

    $group_choices                     = array(
        "{$prefix}_info_fields_colors_separator",
        "{$prefix}_information_fields_text_color",
        "{$prefix}_information_fields_icon_color",
        "{$prefix}_info_fields_icons_separator",
    );

    for ($i = 0; $i < 3; $i++) {
        mesmerize_add_kirki_field(array(
            'type'     => 'checkbox',
            'label'    => sprintf(__('Show Field %d', 'mesmerize'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'settings' => "{$prefix}_info_field_{$i}_enabled",
            'default'  => true,
        ));

        $group_choices[] = "{$prefix}_info_field_{$i}_enabled";

        mesmerize_add_kirki_field(array(
            'type'     => 'font-awesome-icon-control',
            'settings' => "{$prefix}_info_field_{$i}_icon",
            'label'    => sprintf(__('Field %d icon', 'mesmerize'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'default'  => $mesmerize_top_bar_fields_defaults[$i]['icon'],

        ));

        $group_choices[] = "{$prefix}_info_field_{$i}_icon";

        mesmerize_add_kirki_field(array(
            'type'     => 'text',
            'settings' => "{$prefix}_info_field_{$i}_text",
            'label'    => sprintf(__('Field %d text', 'mesmerize'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'default'  => $mesmerize_top_bar_fields_defaults[$i]['text'],
        ));

        $group_choices[] = "{$prefix}_info_field_{$i}_text";
    }


    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => "{$prefix}_info_fields_group_button",
        'label'           => esc_html__('Info Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => $group_choices,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_content",
                'operator' => '==',
                'value'    => 'info',
            ),
            array(
                'setting'  => "enable_top_bar",
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

}




/*
    template functions
*/



add_filter("header_top_bar_content_print", function($areaName, $type) {
    if ($type == 'info') {
        mesmerize_print_header_top_bar_info_fields($areaName);
    }
}, 1, 2);


function mesmerize_print_header_top_bar_info_fields($area)
{
    $fields_number = 3;

    $defaults = array(
        array(
            "icon" => "fa-map-marker",
            "text" => "Location,TX 75035,USA",
        ),

        array(
            "icon" => "fa-phone",
            "text" => "+1234567890",
        ),

        array(
            "icon" => "fa-envelope",
            "text" => "info@yourmail.com",
        ),
    );

    for ($i = 0; $i < $fields_number; $i++) {
        $is_enabled = get_theme_mod("header_top_bar_{$area}_info_field_{$i}_enabled", true);
        $icon       = get_theme_mod("header_top_bar_{$area}_info_field_{$i}_icon", $defaults[$i]['icon']);
        $text       = get_theme_mod("header_top_bar_{$area}_info_field_{$i}_text", $defaults[$i]['text']);

        if ( ! intval($is_enabled)) {
            continue;
        }

        ?>
        <div class="top-bar-field">
            <i class="fa <?php echo esc_attr($icon) ?>"></i>
            <span><?php echo esc_html($text); ?></span>
        </div>
        <?php

    }

}

