wp.customize.controlConstructor['sidebar-button-group'] = wp.customize.Control.extend({
    ready: function () {
        var control = this;
        var components = this.params.choices;
        var popupId = this.params.popup;
        var in_row_with = this.params.in_row_with || [];

        control.container.find('#group_customize-button-' + popupId).click(function () {

            if (window.CP_Customizer) {
                CP_Customizer.openRightSidebar(popupId);
            } else {
                Mesmerize.openRightSidebar(popupId);
            }
        });

        control.container.find('#' + popupId + '-popup > ul').on('focus', function (event) {
            return false;
        });

        wp.customize.bind('pane-contents-reflowed', function () {
            var holder = control.container.find('#' + popupId + '-popup > ul');
            _.each(components, function (c) {
                var _c = wp.customize.control(c);
                if (_c) {
                    holder.append(_c.container);
                }
            });
            if (in_row_with && in_row_with.length) {
                _.each(in_row_with, function (c) {
                    control.container.css({
                        "width" : "40%",
                        "clear" : "right",
                        "float" : "right",
                    })

                    var ct = wp.customize.control(c);
                    if (ct) {
                        ct.container.css({
                            "width":"auto",
                            "min-width":"55%"
                        })
                    }
                })
            }
        });
    }
});
