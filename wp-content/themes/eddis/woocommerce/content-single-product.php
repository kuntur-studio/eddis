<?php
/**
 * Plantilla para mostrar el contenido del producto en la plantilla single-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;
global $post;
$product_id = $product->get_id();

// El "Nombre de Identificación" que se definio en el gestor de formularios
$form_name = 'form-product';
$form      = edd_get_eddis_form_data($form_name);

// Obtengo los datos del banner inferior (Modalidad)
$mode_banner = edd_widget_options('mode_banner');

do_action( 'woocommerce_before_single_product' ); ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'course-single-wrapper my-4', $product ); ?>>
    <section class="container">
        <div class="row">
            <div class="col-12">
                <?php 
                // Título del curso
                echo '<h1 class="course-title text-start">' . get_the_title() . '</h1>';?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="course-image text-start">
                    <?php
                    /**
                     * Muestra la galería o imagen destacada del producto.
                     */
                    do_action( 'woocommerce_before_single_product_summary' );
                    ?>
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex justify-content-end">
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
        </div>
        <div class="row">
            <div class="<?php echo $form['active'] ? 'col-lg-7' : 'col-lg-12'; ?> col-md-12 text-start">
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
                    echo '<div class="course-custom-content-blocks">'; // Contenedor para los bloques de contenido personalizados
                    foreach ($content_blocks as $block) {
                        $title = isset($block['title']) ? $block['title'] : '';
                        $content = isset($block['content']) ? $block['content'] : '';

                        if (!empty($title) || !empty($content)) {
                            echo '<div class="custom-content-block">';
                            if (!empty($title)) {
                                echo '<h3>' . esc_html($title) . '</h3>'; // Título
                            }
                            if (!empty($content)) {
                                echo '<div class="block-rich-text">' . wp_kses_post($content) . '</div>'; // Contenido del bloque
                            }
                            echo '</div>'; // .custom-content-block
                        }
                    }
                    echo '</div>'; // .course-custom-content-blocks
                }
                ?>
            </div>

            <?php if ($form['active'] && !empty($form['code'])): ?>
            <div class="col-lg-5 col-md-12 mt-4 mt-lg-0 d-flex justify-content-end">
                <div id="formProductContainer">
                    <div class="external-form-content">
                        <?php echo $form['code']; // Renderiza el código del formulario externo ?>
                    </div>
                </div>
            </div>
            <?php endif; // Fin del bloque condicional para el formulario ?>
                <?php // do_action( 'woocommerce_after_single_product_summary' ); ?>
        </div>
    </section>
</div>
<?php 

if ($mode_banner['enable_mode_banner_widget']) {
    get_template_part('template-parts/mode-banner', null, [
        'options' => $mode_banner
    ]);
}

do_action( 'woocommerce_after_single_product' ); ?>