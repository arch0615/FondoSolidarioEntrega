<?php
// Script para limpiar cache y arreglar rutas de Laravel en cPanel
// IMPORTANTE: Eliminar este archivo después de usar por seguridad

set_time_limit(300);

echo "<h2>🔧 Arreglando rutas de Laravel - Fondo Solidario</h2>";
echo "<hr>";

try {
    // Verificar que el archivo .env existe
    if (!file_exists('../.env')) {
        die('<h2 style="color: red;">❌ Error: No se encuentra el archivo .env</h2>');
    }

    echo "<h3>1. 🧹 Limpiando caches de Laravel...</h3>";
    
    // Eliminar archivos de cache manualmente
    $cacheDirectories = [
        '../storage/framework/cache/data',
        '../storage/framework/sessions',
        '../storage/framework/views',
        '../storage/logs',
        '../bootstrap/cache'
    ];
    
    foreach ($cacheDirectories as $dir) {
        if (is_dir($dir)) {
            $files = glob($dir . '/*');
            foreach ($files as $file) {
                if (is_file($file) && basename($file) !== '.gitignore') {
                    unlink($file);
                }
            }
            echo "<p>✅ Limpiado: $dir</p>";
        } else {
            echo "<p>⚠️ Directorio no encontrado: $dir</p>";
        }
    }
    
    echo "<h3>2. 📁 Verificando permisos de directorios...</h3>";
    
    $storageDirectories = [
        '../storage',
        '../storage/app',
        '../storage/framework',
        '../storage/framework/cache',
        '../storage/framework/sessions',
        '../storage/framework/views',
        '../storage/logs',
        '../bootstrap/cache'
    ];
    
    foreach ($storageDirectories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
            echo "<p>✅ Creado directorio: $dir</p>";
        } else {
            chmod($dir, 0775);
            echo "<p>✅ Permisos configurados: $dir</p>";
        }
    }
    
    echo "<h3>3. ⚙️ Verificando configuración .env...</h3>";
    
    $envContent = file_get_contents('../.env');
    
    // Verificar configuraciones problemáticas
    $hasIssues = false;
    if (strpos($envContent, 'C:\\') !== false || strpos($envContent, 'C:/') !== false) {
        echo "<p style='color: red;'>❌ Encontradas rutas absolutas de Windows en .env</p>";
        $hasIssues = true;
    }
    
    if (!$hasIssues) {
        echo "<p style='color: green;'>✅ No se encontraron rutas problemáticas en .env</p>";
    }
    
    // Mostrar configuración relevante del .env
    echo "<h4>Configuración actual del .env:</h4>";
    echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px;'>";
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (strpos($line, 'APP_') === 0 || 
            strpos($line, 'DB_') === 0 || 
            strpos($line, 'SESSION_') === 0 ||
            strpos($line, 'CACHE_') === 0) {
            if (strpos($line, 'DB_PASSWORD') === 0) {
                echo "DB_PASSWORD=***hidden***\n";
            } else {
                echo htmlspecialchars($line) . "\n";
            }
        }
    }
    echo "</pre>";
    
    echo "<h3>4. 🔄 Cargando Laravel para limpiar cache...</h3>";
    
    // Cargar Laravel
    require_once '../vendor/autoload.php';
    $app = require_once '../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Limpiar caches
    $commands = [
        'cache:clear' => 'Cache de aplicación',
        'config:clear' => 'Cache de configuración',
        'route:clear' => 'Cache de rutas',
        'view:clear' => 'Cache de vistas'
    ];
    
    foreach ($commands as $command => $description) {
        try {
            $exitCode = $kernel->call($command);
            if ($exitCode === 0) {
                echo "<p style='color: green;'>✅ $description limpiado</p>";
            } else {
                echo "<p style='color: orange;'>⚠️ $description - código: $exitCode</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error limpiando $description: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    
    echo "<h3>5. 🔗 Verificando enlace de storage...</h3>";
    
    $storageLink = 'storage';
    if (is_link($storageLink)) {
        echo "<p style='color: green;'>✅ Enlace de storage existe</p>";
    } elseif (is_dir($storageLink)) {
        echo "<p style='color: orange;'>⚠️ 'storage' es un directorio, no un enlace simbólico</p>";
    } else {
        // Intentar crear enlace simbólico
        $targetFolder = '../storage/app/public';
        if (symlink($targetFolder, $storageLink)) {
            echo "<p style='color: green;'>✅ Enlace simbólico de storage creado</p>";
        } else {
            echo "<p style='color: red;'>❌ No se pudo crear enlace simbólico de storage</p>";
        }
    }
    
    echo "<hr>";
    echo "<h3>🎉 ¡Limpieza completada!</h3>";
    echo "<p style='color: green; font-weight: bold;'>✅ Intenta acceder al sitio ahora</p>";
    echo "<p style='color: red; font-weight: bold; background: #ffe6e6; padding: 10px; border: 2px solid #ff0000; border-radius: 5px;'>";
    echo "⚠️ IMPORTANTE: Elimina este archivo (fix-laravel-paths.php) por seguridad después de usar.";
    echo "</p>";
    echo "<p><a href='/' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>← Probar sitio principal</a></p>";
    
} catch (Exception $e) {
    echo "<div style='background: #ffe6e6; padding: 15px; border: 2px solid #ff0000; border-radius: 5px;'>";
    echo "<h3 style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
    echo "</div>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background: #f9f9f9;
    line-height: 1.6;
}
h2, h3, h4 {
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 5px;
}
pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    max-height: 300px;
    overflow-y: auto;
}
hr {
    border: none;
    border-top: 2px solid #007cba;
    margin: 20px 0;
}
</style>
