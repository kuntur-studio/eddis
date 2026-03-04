<?php
/**
 * Script de prueba para verificar rutas
 */

echo "<h1>Test de Rutas PHP</h1>";

echo "<h2>Información del Script</h2>";
echo "<pre>";
echo "__FILE__: " . __FILE__ . "\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "dirname(__DIR__): " . dirname(__DIR__) . "\n";
echo "dirname(dirname(__DIR__)): " . dirname(dirname(__DIR__)) . "\n";
echo "</pre>";

echo "<h2>Rutas Calculadas</h2>";
echo "<pre>";
$baseDir = dirname(dirname(__DIR__));
echo "Base Dir: " . $baseDir . "\n";
echo "Archivo EDDIS: " . $baseDir . '/js/chatbot-config.json' . "\n";
echo "Archivo Studio: " . $baseDir . '/js/chatbot-config-studio.json' . "\n";
echo "</pre>";

echo "<h2>Verificación de Archivos</h2>";
echo "<pre>";

$eddisFile = $baseDir . '/js/chatbot-config.json';
$studioFile = $baseDir . '/js/chatbot-config-studio.json';

echo "EDDIS:\n";
echo "  Existe: " . (file_exists($eddisFile) ? 'SI' : 'NO') . "\n";
echo "  Readable: " . (is_readable($eddisFile) ? 'SI' : 'NO') . "\n";
echo "  Writable: " . (is_writable($eddisFile) ? 'SI' : 'NO') . "\n";
echo "  Permisos: " . substr(sprintf('%o', fileperms($eddisFile)), -4) . "\n";
echo "  Owner: " . fileowner($eddisFile) . " (uid), " . filegroup($eddisFile) . " (gid)\n";
echo "  Tamaño: " . filesize($eddisFile) . " bytes\n";

echo "\nStudio:\n";
echo "  Existe: " . (file_exists($studioFile) ? 'SI' : 'NO') . "\n";
echo "  Readable: " . (is_readable($studioFile) ? 'SI' : 'NO') . "\n";
echo "  Writable: " . (is_writable($studioFile) ? 'SI' : 'NO') . "\n";
echo "  Permisos: " . substr(sprintf('%o', fileperms($studioFile)), -4) . " \n";
echo "  Owner: " . fileowner($studioFile) . " (uid), " . filegroup($studioFile) . " (gid)\n";
echo "  Tamaño: " . filesize($studioFile) . " bytes\n";

echo "</pre>";

echo "<h2>Usuario del Proceso PHP</h2>";
echo "<pre>";
echo "User: " . get_current_user() . "\n";
echo "UID: " . getmyuid() . "\n";
echo "GID: " . getmygid() . "\n";

if (function_exists('posix_getpwuid')) {
    $processUser = posix_getpwuid(posix_geteuid());
    echo "Process User: " . $processUser['name'] . "\n";
}

echo "</pre>";

echo "<h2>Test de Escritura</h2>";
echo "<pre>";

$testContent = json_encode(['test' => 'timestamp ' . date('Y-m-d H:i:s')], JSON_PRETTY_PRINT);
$testFile = $baseDir . '/js/test-write.json';

echo "Intentando escribir en: " . $testFile . "\n";

$result = file_put_contents($testFile, $testContent);

if ($result !== false) {
    echo "✓ Escritura exitosa: " . $result . " bytes\n";
    echo "✓ Contenido: " . file_get_contents($testFile) . "\n";
    unlink($testFile);
    echo "✓ Archivo de prueba eliminado\n";
} else {
    echo "✗ Error al escribir\n";
    echo "Error: " . error_get_last()['message'] . "\n";
}

echo "</pre>";
