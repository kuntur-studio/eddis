<?php
/**
 * Template Part: branches.php
 *
 * Estructura raíz para inclusión del widget de sedes
 */

// Inicializa $classes con un array vacío si no existe en $args
$classes = $args['classes'] ?? [];

// Convierte el array de clases en un string separado por espacios
$class_string = implode(' ', $classes);

// Obtengo parámetros extra del widget
$widget_options = edd_widget_options('branches_widget');
?>
    <section class="sedes">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="global-title text-center"><?php echo wp_kses_post($widget_options['branches_widget_title']); ?></h2>
                    <p class="global-subtitle text-center"><?php echo wp_kses_post($widget_options['branches_widget_subtitle']); ?></p>
                </div>
            </div>
        </div>
    </section>
    <div id="branches-widget-root" class="<?php echo esc_attr($class_string); ?>"></div>