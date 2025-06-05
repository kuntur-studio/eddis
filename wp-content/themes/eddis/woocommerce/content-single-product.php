<?php
/**
 * Plantilla para mostrar el contenido del producto en la plantilla single-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;
global $post;
$product_id = $product->get_id();

do_action( 'woocommerce_before_single_product' ); ?>

<section class="container">
    <div class="row my-4 justify-content-center">
        <div class="col-12 col-lg-12">
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

                <div class="course-details shadowed-box">
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
                    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );

                    /**
                     * Agrego contenido personalizado.
                     */
                    add_action( 'woocommerce_single_product_summary', function () {
                        global $product;
                        if (!$product) return;
                        $product_id = $product->get_id();

                        echo '<div class="course-card">';

                        // Precio
                        echo '<div class="course-price">' . $product->get_price_html() . '</div>';

                        // Botón de inscripción (add to cart)
                        woocommerce_template_single_add_to_cart();

                        // Especificaciones del curso ?>
                        <div class="course-specifications">
                            <ul>
                                <li><i class="fas fa-clock"></i> <b>Duración:</b> <?php echo carbon_get_post_meta($product_id, 'duration'); ?></li>
                                <li><i class="fas fa-graduation-cap"></i> <b>Certificación:</b> <?php echo carbon_get_post_meta($product_id, 'certification'); ?></li>
                                <li><i class="fas fa-circle-play"></i> <b>Modalidad:</b> <?php echo carbon_get_post_meta($product_id, 'mode'); ?></li>
                            </ul>
                        </div>
                        <?php

                        echo '</div>'; // .course-card
                    }, 5 );

                    /**
                     * Ejecuto la acción con el contenido del producto.
                     */
                    do_action( 'woocommerce_single_product_summary' );
                    ?>
                </div>
            </div>
            <div class="course-description">
                <h2>Descripción del Curso</h2>
                <?php
                // Imprimir la descripción completa del producto
                if ( $post->post_content ) {
                    echo '<div class="woocommerce-product-details__full-description">';
                    the_content(); // the_content() ya aplica filtros y es seguro para HTML
                    echo '</div>';
                }
                ?>
            </div>

            <?php
            // Obtener y mostrar content_blocks de Carbon Fields
            $content_blocks = carbon_get_post_meta($product_id, 'content_blocks');

            if (!empty($content_blocks)) {
                echo '<div class="course-custom-content-blocks">'; // A container for your custom content blocks
                foreach ($content_blocks as $block) {
                    $title = isset($block['title']) ? $block['title'] : '';
                    $content = isset($block['content']) ? $block['content'] : '';

                    if (!empty($title) || !empty($content)) {
                        echo '<div class="custom-content-block">';
                        if (!empty($title)) {
                            echo '<h3>' . esc_html($title) . '</h3>'; // Title of the Carbon Fields block
                        }
                        if (!empty($content)) {
                            // For rich_text, Carbon Fields already returns safe HTML,
                            // but it's good practice to use wp_kses_post for added security.
                            echo '<div class="block-rich-text">' . wp_kses_post($content) . '</div>'; // Content of the Carbon Fields block
                        }
                        echo '</div>'; // .custom-content-block
                    }
                }
                echo '</div>'; // .course-custom-content-blocks
            }
            ?>
            <?php // do_action( 'woocommerce_after_single_product_summary' ); ?>

            <?php do_action( 'woocommerce_after_single_product' ); ?>
        </div>
    </div>
</section>