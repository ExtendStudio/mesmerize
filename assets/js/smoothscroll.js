var currentPageURL = document.location.toString();
var isAnchor = false;
if (location.hash) {
    isAnchor = true;
    window.scrollTo(0, 0);
}
(function ($) {
    if (window.useManagedSmoothScroll) {
        return;
    }

    var duration = 1500;
    var easing = 'easeInOutQuart';
    var lastId, anchors, scrollItems;

    function targetIsSamePage(target) {
        return !target || target == "_self";
    }

    function getHash(url) {
        if (!url) {
            return false;
        }
        var indexOfHash = url.indexOf('#');
        if (indexOfHash > -1) {
            if (indexOfHash === 0) {
                return url.replace('#', '');
            }
            var hash = url.substring(indexOfHash + 1);
            var urlQuery = "";
            if (url.indexOf('?') > -1) {
                urlQuery = url.substring(url.indexOf('?'));
            }
            var absLinkRegExp = /(https?|file):\/\//;
            var pageLocation = window.location.pathname;
            var urlLocation = url.replace(urlQuery, '').replace('#' + hash, '').replace(absLinkRegExp, '');
            if (url.match(absLinkRegExp)) {
                pageLocation = window.location.host + pageLocation;
            } else {
                urlLocation = pageLocation.substring(0, pageLocation.lastIndexOf("/")) + "/" + urlLocation;
            }
            if (pageLocation == urlLocation || pageLocation == urlLocation + "/") {
                return hash;
            }
        }
        return false;
    }

    function change_url_hash(hash) {
        setTimeout(function () {
            if (hash) {
                hash = "#" + hash;
            } else {
                hash = "";
            }
            if (history && history.replaceState) {
                history.replaceState({}, "", hash);
            } else {
            }
        }, 100);
        /* safari issue fixed by throtteling the event */
    }

    var scrollStarted = false;


    function scrollToSection(section, elem) {
        if (scrollStarted) {
            return;
        }

        try {
            scrollStarted = true;

            if (section) {
                var parent;
                if (elem) {
                    parent = elem.parent().parentsUntil('body').filter(function () {
                        if (jQuery(this).css('position') == "fixed" && !jQuery(this).is('.mobile-overlay')) return jQuery(this);
                    }).eq(0);
                }

                var topDistance = 0;
                if (parent && parent.length) {
                    var parentClass = parent.attr("class");
                    var flexiMenu = jQuery('div[class*="main-menu"]');
                    if (parent.outerHeight() !== window.innerHeight || !parent.is('.full-sidebar')) {
                        topDistance = parent.outerHeight() + parent.position().top;
                    }
                }
                var scrollToValue = section.offset().top - topDistance;
                if (scrollToValue < 0) {
                    scrollToValue = 0;
                }
                var stickTo = jQuery("[data-cp-shrink=initial]");
                if (scrollToValue > stickTo.height()) {
                    scrollToValue -= jQuery('[data-cp-shrink=shrinked]').height();
                }

                var ratio = Math.max(0.5, scrollToValue / jQuery('body').height());

                jQuery('html, body').animate({
                    scrollTop: scrollToValue
                }, duration * ratio, easing, function () {
                    scrollStarted = false;
                    jQuery(window).trigger('scroll');
                    jQuery(document).trigger('scroll');
                });

                return true;
            }
        } catch (e) {
            // alert('error in xtd one page site script ' + e);
        }
    }

    function linkClick(ev, elem) {

        if (!targetIsSamePage(elem.attr("target"))) {
            return;
        }

        var section = elem.data('onepage-section') ? elem.data('onepage-section') : false;

        if (section && section.length) {
            ev.preventDefault();

            // ev.stopPropagation();
        }

        var scrolled = scrollToSection(section, elem);
        if (scrolled && ev) {
            ev.preventDefault();
        }

    }

    function bubbleSortByTop(arr) {
        var swapped;
        do {
            swapped = false;
            for (var i = 0; i < arr.length - 1; i++) {
                var elem = arr[i];
                var elem2 = arr[i + 1];
                if (elem.offset().top > elem2.offset().top) {
                    var temp = arr[i];
                    arr[i] = arr[i + 1];
                    arr[i + 1] = temp;
                    swapped = true;
                }
            }
        } while (swapped);
    }

    function getAnchors() {
        scrollItems = [];
        anchors = jQuery('a').filter(function () {
            var elem = jQuery(this);
            var href = elem.attr('href');
            var target = elem.attr('target');
            var hash = getHash(href);
            if (hash && hash !== 'wp-toolbar') {
                try {
                    var section = jQuery("#" + hash);
                    if (section.length > 0) {
                        elem.data('onepage-section', section);
                        if (elem.parent()[0].tagName == "LI") {
                            var dataElem = section.data('onepage-anchor') || $("");
                            dataElem = dataElem.add(elem);
                            section.data('onepage-anchor', dataElem);
                        }
                        scrollItems.push(section);
                        return true;
                    }
                } catch (e) {

                }
            }
            return false;
        });


        anchors.each(function () {

            if (jQuery(this).closest('.fm2_mobile_jq_menu').length || !jQuery(this).is(':visible')) {
                return;
            }

            if (jQuery(this).parent().is('li.menu-item')) {
                var selfAnchor = this;
                jQuery(this).unbind('click.onepage');
                jQuery(this).attr('data-smoothscroll', 'true');
                jQuery(this).parent().unbind('click.onepage').bind("click.onepage", function (e) {

                    if (!jQuery(e.target).parent().is(e.currentTarget)) {
                        return;
                    }

                    e.preventDefault();
                    e.stopPropagation();
                    linkClick(e, jQuery(selfAnchor));
                });
            } else {
                jQuery(this).unbind('click.onepage').bind("click.onepage", function (e) {

                    linkClick(e, jQuery(this));
                });
            }
        });
        try {
            bubbleSortByTop(scrollItems);
        } catch (e) {
        }
    }

    var scrollTimeout;
    var is_touch_device = 'ontouchstart' in document.documentElement;
    if (!is_touch_device) {
        jQuery(window).scroll(function () {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(doneScrolling, 20);
        });
    }

    function doneScrolling() {
        var windowElem = jQuery(window);
        var fromTop = windowElem.scrollTop() + window.innerHeight * 0.5;
        var cur = [];
        if (!scrollItems) {
            getAnchors();
        }
        for (var i = 0; i < scrollItems.length; i++) {
            if (scrollItems[i].offset().top < fromTop) {
                cur.push(scrollItems[i]);
            }
        }
        var lastItem = scrollItems[scrollItems.length - 1];
        if ((windowElem.scrollTop() + windowElem.height() + 50) >= jQuery(document).height()) {
            cur.push(lastItem);
        }
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";
        change_url_hash(id);
        if (id.length === 0 && anchors) {
            // anchors.closest('ul').find('.current_page_item').removeClass('current_page_item');
            anchors.parent().andSelf().removeClass('current_page_item current-menu-item');
            loc = (window.location + "").split('#')[0].replace(/\/$/, "");
            anchors.closest('ul').find('[href$="' + loc + '"]').parent().andSelf().addClass('current-menu-item');
            if (!loc.length) {
                anchors.closest('ul').find('[href$="' + window.location + '"]').parent().andSelf().addClass('current-menu-item');

            }
        }

        if (lastId !== id && id.length) {
            lastId = id;
            try {
                anchors.filter('.current_page_item, .current-menu-item').each(function () {
                    jQuery(this).parent().andSelf().removeClass('current_page_item current-menu-item');

                });
                anchors.closest('ul').find('.current_page_item, .current-menu-item').removeClass('current_page_item current-menu-item');
                cur.data('onepage-anchor').each(function () {
                    $(this).parent().andSelf().addClass('current-menu-item');
                });
            } catch (e) {
            }
        }
    }

    var id;
    jQuery(window).bind("resize orientationchange", function () {
        clearTimeout(id);
        id = setTimeout(doneResizing, 100);
    });

    function doneResizing() {
        getAnchors();
    }

    getAnchors();

    is_touch_device = 'ontouchstart' in document.documentElement;

    if (!is_touch_device) {
        doneScrolling();
    }
    if (isAnchor) {
        if (jQuery.find('a[href^="' + currentPageURL + '"]').length > 0) {
            jQuery(jQuery.find('a[href="' + currentPageURL + '"]')).trigger('click');
        } else {
            var hash = getHash(currentPageURL);
            if (hash.length) {
                jQuery(jQuery.find('a[href*="#' + hash + '"]')).trigger('click');
            }
        }
    } else {
        jQuery('a[href*="#"]').each(function (index, el) {
            var parts = el.href.split('#'),
                anchor = parts[parts.length - 1];

            if (parts.length >= 2) {
                if (anchor.length) {
                    jQuery(this).parent().andSelf().removeClass('current_page_item current-menu-item');
                }
            }
        });
    }

    if (window.wp && window.wp.customize) {
        $('.dropdown-menu').parent('div').parent().on('DOMNodeInserted DOMNodeRemoved', function (event) {
            getAnchors();
            doneScrolling();
        });
    }

    window.scrollToSection = scrollToSection;
    window.smoothScrollGetAnchors = getAnchors;
})(jQuery);


