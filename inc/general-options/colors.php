<?php

function mesmerize_get_default_colors()
{
    return array(
        array("label" => "Primary", "name" => "color1", "value" => "#03a9f4"),
        array("label" => "Secondary", "name" => "color2", "value" => "#ff8c00"),
        array("label" => "color3", "name" => "color3", "value" => "#fbc02d"),
        array("label" => "color4", "name" => "color4", "value" => "#8c239f"),
        array("label" => "color5", "name" => "color5", "value" => "#4caf50"),
    );
}


function mesmerize_get_theme_colors($color = false)
{
    $colors = apply_filters("mesmerize_get_theme_colors", mesmerize_get_default_colors(), $color);

    if ($color) {
        global $mesmerize_cached_colors;

        if ( ! $mesmerize_cached_colors) {

            $mesmerize_cached_colors = array();

            foreach ($colors as $colorData) {
                $mesmerize_cached_colors[$colorData['name']] = $colorData['value'];
            }
        }


        if (isset($mesmerize_cached_colors[$color])) {
            return $mesmerize_cached_colors[$color];
        } else {
            return "{$color} not found";
        }

    }

    return $colors;
}