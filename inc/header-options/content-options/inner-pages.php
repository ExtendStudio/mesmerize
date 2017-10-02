<?php

function mesmerize_inner_pages_header_content_options($section, $prefix, $priority)
{
   
    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => __('Content', 'mesmerize'),
        'section'  => $section,
        'settings' => "inner_header_content_options_separator",
        'priority' => $priority,
    ));


    mesmerize_add_kirki_field(array(
        'type'     => 'radio-buttonset',
        'label'    => __('Text Align', 'mesmerize'),
        'section'  => $section,
        'settings' => 'inner_header_text_align',
        'default'  => "center",
        'priority' => $priority,
        "choices"  => array(
            "left"   => __("Left", "mesmerize"),
            "center" => __("Center", "mesmerize"),
            "right"  => __("Right", "mesmerize"),
        ),

        "output" => array(
            array(
                "element"     => ".inner-header-description",
                "property"    => "text-align",
                "suffix"      => "!important",
                "media_query" => "@media only screen and (min-width: 768px)",
            ),

        ),

        'transport' => 'postMessage',

        'js_vars' => array(
            array(
                'element'  => ".inner-header-description",
                'function' => 'css',
                "suffix"   => "!important",
                'property' => 'text-align',
            ),
        ),
    ));


   

    mesmerize_add_kirki_field(array(






        'type'     => 'spacing',
        'label'    => __('Content Spacing', 'mesmerize'),
        'section'  => $section,
        'settings' => 'inner_header_spacing',

        'default' => array(
            "top"    => "17%",
            "bottom" => "12%",
        ),

        "output" => array(
            array(
                "element"  => ".inner-header-description",
                "property" => "padding",
                'suffix'   => ' !important',
            ),
        ),

        'transport' => 'postMessage',

        'js_vars'  => array(
            array(
                "element"  => ".inner-header-description",
                'function' => 'css',
                'property' => 'padding',
                'suffix'   => ' !important',
            ),
        ),
        'priority' => $priority + 1,
    ));


     mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'inner_header_show_subtitle',
        'label'    => __('Show subtitle (blog description)', 'mesmerize'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority,
    ));
}





/*
    template functions
*/


function mesmerize_print_inner_pages_header_content()
{
    ?>
    <div class="col-xs col-xs-12">
        <h1 class="hero-title">
            <?php echo mesmerize_title(); ?>
        </h1>
        <?php
        $show_subtitle = get_theme_mod('inner_header_show_subtitle', true);
        if ($show_subtitle && mesmerize_post_type_is(array('post', 'attachment'))):
            ?>
            <p class="header-subtitle"><?php echo esc_html(get_bloginfo('description')); ?></p>
        <?php endif; ?>
    </div>
    <?php

}


