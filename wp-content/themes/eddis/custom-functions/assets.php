<?php
/**
 * Determina si un asset debe cargarse en el front-end
 */
function edd_should_load_in_frontend($asset) {
    // Si no hay páginas definidas, no cargar
    if (empty($asset['load_pages'])) {
        return false;
    }

    // Verificar condiciones específicas
    $load_pages = (array) $asset['load_pages'];
    $current_page_id = get_queried_object_id();

    // Lógica de carga
    return 
        in_array('all', $load_pages) ||
        (is_front_page() && in_array('home', $load_pages)) ||
        (is_archive() && in_array('archive', $load_pages)) ||
        (is_search() && in_array('search', $load_pages)) ||
        (is_404() && in_array('404', $load_pages)) ||
        (is_singular() && in_array($current_page_id, $load_pages));
}

/**
 * Determina si un asset debe cargarse en el admin
 */
function edd_should_load_in_admin($asset, $hook_suffix = '') {
    // Solo si está marcado para admin
    if (empty($asset['load_in_admin'])) {
        return false;
    }

    // Opcional: cargar solo en páginas específicas del admin
    if (isset($asset['admin_pages']) && !empty($asset['admin_pages'])) {
        return in_array($hook_suffix, (array) $asset['admin_pages']);
    }

    return true;
}

/**
 * Determina si el widget de sedes debe cargarse
 */
function edd_should_load_branches_widget() {
    $options = edd_widget_options('branches_widget');
    
    if (!$options['enable_branches_widget']) {
        return false;
    }

    $target_pages = $options['branches_widget_pages'];
    
    // Si está marcado "all" o estamos en una página seleccionada
    return in_array('all', (array)$target_pages) || 
           (in_array('home', (array)$target_pages) && is_front_page()) ||
           (is_page() && in_array(strval(get_queried_object_id()), (array)$target_pages));
}

/**
 * Localiza los datos de las sedes para el widget
 */
function edd_localize_branches_data() {
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
                                'title' => get_post_field('post_title', $branch_id, 'raw'),
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

/**
 * Normaliza la URL del asset según las reglas:
 * - Externos: URLs con http/https (se usan tal cual)
 * - Internos: Rutas relativas a la carpeta /assets/ del tema (se auto-completan)
 * - Rutas absolutas (/wp-content/...) no están permitidas (devuelve false)
 * 
 * @param string $url Ruta del asset
 * @return string|false URL normalizada o false si no cumple las reglas
 */
function edd_get_normalized_asset_url($url) {
    // 1. Validar URL externa
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return $url; // Retorna URLs https://... sin cambios
    }
    
    // 2. Rechazar rutas absolutas
    if (strpos($url, '/') === 0) {
        trigger_error('Rutas absolutas no permitidas. Usa rutas relativas a /assets/', E_USER_WARNING);
        return false;
    }
    
    // 3. Validar ruta interna (relativa a /assets/)
    // Asegurar que no hay intentos de directory traversal (../)
    $clean_path = ltrim($url, '/');
    if (strpos($clean_path, '../') !== false || strpos($clean_path, '..\\') !== false) {
        trigger_error('Directory traversal no permitido en rutas de assets', E_USER_WARNING);
        return false;
    }
    
    // Construir ruta final (asegurar que comienza con /assets/)
    return get_template_directory_uri() . '/assets/' . $clean_path;
}

/**
 * Obtiene la versión del asset (filemtime para locales, null para externos)
 */
function edd_get_asset_version($url) {
    // Si es una URL externa, no usar filemtime
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return null;
    }
    
    // Ruta local absoluta en el servidor
    $local_path = get_template_directory() . '/assets/' . ltrim($url, '/');
    
    return file_exists($local_path) ? filemtime($local_path) : null;
}

// Función compartida
function edd_enqueue_single_asset($asset) {
    $handle = sanitize_title($asset['asset_name']);
    $url = edd_get_normalized_asset_url($asset['asset_url']);
    $ver = edd_get_asset_version($asset['asset_url']);

    if ($asset['asset_type'] === 'js') {
        wp_enqueue_script(
            $handle,
            $url,
            [],
            $ver,
            $asset['load_location'] === 'footer'
        );
    } else {
        wp_enqueue_style(
            $handle,
            $url,
            [],
            $ver
        );
    }
}

// Front-end
add_action('wp_enqueue_scripts', 'edd_enqueue_frontend_assets');
function edd_enqueue_frontend_assets() {
    //require_once get_template_directory() . '/custom-functions/developer.php';
    
    if (is_admin()) return;

    // edd_write_log('Iniciando carga de assets frontend');
    
    // Cargar los assets definidos en el panel de Gestión de Assets de la página
    // de Configuración General
    $assets = carbon_get_theme_option('assets');
    foreach ($assets as $asset) {
        if (edd_should_load_in_frontend($asset)) {
            edd_enqueue_single_asset($asset);
        }
    }

    // Cargar el widget de sedes (si corresponde)
    if (edd_should_load_branches_widget()) {
        $assets_path = get_template_directory() . '/assets/';
        $assets_uri = get_template_directory_uri() . '/assets/';
        
        $widget_js_path = $assets_path . 'widgets/branches-widget/dist/branches-widget.min.js';
        $widget_css_path = $assets_path . 'widgets/branches-widget/dist/branches-widget.min.css';
        
        // edd_write_log('Ruta CSS: ' . $widget_css_path);
        // edd_write_log('URL CSS: ' . $widget_css_url);
        // edd_write_log('Existe archivo CSS: ' . (file_exists($widget_css_path) ? 'Sí' : 'No'));
        
        // Debug de dependencias
        // edd_write_log('Estado de bootstrap-css: ' . (wp_style_is('bootstrap-css', 'registered') ? 'Registrado' : 'NO registrado'));

        wp_enqueue_script(
            'branches-widget',
            $assets_uri . 'widgets/branches-widget/dist/branches-widget.min.js',
            ['wp-element'],
            filemtime($widget_js_path),
            true
        );
        
        wp_enqueue_style(
            'branches-widget-css',
            $assets_uri . 'widgets/branches-widget/dist/branches-widget.min.css',
            ['bootstrap-css'],
            filemtime($widget_css_path)
        );

        // Verificar si el style fue encolado correctamente
        // add_action('wp_footer', function() {
        //     global $wp_styles;
        //     edd_write_log('Styles encolados: ' . print_r($wp_styles->queue, true));
        //     edd_write_log('Estado branches-widget-css: ' . (wp_style_is('branches-widget-css', 'enqueued') ? 'Encolado' : 'NO encolado'));
        // }, 9999);
        
        edd_localize_branches_data();
    }

    // Cargar style.css principal del tema
    $style_path = get_template_directory() . '/style.css';
    $style_url = get_template_directory_uri() . '/style.css';

    if (file_exists($style_path)) {
        wp_enqueue_style(
            'theme-main-style',
            $style_url,
            [],
            filemtime($style_path)
        );
    }
}

// Admin
add_action('admin_enqueue_scripts', 'edd_enqueue_admin_assets');
function edd_enqueue_admin_assets($hook_suffix) {
    $assets = carbon_get_theme_option('assets');
    foreach ($assets as $asset) {
        if (edd_should_load_in_admin($asset, $hook_suffix)) {
            edd_enqueue_single_asset($asset);
        }
    }
}