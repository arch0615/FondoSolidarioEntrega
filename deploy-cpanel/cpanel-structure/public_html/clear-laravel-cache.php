<?php
/**
 * Script para limpiar la caché de Laravel en producción
 * Sube este archivo a la carpeta public y accede a él desde el navegador
 * IMPORTANTE: Elimina este archivo después de usarlo
 */

echo "<h2>Limpiando caché de Laravel...</h2>";

// Definir la ruta base de Laravel
$laravelPath = __DIR__ . '/../';

// Archivos de caché a eliminar
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/services.php',
];

echo "<h3>1. Eliminando archivos de caché compilados:</h3>";
foreach ($cacheFiles as $file) {
    $fullPath = $laravelPath . $file;
    if (file_exists($fullPath)) {
        if (unlink($fullPath)) {
            echo "✅ Eliminado: $file<br>";
        } else {
            echo "❌ Error al eliminar: $file<br>";
        }
    } else {
        echo "⚠️ No existe: $file<br>";
    }
}

// Limpiar sesiones
echo "<h3>2. Limpiando sesiones:</h3>";
$sessionPath = $laravelPath . 'storage/framework/sessions/';
if (is_dir($sessionPath)) {
    $files = glob($sessionPath . '*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file) && basename($file) != '.gitignore') {
            unlink($file);
            $count++;
        }
    }
    echo "✅ Eliminadas $count sesiones<br>";
} else {
    echo "❌ No se encontró la carpeta de sesiones<br>";
}

// Limpiar vistas compiladas
echo "<h3>3. Limpiando vistas compiladas:</h3>";
$viewsPath = $laravelPath . 'storage/framework/views/';
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '*.php');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $count++;
        }
    }
    echo "✅ Eliminadas $count vistas compiladas<br>";
} else {
    echo "❌ No se encontró la carpeta de vistas<br>";
}

// Limpiar caché general
echo "<h3>4. Limpiando caché general:</h3>";
$cachePath = $laravelPath . 'storage/framework/cache/data/';
if (is_dir($cachePath)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cachePath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    $count = 0;
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getFilename() != '.gitignore') {
            unlink($file->getRealPath());
            $count++;
        }
    }
    echo "✅ Eliminados $count archivos de caché<br>";
} else {
    echo "⚠️ No se encontró la carpeta de caché<br>";
}

// Verificar y crear carpetas necesarias
echo "<h3>5. Verificando estructura de carpetas:</h3>";
$requiredDirs = [
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/framework/cache/data',
    'storage/app/public',
    'storage/logs',
];

foreach ($requiredDirs as $dir) {
    $fullPath = $laravelPath . $dir;
    if (!is_dir($fullPath)) {
        if (mkdir($fullPath, 0755, true)) {
            echo "✅ Creada carpeta: $dir<br>";
        } else {
            echo "❌ Error al crear: $dir<br>";
        }
    } else {
        echo "✅ Existe: $dir<br>";
    }
}

// Verificar permisos
echo "<h3>6. Verificando permisos:</h3>";
$checkPermissions = [
    'storage',
    'bootstrap/cache',
];

foreach ($checkPermissions as $dir) {
    $fullPath = $laravelPath . $dir;
    if (is_writable($fullPath)) {
        echo "✅ Permisos correctos: $dir<br>";
    } else {
        echo "❌ Sin permisos de escritura: $dir (necesita chmod 755 o 775)<br>";
    }
}

echo "<hr>";
echo "<h2>✅ Proceso completado</h2>";
echo "<p><strong>IMPORTANTE:</strong></p>";
echo "<ol>";
echo "<li>Elimina este archivo inmediatamente</li>";
echo "<li>Recarga tu sitio web</li>";
echo "<li>Si persiste el error, verifica los permisos de las carpetas storage</li>";
echo "</ol>";
?>