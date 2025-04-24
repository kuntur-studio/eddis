<?php

// Agregar en este archivo funciones y hooks que se utilicen o deban ejecutarse en el admin

function edd_get_product_bullet_icons() {
    return [
        'graduation-cap' => '<i class="fas fa-graduation-cap"></i> Graduation Cap',
        'user-graduate'  => '<i class="fas fa-user-graduate"></i> User Graduate'
    ];
}

function edd_get_social_icons() {
	return [
        'facebook-square' => '<i class="fab fa-facebook-square"></i> Facebook',
        'instagram'	      => '<i class="fab fa-instagram"></i> Instagram',
		'youtube'         => '<i class="fab fa-youtube"></i> Youtube',
		'x-twitter'       => '<i class="fa-brands fa-x-twitter"></i> X (Twitter)',
		'whatsapp'        => '<i class="fa-brands fa-whatsapp"></i> Whatsapp',
    ];
}


// Filtro solo las provincias de la taxonomía Ubicaciones para mostrarlas en el desplegable
// que permite agregar nuevas ciudades a la taxonomía

function edd_filter_dropdown_ubicaciones($args, $taxonomy, $context) {
    // Verificar que estamos en el admin y en la taxonomía correcta
    if (is_admin() && $taxonomy === 'ubicaciones') {
        // Mostrar solo los términos que no tienen padre (provincias)
        $args['parent'] = 0;
    }
    return $args;
}
add_filter('taxonomy_parent_dropdown_args', 'edd_filter_dropdown_ubicaciones', 10, 3);

// Obtengo la lista de páginas para el campo de selección
// del gestor de assets
function edd_get_pages_list() {
    $pages = get_pages();
    $options = [];

    foreach ($pages as $page) {
        $options[$page->ID] = $page->post_title;
    }

    $options['home'] = 'Página de Inicio';
    $options['archive'] = 'Archivos';
    $options['search'] = 'Búsqueda';
    $options['404'] = 'Página 404';

    return $options;
}