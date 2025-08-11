jQuery(function($) {
    function initOwl(selector, options) {
        if ($(selector).length) {
            $(selector).owlCarousel(options);
        }
    }

    const baseOptions = {
        loop: true,
        margin: 10,
        responsiveClass: true
    };

    initOwl('#sliderHero', {
        ...baseOptions,
        responsive: {
            0: { items: 1, nav: true },
            768: { items: 1, nav: false },
            1200: { items: 1, nav: true, loop: false }
        }
    });
});