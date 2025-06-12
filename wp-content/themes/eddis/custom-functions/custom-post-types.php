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

// Formularios ------------------------------------------------------------------------------------------------
add_action( 'init', 'eddis_forms_cpt' );
function eddis_forms_cpt() {
    $labels = array(
        'name'                  => 'Formularios',
        'singular_name'         => 'Formulario',
        'menu_name'             => 'Formularios',
        'name_admin_bar'        => 'Formulario',
        'archives'              => 'Archivo de Formularios',
        'attributes'            => 'Atributos del Formulario',
        'parent_item_colon'     => 'Formulario Padre:',
        'all_items'             => 'Todos los Formularios',
        'add_new_item'          => 'Agregar Nuevo Formulario',
        'add_new'               => 'Agregar Nuevo',
        'new_item'              => 'Nuevo Formulario',
        'edit_item'             => 'Editar Formulario',
        'update_item'           => 'Actualizar Formulario',
        'view_item'             => 'Ver Formulario',
        'view_items'            => 'Ver Formularios',
        'search_items'          => 'Buscar Formulario',
        'not_found'             => 'No encontrado',
        'not_found_in_trash'    => 'No encontrado en la papelera',
        'insert_into_item'      => 'Insertar en formulario',
        'uploaded_to_this_item' => 'Subido a este formulario',
        'filter_items_list'     => 'Filtrar lista de formularios',
        'items_list_navigation' => 'Navegación de lista de formularios',
        'items_list'            => 'Lista de Formularios',
    );
    $args = array(
        'label'                 => 'Formulario',
        'description'           => 'Formularios generados por CRM externos (Eddis)',
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-feedback',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'eddis_form', $args );
}
// Fin Formularios -------------------------------------------------------------------------------------------