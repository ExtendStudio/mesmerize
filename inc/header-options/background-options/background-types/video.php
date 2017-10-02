<?php

function mesmerize_header_background_type_video($values, $inner, $prefix) {
	$values["video"] = array(
        "label"   => __("Video", 'mesmerize'),
        "control" => array(
            $prefix . "_video",
            $prefix . "_video_external",
            $prefix . "_video_poster",
        ),
    );
    return $values;
}

add_filter("mesmerize_header_background_type", 'mesmerize_header_background_type_video', 1, 3);

add_action("mesmerize_background", function($bg_type, $inner, $prefix) {
	if ($bg_type == 'video') {
	    $internalVideo = get_theme_mod($prefix . '_video', "");
        $video_url     = get_theme_mod($prefix . '_video_external', "https://www.youtube.com/watch?v=3iXYciBTQ0c");
        $videoPoster   = get_theme_mod($prefix . '_video_poster', get_template_directory_uri() . "/assets/images/Mock-up.jpg");

        if ($internalVideo) {
            $video_url = wp_get_attachment_url($internalVideo);
            $video_url = apply_filters('get_header_video_url', $video_url);
        }

        $video_type = wp_check_filetype($video_url, wp_get_mime_types());
        $header     = get_custom_header();
        $settings   = array(
            'mimeType'  => '',
            'videoUrl'  => $video_url,
            'posterUrl' => $videoPoster,
            'width'     => absint($header->width),
            'height'    => absint($header->height),
            'minWidth'  => 900,
            'minHeight' => 500,
            'l10n'      => array(
                'pause'      => __('Pause', 'mesmerize'),
                'play'       => __('Play', 'mesmerize'),
                'pauseSpeak' => __('Video is paused.', 'mesmerize'),
                'playSpeak'  => __('Video is playing.', 'mesmerize'),
            ),
        );

        if (preg_match('#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $video_url)) {
            $settings['mimeType'] = 'video/x-youtube';
        } else if ( ! empty($video_type['type'])) {
            $settings['mimeType'] = $video_type['type'];
        }

        $settings = apply_filters('header_video_settings', $settings);

        wp_enqueue_script('wp-custom-header');
        wp_localize_script('wp-custom-header', '_wpCustomHeaderSettings', $settings);
        wp_enqueue_script('cp-video-bg', get_template_directory_uri() . "/assets/js/video-bg.js", array('wp-custom-header'));
        
        add_filter("mesmerize_header_background_atts", function($attrs, $bgType, $inner) {
			$attrs['class'] .=" cp-video-bg";
			return $attrs;
		}, 1, 3);
	}
}, 1, 3);


add_action("mesmerize_header_background_type_settings", "mesmerize_header_background_type_video_settings", 2, 6);

function mesmerize_header_background_type_video_settings($wp_customize, $section, $prefix, $group, $inner, $priority) {
    /* video settings */

    $prefix  = $inner ? "inner_header" : "header";
    $section = $inner ? "header_image" : "header_background_chooser";

    $group = "{$prefix}_bg_options_group_button";

    $wp_customize->add_setting($prefix . '_video', array(
        'default'           => "",
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, $prefix . '_video', array(
        'label'     => __('Self hosted video (MP4)', 'mesmerize'),
        'section'   => $section,
        'mime_type' => 'video',
        "priority"  => 2,
    )));

    $wp_customize->add_setting($prefix . '_video_external', array(
        'default'           => "https://www.youtube.com/watch?v=3iXYciBTQ0c",
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control($prefix . '_video_external', array(
        'label'    => __('External Video', 'mesmerize'),
        'section'  => $section,
        'type'     => 'text',
        "priority" => 2,
    ));

    $wp_customize->add_setting($prefix . '_video_poster', array(
        'default'           => get_template_directory_uri() . "/assets/images/Mock-up.jpg",
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $prefix . '_video_poster', array(
        'label'    => __('Video Poster', 'mesmerize'),
        'section'  => $section,
        "priority" => 2,
    )));


    add_filter($group."_filter", function($settings) use ($prefix) {
        
        $new_settings =array(
            "_video",
            "_video_external",
            "_video_poster"
        );

        foreach ($new_settings as $key => $value) {
           $settings[] = $prefix.$value;
        }

        return $settings;
    });
}

function mesmerize_print_video_container()
{
    $inner  = mesmerize_is_inner();
    $prefix = $inner ? "inner_header" : "header";
    $bgType = get_theme_mod($prefix . "_background_type", null);
    $poster = get_theme_mod($prefix . '_video_poster', get_template_directory_uri() . "/assets/images/Mock-up.jpg");

    if ($bgType === "video"):
        ?>
        <div id="wp-custom-header" class="wp-custom-header cp-video-bg">
            <script>
                // resize the poster image as fast as possible to a 16:9 visible ratio
                var mesmerize_video_background = {
                    getVideoRect: function () {
                        var header = document.querySelector(".cp-video-bg");
                        var headerWidth = header.getBoundingClientRect().width,
                            videoWidth = headerWidth,
                            videoHeight = header.getBoundingClientRect().height;

                        videoWidth = Math.max(videoWidth, videoHeight);

                        if (videoWidth < videoHeight * 16 / 9) {
                            videoWidth = 16 / 9 * videoHeight;
                        } else {
                            videoHeight = videoWidth * 9 / 16;
                        }

                        videoWidth *= 1.2;
                        videoHeight *= 1.2;

                        var marginLeft = -0.5 * (videoWidth - headerWidth);

                        return {
                            width: Math.round(videoWidth),
                            height: Math.round(videoHeight),
                            left: Math.round(marginLeft)
                        }
                    },

                    resizePoster: function () {
                        var posterHolder = document.querySelector('#wp-custom-header');

                        var size = mesmerize_video_background.getVideoRect();
                        posterHolder.style.backgroundSize = size.width + 'px auto'


                    }

                }

                setTimeout(mesmerize_video_background.resizePoster, 0);
            </script>
        </div>
        <style>
            .header-wrapper {
                background: transparent;
            }

            div#wp-custom-header.cp-video-bg {
                background-image: url('<?php echo esc_url($poster); ?>');
                background-color: #000000;
                background-position: center top;
                background-size: cover;
                position: absolute;
                z-index: -2;
                height: 100%;
                width: 100%;
                margin-top: 0;
                top: 0px;
                -webkit-transform: translate3d(0, 0, -2px);
            }

            .header-homepage.cp-video-bg,
            .header.cp-video-bg {
                background-color: transparent !important;
                overflow: hidden;
            }

            div#wp-custom-header.cp-video-bg #wp-custom-header-video {
                object-fit: cover;
                position: absolute;
                opacity: 0;
                width: 100%;
                transition: opacity 0.4s cubic-bezier(0.44, 0.94, 0.25, 0.34);
            }

            div#wp-custom-header.cp-video-bg button#wp-custom-header-video-button {
                display: none;
            }
        </style>
        <?php
    endif;
}
