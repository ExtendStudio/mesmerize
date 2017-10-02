if ("ontouchstart" in window) {
    document.documentElement.className = document.documentElement.className + " touch-enabled";
}
if (navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/i)) {
    document.documentElement.className = document.documentElement.className + " no-parallax";
}
jQuery(document).ready(function ($) {


    if (window.mesmerize_backstretch) {

        window.mesmerize_backstretch.duration = parseInt(window.mesmerize_backstretch.duration);
        window.mesmerize_backstretch.transitionDuration = parseInt(window.mesmerize_backstretch.transitionDuration);

        var images = mesmerize_backstretch.images;

        if (!images) {
            return;
        }

        jQuery('.header-homepage, .header').backstretch(images, mesmerize_backstretch);
    }


    var masonry = $(".post-list.row");
    if (masonry.length) {
        masonry.masonry({
            itemSelector: '.post-list-item',
            percentPosition: true,
            columnWidth: '.' + $(".post-list.row .post-list-item").eq(0).attr('data-masonry-width')
        });
    }

    $('.header-homepage-arrow-c').click(function () {
        scrollToSection($('body').find('[data-id]').first());
    });
});


(function ($) {
    var masonry = $(".post-list-c");

    var images = masonry.find('img');
    var loadedImages = 0;

    function imageLoaded() {
        loadedImages++;
        if (images.length === loadedImages && masonry.data().masonry) {
            masonry.data().masonry.layout();
        }
    }

    images.each(function () {
        $(this).on('load', imageLoaded);
    });

    var morphed = $("[data-text-effect]");
    if ($.fn.typed && morphed.length && JSON.parse(mesmerize_morph.header_text_morph)) {
        morphed.each(function () {
            $(this).empty();
            $(this).typed({
                strings: JSON.parse($(this).attr('data-text-effect')),
                typeSpeed: parseInt(mesmerize_morph.header_text_morph_speed),
                loop: true
            });

        });
    }
})(jQuery);

// OffScreen Menu

(function ($) {
    var $menus = $('.offcanvas_menu');
    var $offCanvasWrapper = $('#offcanvas-wrapper');

    if ($offCanvasWrapper.length) {
        $('html').addClass('has-offscreen')
        $offCanvasWrapper.appendTo('body');


        $offCanvasWrapper.on('kube.offcanvas.ready', function () {
            $offCanvasWrapper.removeClass('force-hide');
        });


        $offCanvasWrapper.on('kube.offcanvas.opened', function () {
            $('html').addClass('offcanvas-opened')
        });


        $offCanvasWrapper.on('kube.offcanvas.closed', function () {
            $('html').removeClass('offcanvas-opened')
        });
    }


    $menus.each(function () {

        var $menu = $(this);

        $menu.on('mesmerize.open-all', function () {
            $(this).find('.menu-item-has-children, .page_item_has_children').each(function () {
                $(this).addClass('open');
                $(this).children('ul').slideDown(100);
            });
        });

        $menu.find('.menu-item-has-children a, .page_item_has_children a').each(function () {
            if ($(this).children('i.fa.arrow').length === 0) {
                $(this).append('<i class="fa arrow"></i>');

            }
        });

        $menu.on('click', '.menu-item-has-children a, .page_item_has_children a,.menu-item-has-children .arrow, .page_item_has_children .arrow', function (event) {
            var $this = $(this);
            var $li = $this.closest('li');

            if ($li.hasClass('open')) {
                if ($this.is('a')) {
                    return true;
                }
                $li.children('ul').slideUp(100, function () {
                    $li.find('ul').each(function () {
                        $(this).parent().removeClass('open');
                        $(this).css('display', 'none');
                    })
                });
            } else {
                $li.children('ul').slideDown(100);
            }

            $li.toggleClass('open');

            event.preventDefault();
            event.stopPropagation();
        });

    });


})(jQuery);