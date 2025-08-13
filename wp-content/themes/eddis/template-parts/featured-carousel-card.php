<?php
/**
 * Card de producto para el carrusel de "Cursos Destacados"
 */

$product       = wc_get_product(get_the_ID());
$product_name  = $product->get_name();
$product_price = $product->get_price_html();
$product_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
$product_link  = get_permalink();

$categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('exclude' => array(2)));
?>
<div class="item">
    <div class="global-card">
        <a class="global-card-anchor" href="<?php echo esc_url($product_link); ?>"></a>
        <?php if ($product_image): ?>
            <div class="imagen-de-fondo" style="background-image: url('<?php echo esc_url($product_image); ?>')"></div>
        <?php endif; ?>

        <div class="global-card-body igualar">
            <?php foreach ($categories as $category): ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>

            <h3><?php echo esc_html($product_name); ?></h3>
            <h6><?php echo wp_kses_post($product_price); ?></h6>
        </div>

        <div class="global-card-footer text-right">
            <a href="<?php echo esc_url($product_link); ?>">Ver curso</a>
        </div>
    </div>
</div>
