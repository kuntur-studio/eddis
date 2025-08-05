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
 * Determina el color del texto (blanco o negro) basándose en el color de fondo hexadecimal.
 * Los ponderadores para R, G y B surgen de la fórmula de la luminosidad perceptual o luminancia,
 * basada en el estándar BT.709 y se usa para calcular la "brillantez" o "claridad" que una persona 
 * percibe de un color, en lugar de un promedio matemático simple.
 * * @param string $backgroundColorHex El color de fondo en formato hexadecimal (por ejemplo, '#BA21FF').
 * @return string El color de texto hexadecimal apropiado para un buen contraste ('#000000' para negro o '#FFFFFF' para blanco).
 */
function edd_define_text_color($backgroundColorHex) {
    // Eliminar el símbolo '#' si está presente
    $backgroundColorHex = ltrim($backgroundColorHex, '#');

    // Dividir la cadena en valores RGB y convertirlos a decimal
    $red = hexdec(substr($backgroundColorHex, 0, 2));
    $green = hexdec(substr($backgroundColorHex, 2, 2));
    $blue = hexdec(substr($backgroundColorHex, 4, 2));

    // Fórmula para calcular la luminosidad
    // El resultado estará en un rango de 0 a 1
    $luminosity = ($red * 0.299 + $green * 0.587 + $blue * 0.114) / 255;

    // Determinar si el color de fondo es claro u oscuro
    if ($luminosity > 0.5) {
        // Es un color claro, usa texto negro
        return '#000000';
    } else {
        // Es un color oscuro, usa texto blanco
        return '#FFFFFF';
    }
}