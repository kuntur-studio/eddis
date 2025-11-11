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

        return '<a href="' . esc_url($url) . '" class="button more-info-button">' . esc_html($label) . '</a>';
    }

    return $button;
}

// Añade el campo DNI, lo hace requerido, y hace que el teléfono sea requerido.
add_filter('woocommerce_checkout_fields', 'customize_checkout_fields', 10, 1);
function customize_checkout_fields($fields) {
    edd_write_log('Agregando campo DNI');
    // --- Campo DNI (billing_dni) ---
    // Añade el campo DNI a la sección 'billing' (Facturación)
    $fields['billing']['billing_dni'] = [
        'label'         => __('DNI', 'woocommerce'),
        'placeholder'   => _x('Nº de DNI', 'placeholder', 'woocommerce'),
        'required'      => true,
        'class'         => ['form-row-wide'],
        'clear'         => true,
        'priority'      => 35, // Para ubicarlo después del nombre y apellido
    ];

    // --- Campo Teléfono (billing_phone) ---
    // Asegura que el campo de teléfono sea requerido
    $fields['billing']['billing_phone']['required'] = true;
    edd_write_log($fields);
    return $fields;
}

// Guarda el valor del campo DNI con el pedido
add_action('woocommerce_checkout_update_order_meta', 'save_dni_field_order_meta');
function save_dni_field_order_meta($order_id) {
    if (!empty($_POST['billing_dni'])) {
        // Guarda el DNI como metadato del pedido, usando la clave original.
        update_post_meta($order_id, '_billing_dni', sanitize_text_field($_POST['billing_dni']));
    }
}

// Muestra el DNI en la página de administración del pedido
add_action('woocommerce_admin_order_data_after_billing_address', 'display_dni_in_admin_order', 10, 1);
function display_dni_in_admin_order($order) {
    // Obtiene el DNI guardado del metadato
    $dni = $order->get_meta('_billing_dni');
    if ($dni) {
        echo '<p><strong>' . __('DNI') . ':</strong> ' . esc_html($dni) . '</p>';
    }
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