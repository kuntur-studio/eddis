<?php

add_filter('parse_query', 'edd_limit_search_to_products');
function edd_limit_search_to_products($wp_query) {
	// Solo aplica en el frontend y en búsquedas principales
	if (!is_admin() && $wp_query->is_main_query() && $wp_query->is_search()) {
		// Limitar la búsqueda a productos de WooCommerce
		$wp_query->set('post_type', 'product');
	}

	return $wp_query;
}