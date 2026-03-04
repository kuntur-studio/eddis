<?php
/**
 * API para guardar configuración del chatbot
 */

// Habilitar errores para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Log para debug
error_log("=== SAVE.PHP INICIADO ===");
error_log("Método: " . $_SERVER['REQUEST_METHOD']);

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

try {
    // Leer datos del body
    $input = file_get_contents('php://input');
    error_log("Input recibido: " . substr($input, 0, 200) . "...");
    
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Datos inválidos: ' . json_last_error_msg());
    }
    
    error_log("Datos decodificados correctamente");
    
    // Validar entity
    $entity = isset($data['entity']) ? $data['entity'] : '';
    error_log("Entity: " . $entity);
    
    if (!in_array($entity, ['eddis', 'studio'])) {
        throw new Exception('Entidad inválida: ' . $entity);
    }
    
    // Validar que tenga data
    if (!isset($data['data'])) {
        throw new Exception('No se recibieron datos para guardar');
    }
    
    // Determinar archivo de destino usando ruta absoluta
    $baseDir = dirname(dirname(__DIR__)); // Subir 2 niveles desde /cbotadm/api/
    $filename = $entity === 'eddis' 
        ? $baseDir . '/js/chatbot-config.json' 
        : $baseDir . '/js/chatbot-config-studio.json';
    
    error_log("Base dir: " . $baseDir);
    error_log("Archivo destino: " . $filename);
    error_log("Archivo existe: " . (file_exists($filename) ? 'SI' : 'NO'));
    error_log("Ruta absoluta: " . realpath($filename));
    
    // Validar que el archivo existe
    if (!file_exists($filename)) {
        throw new Exception('Archivo de configuración no encontrado: ' . $filename);
    }
    
    // Verificar permisos de escritura
    if (!is_writable($filename)) {
        throw new Exception('El archivo no tiene permisos de escritura: ' . $filename);
    }
    
    error_log("Archivo tiene permisos de escritura");
    
    // Crear backup antes de guardar
    $backupFilename = $filename . '.backup.' . date('Y-m-d_H-i-s');
    if (!copy($filename, $backupFilename)) {
        throw new Exception('No se pudo crear el backup');
    }
    
    error_log("Backup creado: " . $backupFilename);
    
    // Convertir a JSON con formato bonito
    $jsonData = json_encode($data['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
    if ($jsonData === false) {
        throw new Exception('Error al codificar JSON: ' . json_last_error_msg());
    }
    
    error_log("JSON generado, tamaño: " . strlen($jsonData) . " bytes");
    
    // Guardar archivo
    $bytesWritten = file_put_contents($filename, $jsonData);
    
    if ($bytesWritten === false) {
        throw new Exception('Error al escribir el archivo');
    }
    
    error_log("Archivo guardado exitosamente: " . $bytesWritten . " bytes");
    
    // Limpiar backups antiguos (mantener solo los últimos 5)
    cleanOldBackups($filename);
    
    // Respuesta exitosa
    $response = [
        'success' => true,
        'message' => 'Configuración guardada correctamente',
        'backup' => basename($backupFilename),
        'bytes' => $bytesWritten
    ];
    
    error_log("Respuesta: " . json_encode($response));
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("ERROR: " . $e->getMessage());
    error_log("Trace: " . $e->getTraceAsString());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

/**
 * Limpiar backups antiguos
 */
function cleanOldBackups($originalFile) {
    $dir = dirname($originalFile);
    $basename = basename($originalFile);
    $pattern = $dir . '/' . $basename . '.backup.*';
    
    $backups = glob($pattern);
    
    if (count($backups) > 5) {
        // Ordenar por fecha (los más antiguos primero)
        usort($backups, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        
        // Eliminar los más antiguos, dejando solo 5
        $toDelete = array_slice($backups, 0, count($backups) - 5);
        foreach ($toDelete as $file) {
            @unlink($file);
        }
    }
}
