jQuery(document).ready(function($) {
    $('.ir-arriba').click(function(){
        $('body, html').animate({
            scrollTop: '0px'
        }, 1000);
    });

    $(window).scroll(function(){
        if( $(this).scrollTop() > 600 ){
            $('.ir-arriba').slideDown(100);
        } else {
            $('.ir-arriba').slideUp(100);
        }
    });
});