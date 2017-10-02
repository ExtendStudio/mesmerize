<?php

require_once get_template_directory() . "/inc/header-options/content-options/content-type.php";
require_once get_template_directory() . "/inc/header-options/content-options/inner-pages.php";
require_once get_template_directory() . "/inc/header-options/content-options/title.php";
require_once get_template_directory() . "/inc/header-options/content-options/subtitle.php";
require_once get_template_directory() . "/inc/header-options/content-options/buttons.php";



add_action("mesmerize_customize_register_options", function() {
    mesmerize_add_options_group(array(
        "mesmerize_front_page_header_title_options" => array(
            // section, prefix, priority
          "header_background_chooser", "header", 6
        ),
        "mesmerize_front_page_header_subtitle_options" => array(
          "header_background_chooser", "header", 6
        ),
        "mesmerize_front_page_header_buttons_options" => array(
          "header_background_chooser", "header", 6
        ),

        "mesmerize_front_page_header_content_options" => array(
          "header_background_chooser", "header", 5
        ),

        "mesmerize_inner_pages_header_content_options" => array(
          "header_image", "inner_header", 9
        )
    ));
});



if ( ! function_exists("mesmerize_print_header_content")) {
    function mesmerize_print_header_content()
    {
        do_action("mesmerize_print_header_content");
    }
}

function mesmerize_get_front_page_header_media_and_partial()
{
    $partial   = get_theme_mod('header_content_partial', "media-on-right");
    $mediaType = get_theme_mod('header_content_media', 'image');

    switch ($partial) {
        case "image-on-left":
            $partial   = 'media-on-left';
            $mediaType = 'image';
            break;
        case "image-on-right":
            $partial   = 'media-on-right';
            $mediaType = 'image';
            break;
    }

    return array(
        'partial' => $partial,
        'media'   => $mediaType,
    );

}

function mesmerize_print_front_page_header_content()
{
    $headerContent = mesmerize_get_front_page_header_media_and_partial();
    $partial       = $headerContent['partial'];
    $classes       = apply_filters('mesmerize_header_description_classes', $partial);

    do_action('mesmerize_before_front_page_header_content');

    ?>

    <div class="header-description gridContainer <?php echo esc_attr($classes); ?>">
        <?php get_template_part('template-parts/header/hero', $partial); ?>
    </div>

    <?php

    do_action('mesmerize_after_front_page_header_content');
}

add_action("mesmerize_print_header_media", function($mediaType){
    if ($mediaType == "image") {
        $roundImage   = get_theme_mod('header_content_image_rounded', false);
        $extraClasses = "";
        if (intval($roundImage)) {
            $extraClasses .= " round";
        }

        $image = get_theme_mod('header_content_image', get_template_directory_uri() . "/assets/images/iMac.png");
        if ( ! empty($image)) {
            printf('<img class="homepage-header-image %2$s" src="%1$s"/>', esc_url($image), $extraClasses);
        }
    }
  });

if ( ! function_exists('mesmerize_print_header_media')) {
    function mesmerize_print_header_media()
    {
        $headerContent = mesmerize_get_front_page_header_media_and_partial();
        $mediaType     = $headerContent['media'];

        do_action('mesmerize_print_header_media', $mediaType);
      
    }
}