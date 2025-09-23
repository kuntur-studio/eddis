<?php
/**
 * Carrusel de logos de instituciones
 */

if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

extract($args['options']);

// El array de logos puede estar vacío, así que lo comprobamos
if (empty($logos) || !is_array($logos)) {
    return;
}
?>
<section class="mb-5" id="logosCarousel">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="global-title text-center mb-5"><?php echo wp_kses_post($title); ?></h2>
                <?php if (!empty($subtitle)) : ?>
                    <h5 class="global-subtitle text-center"><?php echo wp_kses_post($subtitle); ?></h5>
                <?php endif; ?>
                
                <div class="owl-carousel owl-theme mb-5" id="logosCarouselSlider">
                    <?php foreach ($logos as $logo) : ?>
                        <div class="item">
                            <img class="img-fluid" src="<?php echo esc_url($logo['logo_img']); ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>