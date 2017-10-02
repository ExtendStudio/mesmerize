<?php

add_action('customize_register', 'mesmerize_customize_register', 10, 1);
add_action('customize_register', 'mesmerize_customize_reorganize', PHP_INT_MAX, 1);

require_once get_template_directory() . "/inc/general-options.php";
require_once get_template_directory() . "/inc/header-options.php";
require_once get_template_directory() . "/inc/footer-options.php";


function mesmerize_add_options_group($options) {
    foreach ($options as $option  => $args) {
        do_action_ref_array($option."_before", $args);
        call_user_func_array($option, $args);
        do_action_ref_array($option."_after", $args);
    }
}
function mesmerize_customize_register($wp_customize)
{

    mesmerize_customize_register_controls($wp_customize);

    do_action('mesmerize_customize_register', $wp_customize);
}

function mesmerize_add_sections($wp_customize)
{

    $wp_customize->add_panel('navigation_panel',
        array(
            'priority'       => 2,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Navigation', 'mesmerize'),
            'description'    => '',
        )
    );

    $wp_customize->add_panel('header',
        array(
            'priority'       => 2,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Hero', 'mesmerize'),
            'description'    => '',
        )
    );

    $wp_customize->add_section('page_content', array(
        'priority' => 2,
        'title'    => __('Front Page content', 'mesmerize'),
    ));

	$wp_customize->add_panel( 'footer',
		array(
			'priority'       => 3,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Footer', 'mesmerize' ),
			'description'    => '',
		)
	);

    $wp_customize->add_panel('general_settings', array(
        'title'    => __('General Settings', 'mesmerize'),
        'priority' => 4,
    ));

    do_action('mesmerize_add_sections', $wp_customize);

    $sections = array(

        'header_background_chooser' => array(
            'title' => __('Front Page Hero', 'mesmerize'),
            'panel' => 'header',
        ),

        'header_content' => array(
            'title' => __('Front Page Hero Content', 'mesmerize'),
            'panel' => 'header',
        ),



        'header_image' => array(
            'title' => __('Inner Pages Hero', 'mesmerize'),
            'panel' => 'header',
        ),





		'footer_content' => array(
			'title' => __( 'Footer Content', 'mesmerize' ),
			'panel' => 'footer',
		),
	);

    foreach ($sections as $name => $value) {
        $wp_customize->add_section($name, $value);
    }

}

function mesmerize_customize_register_controls($wp_customize)
{
    $wp_customize->register_control_type('Mesmerize\Kirki_Controls_Separator_Control');
    $wp_customize->register_control_type("\\Mesmerize\\WebGradientsControl");
    $wp_customize->register_control_type("\\Mesmerize\\SidebarGroupButtonControl");

    // Register our custom control with Kirki
    add_filter('kirki/control_types', function ($controls) {
        $controls['sectionseparator']     = '\\Mesmerize\\Kirki_Controls_Separator_Control';
        $controls['ope-info']             = '\\Mesmerize\\Info_Control';
        $controls['ope-info-pro']         = '\\Mesmerize\\Info_PRO_Control';
        $controls['web-gradients']        = "\\Mesmerize\\WebGradientsControl";
        $controls['sidebar-button-group'] = "\\Mesmerize\\SidebarGroupButtonControl";


        return $controls;
    });

    $wp_customize->register_control_type('\Mesmerize\Kirki_Controls_Radio_HTML_Control');

    // Register our custom control with Kirki
    add_filter('kirki/control_types', function ($controls) {
        $controls['radio-html'] = '\\Mesmerize\\Kirki_Controls_Radio_HTML_Control';

        return $controls;
    });

    $wp_customize->register_control_type('\\Mesmerize\FontAwesomeIconControl');
    add_filter('kirki/control_types', function ($controls) {
        $controls['font-awesome-icon-control'] = "\\Mesmerize\\FontAwesomeIconControl";

        return $controls;
    });

    $wp_customize->register_control_type('\\Mesmerize\GradientControl');
    add_filter('kirki/control_types', function ($controls) {
        $controls['gradient-control'] = "\\Mesmerize\\GradientControl";

        return $controls;
    });

    require_once get_template_directory() . "/customizer/customizer-controls.php";
    require_once get_template_directory() . "/customizer/WebGradientsControl.php";
    require_once get_template_directory() . "/customizer/SidebarGroupButtonControl.php";

    mesmerize_add_sections($wp_customize);
    mesmerize_add_general_settings($wp_customize);
}

function mesmerize_add_general_settings($wp_customize)
{

    $wp_customize->add_setting('header_presets', array(
        'default'           => "image",
        'sanitize_callback' => 'esc_html',
        "transport"         => "postMessage",
    ));



    /* logo height */
    $wp_customize->add_setting('logo_max_height', array(
        'default'           => 70,
        'sanitize_callback' => 'sanitize_textfield',
    ));

    $wp_customize->add_control('logo_max_height', array(
        'label'    => __('Logo Max Height', 'mesmerize'),
        'section'  => 'title_tagline',
        'priority' => 8,
        'type'     => 'number',
    ));

    $wp_customize->add_setting('bold_logo', array(
        'default'           => true,
        'sanitize_callback' => 'sanitize_checkbox',
    ));
    $wp_customize->add_control('bold_logo', array(
        'label'    => __('Alternate text logo words', 'mesmerize'),
        'section'  => 'title_tagline',
        'priority' => 9,
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('logo_dark', array(
        'default'           => false,
        'sanitize_callback' => 'absint',
    ));

    $custom_logo_args = get_theme_support('custom-logo');
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'logo_dark', array(
        'label'         => __('Dark Logo', 'mesmerize'),
        'section'       => 'title_tagline',
        'priority'      => 9,
        'height'        => $custom_logo_args[0]['height'],
        'width'         => $custom_logo_args[0]['width'],
        'flex_height'   => $custom_logo_args[0]['flex-height'],
        'flex_width'    => $custom_logo_args[0]['flex-width'],
        'button_labels' => array(
            'select'       => __('Select logo', 'mesmerize'),
            'change'       => __('Change logo', 'mesmerize'),
            'remove'       => __('Remove', 'mesmerize'),
            'default'      => __('Default', 'mesmerize'),
            'placeholder'  => __('No logo selected', 'mesmerize'),
            'frame_title'  => __('Select logo', 'mesmerize'),
            'frame_button' => __('Choose logo', 'mesmerize'),
        ),
    )));
}


function mesmerize_customize_reorganize($wp_customize)
{
    $generalSettingsSections = array(
        'title_tagline',
        'colors',
        'general_site_style',
        'background_image',
        'static_front_page',
        'custom_css',
        'user_custom_widgets_areas',
        'blog_settings',
    );

    $priority = 1;
    foreach ($generalSettingsSections as $section_id) {
        $section = $wp_customize->get_section($section_id);

        if ($section) {
            $section->panel    = 'general_settings';
            $section->priority = $priority;
            $priority++;
        }

    }
}

add_action('customize_controls_enqueue_scripts', function () {

    $textDomain = mesmerize_get_text_domain();

    $cssUrl = get_template_directory_uri() . "/customizer/";
    $jsUrl  = get_template_directory_uri() . "/customizer/js/";

    wp_enqueue_style('thickbox');
    wp_enqueue_script('thickbox');

    wp_enqueue_style($textDomain . '-webgradients', get_template_directory_uri() . '/assets/css/webgradients.css');
    wp_enqueue_style($textDomain . '-customizer-base', $cssUrl . '/customizer.css');

    wp_enqueue_script($textDomain . '-customize', $jsUrl . "/customize.js", array('jquery'));
    $settings = array(
        'stylesheetURL' => get_template_directory_uri(),
        'templateURL'   => get_template_directory_uri(),
        'includesURL'   => includes_url(),
    );

    wp_localize_script($textDomain . '-customize', 'mesmerize_customize_settings', $settings);
});

add_action('customize_preview_init', function () {
    $textDomain = mesmerize_get_text_domain();

    $jsUrl = get_template_directory_uri() . "/customizer/js/";
    wp_enqueue_script($textDomain . '-customize-preview', $jsUrl . "/customize-preview.js", array('jquery', 'customize-preview'), '', true);
});


function mesmerize_get_gradients_classes()
{
    return array(
        "plum_plate",
        "ripe_malinka",
        "new_life",
        "sunny_morning"
    );
}


add_action('wp_ajax_cp_webgradients_list', function () {
    $result       = array();
    $webgradients = mesmerize_get_gradients_classes();

    foreach ($webgradients as $icon) {
        $title    = str_replace('_', ' ', $icon);
        $result[] = array(
            'id'       => $icon,
            'gradient' => $icon,
            "title"    => $title,
            'mime'     => "web-gradient/class",
            'sizes'    => null,
        );
    }


    $result = apply_filters("ope_wp_ajax_cp_webgradients_list", $result);

    echo json_encode($result);

    exit;
});

add_action('wp_ajax_cp_list_fa', function () {
    $result = array();
    $icons  = (require get_template_directory() . "/customizer/fa-icons-list.php");
    foreach ($icons as $icon) {
        $title    = str_replace('-', ' ', str_replace('fa-', '', $icon));
        $result[] = array(
            'id'    => $icon,
            'fa'    => $icon,
            "title" => $title,
            'mime'  => "fa-icon/font",
            'sizes' => null,
        );
    }

    echo json_encode($result);
    exit;

});


add_filter('body_class', function ($classes) {

    $classes[] = mesmerize_is_front_page() ? "mesmerize-front-page" : "mesmerize-inner-page";

    return $classes;
});
