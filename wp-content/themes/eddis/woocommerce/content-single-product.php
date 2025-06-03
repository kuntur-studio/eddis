<?php
/**
 * Plantilla para mostrar el contenido del producto en la plantilla single-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' ); ?>

<section class="container">
    <div class="row my-4 justify-content-center">
        <div class="col-12 col-lg-8">
            <?php
            // Título del curso
            echo '<h1 class="course-title">' . get_the_title() . '</h1>';?>
        <div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'course-single-wrapper', $product ); ?>>
            <div class="course-image">
                <?php
                /**
                 * Muestra la galería o imagen destacada del producto.
                 */
                do_action( 'woocommerce_before_single_product_summary' );
                ?>
            </div>

            <div class="course-detalle">
                <?php
                /**
                 * Elimino los hooks por defecto para personalizar el contenido más adelante.
                 */
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

                /**
                 * Agrego contenido personalizado.
                 */
                add_action( 'woocommerce_single_product_summary', function () use ( $product ) {
                    echo '<div class="course-content">';

                    // Descripción corta
                    $short_description = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
                    if ( $short_description ) {
                        echo '<div class="course-description">' . $short_description . '</div>';
                    }

                    // Precio
                    echo '<div class="course-price">' . $product->get_price_html() . '</div>';

                    // Botón de inscripción (add to cart)
                    woocommerce_template_single_add_to_cart();

                    echo '</div>';
                }, 5 );

                /**
                 * Ejecuto la acción con el contenido del producto.
                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>
            </div>
        </div>

<?php do_action( 'woocommerce_after_single_product_summary' ); ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>

    </div>
</section>