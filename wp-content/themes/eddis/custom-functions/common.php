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