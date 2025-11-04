<?php
/**
 * Template Part: featured-carousel.php
 *
 * Carrusel de productos
 * Originalmente creado para mostrar los productos de la categoría Cursos destacados, 
 * sin embargo la categoría a mostrar es un parámetro.
 *
 * @param array $args Los argumentos pasados a get_template_part.
 */

if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

extract($args['options']);

if ($category_id) {
    $query_args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        ),
    );
    $query = new WP_Query($query_args);

    if ($query->have_posts()):
?>
<section class="py-5" id="featuredCarousel">
    <div class="container">
        <div class="row mb-4 align-items-center">
            <div class="col-xl-10 col-lg-10 col-sm-12">
                <?php if ($title): ?>
                    <h2 class="global-title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif; ?>
                <?php if ($subtitle): ?>
                    <p class="global-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
            <?php if ($button_text && $button_link): ?>
                <div class="col-xl-2 col-lg-2 col-sm-12 text-lg-right mt-3 mt-lg-0">
                    <a class="btn btn-primary text-nowrap" href="<?php echo esc_url($button_link); ?>" id="allFeaturedButton">
                        <?php echo esc_html($button_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="owl-carousel owl-theme featured-carousel-slider" id="featuredCarouselSlider">
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <?php get_template_part('template-parts/featured-carousel-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php
    endif;
}
?>