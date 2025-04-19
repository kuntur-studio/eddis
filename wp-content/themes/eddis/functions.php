<?php

/**
 * Setup
 */
add_theme_support('title-tag');

@ini_set( 'upload_max_size' , '256M' );
@ini_set( 'post_max_size', '256M');
@ini_set( 'max_execution_time', '600' );

// Los siguientes archivos contienen hooks y funciones
// Las funciones que no se hayan ejecutado dentro del contexto de cada archivo,
// por funcionamiento de PHP, no estarán disponibles en los demás y se deberá 
// realizar un nuevo require en ese archivo
require_once(get_stylesheet_directory().'/custom-functions/startup.php');
require_once(get_stylesheet_directory().'/custom-functions/admin.php');
require_once(get_stylesheet_directory().'/custom-functions/api-calls.php');
require_once(get_stylesheet_directory().'/custom-functions/assets.php');
require_once(get_stylesheet_directory().'/custom-functions/common.php');
require_once(get_stylesheet_directory().'/custom-functions/custom-fields.php');
require_once(get_stylesheet_directory().'/custom-functions/custom-post-types.php');
require_once(get_stylesheet_directory().'/custom-functions/maintenance-mode.php');
require_once(get_stylesheet_directory().'/custom-functions/other.php');
require_once(get_stylesheet_directory().'/custom-functions/security.php');
require_once(get_stylesheet_directory().'/custom-functions/shortcodes.php');
require_once(get_stylesheet_directory().'/custom-functions/taxonomies.php');
require_once(get_stylesheet_directory().'/custom-functions/widgets.php');
require_once(get_stylesheet_directory().'/custom-functions/woocommerce.php');
require_once(get_stylesheet_directory().'/custom-functions/temp.php');