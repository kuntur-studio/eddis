<?php
/**
 * Template Part: full-width-carousel.php
 *
 * Carrusel de Ancho Completo.
 * Utiliza Owl Carousel y <picture> para imágenes responsivas.
 *
 * @param array $args Los argumentos pasados a get_template_part.
 */

if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

extract($args['options']);

if (empty($slides) || !is_array($slides)) {
    return;
}

// Inicializa $classes con un array vacío si no existe en $args
$classes = $args['classes'] ?? [];

// Convierte el array de clases en un string separado por espacios
$class_string = implode(' ', $classes);

?>
<section class="owl-carousel owl-theme full-width-carousel <?php echo esc_attr($class_string); ?>">
    <?php foreach ($slides as $slide): ?>
        <div class="item">
            <?php if (!empty($slide['slide_enable_link']) && !empty($slide['slide_link'])): ?>
                <a href="<?php echo esc_url($slide['slide_link']); ?>">
            <?php endif; ?>

            <picture>
                <source media="(min-width: 1200px)" srcset="<?php echo esc_url($slide['slide_lg']); ?>">
                <source media="(min-width: 768px)" srcset="<?php echo esc_url($slide['slide_md']); ?>">
                <img src="<?php echo esc_url($slide['slide_sm']); ?>" alt="" class="img-fluid">
            </picture>

            <?php if (!empty($slide['slide_enable_link']) && !empty($slide['slide_link'])): ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>
