<?php

function edd_woocommerce_setup() {
    add_theme_support( 'woocommerce' );
    // add_theme_support( 'wc-product-gallery-zoom' );
    // add_theme_support( 'wc-product-gallery-lightbox' );
    // add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'edd_woocommerce_setup' );

function edd_remove_metabox_short_description() {
    // Verifica si estamos en la pantalla de edición de productos
    if ( 'product' === get_post_type() ) {
        // Elimina el metabox de "Descripción corta"
        remove_meta_box('postexcerpt', 'product', 'normal');
    }
}
add_action('add_meta_boxes', 'edd_remove_metabox_short_description', 99);

// Acciones para ejecutar al iniciar WooCommerce
add_action( 'init', function () {
    // Elimina el breadcrumb de WooCommerce
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    
    // Desactiva la barra lateral de WooCommerce
    // La función woocommerce_get_sidebar está hookeada a 'woocommerce_sidebar' con prioridad 10.
    // Para desengancharla, debemos usar remove_action con los mismos argumentos.
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

    // Deshabilita el campo de cantidad para productos simples
    // y hace que se añadan individualmente.
    add_filter( 'woocommerce_is_sold_individually', '__return_true' );
});