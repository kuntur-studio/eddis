<?php

/**
 * Función para forzar que la categoría de producto con ID 215 aparezca primero
 * en las consultas de términos (get_terms).
 *
 * @param array $pieces Componentes de la cláusula SQL (SELECT, FROM, WHERE, ORDER BY, etc.).
 * @param array $taxonomies Los nombres de las taxonomías consultadas.
 * @param array $args Los argumentos originales de la consulta get_terms().
 * @return array Los componentes de la cláusula SQL modificados.
 */
function edd_force_first_category($pieces, $taxonomies, $args) {
    
    // 1. Define la ID de la categoría que debe aparecer primero
    $category_id = 215;

    // 2. Solo aplica el cambio si la consulta es para categorías de producto ('product_cat')
    if (in_array('product_cat', $taxonomies)) {
        
        // Usa la función FIELD() de MySQL para ordenar específicamente la categoría $category_id
        // FIELD(t.term_id, 215) hace que solo esta ID tenga un valor que se puede ordenar.
        // ORDER BY ... DESC garantiza que 215 esté al principio.
        // El 't.name ASC' se usa como orden secundario para el resto de categorías.
        // Se podría usar orden manual utilizando drag & drop en la página de categorías 
        // de wordpress, pero eso requiere modificar además el join con la tabla termmeta
        // y ordenar por meta_key = order con meta_value ASC
        // Ver https://gemini.google.com/app/c5dd00577476a27e
        
        $pieces['orderby'] = "ORDER BY FIELD(t.term_id, {$category_id}) DESC, t.name";
    }

    // 3. Devuelve las cláusulas modificadas
    return $pieces;
}

// Engancha la función al filtro 'terms_clauses' con prioridad 10 y acepta 3 argumentos.
add_filter('terms_clauses', 'edd_force_first_category', 10, 3);


/*
 * Toma desde la configuración general los valores relacionados con GTM,
 * verifica si está activa la configuración e imprime al output el script 
 * con el service tag correspondiente
 * */
function edd_google_tag_manager() {
    // Obtener valores desde la configuración
    $active = carbon_get_theme_option('gtm_active');
    $tag = carbon_get_theme_option('gtm_service_tag');

    // Verificar si GTM está activado y si hay un Service Tag válido
    if ($active && !empty($tag)) {
        echo <<<GTM
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{$tag}');</script>
        <!-- End Google Tag Manager -->
GTM, PHP_EOL;
    }
}

/**
 * Normaliza enlaces internos y externos para banners/slides.
 *
 * - Si el enlace es una URL completa (http/https), lo devuelve sin cambios.
 * - Si es una ruta interna absoluta (comienza con "/"), la convierte en URL absoluta usando home_url().
 * - Si es una ruta interna relativa, le agrega el prefijo del sitio y la convierte en absoluta.
 *
 * Siempre retorna una URL absoluta lista para usar en atributos href o src.
 *
 * @param string $link Enlace interno o externo.
 * @return string URL absoluta.
 */

function edd_normalize_link($link) {
    // URL externa completa
    if (filter_var($link, FILTER_VALIDATE_URL)) {
        return $link;
    }

    // Ruta interna absoluta
    if (strpos($link, '/') === 0) {
        return home_url($link);
    }

    // Ruta interna relativa
    return home_url('/' . ltrim($link, '/'));
}

/**
 * Función para generar el botón de WhatsApp para consulta sobre productos de WC
 *
 * @param WC_Product $product El objeto del producto de WooCommerce.
 * @return string El código HTML del botón de WhatsApp.
 */
function edd_whatsapp_product_button($product) {
    
    // Obtener el número de WhatsApp de la configuración del tema (Carbon Fields)
    $wsapp_number = carbon_get_theme_option('contact_whatsapp');
    
    // Si no hay número configurado, no se muestra el botón
    if (empty($wsapp_number)) {
        return '';
    }

    // Limpiar el número para el enlace (solo dígitos, sin símbolos ni espacios)
    $clean_number = preg_replace('/[^0-9]/', '', $wsapp_number);

    // Configuración del mensaje y del botón
    $product_name = $product->get_name();
    $config = [
        // El número limpio. Usamos '54911...' como ejemplo si el campo solo guarda '11...'
        // Es crucial que el número tenga el código de país y de área (sin el signo +).
        'number'  => $clean_number,
        'message' => 'Quiero consultar sobre el curso: ' . $product_name,
        'text'    => 'Hablemos por Whatsapp',
        'icon'    => 'fab fa-whatsapp'
    ];

    // Generar enlace de WhatsApp con mensaje pre-rellenado y URL del producto
    // Usamos rawurlencode() para codificar la URL del producto y el mensaje.
    $full_message = $config['message'] . ' - ' . get_permalink( $product->get_id() );
    $url = 'https://wa.me/' . $config['number'] . '?text=' . rawurlencode( $full_message );

    // Generar el HTML del botón
    $html = sprintf(
        '<a id="whatsappCourseButton" href="%s" class="whatsapp-btn" target="_blank" rel="noopener noreferrer" style="%s">
            <span class="whatsapp-btn-content" style="%s">%s %s</span>
        </a>',
        esc_url( $url ),
        'display:flex; justify-content:center; width:100%;', // Contenedor principal
        'display:inline-flex; align-items:center; gap:8px;', // Contenido interno
        $config['icon'] ? '<i class="' . esc_attr( $config['icon'] ) . '"></i>' : '',
        esc_html( $config['text'] )
    );

    return $html;
}

// Este hook se utiliza para imprimir html en el encabezado de las páginas del frontend
function wp_head_hook() {
    if (is_admin()) {
        return; // Evita que se ejecute en el panel de administración
    }

    edd_google_tag_manager(); // Imprime la etiqueta de GTM
}
add_action('wp_head', 'wp_head_hook');
