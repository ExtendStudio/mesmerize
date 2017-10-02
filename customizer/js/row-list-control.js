(function ($) {
    var $preview;

    function showPreview($item) {
        $preview = jQuery('#ope_section_preview');
        if (!$preview.length) {
            jQuery('body').append('<div id="ope_section_preview"></div>');
            $preview = jQuery('#ope_section_preview');
        }
        var bounds = $item[0].getBoundingClientRect();
        var scrollTop = 0;
        var scrollLeft = 0;
        $preview.css({
            left: (parseInt(bounds.right) + 10 + scrollLeft) + "px",
            top: Math.max(10, (parseInt(bounds.top) + scrollTop)) + "px",
            'background-image': 'url("' + $item.data('preview') + '?cloudpress-companion=v1")'
        });
        $preview.show();

        if ($preview.offset().top + $preview.height() + 10 > window.innerHeight) {
            $preview.css({
                top: window.innerHeight - ($preview.height() + 10)
            })
        }
    }

    function hidePreview() {
        $preview = jQuery('#ope_section_preview');
        $preview.hide();
    }

    function selectItem(id, $list, selectionType) {
        var $currentItem = $list.find('li[data-id="' + id + '"]');
        var response = false
        switch (selectionType) {
            case 'toggle':
                $currentItem.toggleClass('already-in-page');
                response = $currentItem.hasClass('already-in-page');
                break;

            case 'multiple':
                response = true;
                break;

            case 'check':
                $currentItem.addClass('already-in-page');
                response = true;
                break;

            default: // radio
                $currentItem.addClass('already-in-page');
                $currentItem.siblings().removeClass('already-in-page');
                response = true;
                break;
        }

        return response;

    }

    wp.customize.controlConstructor["mod_changer"] = wp.customize.Control.extend({
        ready: function () {

            'use strict';
            var control = this;

            this.container.on('mouseover.mod_changer', '[data-apply="mod_changer"] .item-preview', function (event) {
                event.preventDefault();
                showPreview($(this));
            });

            this.container.on('mouseout.mod_changer', '[data-apply="mod_changer"] .item-preview', function (event) {
                event.preventDefault();
                hidePreview($(this));
            });

            this.container.on('click.mod_changer', '[data-apply="mod_changer"] .available-item-hover-button', function (event) {
                event.preventDefault();
                event.stopPropagation();
                var setting = $(this).data('setting-link'),
                    itemId = $(this).data('id'),
                    $list = $(this).closest('[data-type="row-list-control"]'),
                    selectionType = $list.attr('data-selection') || "radio";


                if ($list.is('[data-apply="mod_changer"]')) {

                    var selected = selectItem(itemId, $list, selectionType);

                    if (selectionType === "radio") {
                        wp.customize(setting).set(itemId);
                    } else {
                        $list.trigger('cp.item.click', [itemId, selected]);
                    }
                }
            });
        }
    });

    wp.customize.controlConstructor["presets_changer"] = wp.customize.Control.extend({

        ready: function () {

            'use strict';
            var control = this;


            this.container.on('mouseover.presets_changer', '[data-apply="presets_changer"] .item-preview', function (event) {
                event.preventDefault();
                showPreview($(this));
            });

            this.container.on('mouseout.presets_changer', '[data-apply="presets_changer"] .item-preview', function (event) {
                event.preventDefault();
                hidePreview($(this));
            });

            this.container.on('click.presets_changer', '[data-apply="presets_changer"] .available-item-hover-button', function (event) {
                event.preventDefault();
                event.stopPropagation();
                var setting = $(this).data('setting-link'),
                    itemId = $(this).data('id'),
                    $list = $(this).closest('[data-type="row-list-control"]'),
                    selectionType = $list.attr('data-selection') || "radio";

                var varName = $(this).closest('li').data('varname');
                var presetsValues = window[varName][itemId];

                if (window.CP_Customizer) {
                    CP_Customizer.showLoader();
                    CP_Customizer.setMultipleMods(presetsValues, 'postMessage', function () {
                        CP_Customizer.preview.refresh();
                    });
                    return;
                }

                _.each(presetsValues, function (value, name) {
                    var control = wp.customize.settings.controls[name];
                    if (control) {
                        var type = control.type;

                        if (type == "radio-html") {
                            jQuery(wp.customize.control(name).container.find('input[value="' + value + '"]')).prop('checked', true);
                            wp.customize.instance(name).set(value);
                        } else {
                            if (type == "kirki-spacing") {
                                for (var prop in value) {
                                    if (value.hasOwnProperty(prop)) {
                                        jQuery(wp.customize.control(name).container.find('.' + prop + ' input')).prop('value', value[prop]);
                                    }
                                }
                                wp.customize.instance(name).set(value);
                            } else {
                                if (type.match('kirki')) {
                                    kirkiSetSettingValue(name, value);
                                } else {
                                    wp.customize.instance(name).set(value);
                                }
                            }
                        }
                    }
                });
            });
        }
    });
})(jQuery);
