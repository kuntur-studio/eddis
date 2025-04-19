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
