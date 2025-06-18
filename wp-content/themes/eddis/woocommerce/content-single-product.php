<?php
/**
 * Plantilla para mostrar el contenido del producto en la plantilla single-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;
global $post;
$product_id = $product->get_id();

// --- Lógica para obtener el formulario de CPT 'eddis_form' ---
$form_post_name = 'form-producto'; // El slug que definiste para este formulario
$form_query_args = array(
    'post_type'      => 'eddis_form',
    'name'           => $form_post_name,
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'fields'         => 'ids', // Solo necesitamos el ID para Carbon Fields
);
$form_posts = get_posts( $form_query_args );
$form_id = ! empty( $form_posts ) ? $form_posts[0] : 0;

$is_form_active = false;
$form_code = '';

if ( $form_id ) {
    $is_form_active_field = carbon_get_post_meta( $form_id, 'eddis_form_active' );
    $is_form_active = ( $is_form_active_field === 'yes' );
    $form_code = carbon_get_post_meta( $form_id, 'eddis_form_code' );
    // Ya no necesitamos 'eddis_form_inactive_content' aquí
}
// -------------------------------------------------------------

do_action( 'woocommerce_before_single_product' ); ?>

<section class="container my-5">
    <div class="row">
        <div class="col-12">
            <?php echo '<h1 class="course-title text-center">' . get_the_title() . '</h1>';?>
        </div>
    </div>

    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'course-single-wrapper', $product ); ?>>
        <div class="row mb-5 mt-4"> <div class="col-lg-8 col-md-12">
                <div class="course-image">
                    <?php
                    /**
                     * Muestra la galería o imagen destacada del producto.
                     * Asegúrate de que el output de este hook sea responsivo (e.g., img-fluid de Bootstrap).
                     * Si no lo es, deberías envolverlo en un div y aplicar img-fluid a la imagen dentro.
                     */
                    do_action( 'woocommerce_before_single_product_summary' );
                    ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
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
                    add_action( 'woocommerce_single_product_summary', function () use ($product_id) { // Pasamos $product_id
                        global $product;
                        if (!$product) return;

                        // Precio
                        echo '<h2 class="text-end mb-4">' . $product->get_price_html() . '</h2>'; // Estilo para el precio

                        // Botón de inscripción (add to cart)
                        echo '<div class="d-grid mb-3">';
                        woocommerce_template_single_add_to_cart();
                        echo '</div>';


                        // Especificaciones del curso
                        ?>
                        <div class="course-specifications">
                            <div class="icon-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                </svg>
                                <span><b>Duración:</b> <?php echo carbon_get_post_meta($product_id, 'duration'); ?></span>
                            </div>
                            <div class="icon-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-award" viewBox="0 0 16 16">
                                    <path d="M9.664.865a.5.5 0 0 0-.928 0l-.666 1.667-1.554.414a.5.5 0 0 0-.317.721l1.173 1.173-.242 1.626a.5.5 0 0 0 .614.591l1.626-.242 1.173 1.173a.5.5 0 0 0 .721-.317l.414-1.554 1.667-.666a.5.5 0 0 0 0-.928L10.336.865zM4.309 11.996a.5.5 0 0 0-.103-.238l-1.626-.242-1.173 1.173a.5.5 0 0 0 .317.721l1.554.414.666 1.667a.5.5 0 0 0 .928 0l.666-1.667 1.554-.414a.5.5 0 0 0 .317-.721l-1.173-1.173.242-1.626a.5.5 0 0 0-.614-.591l-1.626.242-1.173-1.173a.5.5 0 0 0-.721.317l-.414 1.554-1.667.666a.5.5 0 0 0 0 .928L5.691 11.996z"/>
                                </svg>
                                <span><b>Certificación:</b> <?php echo carbon_get_post_meta($product_id, 'certification'); ?></span>
                            </div>
                            <div class="icon-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M6.271 5.053a.5.5 0 0 1 .531.02L10 8l-3.198 2.927a.5.5 0 0 1-.652-.767L9.348 8 6.271 5.82a.5.5 0 0 1-.02-.531"/>
                                </svg>
                                <span><b>Modalidad:</b> <?php echo carbon_get_post_meta($product_id, 'mode'); ?></span>
                            </div>
                        </div>
                        <?php
                    }, 5 );

                    /**
                     * Ejecuto la acción con el contenido del producto.
                     */
                    do_action( 'woocommerce_single_product_summary' );
                    ?>
                </div>
            </div>
        </div>

        <div class="row mt-5"> <div class="<?php echo $is_form_active ? 'col-lg-8' : 'col-lg-12'; ?> col-md-12">
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
                                echo '<div class="block-rich_text">' . wp_kses_post($content) . '</div>'; // Content of the Carbon Fields block
                            }
                            echo '</div>'; // .custom-content-block
                        }
                    }
                    echo '</div>'; // .course-custom-content-blocks
                }
                ?>
            </div>

            <?php if ($is_form_active && !empty($form_code)): ?>
                <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
                    <div class="form-container">
                        <h4 class="text-center mb-4">Consulta por este curso</h4>
                        <div class="external-form-content">
                            <?php echo $form_code; // Renderiza el código del formulario externo ?>
                        </div>
                    </div>
                </div>
            <?php endif; // Fin del bloque condicional para el formulario ?>

        </div>
    </div>
</section>

<?php do_action( 'woocommerce_after_single_product' ); ?>