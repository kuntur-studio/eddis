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
<style>
    .youtube-video-section {
        position: relative;
    }

    .youtube-video-section .youtube-video-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        /* Versión móvil */
        background-image: url('<?php echo esc_url($background_sm ?? ''); ?>');
    }

    @media (min-width: 768px) {
        .youtube-video-section .youtube-video-background {
            /* Versión para tablet */
            background-image: url('<?php echo esc_url($background_md ?? ''); ?>');
        }
    }

    @media (min-width: 992px) {
        .youtube-video-section .youtube-video-background {
            /* Versión de escritorio */
            background-image: url('<?php echo esc_url($background_lg ?? ''); ?>');
        }
    }

    .youtube-video-section .container {
        position: relative;
        z-index: 1;
    }
</style>
<section class="youtube-video-section">
    <div class="youtube-video-background"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 video-column">
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
            <div class="col-12 col-lg-6 content-column">
                <?php echo wp_kses_post($content ?? ''); ?>
            </div>
        </div>
    </div>
</section>
<?php
}