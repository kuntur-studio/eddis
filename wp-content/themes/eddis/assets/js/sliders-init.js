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
            0: {items: 1, nav: false, dots: true},
            768: {items: 1, nav: false},
            1200: {items: 1, nav: true, loop: false}
        }
    });

    initOwl('#featuredCarousel', {
        ...baseOptions,
        margin:20,
        mouseDrag: true,
        responsive:{
            0: {items:1, nav:false},
            768: {items:2, nav:false},
            1200: {items:3, nav:true, loop:false}
        }
    });
});