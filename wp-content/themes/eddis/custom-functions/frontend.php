<?php

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

// Este hook se utiliza para imprimir html en el encabezado de las páginas del frontend
function wp_head_hook() {
    if (is_admin()) {
        return; // Evita que se ejecute en el panel de administración
    }

    edd_google_tag_manager(); // Imprime la etiqueta de GTM
}
add_action('wp_head', 'wp_head_hook');
