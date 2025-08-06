<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Obtengo el término actual (categoría de producto)
$term = get_queried_object();
$term_id = $term->term_id;

// Color representativo de la categoría
$category_color = carbon_get_term_meta( $term_id, 'category_color' );

if ( $category_color ) : ?>
    <style>
        /* Estilos personalizados para el botón "Más información" según el color de la categoría */
        .woocommerce .product-card .button {
            background-color: <?php echo esc_attr($category_color); ?>;
            border-color: <?php echo esc_attr($category_color); ?>;
            color: <?php echo esc_attr(edd_define_text_color($category_color)); ?>;
        }

        .woocommerce .product-card .button:hover {
            background-color: <?php echo esc_attr($category_color); ?>; /* anula override de WC */
            border-color: <?php echo esc_attr($category_color); ?>;
            color: <?php echo esc_attr(edd_define_text_color($category_color)); ?>;
        }
    </style>
<?php endif;


// Imágenes para el banner responsivo de categoría
$category_banner_lg = carbon_get_term_meta( $term_id, 'category_banner_lg' );
$category_banner_md = carbon_get_term_meta( $term_id, 'category_banner_md' );
$category_banner_sm = carbon_get_term_meta( $term_id, 'category_banner_sm' );

// Determinar una imagen de fallback si ninguna está configurada (preferencia: LG > MD > SM)
$fallback_image = '';
if ( ! empty( $category_banner_lg ) ) {
    $fallback_image = $category_banner_lg;
} elseif ( ! empty( $category_banner_md ) ) {
    $fallback_image = $category_banner_md;
} elseif ( ! empty( $category_banner_sm ) ) {
    $fallback_image = $category_banner_sm;
}

// Mostrar el banner responsivo si al menos una imagen está configurada
if ( ! empty( $category_banner_lg ) || ! empty( $category_banner_md ) || ! empty( $category_banner_sm ) ) : ?>
    <div class="banner-full-width-container category-banner-wrapper">
        <picture id="widget-category-banner">
            <?php if (!empty($category_banner_lg)) : ?>
                <source srcset="<?php echo esc_url($category_banner_lg); ?>" media="(min-width: 1200px)">
            <?php endif; ?>
            <?php if (!empty($category_banner_md)) : ?>
                <source srcset="<?php echo esc_url($category_banner_md); ?>" media="(min-width: 768px)">
            <?php endif; ?>
            <?php if (!empty($category_banner_sm)) : ?>
                <source srcset="<?php echo esc_url($category_banner_sm); ?>" media="(max-width: 767px)">
            <?php endif; ?>
            <?php if ( ! empty( $fallback_image ) ) : ?>
                <img src="<?php echo esc_url($fallback_image); ?>"
                        alt="<?php echo esc_attr( $term->name ); ?> Banner"
                        class="banner-full-width-image">
            <?php endif; ?>
        </picture>
    </div>
<?php
endif;

// Slider del encabezado, se edita desde el editor de SS3 (ver el ID del slider en el código de abajo)
//echo do_shortcode('[smartslider3 slider="4"]');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

// Elimina el conteo de resultados
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// Elimina el ordenamiento del hook predeterminado para moverlo
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

?>
<div class="container my-5"> 
    <?php if ( woocommerce_product_loop() ) : ?>
        <div class="eddis-category-ordering-title-wrapper">
            <?php
            // Llama directamente a la función de ordenamiento para colocarlo primero
            woocommerce_catalog_ordering();
            ?>
            
            <header class="woocommerce-products-header">
                <h1 class="woocommerce-products-header__title page-title eddis-page-title">Nuestros cursos</h1>
            </header>
        </div>

        <?php
        do_action( 'woocommerce_before_shop_loop' );
        ?>

        <div class="row"> <?php /*woocommerce_product_loop_start();*/ ?>

            <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>

                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <?php
                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content', 'product' );
                        ?>
                    </div>

                <?php endwhile; ?>
            <?php endif; ?>

            <?php /*woocommerce_product_loop_end();*/ ?>

        </div> <?php
        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action( 'woocommerce_after_shop_loop' );
        ?>

    <?php else : ?>
        <?php
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action( 'woocommerce_no_products_found' );
        ?>
    <?php endif; ?>

</div><?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
?>