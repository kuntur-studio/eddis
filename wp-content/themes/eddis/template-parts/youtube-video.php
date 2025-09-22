<?php
/**
 * Bloque del widget de YouTube
 */

// Verifica si los datos de configuración están presentes
if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

// Extrae las variables del array de opciones
extract($args['options']);

// Renderiza el HTML si hay un ID de video
if (!empty($id)) {
?>
<section class="youtube-video-section position-relative">
    <div class="youtube-banner-crop-container">
        <picture>
            <?php if (!empty($background_lg)) : ?>
                <source srcset="<?php echo esc_url($background_lg); ?>" media="(min-width: 992px)">
            <?php endif; ?>
            <?php if (!empty($background_md)) : ?>
                <source srcset="<?php echo esc_url($background_md); ?>" media="(min-width: 768px)">
            <?php endif; ?>
            <?php if (!empty($background_sm)) : ?>
                <source srcset="<?php echo esc_url($background_sm); ?>" media="(max-width: 767px)">
            <?php endif; ?>
            <img src="<?php echo esc_url($background_lg ?? $background_md ?? $background_sm ?? ''); ?>"
                 alt="Fondo de sección"
                 class="banner-main-image youtube-video-background-img">
        </picture>
    </div>

    <div class="container youtube-video-content-container">
        <div class="row">
            <div class="col-12 col-lg-7 video-column">
                <div class="youtube-video-container">
                    <iframe
                        data-src="https://www.youtube.com/embed/<?php echo esc_attr($id); ?>?autoplay=1&amp;mute=1&amp;enablejsapi=1"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen=""
                        src="https://www.youtube.com/embed/<?php echo esc_attr($id); ?>?autoplay=1&amp;mute=1&amp;enablejsapi=1"
                        class="lazyloaded"
                        data-load-mode="1">
                    </iframe>
                </div>
            </div>
            <div class="col-12 col-lg-5 content-column">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</section>
<?php
}