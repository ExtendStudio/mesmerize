<?php

function mesmerize_get_footer_shapes_overlay($asControlOptions = true)
{
    $shapes = array(
        'circles'                => array(
            'label' => __('Circles', 'mesmerize'),
            'tile'  => false,
        ),
        'circles-2'              => array(
            'label' => __('Circles 2', 'mesmerize'),
            'tile'  => false,
        ),
        'circles-3'              => array(
            'label' => __('Circles 3', 'mesmerize'),
            'tile'  => false,
        ),
        'circles-gradient'       => array(
            'label' => __('Circles Gradient', 'mesmerize'),
            'tile'  => false,
        ),
        'circles-white-gradient' => array(
            'label' => __('Circles White Gradient', 'mesmerize'),
            'tile'  => false,
        ),
        'waves'                  => array(
            'label' => __('Waves', 'mesmerize'),
            'tile'  => false,
        ),
        'waves-inverted'         => array(
            'label' => __('Waves Inverted', 'mesmerize'),
            'tile'  => false,
        ),
        'dots'                   => array(
            'label' => __('Dots', 'mesmerize'),
            'tile'  => true,
        ),
        'left-tilted-lines'      => array(
            'label' => __('Left tilted lines', 'mesmerize'),
            'tile'  => true,
        ),
        'right-tilted-lines'     => array(
            'label' => __('Right tilted lines', 'mesmerize'),
            'tile'  => true,
        ),
        'right-tilted-strips'     => array(
            'label' => __('Right tilted strips', 'mesmerize'),
            'tile'  => false,
        ),
    );

    $result = array(
        "none" => __('None', 'mesmerize'),
    );

    foreach ($shapes as $shape => $data) {
        $label  = $data['label'];
        $isTile = $data['tile'];
        $url    = get_template_directory_uri() . "/assets/images/header-shapes/{$shape}.png";

        if ($asControlOptions) {
            $value = "url({$url})";

            if ($isTile) {
                $value .= " top left repeat";
            } else {
                $value .= " center center/ cover no-repeat";
            }

            $result[$value] = $label;
        } else {
            $result[$shape] = array(
                'url'   => $url,
                'label' => $label,
                'tile'  => $isTile,
            );
        }

    }

    return $result;

}

require_once get_template_directory() . "/inc/footer-options/content.php";
