jQuery(document).ready(function($) {
    let firstInteraction = true;
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
        let coursesMenuFirstInteraction = true;
  
        $('nav li.dropdown').hover(
            // Mouse enter
            function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(280);
                
                if (coursesMenuFirstInteraction && $('#tabCursos .tab-pane.active').length === 0) {
                    $('#tabCursos a:first').tab('show');
                }
                coursesMenuFirstInteraction = false;
            },
            // Mouse leave
            function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(280, function() {
                // Solo limpia active de los nav-links dentro de este menú específico
                $(this).find('.nav-link.active').removeClass('active');
            });
            }
        );
    }

    // Funcionalidad del submenú en el menú de navegación.
    // Al hacer mouseover en un elemento del submenú, se marca como seleccionado y
    // se visualiza la información relacionada en la segunda columna.
    // Esto se usa en el menú de cursos.
    $('.tab-menu a').hover(function (e) {
            e.preventDefault()
            $(this).tab('show')
    });

    // $('#tabCursos a:first').tab('show');
    // Inicializar el primer tab del menú de cursos al cargar sin abrir el dropdown
    // const firstTab = document.querySelector('#tabCursos a');
    // if (firstTab) {
    //     new bootstrap.Tab(firstTab).show();

    //     // Evita que el dropdown quede abierto al iniciar
    //     document.querySelectorAll('.dropdown.show').forEach(el => el.classList.remove('show'));
    //     document.querySelectorAll('.dropdown-menu.show').forEach(el => el.classList.remove('show'));
    // }

    // // Limpiar selección cuando el mouse sale del menú
    // document.querySelector('#tabCursos')?.addEventListener('mouseleave', () => {
    //     document.querySelector('#tabCursos a.active')?.classList.remove('active');
    //     document.querySelector('.tab-content .tab-pane.active')?.classList.remove('active', 'show');
    // });
});