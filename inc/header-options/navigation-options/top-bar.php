<?php

mesmerize_require("/inc/header-options/navigation-options/top-bar/content-areas.php");

add_action("mesmerize_customize_register_options", function() {
    mesmerize_add_options_group(array(
        "mesmerize_top_bar_options" => array(
           // section
          "navigation_top_bar"
        )
    ));
});

function mesmerize_top_bar_options($section)
{
    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Top Bar Display', 'mesmerize'),
        'section'  => $section,
        'settings' => "top_bar_display_separator",
        'priority' => 0,
    ));

    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'label'    => __('Show Top Bar', 'mesmerize'),
        'section'  => $section,
        'priority' => 0,
        'settings' => "enable_top_bar",
        'default'  => true,
    ));
}


function mesmerize_print_top_bar_area($areaName, $default = "info")
{

    $to_print = get_theme_mod("header_top_bar_{$areaName}_content", $default);
    ?>
    <div class="header-top-bar-area <?php echo esc_attr($areaName); ?>">
        <?php
            do_action("header_top_bar_content_print", $areaName, $to_print);
        ?>
    </div>
    <?php
}

function mesmerize_print_header_top_bar()
{
    $inner   = mesmerize_is_inner();
    $enabled = get_theme_mod('enable_top_bar', true);

    $classes = array();
    $prefix  = $inner ? "inner_header" : "header";

    if (get_theme_mod("{$prefix}_nav_boxed", false)) {
        $classes[] = "gridContainer";
    }

    if ($enabled) {
       
        $header_top_bar_class = apply_filters('header_top_bar_class', '');
        ?>
        <div class="header-top-bar <?php echo $header_top_bar_class; ?>">
            <div class="<?php echo implode(' ', $classes); ?>">
                <?php mesmerize_print_top_bar_area('area-left', 'info') ?>
                <?php mesmerize_print_top_bar_area('area-right', 'social') ?>
            </div>
        </div>
        <?php
    }

}