<?php
/**
 * The Footer for our theme's WooCommerce pages.
 *
 * This file is specifically for WooCommerce pages (e.g., product, shop).
 * It explicitly includes the main site footer.php.
 *
 * @package Eddis
 */

// Llama al pie de página global del sitio
// Esta estrategia permite mantener el footer.php del tema principal en esta instancia,
// y en un futuro poder crear un footer específico para WooCommerce si es necesario.
get_footer();
?>