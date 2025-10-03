<?php
/**
 * Template Part: sedes.php
 *
 * Estructura raíz para inclusión del widget de sedes
 */

// Inicializa $classes con un array vacío si no existe en $args
$classes = $args['classes'] ?? [];

// Convierte el array de clases en un string separado por espacios
$class_string = implode(' ', $classes);
?>    <div id="branches-widget-root" class="<?php echo esc_attr($class_string); ?>"></div>