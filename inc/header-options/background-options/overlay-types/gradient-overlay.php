<?php


add_action("mesmerize_header_background_overlay_settings", function($section, $prefix, $group, $inner, $priority) {  
    mesmerize_add_kirki_field(array(
        'type'            => 'gradient-control',
        'label'           => __('Gradient', 'mesmerize'),
        'section'         => $section,
        'settings'        => $prefix . '_overlay_gradient_colors',
        'default'         => json_encode(array(
            'colors' => array(
                array("color" => "#ffffff", "position" => "0%"),
                array("color" => "#ffffff", "position" => "100%"),
            ),
            'angle'  => "0",
        )),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_overlay_type',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'priority'        => $priority,
        'transport'       => 'postMessage',
        'group' => $group
    ));
}, 1, 5);

function mesmerize_get_gradient_value($colors, $angle)
{
    $angle    = intval($angle);
    $gradient = "{$angle}deg , {$colors[0]['color']} 0%, {$colors[1]['color']} 100%";
    $gradient = 'linear-gradient(' . $gradient . ')';

    return $gradient;
}

// print gradient overlay option
add_action('wp_head', function () {
    $type = get_theme_mod('header_overlay_type', "color");
    if ($type != "gradient") {
        return;
    }

    $colors = get_theme_mod('header_overlay_gradient_colors', "");
    $colors = json_decode($colors, true);

    $gradient = mesmerize_get_gradient_value($colors['colors'], $colors['angle']);


    ?>
    <style data-name="header-gradient-overlay">
        .background-overlay {
            background: <?php echo $gradient; ?>;
        }
    </style>
    <?php
});