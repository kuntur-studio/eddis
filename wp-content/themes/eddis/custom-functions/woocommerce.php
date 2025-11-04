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

// Optimización
// Evita la carga de datos del carrito en páginas que no son necesarias
add_filter( 'woocommerce_get_script_data', function( $script_data, $handle ) {

     if ( 'wc-cart-fragments' === $handle ) {

         if ( is_woocommerce() || is_cart() || is_checkout() ) {

             return $script_data;

         }

        return null;

      } 

      return $script_data;

 }, 10, 2 );

 // Customización del botón Agregar al carrito en la página de categoría
 add_filter('woocommerce_loop_add_to_cart_link', 'edd_custom_loop_add_to_cart_button', 10, 2);

function edd_custom_loop_add_to_cart_button($button, $product) {
    if ($product->is_type('simple') || $product->is_type('variable')) {
        $url = get_permalink($product->get_id());
        $label = __('Más información', 'woocommerce');

        return '<a href="' . esc_url($url) . '" class="button">' . esc_html($label) . '</a>';
    }

    return $button;
}

/**
    * auto_complete_order
    */
    add_action('woocommerce_order_status_changed', 'edd_auto_complete_by_payment_method', 10, 3);
    function edd_auto_complete_by_payment_method($order_id, $old_status, $new_status) {
        global $product;
        
        if (!$order_id) {
            return;
        }

        $order = wc_get_order($order_id);

		if ($order->get_status() == 'processing') {
            $order->update_status('completed');
        }
    }

    /*
    * WooCoomerce order complete 
    */
    add_action('woocommerce_order_status_completed', 'edd_payment_complete', 1, 1);
    function edd_payment_complete($order_id) {
        $order           = wc_get_order($order_id);
        $sede            = $order->get_meta('sede_selector');
        $sede_id         = substr($sede, 3);
        $billingEmail    = $order->get_billing_email();
        $billingName     = $order->get_billing_first_name();
        $billingLastName = $order->get_billing_last_name();
        $billingPhone    = $order->get_billing_phone();
        $getItems        = $order->get_items();
        $documento       = $order->get_meta('_billing_dni');

        $payment_method  = $order->get_payment_method();
        $nroOperacion    = '';

        if ('woo-mercado-pago-custom' === $payment_method) {
            $nroOperacion = get_post_meta($order_id, '_Mercado_Pago_Payment_IDs', true);
        }

		$order_items = $order->get_items();
		
		// Verificamos si hay elementos en el pedido antes de intentar acceder a ellos
		if (empty($order_items)) {
			error_log('so_payment_complete: El pedido ' . $order_id . ' no tiene productos.');
			$idCurso = -1;
		}
		else {
			// Obtenemos el primer elemento del array de ítems del pedido de forma segura
			$first_item = reset($order_items); // Devuelve el primer elemento del array
			
			if ($first_item instanceof WC_Order_Item_Product) {
				$idCurso = $first_item->get_product_id();
			} else {
				$idCurso = -1;
			}
		}
		
        $nroPago = get_post_meta($idCurso, 'matricula_cuota', true);

        if (!$nroPago) {$nroPago = 0;};

        $url = 'https://servidoreddis.com.ar/sistema/commerce.php';

        // post to the request somehow
        $res = wp_remote_post($url, [
            'method' => 'POST',
            'timeout' => 300,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => [],
            'body' => [
                'apellido'     => $billingLastName,
                'nombre'       => $billingName,
                'telefono'     => $billingPhone,
                'email'        => $billingEmail,
                'idcurweb'     => $idCurso,
                'centro'       => $sede_id,
                'nropago'      => 1,
                'documento'    => $documento,
                'nrooperacion' => $nroOperacion,
                'test'         => 0,],
            'cookies' => []
        ]);

        if (is_wp_error($res)) {
            $error_message = $res->get_error_message();
            echo "Something went wrong: $error_message";
        }
    }