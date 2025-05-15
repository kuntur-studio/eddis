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
        'fa-brands fa-square-facebook'  => '<i class="fa-brands fa-square-facebook"></i> Facebook',
        'fa-brands fa-instagram'        => '<i class="fa-brands fa-instagram"></i> Instagram',
        'fa-brands fa-youtube'          => '<i class="fa-brands fa-youtube"></i> YouTube',
        'fa-brands fa-x'                => '<i class="fa-brands fa-x"></i> X (Twitter)',
        'fa-brands fa-whatsapp'         => '<i class="fa-brands fa-whatsapp"></i> WhatsApp',
        'fa-brands fa-linkedin'         => '<i class="fa-brands fa-linkedin"></i> LinkedIn',
        'fa-brands fa-tiktok'           => '<i class="fa-brands fa-tiktok"></i> TikTok',
        'fa-brands fa-telegram'         => '<i class="fa-brands fa-telegram"></i> Telegram',
        'fa-brands fa-discord'          => '<i class="fa-brands fa-discord"></i> Discord',
        'fa-solid fa-envelope'          => '<i class="fa-solid fa-envelope"></i> Email',
        'fa-solid fa-phone'             => '<i class="fa-solid fa-phone"></i> Teléfono',
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