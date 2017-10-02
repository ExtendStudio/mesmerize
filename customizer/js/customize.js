(function (root, $) {
    if (!root.Mesmerize) {
        root.Mesmerize = {

            Utils : {
                getGradientString: function(colors, angle) {
                    var gradient = angle + "deg, " + colors[0].color + " 0%, "  + colors[1].color + " 100%";
                    gradient = 'linear-gradient(' + gradient + ')';
                    return gradient;
                },
            },

            hooks: {
                addAction: function () {
                },
                addFilter: function () {
                },
                doAction: function () {

                },
                applyFilters: function () {

                }
            },

            wpApi: root.wp.customize,

            closePopUps: function () {
                root.tb_remove();
                root.jQuery('#TB_overlay').css({
                    'z-index': '-1'
                });
            },

            options: function (optionName) {
                return root.mesmerize_customize_settings[optionName];
            },

            popUp: function (title, elementID, data) {
                var selector = "#TB_inline?inlineId=" + elementID;
                var query = [];


                $.each(data || {}, function (key, value) {
                    query.push(key + "=" + value);
                });

                selector = query.length ? selector + "&" : selector + "";
                selector += query.join("&");

                root.tb_show(title, selector);

                root.jQuery('#TB_window').css({
                    'z-index': '5000001',
                    'transform': 'opacity .4s',
                    'opacity': 0
                });

                root.jQuery('#TB_overlay').css({
                    'z-index': '5000000'
                });


                setTimeout(function () {
                    root.jQuery('#TB_window').css({
                        'margin-top': -1 * ((root.jQuery('#TB_window').outerHeight() + 50) / 2),
                        'opacity': 1
                    });
                    root.jQuery('#TB_window').find('#cp-item-ok').focus();
                }, 0);

                if (data && data.class) {
                    root.jQuery('#TB_window').addClass(data.class);
                }

                return root.jQuery('#TB_window');
            },

            addModule: function (callback) {
                var self = this;

                jQuery(document).ready(function () {
                    // this.__modules.push(callback);
                    callback(self);
                });

            },
            getCustomizerRootEl: function () {
                return root.jQuery(root.document.body).find('form#customize-controls');
            },
            openRightSidebar: function (elementId, options) {
                options = options || {};
                this.hideRightSidebar();
                var $form = this.getCustomizerRootEl();
                var self = this;
                var $container = $form.find('#' + elementId + '-popup');
                if ($container.length) {
                    $container.addClass('active');

                    if (options.floating && !_(options.y).isUndefined()) {
                        $container.css({
                            top: options.y
                        });
                    }
                } else {
                    $container = $('<li id="' + elementId + '-popup" class="customizer-right-section active"> <span data-close-right-sidebar="true" title="Close Panel" class="close-panel"></span> </li>');

                    if (options.floating) {
                        $container.addClass('floating');
                    }

                    $toAppend = $form.find('li#accordion-section-' + elementId + ' > ul');

                    if ($toAppend.length === 0) {
                        $toAppend = $form.find('#sub-accordion-section-' + elementId);
                    }


                    if ($toAppend.length === 0) {
                        $toAppend = $('<div class="control-wrapper" />');
                        $toAppend.append($form.find('#customize-control-' + elementId).children());
                    }

                    $form.append($container);
                    $container.append($toAppend);

                    if (options.floating && !_(options.y).isUndefined()) {
                        $container.css({
                            top: options.y
                        });
                    }


                    $container.find('span.close-panel').click(self.hideRightSidebar);

                }

                if (options.focus) {
                    $container.find(options.focus)[0].scrollIntoViewIfNeeded();
                }

                $container.css('left', jQuery('#customize-header-actions')[0].offsetWidth + 1);


                $container.find('span[data-close-right-sidebar="true"]').click(function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    self.hideRightSidebar();
                });

                $form.find('li.accordion-section').unbind('click.right-section').bind('click.right-section', function (event) {
                    if ($(event.target).is('li') || $(event.target).is('.accordion-section-title')) {
                        if ($(event.target).closest('.customizer-right-section').length === 0) {
                            self.hideRightSidebar();
                        }
                    }
                });

                self.hooks.doAction('right_sidebar_opened', elementId, options, $container);


            },

            hideRightSidebar: function () {
                var $form = root.jQuery(root.document.body).find('#customize-controls');
                var $visibleSection = $form.find('.customizer-right-section.active');
                if ($visibleSection.length) {
                    $visibleSection.removeClass('active');
                }
            }

        };
    }

    function openMediaBrowser(type, callback, data) {
        var cb;
        if (callback instanceof jQuery) {
            cb = function (response) {

                if (!response) {
                    return;
                }

                var value = response[0].url;
                if (data !== "multiple") {
                    if (type == "icon") {
                        value = response[0].fa
                    }
                    callback.val(value).trigger('change');
                }
            }
        } else {
            cb = callback;
        }

        switch (type) {
            case "image":
                openMultiImageManager('Change image', cb, data);
                break;
        }
    }

    function openMediaCustomFrame(extender, mode, title, single, callback) {
        var interestWindow = window.parent;

        var frame = extender(interestWindow.wp.media.view.MediaFrame.Select);

        var custom_uploader = new frame({
            title: title,
            button: {
                text: title
            },
            multiple: !single
        });


        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').toJSON();
            custom_uploader.content.mode('browse');
            callback(attachment);
        });


        custom_uploader.on('close', function () {
            custom_uploader.content.mode('browse');
            callback(false);
        });

        //Open the uploader dialog
        custom_uploader.open();
        custom_uploader.content.mode(mode);
        // Show Dialog over layouts frame
        interestWindow.jQuery(custom_uploader.views.selector).parent().css({
            'z-index': '16000000'
        });

    }

    function openMultiImageManager(title, callback, single) {
        var node = false;
        var interestWindow = window.parent;
        var custom_uploader = interestWindow.wp.media.frames.file_frame = interestWindow.wp.media({
            title: title,
            button: {
                text: 'Choose Images'
            },
            multiple: !single
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').toJSON();
            callback(attachment);
        });
        custom_uploader.off('close.cp').on('close.cp', function () {
            callback(false);
        });
        //Open the uploader dialog
        custom_uploader.open();

        custom_uploader.content.mode('browse');
        // Show Dialog over layouts frame
        interestWindow.jQuery(interestWindow.wp.media.frame.views.selector).parent().css({
            'z-index': '16000000'
        });
    }

    root.Mesmerize.openMediaBrowser = openMediaBrowser;
    root.Mesmerize.openMediaCustomFrame = openMediaCustomFrame;

    if (window.wp && window.wp.customize) {
        wp.customize.controlConstructor['radio-html'] = wp.customize.Control.extend({

            ready: function () {

                'use strict';

                var control = this;

                // Change the value
                this.container.on('click', 'input', function () {
                    control.setting.set(jQuery(this).val());
                });

            }

        });

    }
})(window, jQuery);

// fix selectize opening
(function ($) {

    $(document).on('mouseup', '.selectize-input', function () {
        if ($(this).parent().height() + $(this).parent().offset().top > window.innerHeight) {
            $('.wp-full-overlay-sidebar-content').scrollTop($(this).parent().height() + $(this).parent().offset().top)
        }
    });

    $(document).on('change', '.customize-control-kirki-select select', function () {
        $(this).focusout();
    });


    $(function () {
        var linkMods = null;

        if (window.CP_Customizer && window.CP_Customizer.onModChange) {
            linkMods = CP_Customizer.onModChange.bind(CP_Customizer);
        } else {
            linkMods = function (mod, callback) {
                wp.customize(mod, function () {
                    this.bind(callback)
                });
            }
        }


        function setTextWidth(newValue) {
            if (newValue === "content-on-right" || newValue === "content-on-left") {
                var setting = wp.customize('header_text_box_text_width');

                if (setting.get() == 100) {
                    setting.set(50);
                    wp.customize.previewer.refresh();
                    kirkiSetSettingValue('header_text_box_text_width', 50);
                }

            }
        }

        linkMods('ope_header_content_layout', function (newValue, oldValue) {
            setTextWidth(newValue);
        });

        linkMods('header_content_partial', function (newValue, oldValue) {
            setTextWidth(newValue);
        });
    });
})(jQuery);
