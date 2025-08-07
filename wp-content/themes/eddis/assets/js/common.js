jQuery(document).ready(function($) {
    let firstInteraction = true;
    // Funcionalidad del botón de scroll arriba
    // Al hacer clic en el botón, se desplaza suavemente hacia arriba
    $('.ir-arriba').click(function(){
        window.scrollTo(0, 0);
        // La versión anterior usaba jQuery y aplicaba animación, pero bootstrap y elementor 
        // ya establecen scroll behaviour a smooth
    });

    // Mostrar u ocultar el botón de scroll arriba
    $(window).scroll(function(){
        if( $(this).scrollTop() > 600 ){
            $('.ir-arriba').slideDown(100);
        } else {
            $('.ir-arriba').slideUp(100);
        }
    });

    // Funcionalidad del menú desplegable.
    // Al pasar el mouse en un elemento del menú, se despliega el submenú.
    // no es funcionalidad estandar de bootstrap.
    // Aplica solo en pantallas grandes.
    if (window.matchMedia('(max-width: 992px)').matches) {} else {
        // let coursesMenuFirstInteraction = true;
        const $dropdownParent = $('nav li.dropdown'); // Contenedor principal
        
        $dropdownParent.hover(
            function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(280);
            
            // if (coursesMenuFirstInteraction && $('#tabCursos .tab-pane.active').length === 0) {
            //     $('#tabCursos a:first').tab('show');
            // }
            // coursesMenuFirstInteraction = false;
            },
            function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(280, function() {
                $dropdownParent.find('.nav-link.active').removeClass('active');
            });
            }
        );
    }
});

function showSearchBox() {
    div = document.getElementById('floatSearchBox');
    div.style.visibility = 'visible';
    div.style.opacity = '1';
}

function hideSearchBox() {
    div = document.getElementById('floatSearchBox');
    div.style.visibility = 'hidden';
    div.style.opacity = '0';
}