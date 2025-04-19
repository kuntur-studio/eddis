<?php

// Sedes ----------------------------------------------------------------------------------------------------
function edd_register_sedes_taxonomy() {
	$labels = [
		'name'              => 'Ubicaciones',
		'singular_name'     => 'Ubicación',
		'search_items'      => 'Buscar Ubicaciones',
		'all_items'         => 'Todas las Ubicaciones',
		'parent_item'       => 'Provincia',
		'parent_item_colon' => 'Provincia:',
		'edit_item'         => 'Editar Ubicación',
		'update_item'       => 'Actualizar Ubicación',
		'add_new_item'      => 'Añadir Nueva Ubicación',
		'new_item_name'     => 'Nuevo Nombre de Ubicación',
		'menu_name'         => 'Ubicaciones',
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => true, // Provincias > Ciudades
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => ['slug' => 'ubicaciones'],
	];

	register_taxonomy('ubicaciones', ['sedes'], $args);
}
add_action('init', 'edd_register_sedes_taxonomy');
// Fin Sedes ------------------------------------------------------------------------------------------------