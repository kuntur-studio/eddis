<?php

// function import_sedes_taxonomy_from_csv($csv_file_path) {
//     $taxonomy = 'ubicaciones'; // Asegurate de que la taxonomía esté registrada

//     if (!file_exists($csv_file_path)) {
//         wp_die('El archivo CSV no existe.');
//     }

//     $file = fopen($csv_file_path, 'r');
//     $header = fgetcsv($file); // Leer encabezados (ID, Name, Slug, Parent ID)

//     $terms_data = [];
//     while (($row = fgetcsv($file)) !== false) {
//         $terms_data[] = [
//             'id'      => $row[0],
//             'name'    => $row[1],
//             'slug'    => $row[2],
//             'parent'  => $row[3], // ID de la categoría padre en la web vieja
//         ];
//     }
//     fclose($file);

//     // Mapeo de IDs viejos a nuevos términos
//     $id_map = [];

//     // Crear términos sin jerarquía primero
//     foreach ($terms_data as $term) {
//         $new_term = wp_insert_term($term['name'], $taxonomy, [
//             'slug' => $term['slug'],
//         ]);

//         if (!is_wp_error($new_term)) {
//             $id_map[$term['id']] = $new_term['term_id']; // Guardamos el nuevo ID
//         }
//     }

//     // Asignar jerarquía (parent-child)
//     foreach ($terms_data as $term) {
//         if ($term['parent'] && isset($id_map[$term['parent']])) {
//             wp_update_term($id_map[$term['id']], $taxonomy, [
//                 'parent' => $id_map[$term['parent']],
//             ]);
//         }
//     }

//     echo 'Importación de sedes completada.';
// }

// // Para ejecutar: importar manualmente el CSV desde el path correcto
// // import_sedes_taxonomy_from_csv('/ruta/del/archivo/sedes_taxonomy_export.csv');
 

// add_action('init', function() {
//     if (isset($_GET['import_sedes']) && $_GET['import_sedes'] === '1') {
// 		$path = '/home/eddisar/public_html/dev/temp_can_delete/';
		
//         import_sedes_taxonomy_from_csv($path . 'sedes_taxonomy_export.csv');
//         echo 'Importación completada.';
//         exit;
//     }
// });


// En este paso ya se importó la taxonomía y hago una prueba para verificar la coincidencia de ciudad y provincia de origen con la de destino para tener certeza de que la sede va a apuntar en destino a la ciudad correcta

// function test_import_sedes_from_json() {
//     // Ruta del archivo JSON
//     $path = '/home/eddisar/public_html/dev/temp_can_delete/';
//     $file_path = $path . 'sedes_export.json';

//     if (!file_exists($file_path)) {
//         die('El archivo JSON no existe.');
//     }

//     $json_data = file_get_contents($file_path);
//     $sedes = json_decode($json_data, true);

//     if (!$sedes) {
//         die('Error al decodificar JSON.');
//     }

//     $ciudades_no_encontradas = [];
//     $ciudades_duplicadas = [];

//     foreach ($sedes as $sede) {
//         $categorias = $sede['categorias'];

// 		$ciudad_nombre = end($categorias)['nombre'] ?? null; 
// 		$provincia_nombre = prev($categorias)['nombre'] ?? null;

//         if (!$ciudad_nombre || !$provincia_nombre) {
//             echo "⚠️ Sede sin ciudad/provincia: {$sede['title']}<br>";
//             continue;
//         }

//         // Buscar términos en la taxonomía 'ubicaciones' que coincidan con la ciudad
//         $ciudades_encontradas = get_terms([
//             'taxonomy'   => 'ubicaciones',
//             'name'       => $ciudad_nombre,
//             'hide_empty' => false
//         ]);

//         if (empty($ciudades_encontradas)) {
//             $ciudades_no_encontradas[] = $ciudad_nombre;
//             echo "❌ No se encontró la ciudad: {$ciudad_nombre} (Provincia: {$provincia_nombre})<br>";
//             continue;
//         }

//         // Verificar si la ciudad pertenece a la misma provincia en la taxonomía
//         $ciudad_valida = null;
//         foreach ($ciudades_encontradas as $ciudad) {
//             $provincia = get_term($ciudad->parent, 'ubicaciones'); // Obtener el término padre (provincia)
//             if ($provincia && $provincia->name === $provincia_nombre) {
//                 $ciudad_valida = $ciudad;
//                 break;
//             }
//         }

//         if ($ciudad_valida) {
//             echo "✅ Sede '{$sede['title']}' → Ciudad encontrada: {$ciudad_nombre} ({$provincia_nombre})<br>";
//         } else {
//             $ciudades_duplicadas[] = $ciudad_nombre;
//             echo "⚠️ La ciudad '{$ciudad_nombre}' está en más de una provincia o no coincide con '{$provincia_nombre}'<br>";
//         }
//     }

//     // Resumen
//     echo "<br>🔍 **Resumen de la verificación**:<br>";
//     echo "✔️ Ciudades correctamente asignadas: " . (count($sedes) - count($ciudades_no_encontradas) - count($ciudades_duplicadas)) . "<br>";
//     echo "❌ Ciudades no encontradas: " . count($ciudades_no_encontradas) . "<br>";
//     echo "⚠️ Ciudades con ambigüedad (más de una provincia): " . count($ciudades_duplicadas) . "<br>";
// }

// // Ejecutar con /?test_import_sedes=1
// add_action('init', function() {
//     if (isset($_GET['test_import_sedes']) && current_user_can('manage_options')) {
//         test_import_sedes_from_json();
//     }
// });


// function debug_categorias_json() {
//     $path = '/home/eddisar/public_html/dev/temp_can_delete/';
//     $file_path = $path . 'sedes_export.json';

//     if (!file_exists($file_path)) {
//         die('El archivo JSON no existe.');
//     }

//     $json_data = file_get_contents($file_path);
//     $sedes = json_decode($json_data, true);

//     if (!$sedes) {
//         die('Error al decodificar JSON.');
//     }

//     foreach ($sedes as $sede) {
//         echo "<pre>";
//         echo "📍 **Sede**: " . $sede['title'] . "\n";
//         echo "🔎 **Categorias**: ";
//         print_r($sede['categorias']); // Mostrar todo el array de categorías
//         echo "</pre>";
//     }

//     die();
// }

// // Ejecutar con /?debug_categorias=1
// add_action('init', function() {
//     if (isset($_GET['debug_categorias']) && current_user_can('manage_options')) {
//         debug_categorias_json();
//     }
// });

// function obtenerCiudadCorrecta(array $taxonomia) {
//     // Ordenar la taxonomía por ID descendente y obtener el primer elemento (el de mayor ID)
//     usort($taxonomia, function ($a, $b) {
//         return $b['id'] - $a['id'];
//     });
//     return $taxonomia[0] ?? null;
// }

// function obtenerProvinciaCorrecta(array $taxonomia) {
//     $provincia = null;

//     // Recorremos el array para identificar los elementos clave
//     foreach ($taxonomia as $categoria) {
//         if ($categoria['id'] == 9 || $categoria['id'] == 2) {
//             continue;
// 		} elseif ($categoria['id'] < ($provincia['id'] ?? 10000)) {
// 			$provincia = $categoria;
//         }
//     }

//     // Devolvemos el nombre de la provincia
//     return $provincia;
// }

// function importar_sedes_desde_json() {
//     $path = '/home/eddisar/public_html/dev/temp_can_delete/';
//     $file_path = $path . 'sedes_export.json';

//     if (!file_exists($file_path)) {
//         die('El archivo JSON no existe.');
//     }

//     $json_data = file_get_contents($file_path);
//     $sedes = json_decode($json_data, true);

//     if (!$sedes) {
//         die('Error al decodificar JSON.');
//     }

//     foreach ($sedes as $sede) {
//         $categorias = $sede['categorias'] ?? [];
        
//         $ciudad_data = obtenerCiudadCorrecta($categorias);
//         $provincia_data = obtenerProvinciaCorrecta($categorias);
//         $ciudad_nombre = $ciudad_data['nombre'] ?? null;
//         $provincia_nombre = $provincia_data['nombre'] ?? null;

//         if (!$ciudad_nombre || !$provincia_nombre) {
//             echo "⚠️ Sede sin ciudad/provincia: {$sede['title']}<br>";
//             continue;
//         }

//         // Buscar la ciudad en la taxonomía
//         $ciudad_valida = null;
//         $ciudades_encontradas = get_terms([
//             'taxonomy'   => 'ubicaciones',
//             'name'       => $ciudad_nombre,
//             'hide_empty' => false
//         ]);

//         foreach ($ciudades_encontradas as $ciudad) {
//             $provincia = get_term($ciudad->parent, 'ubicaciones');
//             if ($provincia && $provincia->name === $provincia_nombre) {
//                 $ciudad_valida = $ciudad;
//                 break;
//             }
//         }

//         if (!$ciudad_valida) {
//             echo "❌ No se encontró la ciudad válida: {$ciudad_nombre} (Provincia: {$provincia_nombre})<br>";
//             continue;
//         }

//         // Crear la nueva sede
//         $sede_id = wp_insert_post([
//             'post_title'  => $sede['title'],
//             'post_type'   => 'sedes',
//             'post_status' => 'publish'
//         ]);
//         echo "✅ Creando sede: {$sede['title']}<br>";

//         if ($sede_id) {
//             // Asignar ubicación correctamente
//             wp_set_object_terms($sede_id, [$ciudad_valida->term_id], 'ubicaciones', false);
            
//             // Mapear campos del JSON a los nombres de Carbon Fields
//             $meta_fields = [
//                 'eddis_system_id' => $sede['id_sistema_eddis'] ?? '', // Mapeado correctamente
//                 'description' => $sede['descripcion'] ?? '', // Mapeado correctamente
//                 'address' => $sede['direccion'] ?? '', // Mapeado correctamente
//                 'map_iframe' => $sede['mapa_iframe'] ?? '', // Mapeado correctamente
//                 'email' => $sede['correo_electronico'] ?? '', // Mapeado correctamente
//                 'phone' => $sede['telefono'] ?? '', // Mapeado correctamente
//                 'facebook_link' => $sede['facebook_sede'] ?? '', // Mapeado correctamente
//                 'instagram_link' => $sede['instagram_sede'] ?? '' // Mapeado correctamente
//             ];

//             foreach ($meta_fields as $key => $value) {
//                 if (!empty($value)) {
// 					if ($key === 'map_iframe') {
//                         // Sanitizar el iframe permitiendo HTML
//                         // carbon_set_post_meta($sede_id, $key, wp_kses_post($value));
// 						carbon_set_post_meta($sede_id, $key, $value);
//                     } else {
//                         // Sanitizar campos de texto simples
//                         carbon_set_post_meta($sede_id, $key, sanitize_text_field($value));
//                     }
//                 }
//             }
//         }
//     }
// }

// // Ejecutar con /?import_sedes=1
// add_action('init', function() {
//     if (isset($_GET['import_sedes']) && current_user_can('manage_options')) {
//         importar_sedes_desde_json();
//     }
// });


// function test_import_sedes_from_json() {
//     // Ruta del archivo JSON
//     $path = '/home/eddisar/public_html/dev/temp_can_delete/';
//     $file_path = $path . 'sedes_export.json';

//     if (!file_exists($file_path)) {
//         die('El archivo JSON no existe.');
//     }

//     $json_data = file_get_contents($file_path);
//     $sedes = json_decode($json_data, true);

//     if (!$sedes) {
//         die('Error al decodificar JSON.');
//     }

//     $ciudades_no_encontradas = [];
//     $ciudades_duplicadas = [];

//     foreach ($sedes as $sede) {
//         $categorias = $sede['categorias'];
        
//         $ciudad_data = obtenerCiudadCorrecta($categorias);
// 		$provincia_data = obtenerProvinciaCorrecta($categorias);
//         $ciudad_nombre = $ciudad_data['nombre'] ?? null;
//         $provincia_nombre = $provincia_data['nombre'] ?? null;

// 		echo $ciudad_nombre, ' ', $provincia_nombre;
//         if (!$ciudad_nombre || !$provincia_nombre) {
//             echo "⚠️ Sede sin ciudad/provincia: {$sede['title']}<br>";//, print_r($sede['categorias'], true);
//             continue;
//         }

//         // Buscar términos en la taxonomía 'ubicaciones' que coincidan con la ciudad
//         $ciudades_encontradas = get_terms([
//             'taxonomy'   => 'ubicaciones',
//             'name'       => $ciudad_nombre,
//             'hide_empty' => false
//         ]);

//         if (empty($ciudades_encontradas)) {
//             $ciudades_no_encontradas[] = $ciudad_nombre;
//             echo "❌ No se encontró la ciudad: {$ciudad_nombre} (Provincia: {$provincia_nombre})<br>";
//             continue;
//         }

//         // Verificar si la ciudad pertenece a la misma provincia en la taxonomía
//         $ciudad_valida = null;
//         foreach ($ciudades_encontradas as $ciudad) {
//             $provincia = get_term($ciudad->parent, 'ubicaciones'); // Obtener el término padre (provincia)
//             if ($provincia && $provincia->name === $provincia_nombre) {
//                 $ciudad_valida = $ciudad;
//                 break;
//             }
//         }

//         if ($ciudad_valida) {
//             echo "✅ Sede '{$sede['title']}' → Ciudad encontrada: {$ciudad_nombre} ({$provincia_nombre})<br>";
//         } else {
//             $ciudades_duplicadas[] = $ciudad_nombre;
//             echo "⚠️ La ciudad '{$ciudad_nombre}' está en más de una provincia o no coincide con '{$provincia_nombre}'<br>";
//         }
//     }

//     // Resumen
//     echo "<br>🔍 **Resumen de la verificación**:<br>";
//     echo "✔️ Ciudades correctamente asignadas: " . (count($sedes) - count($ciudades_no_encontradas) - count($ciudades_duplicadas)) . "<br>";
//     echo "❌ Ciudades no encontradas: " . count($ciudades_no_encontradas) . "<br>";
//     echo "⚠️ Ciudades con ambigüedad (más de una provincia): " . count($ciudades_duplicadas) . "<br>";
// }

// // Ejecutar con /?test_import_sedes=1
// add_action('init', function() {
//     if (isset($_GET['test_import_sedes']) && current_user_can('manage_options')) {
//         test_import_sedes_from_json();
//     }
// });

// function debug_categorias_json() {
//     $path = '/home/eddisar/public_html/dev/temp_can_delete/';
//     $file_path = $path . 'sedes_export.json';

//     if (!file_exists($file_path)) {
//         die('El archivo JSON no existe.');
//     }

//     $json_data = file_get_contents($file_path);
//     $sedes = json_decode($json_data, true);

//     if (!$sedes) {
//         die('Error al decodificar JSON.');
//     }

//     foreach ($sedes as $sede) {
//         echo "<pre>";
//         echo "📍 **Sede**: " . $sede['title'] . "\n";
//         echo "🔎 **Categorias**: ";
//         print_r($sede['categorias']); // Mostrar todo el array de categorías
//         echo "</pre>";
//     }

//     die();
// }

// // Ejecutar con /?debug_categorias=1
// add_action('init', function() {
//     if (isset($_GET['debug_categorias']) && current_user_can('manage_options')) {
//         debug_categorias_json();
//     }
// });
