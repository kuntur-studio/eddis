<?php

// Sedes ----------------------------------------------------------------------------------------------------
function edd_register_sedes_post_type() {
	$labels = [
		'name'          => 'Sedes',
		'singular_name' => 'Sede',
		'menu_name'     => 'Sedes',
		'all_items'     => 'Todas las Sedes',
		'add_new'       => 'Añadir Nueva',
		'add_new_item'  => 'Añadir Nueva Sede',
		'edit_item'     => 'Editar Sede',
		'view_item'     => 'Ver Sede',
		'search_items'  => 'Buscar Sedes',
		'not_found'     => 'No se encontraron sedes',
	];

	$args = [
		'label'           	  => 'sedes',
		'labels'          	  => $labels,
		'public'          	  => true, // Permite que el CPT exista en el admin
		'publicly_queryable'  => false,     // Evita que sea accesible via URL (ej: /sedes/)
		'has_archive'         => false,     // Desactiva el archive
		'show_in_nav_menus'   => false,     // Opcional: no mostrar en menús
    	'show_ui'             => true,      // Mantiene la UI en el admin (para editar datos)
		'menu_position'   	  => 5,
		'menu_icon'       	  => 'dashicons-location-alt',
		//'supports'          => ['title', 'editor', 'thumbnail', 'custom-fields'],
		'supports'        	  => ['title'],
		'hierarchical'        => false, // No anidar sedes entre sí
		//'rewrite'         	  => ['slug' => 'sedes'],
		'rewrite' 			  => false,  // Evita que WordPress genere reglas de URL para /sedes/
		'exclude_from_search' => false,
	];

	register_post_type('sedes', $args);
}
add_action('init', 'edd_register_sedes_post_type');
// Fin Sedes ------------------------------------------------------------------------------------------------