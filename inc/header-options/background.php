<?php

require_once get_template_directory() . "/inc/header-options/background-options/background-type.php";
require_once get_template_directory() . "/inc/header-options/background-options/overlay-type.php";
require_once get_template_directory() . "/inc/header-options/background-options/header-separator.php";
require_once get_template_directory() . "/inc/header-options/background-options/general.php";

function mesmerize_header_background_settings($inner)
{
    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";
    
    $group = "{$prefix}_bg_options_group_button";

    $priority = 1;
    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Background', 'mesmerize'),
        'section'  => $section,
        'priority' =>  $priority,
        'settings' => $prefix . "_header_1"
    ));

    do_action("mesmerize_header_background_settings", $section, $prefix, $group, $inner, $priority);
}


add_action("mesmerize_customize_register_options", function() {
    mesmerize_header_background_settings(false);
    mesmerize_header_background_settings(true);
});

