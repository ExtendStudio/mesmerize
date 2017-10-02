<?php

function mesmerize_setup()
{
    global $content_width;


    if ( ! isset($content_width)) {
        $content_width = 640;
    }

    load_theme_textdomain('mesmerize', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(890, 510, true);

    register_default_headers(array(
        'homepage-image' => array(
            'url'           => '%s/assets/images/home_page_header.png',
            'thumbnail_url' => '%s/assets/images/home_page_header.png',
            'description'   => __('Homepage Header Image', 'mesmerize'),
        ),
    ));

    add_theme_support('custom-header', apply_filters('custom_header_args', array(
        'default-image' => get_template_directory_uri() . "/assets/images/home_page_header.png",
        'width'         => 1920,
        'height'        => 800,
        'flex-height'   => true,
        'flex-width'    => true,
        'header-text'   => false,
    )));

    add_theme_support('custom-logo', array(
        'flex-height' => true,
        'flex-width'  => true,
        'width'       => 150,
        'height'      => 70,
    ));

    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menus(array(
        'primary'            => __('Primary Menu', 'mesmerize'),
        'footer_menu'        => __('Footer Menu', 'mesmerize'),
        'top_bar_area-left'  => __('Top Bar Left Menu', 'mesmerize'),
        'top_bar_area-right' => __('Top Bar Right Menu', 'mesmerize'),
    ));

    include_once get_template_directory() . '/customizer/kirki/kirki.php';

    Kirki::add_config('mesmerize', array(
        'capability'  => 'edit_theme_options',
        'option_type' => 'theme_mod',
    ));

    include_once get_template_directory() . "/inc/Mesmerize_Logo_Nav_Menu.php";
    include_once get_template_directory() . "/inc/Mesmerize_Logo_Page_Menu.php";
}

add_action('after_setup_theme', 'mesmerize_setup');


function mesmerize_get_version()
{
    $theme = wp_get_theme();
    $ver   = $theme->get('Version');
    $ver   = apply_filters('mesmerize_get_version', $ver);
    return $ver;
}

function mesmerize_get_text_domain()
{
    $theme = wp_get_theme();
    return $theme->get('TextDomain');
}

function mesmerize_get_stylesheet_text_domain()
{
    $theme = wp_get_theme();
    return $theme->get('TextDomain');
}

function mesmerize_get_template_text_domain()
{
    $theme      = wp_get_theme();
    $textDomain = $theme->get('TextDomain');
    $template   = $theme->get('Template');

    if ($template) {
        $textDomain = $template;
    }

    return $textDomain;
}

function mesmerize_require($path)
{
    $path = trim($path, "\\/");
    require_once get_template_directory() . "/{$path}";
}

if ( ! class_exists("Kirki")) {
    include_once get_template_directory() . '/customizer/kirki/kirki.php';
}

mesmerize_require('/inc/templates-functions.php');
mesmerize_require('/inc/theme-options.php');
mesmerize_require('/inc/Color.php');


function mesmerize_add_kirki_field($args)
{
    Kirki::add_field('mesmerize', $args);
}

// SCRIPTS AND STYLES

function mesmerize_enqueue($type = 'style', $handle, $args = array())
{
    $theme = wp_get_theme();
    $ver   = $theme->get('Version');
    $data  = array_merge(array(
        'src'       => '',
        'deps'      => array(),
        'has_min'   => false,
        'in_footer' => true,
        'media'     => 'all',
        'ver'       => $ver,
    ), $args);

    $isScriptDebug = defined("SCRIPT_DEBUG") && SCRIPT_DEBUG;
    if ($data['has_min'] && ! $isScriptDebug) {
        if ($type === 'style') {
            $data['src'] = str_replace('.css', '.min.css', $data['src']);
        }

        if ($type === 'script') {
            $data['src'] = str_replace('.js', '.min.js', $data['src']);
        }
    }

    if ($type == 'style') {
        wp_enqueue_style($handle, $data['src'], $data['deps'], $data['ver'], $data['media']);
    }

    if ($type == 'script') {
        wp_enqueue_script($handle, $data['src'], $data['deps'], $data['ver'], $data['in_footer']);
    }

}

function mesmerize_enqueue_style($handle, $args)
{
    mesmerize_enqueue('style', $handle, $args);
}

function mesmerize_enqueue_script($handle, $args)
{
    mesmerize_enqueue('script', $handle, $args);
}


function mesmerize_do_enqueue_assets()
{

    mesmerize_enqueue_google_fonts();

    $theme      = wp_get_theme();
    $ver        = $theme->get('Version');
    $textDomain = $theme->get('TextDomain');

    mesmerize_enqueue_style(
        $textDomain . '-style',
        array(
            'src'     => get_stylesheet_directory_uri() . '/style.css',
            'has_min' => true,
        )
    );

    mesmerize_enqueue_style(
        $textDomain . '-font-awesome',
        array(
            'src' => get_template_directory_uri() . '/assets/font-awesome/font-awesome.min.css',
        )
    );

    mesmerize_enqueue_style(
        $textDomain . '-animate',
        array(
            'src'     => get_template_directory_uri() . '/assets/css/animate.css',
            'has_min' => true,
        )
    );

    mesmerize_enqueue_script(
        $textDomain . '-smoothscroll',
        array(
            'src'     => get_template_directory_uri() . '/assets/js/smoothscroll.js',
            'deps'    => array('jquery', 'jquery-effects-core'),
            'has_min' => true,
        )
    );

    mesmerize_enqueue_script(
        $textDomain . '-ddmenu',
        array(
            'src'     => get_template_directory_uri() . '/assets/js/drop_menu_selection.js',
            'deps'    => array('jquery-effects-slide', 'jquery'),
            'has_min' => true,
        )
    );

    mesmerize_enqueue_script(
        $textDomain . '-kube',
        array(
            'src'     => get_template_directory_uri() . '/assets/js/kube.js',
            'deps'    => array('jquery'),
            'has_min' => true,
        )
    );

    mesmerize_enqueue_script(
        $textDomain . '-fixto',
        array(
            'src'     => get_template_directory_uri() . '/assets/js/libs/fixto.js',
            'deps'    => array('jquery'),
            'has_min' => true,
        )
    );

    wp_enqueue_script($textDomain . '-sticky', get_template_directory_uri() . '/assets/js/sticky.js', array($textDomain . '-fixto'), $ver, true);

    mesmerize_enqueue_script(
        $textDomain . '-masonry',
        array(
            'src'     => get_template_directory_uri() . '/assets/js/masonry.js',
            'deps'    => array('jquery'),
            'has_min' => true,
        )
    );

    wp_enqueue_script('comment-reply');

    $if_front_page = (is_front_page() && ! is_home());

    $prefix = ( ! $if_front_page) ? "inner_header" : "header";

    $mesmerize_jssettings = array(
        'header_text_morph_speed' => intval(get_theme_mod('header_text_morph_speed', 200)),
        'header_text_morph'       => get_theme_mod('header_show_text_morph_animation', true),
    );

    wp_enqueue_script($textDomain . '-theme', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), $ver, true);
    wp_localize_script($textDomain . '-theme', 'settings', $mesmerize_jssettings);

    $maxheight = get_theme_mod('logo_max_height', 70);
    wp_add_inline_style($textDomain . '-style', sprintf('img.logo.dark, img.custom-logo{width:auto;max-height:%1$s;}', $maxheight . "px"));

    mesmerize_enqueue_style(
        $textDomain . '-webgradients',
        array(
            'src'     => get_template_directory_uri() . '/assets/css/webgradients.css',
            'has_min' => true,
        )
    );
}

add_action('wp_enqueue_scripts', 'mesmerize_do_enqueue_assets');

function mesmerize_enqueue_google_fonts()
{
    $gFonts = array(

        'Montserrat' => array(
            "weights" => array("normal"),
        ),

        'Muli' => array(
            "weights" => array("400", "900"),
        ),

        'Roboto' => array(
            "weights" => array("300", "500", "400", "900"),
        ),

        'Open Sans' => array(
            "weights" => array("300", "400", "900"),
        ),

    );

    $gFonts = apply_filters("mesmerize_google_fonts", $gFonts);

    foreach ($gFonts as $family => $font) {
        $fontQuery[] = $family . ":" . implode(',', $font['weights']);
    }

    $query_args = array(
        'family' => urlencode(implode('|', $fontQuery)),
        'subset' => urlencode('latin,latin-ext'),
    );

    $fontsURL = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    wp_enqueue_style('mesmerize-fonts', $fontsURL, array(), null);
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function mesmerize_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
    }
}

add_action('wp_head', 'mesmerize_pingback_header');


/**
 * Register sidebar
 */
function mesmerize_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Sidebar widget area', 'mesmerize'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widgettitle">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => "Footer First Box Widgets",
        'id'            => "first_box_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
       'before_title'  => '<h5 class="widgettitle">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => "Footer Second Box Widgets",
        'id'            => "second_box_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widgettitle">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => "Footer Third Box Widgets",
        'id'            => "third_box_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widgettitle">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => "Footer Newsletter Subscriber",
        'id'            => "newsletter_subscriber_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widgettitle">',
        'after_title'   => '</h5>',
    ));
}

add_action('widgets_init', 'mesmerize_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Read more' link.
 *
 * @return string '... Read more'
 */
function mesmerize_excerpt_more($more)
{
    return '&hellip; <br> <a class="read-more" href="' . esc_url(get_permalink(get_the_ID())) . '">' . __('Read more', 'mesmerize') . '</a>';
}

add_filter('excerpt_more', 'mesmerize_excerpt_more');

// UTILS


function mesmerize_nomenu_fallback($walker = '')
{
    $drop_down_menu_classes = apply_filters('mesmerize_primary_drop_menu_classes', array('default'));
    $drop_down_menu_classes = array_merge($drop_down_menu_classes, array('main-menu', 'dropdown-menu'));


    return wp_page_menu(array(
        "menu_class" => esc_attr(implode(" ", $drop_down_menu_classes)),
        "menu_id"    => 'mainmenu_container',
        'before'     => '<ul id="main_menu" class="' . esc_attr(implode(" ", $drop_down_menu_classes)) . '">',
        'walker'     => $walker,
    ));
}


function mesmerize_nomenu_cb()
{
    return mesmerize_nomenu_fallback('');
}


function mesmerize_no_menu_logo_inside_cb()
{
    mesmerize_nomenu_fallback(new Mesmerize_Logo_Page_Menu());
}

function mesmerize_no_hamburdegr_menu_cb()
{
    return wp_page_menu(array(
        "menu_class" => 'offcanvas_menu',
        "menu_id"    => 'offcanvas_menu',
        'before'     => '<ul id="offcanvas_menu" class="offcanvas_menu">',
    ));
}

function mesmerize_no_footer_menu_cb()
{
    return wp_page_menu(array(
        "menu_class" => 'fm2_horizontal_footer_menu',
        "menu_id"    => 'horizontal_main_footer_container',
        'before'     => '<ul id="horizontal_footer_menu" class="fm2_horizontal_footer_menu">',
    ));
}

function mesmerize_title()
{
    $title = array(
        'title' => '',
    );

    if (is_404()) {
        $title['title'] = __('Page not found', 'mesmerize');
    } else if (is_search()) {
        $title['title'] = sprintf(__('Search Results for &#8220;%s&#8221;', 'mesmerize'), get_search_query());
    } else if (is_home()) {
        if (is_front_page()) {
            $title['title'] = get_bloginfo('name');
        } else {
            $title['title'] = single_post_title();
        }
    } else if (is_archive()) {
        $title['title'] = get_the_archive_title();
    } else if (is_single()) {
        $title['title'] = get_bloginfo('name');

        global $post;
        if ($post) {
            $title['title'] = apply_filters('single_post_title', $post->post_title, $post);
        }
    } else {
        $title['title'] = get_the_title();
    }

    $value = apply_filters('header_title', $title['title']);

    return $value;
}

function mesmerize_apply_header_text_effects($text)
{
    if (is_customize_preview()) {
        return $text;
    }

    $matches = array();

    preg_match_all('/\{([^\}]+)\}/i', $text, $matches);

    $alternative_texts = get_theme_mod("header_text_morph_alternatives", "");
    $alternative_texts = preg_split("/[\r\n]+/", $alternative_texts);

    for ($i = 0; $i < count($matches[1]); $i++) {
        $orig    = $matches[0][$i];
        $str     = $matches[1][$i];
        $strings = explode("|", $str);
        if (count($alternative_texts)) {
            $str = json_encode(array_merge($strings, $alternative_texts));
        }
        $text = str_replace($orig, '<span data-text-effect="' . esc_attr($str) . '">' . $strings[0] . '</span>', $text);
    }

    return $text;
}

function mesmerize_bold_text($str)
{
    $bold = get_theme_mod('bold_logo', true);

    if ( ! $bold) {
        return $str;
    }

    $str   = trim($str);
    $words = preg_split("/(?<=[a-z])(?=[A-Z])|(?=[\s]+)/x", $str);

    $result = "";
    $c      = 0;
    for ($i = 0; $i < count($words); $i++) {
        $word = $words[$i];
        if (preg_match("/^\s*$/", $word)) {
            $result .= $words[$i];
        } else {
            $c++;
            if ($c % 2) {
                $result .= $words[$i];
            } else {
                $result .= '<span style="font-weight: 300;" class="span12">' . $words[$i] . "</span>";
            }
        }
    }

    return $result;
}


function mesmerize_sanitize_checkbox($val)
{
    return (isset($val) && $val == true ? true : false);
}

function mesmerize_sanitize_textfield($val)
{
    return wp_kses_post(force_balance_tags($val));
}

if ( ! function_exists('mesmerize_post_type_is')) {
    function mesmerize_post_type_is($type)
    {
        global $wp_query;

        $post_type = $wp_query->query_vars['post_type'] ? $wp_query->query_vars['post_type'] : 'post';

        if ( ! is_array($type)) {
            $type = array($type);
        }

        return in_array($post_type, $type);
    }
}


//////////////////////////////////////////////////////////////////////////////////////

function mesmerize_background()
{
    $inner = mesmerize_is_inner();
    $attrs = array(
        'class' => $inner ? "header " : "header-homepage ",
    );

    $prefix = $inner ? "inner_header" : "header";
    $bgType = get_theme_mod($prefix . '_background_type', 'gradient');

    $header_type = $inner ? "inner_header" : "header";

    $show_overlay = get_theme_mod("" . $header_type . "_show_overlay", true);
    if ($show_overlay) {
        $attrs['class'] .= " color-overlay ";
    }

    do_action("mesmerize_background", $bgType, $inner, $prefix);

    switch ($bgType) {

        case 'image':
            $bgImage        = $inner ? get_header_image() : get_theme_mod($prefix . '_front_page_image', get_template_directory_uri() . "/assets/images/home_page_header.png");
            $attrs['style'] = 'background-image:url("' . esc_url($bgImage) . '")';
            $parallax       = get_theme_mod("" . $header_type . "_parallax", true);
            if ($parallax) {
                $attrs['data-parallax-depth'] = "20";
            }
            break;

        case 'gradient':
            $bgGradient     = get_theme_mod($prefix . "_gradient", "plum_plate");
            $attrs['class'] .= $bgGradient;
            break;
    }


    $result = "";

    if ( ! isset($attrs['style'])) {
        $attrs['style'] = "";
    } else {
        $attrs['style'] .= ";";
    }

    if ( ! $inner) {
        $full_height_header    = get_theme_mod('full_height_header', false);
        $css_full_height_value = "";
        if ($full_height_header) {
            $css_full_height_value = "100vh";
        }

        $attrs['style'] .= " min-height:" . $full_height_header;
    }

    $attrs = apply_filters('mesmerize_header_background_atts', $attrs, $bgType, $inner);

    foreach ($attrs as $key => $value) {
        $value  = trim(esc_attr($value));
        $result .= " {$key}='{$value}'";
    }

    return $result;
}

function mesmerize_footer_background($footer_class)
{
    $attrs = array(
        'class' => $footer_class . " ",
    );

    $bgType = get_theme_mod('footer_background_type', 'none');
    $theme  = wp_get_theme();

    $show_overlay = get_theme_mod("footer_show_overlay", true);
    if ($show_overlay) {
        $overlay_type = get_theme_mod("footer_overlay_type", "color");
        if ($overlay_type !== 'none') {
            $attrs['class'] .= " color-overlay ";
        }
    }

    switch ($bgType) {
        case 'none':
            break;
        case 'image':
            $bgImage        = get_theme_mod('footer_image', get_template_directory_uri() . "/assets/images/home_page_header.png");
            $attrs['style'] = 'background-image:url("' . esc_url($bgImage) . '")';
            break;

        case 'gradient':
            $bgGradient     = get_theme_mod("footer_gradient", "plum_plate");
            $attrs['class'] .= $bgGradient;
            break;
    }

    $result = "";

    if ( ! isset($attrs['style'])) {
        $attrs['style'] = "";
    } else {
        $attrs['style'] .= ";";
    }

    $attrs = apply_filters('footer_background_atts', $attrs, $bgType, false);

    foreach ($attrs as $key => $value) {
        $value  = trim(esc_attr($value));
        $result .= " {$key}='{$value}'";
    }

    return $result;
}


function mesmerize_instantiate_widget($widget, $args = array())
{

    ob_start();
    the_widget($widget, array(), $args);
    $content = ob_get_contents();
    ob_end_clean();

    if (isset($args['wrap_tag'])) {
        $tag     = $args['wrap_tag'];
        $class   = isset($args['wrap_class']) ? $args['wrap_class'] : "";
        $content = "<{$tag} class='{$class}'>{$content}</{$tag}>";
    }

    return $content;

}