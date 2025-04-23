<?php
$base_path = get_template_directory_uri();

function enqueue_font_awesome() {
	global $base_path;
	wp_enqueue_style('fontawesome', "$base_path/assets/fontawesome/css/all.min.css");
}

function enqueue_boostrap_styles() {
	global $base_path;
	wp_enqueue_style( 'bootstrap-css', "$base_path/assets/bootstrap/css/bootstrap.min.css" );
}

function enqueue_boostrap_scripts() {
	global $base_path;
	wp_enqueue_script( 'bootstrap-js', "$base_path/assets/bootstrap/js/bootstrap.min.js", array( 'jquery' ), null, true );
}

function edd_enqueue_frontend_assets() {
	global $base_path;
	
	enqueue_font_awesome();
	
	// Cargo el widget de sedes en las páginas en que se utiliza
	if (is_front_page() || is_page('sedes') || is_page('contacto')) {
		enqueue_boostrap_styles();
		wp_enqueue_script(
			'branches-widget', // Nombre del script
			"$base_path/assets/widgets/branches-widget/dist/branches-widget.min.js", // Ruta al archivo del script
			['wp-element'], // Array de dependencias
			filemtime("$base_path/assets/widgets/branches-widget/dist/branches-widget.min.js"), // Versión del script
			true // Cargar el script en el footer
		);
		
		localize_branches_data(); // Cargo los datos de las sedes
		
		// Cargo la hoja de estilos del widget
		wp_enqueue_style(
			'branches-widget-css', // Handle único
			"$base_path/assets/widgets/branches-widget/dist/branches-widget.min.css", // Ruta al archivo CSS
			['bootstrap-css'], // Dependencias
			filemtime(dirname(__FILE__) . '/assets/widgets/branches-widget/dist/branches-widget.css') // Versión (evita caché)
		);
	}
}

function edd_enqueue_admin_assets() {
    enqueue_font_awesome();
}

add_action('wp_enqueue_scripts', 'edd_enqueue_frontend_assets');
add_action('admin_enqueue_scripts', 'edd_enqueue_admin_assets');

function localize_branches_data() {
    $branches_data = []; 

    // Obtener todas las provincias (términos padre)
    $provinces = get_terms([
        'taxonomy' => 'ubicaciones',
        'parent' => 0,
        'hide_empty' => false,
    ]);

    if (!empty($provinces)) {
        foreach ($provinces as $province) {
            $province_data = [
                'province' => $province->name,
                'cities' => [],
            ];

            // Obtener todas las ciudades de la provincia
            $cities = get_terms([
                'taxonomy' => 'ubicaciones',
                'parent' => $province->term_id,
                'hide_empty' => false,
            ]);

            if (!empty($cities)) {
                foreach ($cities as $city) {
                    $city_data = [
                        'name' => $city->name,
                        'branches' => [],
                    ];

                    // Obtener las sedes de la ciudad
                    $branches_query = new WP_Query([
                        'post_type' => 'sedes',
                        'posts_per_page' => -1,
                        'tax_query' => [
                            [
                                'taxonomy' => 'ubicaciones',
                                'field' => 'term_id',
                                'terms' => $city->term_id,
                            ],
                        ],
                    ]);

                    if ($branches_query->have_posts()) {
                        while ($branches_query->have_posts()) {
                            $branches_query->the_post();
                            $branch_id = get_the_ID();

                            $branch_data = [
                                'id' => $branch_id,
                                'title' => get_post_field('post_title', $branch_id),
                                'eddis_system_id' => carbon_get_post_meta($branch_id, 'eddis_system_id'),
                                'description' => carbon_get_post_meta($branch_id, 'description'),
                                'address' => carbon_get_post_meta($branch_id, 'address'),
                                'map_iframe' => carbon_get_post_meta($branch_id, 'map_iframe'),
                                'email' => carbon_get_post_meta($branch_id, 'email'),
                                'phone' => carbon_get_post_meta($branch_id, 'phone'),
                                'facebook_link' => carbon_get_post_meta($branch_id, 'facebook_link'),
                                'instagram_link' => carbon_get_post_meta($branch_id, 'instagram_link'),
                            ];

                            $city_data['branches'][] = $branch_data;
                        }
                        wp_reset_postdata();
                    }

                    $province_data['cities'][] = $city_data;
                }
            }

            $branches_data[] = $province_data;
        }
    }

    wp_localize_script(
        'branches-widget',
        'branchesData',
        $branches_data
    );
}