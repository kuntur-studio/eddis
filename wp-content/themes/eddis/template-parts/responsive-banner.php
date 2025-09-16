<?php
/**
 * Banner responsivo con imágenes en tres dimensiones.
 * Se puede usar con o sin un enlace.
 */

if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

// Inicializa $classes con un array vacío si no existe en $args
$classes = $args['classes'] ?? [];

// Convierte el array de clases en un string separado por espacios
$class_string = implode(' ', $classes);

// Extrae las opciones del array
extract($args['options']);

// Verificar si debemos envolver en un enlace
$should_wrap_link = $enable_link && !empty($banner_link);

// --- ALTERNATIVA AVANZADA PARA FALLBACK ---
$fallback_image = !empty($banner_lg) ? $banner_lg :
                 (!empty($banner_md) ? $banner_md :
                 (!empty($banner_sm) ? $banner_sm : ''));
// -----------------------------------------

// Mostrar el banner responsivo si al menos una imagen está configurada
if ( ! empty( $banner_lg ) || ! empty( $banner_md ) || ! empty( $banner_sm ) ) {
    if ($should_wrap_link) : ?>
        <a href="<?php echo esc_url($banner_link); ?>">
    <?php endif; ?>
    <div class="banner-full-width-container banner-wrapper <?php echo esc_attr($class_string); ?>">
        <picture id="widget-banner-one">
            <?php if (!empty($banner_lg)) : ?>
                <source srcset="<?php echo esc_url($banner_lg); ?>" media="(min-width: 1200px)">
            <?php endif; ?>
            <?php if (!empty($banner_md)) : ?>
                <source srcset="<?php echo esc_url($banner_md); ?>" media="(min-width: 768px)">
            <?php endif; ?>
            <?php if (!empty($banner_sm)) : ?>
                <source srcset="<?php echo esc_url($banner_sm); ?>" media="(max-width: 767px)">
            <?php endif; ?>
            <?php if ( ! empty( $fallback_image ) ) : ?>
                <img src="<?php echo esc_url($fallback_image); ?>"
                        alt="<?php echo esc_attr( $term->name ); ?> Banner"
                        class="banner-full-width-image">
            <?php endif; ?>
        </picture>
    </div>

    <?php if ($should_wrap_link) : ?>
        </a>
    <?php endif; ?>
<?php
}