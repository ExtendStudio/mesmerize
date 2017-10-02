<?php

require_once get_template_directory() . "/inc/header-options/navigation-options/top-bar.php";
require_once get_template_directory() . "/inc/header-options/navigation-options/nav-bar.php";


add_action('mesmerize_add_sections', function ($wp_customize) {
    $sections = array(
        'navigation_top_bar'    => __('Top Bar', 'mesmerize'),
        'front_page_navigation' => __('Front Page Navigation', 'mesmerize'),
        'front_page_navigation' => __('Front Page Navigation', 'mesmerize'),
        'inner_page_navigation' => __('Inner Page Navigation', 'mesmerize')
    );

    foreach ($sections as $id => $title) {
        $wp_customize->add_section($id, array(
            'title' => $title,
            'panel' => 'navigation_panel',
        ));
    }

});