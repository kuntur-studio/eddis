<?php
/**
 * Card de producto para el carrusel de "Cursos Destacados"
 */

$product = wc_get_product(get_the_ID());

// Asegúrate de que el producto existe antes de obtener sus datos
if ($product) {
    $product_name = $product->get_name();
    $product_price = $product->get_price_html();
    $product_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
    $product_link = get_permalink();
}
?>

<div class="item shadowed-box">
    <div class="global-card">
        <a class="global-card-anchor" href="<?php echo esc_url($product_link); ?>"></a>

        <?php if ($product && has_post_thumbnail()): ?>
            <div class="image-container">
                <?php
                    // Muestra la imagen destacada del producto con los atributos correctos
                    echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', array(
                        'class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail',
                        'decoding' => 'async',
                        'alt' => esc_attr($product_alt ? $product_alt : $product_name)
                    ));
                ?>
            </div>
        <?php endif; ?>

        <div class="global-card-body d-flex flex-column justify-content-between">
            <div>
                <h3><?php echo esc_html($product_name); ?></h3>
                <div class="d-flex justify-content-between align-items-center">
                    <h6><?php echo wp_kses_post($product_price); ?></h6>
                    <a href="<?php echo esc_url($product_link); ?>" id="viewCourseButton">Ver curso</a>
                </div>
            </div>
        </div>
    </div>
</div>