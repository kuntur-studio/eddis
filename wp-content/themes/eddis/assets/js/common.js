jQuery(document).ready(function($) {
    // Funcionalidad del botón de scroll arriba
    // Al hacer clic en el botón, se desplaza suavemente hacia arriba
    $('.ir-arriba').click(function(){
        $('body, html').animate({
            scrollTop: '0px'
        }, 1000);
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
        $('nav li.dropdown').hover(function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(280);
        }, function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(280);
        });
    }

    // Funcionalidad del submenú en el menú de navegación.
    // Al hacer mouseover en un elemento del submenú, se marca como seleccionado y
    // se visualiza la información relacionada en la segunda columna.
    // Esto se usa en el menú de cursos.
    $('.tab-menu a').hover(function (e) {
            e.preventDefault()
            $(this).tab('show')
    });

    // Inicializar el primer tab del menú de cursos al cargar la página
    // $('#tabCursos a:first').tab('show');
    const firstTab = document.querySelector('#tabCursos a');
    if (firstTab) {
    const tab = new bootstrap.Tab(firstTab);
    tab.show();
    }
});