function liveUpdate(setting, callback) {
    var cb = function (value) {
        value.bind(callback);
    };
    var _setting = setting;
    wp.customize(_setting, cb);

    if (parent.CP_Customizer) {
        var _prefixedSetting = parent.CP_Customizer.slugPrefix() + "_" + setting;
        wp.customize(_prefixedSetting, cb);
    }
}

(function ($) {
    wp.customize('full_height_header', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-homepage').css('min-height', "100vh");
            } else {
                $('.header-homepage').css('min-height', "");
            }
        });
    });

    wp.customize('header_show_overlay', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-homepage').addClass('color-overlay');
            } else {
                $('.header-homepage').removeClass('color-overlay');
            }
        });
    });
    wp.customize('header_sticked_background', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.homepage.navigation-bar.fixto-fixed').css('background-color', newval);
            }
            var transparent = JSON.parse(wp.customize('header_nav_transparent').get());
            if (!transparent) {
                $('.homepage.navigation-bar').css('background-color', newval);
            }
        });
    });
    wp.customize('header_nav_transparent', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.homepage.navigation-bar').removeClass('coloured-nav');
            } else {
                $('.homepage.navigation-bar').css('background-color', '');
                $('.homepage.navigation-bar').addClass('coloured-nav');
            }
        });
    });
    wp.customize('inner_header_sticked_background', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.navigation-bar:not(.homepage).fixto-fixed').css('background-color', newval);
            }

            var transparent = JSON.parse(wp.customize('inner_header_nav_transparent').get());
            if (!transparent) {
                $('.navigation-bar:not(.homepage)').css('background-color', newval);
            }
        });
    });
    wp.customize('inner_header_nav_transparent', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.navigation-bar:not(.homepage)').removeClass('coloured-nav');
            } else {
                $('.navigation-bar:not(.homepage)').addClass('coloured-nav');
            }
        });
    });
    wp.customize('inner_header_show_overlay', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header').addClass('color-overlay');
            } else {
                $('.header').removeClass('color-overlay');
            }
        });
    });

    wp.customize('header_gradient', function (value) {
        value.bind(function (newval, oldval) {
            $('.header-homepage').removeClass(oldval);
            $('.header-homepage').addClass(newval);
        });
    });

    wp.customize('inner_header_gradient', function (value) {
        value.bind(function (newval, oldval) {
            $('.header').removeClass(oldval);
            $('.header').addClass(newval);
        });
    });


    wp.customize('header_text_box_text_vertical_align', function (value) {
        value.bind(function (newVal, oldVal) {
            $('.header-hero-content-v-align').removeClass(oldVal).addClass(newVal);
        });
    });

    wp.customize('header_media_box_vertical_align', function (value) {
        value.bind(function (newVal, oldVal) {
            $('.header-hero-media-v-align').removeClass(oldVal).addClass(newVal);
        });
    });

    wp.customize('header_text_box_text_align', function (value) {
        value.bind(function (newVal, oldVal) {
            $('.mesmerize-front-page  .header-content .align-holder').removeClass(oldVal).addClass(newVal);
        });
    })

})(jQuery);

(function ($) {
    function getHeaderSplitGradientValue(color, angle, size, fade) {
        angle = -90 + parseInt(angle);
        fade = parseInt(fade) / 2;
        transparentMax = (100 - size) - fade;
        colorMin = (100 - size) + fade;


        var gradient = angle + "deg, " + "transparent 0%, transparent " + transparentMax + "%, " + color + " " + colorMin + "%, " + color + " 100%";

        // return gradient;

        var result = 'background: linear-gradient(' + gradient + ');' +
            'background: -webkit-linear-gradient(' + gradient + ');' +
            'background: linear-gradient(' + gradient + ');';

        return result;
    }

    function recalculateHeaderSplitGradient() {
        var color = wp.customize('header_split_header_color').get();
        var angle = wp.customize('header_split_header_angle').get();
        var fade = wp.customize('header_split_header_fade') ? wp.customize('split_header_fade').get() : 0;
        var size = wp.customize('header_split_header_size').get();

        var gradient = getHeaderSplitGradientValue(color, angle, size, fade);

        var angle = wp.customize('header_split_header_angle_mobile').get();
        var size = wp.customize('header_split_header_size_mobile').get();

        var mobileGradient = getHeaderSplitGradientValue(color, angle, size, fade);

        var style = '' +
            '.header-homepage  .split-header {' + mobileGradient + '}' + "\n\n" +
            '@media screen and (min-width: 1024px) { .header-homepage  .split-header {' + gradient + '} }';

        jQuery('style[data-name="header-split-style"]').html(style);
    }


    liveUpdate('header_split_header_fade', recalculateHeaderSplitGradient);
    liveUpdate('header_split_header_color', recalculateHeaderSplitGradient);
    liveUpdate('header_split_header_angle', recalculateHeaderSplitGradient);
    liveUpdate('header_split_header_size', recalculateHeaderSplitGradient);
    liveUpdate('header_split_header_angle_mobile', recalculateHeaderSplitGradient);
    liveUpdate('header_split_header_size_mobile', recalculateHeaderSplitGradient);
})(jQuery);


(function ($) {
    function recalculateHeaderOverlayGradient() {
        var control = parent.wp.customize.control('header_overlay_gradient_colors');
        var gradient = parent.CP_Customizer.utils.getValue(control);

        var colors = gradient.colors;
        var angle = gradient.angle;

        angle = parseFloat(angle);

        gradient = parent.Mesmerize.Utils.getGradientString(colors, angle);

        $('.background-overlay').css("background-image", gradient);

    }

    function recalculateFooterOverlayGradient() {
        var control = parent.wp.customize.control('footer_overlay_gradient_colors');
        var gradient = parent.CP_Customizer.utils.getValue(control);

        var colors = gradient.colors;
        var angle = gradient.angle;

        angle = parseFloat(angle);

        gradient = parent.Mesmerize.Utils.getGradientString(colors, angle);

        $('#footer-container #footer-overlay, .footer #footer-overlay').css("background-image", gradient);

    }

    liveUpdate('header_overlay_gradient_colors', recalculateHeaderOverlayGradient);
    liveUpdate('footer_overlay_gradient_colors', recalculateFooterOverlayGradient);
})(jQuery);
