<?php

add_action("mesmerize_customize_register_options", function() {
    mesmerize_navigation_general_options(false);
    mesmerize_navigation_general_options(true);
});


function mesmerize_navigation_general_options($inner = false)
{
    $priority = 1;
    $section  = $inner ? "inner_page_navigation" : "front_page_navigation";
    $prefix   = $inner ? "inner_header" : "header";

    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => $inner ? __('Inner Pages Navigation options', 'mesmerize') : __('Front Page Navigation options', 'mesmerize'),
        'settings' => "{$prefix}_nav_separator",
        'section'  => $section,
        'priority' => $priority,
    ));
    
    mesmerize_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => __('Stick to top', 'mesmerize'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_sticked",
        'default'   => true,
        'transport' => 'refresh',
    ));

    mesmerize_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => __('Boxed Navigation', 'mesmerize'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_boxed",
        'default'   => false,
        'transport' => 'refresh',
    ));


    mesmerize_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => __('Show Navigation Bottom Border', 'mesmerize'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_border",
        'default'   => false,
        'transport' => 'refresh',
    ));
      
    mesmerize_add_kirki_field(array(
        'type'      => 'checkbox',
        'label'     => __('Transparent Nav Bar', 'mesmerize'),
        'section'   => $section,
        'priority'  => $priority,
        'settings'  => "{$prefix}_nav_transparent",
        'default'   => true,
        'transport' => 'postMessage',
    ));
}




/*
    template functions
*/

function mesmerize_print_offscreen_social_icons()
{
    $prefix  = "header_offscreen_nav";
    $area    = "offscreen_nav";
    $enabled = get_theme_mod("{$prefix}_show_social", true);

    if ( ! intval($enabled)) {
        return;
    }

    mesmerize_print_area_social_icons($prefix, $area);
}

function mesmerize_get_offcanvas_primary_menu()
{
    ?>
    <a href="#" data-component="offcanvas" data-target="#offcanvas-wrapper" data-direction="right" data-width="300px" data-push="false">
        <div class="bubble"></div>
        <i class="fa fa-bars"></i>
    </a>
    <div id="offcanvas-wrapper" class="hide force-hide  offcanvas-right">
        <div class="offcanvas-top">
            <div class="logo-holder">
                <?php mesmerize_print_logo(); ?>
            </div>
        </div>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'offcanvas_menu',
            'menu_class'     => 'offcanvas_menu',
            'container_id'   => 'offcanvas-menu',
            'fallback_cb'    => 'mesmerize_no_hamburdegr_menu_cb',
        ));
        ?>

        <?php mesmerize_print_offscreen_social_icons(); ?>
    </div>
    <?php
}


function mesmerize_print_primary_menu($walker = '', $fallback = 'mesmerize_nomenu_cb')
{

    $drop_down_menu_classes = apply_filters('mesmerize_primary_drop_menu_classes', array('default'));
    $drop_down_menu_classes = array_merge($drop_down_menu_classes, array('main-menu', 'dropdown-menu'));
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_id'        => 'main_menu',
        'menu_class'     => esc_attr(implode(" ", $drop_down_menu_classes)),
        'container_id'   => 'mainmenu_container',
        'fallback_cb'    => $fallback,
        'walker'         => $walker,
    ));

    mesmerize_get_offcanvas_primary_menu();
}


// sticky navigation
function mesmerize_navigation_sticky_attrs()
{
    $inner = mesmerize_is_inner();
    $atts  = array(
        "data-sticky"        => 0,
        "data-sticky-mobile" => 1,
        "data-sticky-to"     => "top",
    );

    $atts   = apply_filters("mesmerize_navigation_sticky_attrs", $atts);
    $prefix = $inner ? "inner_header" : "header";

    $result = "";
    if (get_theme_mod("{$prefix}_nav_sticked", true)) {
        foreach ($atts as $key => $value) {
            $result .= " {$key}='{$value}' ";
        }
    } else {
        //$result = 'style="position:absolute;z-index: 1;"';
    }

    echo $result;
}

function mesmerize_navigation_wrapper_class()
{
    $inner   = mesmerize_is_inner();
    $classes = array();

    $prefix = $inner ? "inner_header" : "header";

    if (get_theme_mod("{$prefix}_nav_boxed", false)) {
        $classes[] = "gridContainer";
    }

    echo implode(" ", $classes);
}