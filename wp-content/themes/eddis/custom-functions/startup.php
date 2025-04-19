<?php

add_action('after_setup_theme', function() {	
	// Carga el autoloader de Composer para el tipo personalizado de campo Icon Select.
	require_once(__DIR__.'/carbon-field-extensions/icon-select/vendor/autoload.php');
	\Carbon_Fields\Carbon_Fields::boot();
});
