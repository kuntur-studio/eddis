<?php

/**
 * Obtiene las opciones de un widget específico dentro del campo 'widgets' de Carbon Fields.
 *
 * @param string $widget_type El tipo de widget que se desea obtener (e.g., 'branches_widget', 'product_banner').
 * @return array|null Un array con las opciones del widget si se encuentra, o null si no.
 */
function edd_widget_options(string $widget_type): ?array {
    // Asume que el campo 'widgets' está en las opciones de tema.
    $all_widgets = carbon_get_theme_option('widgets');
    
    if (empty($all_widgets) || !is_array($all_widgets)) {
        return null;
    }

    foreach ($all_widgets as $widget) {
        if (isset($widget['_type']) && $widget['_type'] === $widget_type) {
            // Elimina la clave '_type' ya que no es una opción del widget en sí.
            unset($widget['_type']); 
            return $widget;
        }
    }

    return null; // Si el widget no se encuentra
}

/**
 * Obtiene los datos de un formulario de contacto de marketing.
 * Los formularios son CPT con campos personalizados de Carbon Fields y se
 * definen en la sección formularios del admin de wordpress.
 *
 * @param string $form_name El nombre de identificación del formulario.
 * @return array Un array con las claves 'active' y 'code'.
 */
function edd_get_eddis_form_data($form_name) {
    $form_query_args = [
        'post_type'      => 'eddis_form',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'meta_query'     => [
            [
                'key'   => 'eddis_form_name',
                'value' => $form_name,
            ],
        ],
    ];

    $form_posts = get_posts($form_query_args);
    $form_id    = !empty($form_posts)? $form_posts[0]: 0;

    $form_data = ['active' => false, 'code' => ''];

    if ( $form_id ) {
        $form_data['active'] = (bool)carbon_get_post_meta($form_id, 'eddis_form_active');
        $form_data['code']   = carbon_get_post_meta($form_id, 'eddis_form_code');
    }

    return $form_data;
}