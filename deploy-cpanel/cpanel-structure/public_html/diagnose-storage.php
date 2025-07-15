<?php
/**
 * Diagnóstico completo del sistema de storage
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Diagnóstico del Sistema de Storage</h2>";

// Rutas importantes
$basePath = dirname(__DIR__);
$publicPath = __DIR__;
$storagePath = $basePath . '/storage';
$storageAppPublic = $storagePath . '/app/public';

echo "<h3>1. Rutas del sistema:</h3>";
echo "<ul>";
echo "<li>Base: <code>$basePath</code></li>";
echo "<li>Public: <code>$publicPath</code></li>";
echo "<li>Storage: <code>$storagePath</code></li>";
echo "<li>Storage App Public: <code>$storageAppPublic</code></li>";
echo "</ul>";

echo "<h3>2. Verificando enlace simbólico:</h3>";
$storageLink = $publicPath . '/storage';
if (file_exists($storageLink)) {
    if (is_link($storageLink)) {
        $target = readlink($storageLink);
        echo "<p>✅ Enlace simbólico existe</p>";
        echo "<p>Apunta a: <code>$target</code></p>";
        
        // Verificar si el destino existe
        if (file_exists($storageLink . '/test-link.txt')) {
            file_put_contents($storageLink . '/test-link.txt', 'test');
            echo "<p>✅ El enlace funciona correctamente</p>";
            unlink($storageLink . '/test-link.txt');
        } else {
            // Intentar crear archivo de prueba
            @file_put_contents($storageAppPublic . '/test-link.txt', 'test');
            if (file_exists($storageLink . '/test-link.txt')) {
                echo "<p>✅ El enlace funciona correctamente</p>";
                unlink($storageLink . '/test-link.txt');
            } else {
                echo "<p>❌ El enlace existe pero no funciona</p>";
            }
        }
    } else {
        echo "<p>❌ Existe algo llamado 'storage' pero no es un enlace simbólico</p>";
    }
} else {
    echo "<p>❌ No existe el enlace simbólico</p>";
}

echo "<h3>3. Verificando carpetas de archivos:</h3>";
$folders = [
    'archivos_documentos',
    'archivos_accidentes', 
    'archivos_reintegros'
];

foreach ($folders as $folder) {
    $fullPath = $storageAppPublic . '/' . $folder;
    echo "<p><strong>$folder:</strong></p>";
    echo "<ul>";
    
    if (is_dir($fullPath)) {
        echo "<li>✅ Existe en: <code>$fullPath</code></li>";
        
        // Verificar permisos
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        echo "<li>Permisos: $perms</li>";
        
        // Contar archivos
        $files = glob($fullPath . '/*');
        $count = count($files);
        echo "<li>Archivos: $count</li>";
        
        // Mostrar algunos archivos
        if ($count > 0) {
            echo "<li>Ejemplos:";
            echo "<ul>";
            foreach (array_slice($files, 0, 3) as $file) {
                echo "<li><code>" . basename($file) . "</code></li>";
            }
            echo "</ul></li>";
        }
    } else {
        echo "<li>❌ No existe</li>";
        echo "<li>Intentando crear...</li>";
        if (mkdir($fullPath, 0755, true)) {
            echo "<li>✅ Carpeta creada exitosamente</li>";
        } else {
            echo "<li>❌ No se pudo crear la carpeta</li>";
        }
    }
    echo "</ul>";
}

echo "<h3>4. Prueba de acceso a archivo específico:</h3>";
$testFile = 'Ch4h22zmwdRI9lMn2SPkFUJW5GzELj2pvi08044A.png';
$paths = [
    $storageAppPublic . '/archivos_documentos/' . $testFile,
    $storageLink . '/archivos_documentos/' . $testFile,
    $publicPath . '/storage/archivos_documentos/' . $testFile
];

foreach ($paths as $path) {
    echo "<p>Buscando en: <code>$path</code></p>";
    if (file_exists($path)) {
        echo "<p>✅ Archivo encontrado!</p>";
        echo "<p>Tamaño: " . filesize($path) . " bytes</p>";
        break;
    } else {
        echo "<p>❌ No encontrado</p>";
    }
}

echo "<h3>5. Configuración de Laravel:</h3>";
// Verificar filesystem config
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    $env = file_get_contents($envPath);
    if (preg_match('/FILESYSTEM_DISK=(.*)/', $env, $matches)) {
        echo "<p>FILESYSTEM_DISK = " . trim($matches[1]) . "</p>";
    }
}

echo "<h3>6. Solución recomendada:</h3>";
echo "<ol>";
echo "<li>Si el enlace simbólico no funciona, elimínalo y créalo de nuevo</li>";
echo "<li>Verifica que las carpetas existan en <code>storage/app/public/</code></li>";
echo "<li>Los archivos nuevos que subas deberían guardarse automáticamente en las carpetas correctas</li>";
echo "<li>Si un archivo específico no se encuentra, puede que se haya subido antes de crear las carpetas</li>";
echo "</ol>";

echo "<hr>";
echo "<p><strong style='color: red;'>⚠️ ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO</strong></p>";
?>