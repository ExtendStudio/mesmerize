<?php
//HEADER

function mesmerize_get_current_template()
{
    global $template;

    $current_template = str_replace("\\", "/", $template);
    $pathParts        = explode("/", $current_template);
    $current_template = array_pop($pathParts);

    return $current_template;
}

function mesmerize_is_page_template()
{

    $templates   = wp_get_theme()->get_page_templates();
    $templates   = array_keys($templates);
    $templates[] = "woocommerce.php";

    $current_template = mesmerize_get_current_template();

    foreach ($templates as $_template) {
        if ($_template === $current_template) {
            return true;
        }

    }

    return false;

}

function mesmerize_is_front_page()
{
    $is_front_page = (is_front_page() && ! is_home());

    return $is_front_page;
}

function mesmerize_is_inner_page()
{
    global $post;

    return ($post && $post->post_type === "page" && ! mesmerize_is_front_page());
}

function mesmerize_is_inner()
{

    return ! mesmerize_is_front_page();
}

function mesmerize_page_content_wrapper_class()
{

    $class = array('gridContainer');
    $class = apply_filters('mesmerize_page_content_wrapper_class', $class);

    echo esc_attr(implode(' ', $class));
}

function mesmerize_get_header($header = null)
{
    $template = apply_filters('mesmerize_header', null);

    if ( ! $template) {
        $template = $header;
    }
    do_action("mesmerize_before_header", $template);
    get_header($template);
}

function mesmerize_get_navigation($navigation = null)
{
    $template = apply_filters('mesmerize_navigation', null);

    if ( ! $template || $template === "default") {
        $template = $navigation;
    }

    get_template_part('template-parts/navigation/navigation', $template);
}


function mesmerize_header_main_class()
{
    $inner   = mesmerize_is_inner();
    $classes = array();

    $prefix = $inner ? "inner_header" : "header";

    if (get_theme_mod("{$prefix}_nav_boxed", false)) {
        $classes[] = "boxed";
    }

    $transparent_nav = get_theme_mod($prefix . '_nav_transparent', true);

    if (!$transparent_nav) {
        $classes[] = "coloured-nav";
    }

    if (get_theme_mod("{$prefix}_nav_border", false)) {
        $classes[] = "bordered";
    }

    if (mesmerize_is_front_page()) {
        $classes[] = "homepage";
    }

    echo implode(" ", $classes);
}


function mesmerize_print_logo($footer = false)
{
    if (function_exists('has_custom_logo') && has_custom_logo()) {
        $dark_logo_image = get_theme_mod('logo_dark', false);
        if ($dark_logo_image) {
            $dark_logo_html = sprintf('<a href="%1$s" class="logo-link dark" rel="home" itemprop="url">%2$s</a>',
                esc_url(home_url('/')),
                wp_get_attachment_image($dark_logo_image, 'full', false, array(
                    'class'    => 'logo dark',
                    'itemprop' => 'logo',
                ))
            );

            echo $dark_logo_html;
        }

        the_custom_logo();
    } else if ($footer) {
        printf('<h2 class="footer-logo">%1$s</h2>', get_bloginfo('name'));
    } else {
        printf('<a class="text-logo" href="%1$s">%2$s</a>', esc_url(home_url('/')), mesmerize_bold_text(get_bloginfo('name')));
    }
}



if ( ! function_exists('print_header_content_holder_class')) {
    function print_header_content_holder_class()
    {
        $align = get_theme_mod('header_text_box_text_align', 'left');
        echo "align-holder $align";
    }
}


//FOOTER FUNCTIONS

function mesmerize_get_footer($footer = null)
{
    $template = apply_filters('mesmerize_footer', null);

    if ( ! $template) {
        $template = $footer;
    }

//    get_footer($template);
    get_template_part('template-parts/footer/footer', $template);

}

function mesmerize_get_footer_copyright()
{
    $defaultText   = __('Built using WordPress and <a href="#">Mesmerize Theme</a>.', 'mesmerize');
    $copyrightText = apply_filters("mesmerize-copyright", $defaultText);

    return '&copy;&nbsp;' . "&nbsp;" . date('Y') . '&nbsp;' . esc_html(get_bloginfo('name')) . '.&nbsp;' . wp_kses_post($copyrightText);
}

function mesmerize_print_footer_social_icons()
{
    $mesmerize_footer_socials_icons = mesmerize_get_footer_social_icons();

    foreach ($mesmerize_footer_socials_icons as $social_icon) {
        $socialid = $social_icon['id'];
        $show     = get_theme_mod('footer_social_icons_show_' . $socialid, true);
        if ($show) {
            $url      = get_theme_mod('footer_social_icons_' . $socialid . '_url', '#');
            $icon_mod = 'footer_social_icons_' . $socialid . '_icon';
            $icon     = get_theme_mod($icon_mod, $social_icon['icon']);
            printf('<a href="%1$s" target="_blank"><i class="font-icon-19 fa %2$s"></i></a>', esc_url($url), esc_attr($icon));
        }
    }
}

function mesmerize_print_footer_box_description()
{

    $text = get_theme_mod('footer_content_box_text', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book');

    printf(esc_html($text));
}


function mesmerize_no_footermenu_cb()
{
    return wp_page_menu(array(
        'menu_id'    => 'horizontal_main_footer_container',
        'menu_class' => 'fm2_horizontal_footer_menu',
    ));
}

// PAGE FUNCTIONS

function mesmerize_print_pagination($args = array(), $class = 'pagination')
{
    if ($GLOBALS['wp_query']->max_num_pages <= 1) {
        return;
    }

    $args = wp_parse_args($args, array(
        'mid_size'           => 2,
        'prev_next'          => false,
        'prev_text'          => __('Older posts', 'mesmerize'),
        'next_text'          => __('Newer posts', 'mesmerize'),
        'screen_reader_text' => __('Posts navigation', 'mesmerize'),
    ));

    $links = paginate_links($args);

    $next_link = get_previous_posts_link($args['next_text']);
    $prev_link = get_next_posts_link($args['prev_text']);

    $template = apply_filters('the_mesmerize_pagination_navigation_markup_template', '
    <div class="navigation %1$s" role="navigation">
        <h2 class="screen-reader-text">%2$s</h2>
        <div class="nav-links"><div class="prev-navigation">%3$s</div><div class="numbers-navigation">%4$s</div><div class="next-navigation">%5$s</div></div>
    </div>', $args, $class);

    echo sprintf($template, $class, $args['screen_reader_text'], $prev_link, $links, $next_link);
}

// POSTS, LIST functions

function mesmerize_print_archive_entry_class()
{
    global $wp_query;
    $classes      = array("post-list-item", "col-xs-12", "space-bottom");
    $index        = $wp_query->current_post;
    $hasBigClass  = (is_sticky() || $index === 0);
    $showBigEntry = (is_archive() || is_home());

    if ($showBigEntry && $hasBigClass) {
        $classes[] = "col-sm-12";
    } else {
        $postsPerRow = apply_filters('mesmerize_posts_per_row', 2);
        $classes[]   = "col-sm-" . (12 / intval($postsPerRow));
    }

    $classes = apply_filters('mesmerize_archive_entry_class', $classes);

    $classesText = implode(" ", $classes);

    echo esc_attr($classesText);
}

function mesmerize_print_masonry_col_class($echo = false)
{
    $postsPerRow = apply_filters('mesmerize_posts_per_row', 2);

    if ($echo) {
        echo "col-sm-" . (12 / intval($postsPerRow));
    }

    return "col-sm-" . (12 / intval($postsPerRow));
}

function mesmerize_print_post_thumb($classes = "")
{
    ?>
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>" class="post-list-item-thumb <?php echo esc_attr($classes); ?>">

            <?php
            if (has_post_thumbnail()):
                the_post_thumbnail();
            else:
//                global $wp_query;
                //                $index = $wp_query->current_post;
                //$color = mesmerize_get_theme_colors('color2');
                //$color = str_replace('#', '', $color);
                ?>
                <!-- <img src="http://placehold.it/200X100/<?php echo $color; ?>/ffffff?text=%20" -->
            <?php endif; ?>
        </a>
    </div>
    <?php
}

function mesmerize_is_customize_preview()
{
    $is_preview = (function_exists('is_customize_preview') && is_customize_preview());

    if ( ! $is_preview) {
        $is_preview = apply_filters('is_shortcode_refresh', $is_preview);
    }

    return $is_preview;

}

function mesmerize_placeholder_p($text, $echo = false)
{
    $content = "";

    if (mesmerize_is_customize_preview()) {
        $content = '<p class="content-placeholder-p">' . $text . '</p>';
    }

    if ($echo) {
        echo $content;
    } else {
        return $content;
    }
}
