<?php
/**
 * Script para Limpiar Cache de Laravel desde el Navegador
 * 
 * Este script ejecuta los comandos de limpieza de cache de Laravel
 * sin necesidad de acceso a terminal/SSH
 * 
 * Autor: Sistema de Diagnóstico
 * Fecha: 2025-09-22
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🧹 Limpieza de Cache Laravel - Fondo Solidario</h1>";
echo "<p><strong>Fecha/Hora:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Función para mostrar información formateada
function mostrarInfo($titulo, $contenido, $tipo = 'info') {
    $color = $tipo == 'error' ? '#ff6b6b' : ($tipo == 'success' ? '#51cf66' : '#4dabf7');
    echo "<div style='border: 2px solid $color; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h3 style='color: $color; margin: 0 0 10px 0;'>$titulo</h3>";
    echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 3px; overflow-x: auto;'>$contenido</pre>";
    echo "</div>";
}

// Función para ejecutar comandos de Laravel
function ejecutarComandoLaravel($comando) {
    $output = '';
    $return_var = 0;
    
    try {
        // Intentar ejecutar el comando
        exec("php artisan $comando 2>&1", $output_array, $return_var);
        $output = implode("\n", $output_array);
        
        return [
            'exito' => $return_var === 0,
            'output' => $output,
            'codigo' => $return_var
        ];
    } catch (Exception $e) {
        return [
            'exito' => false,
            'output' => 'Error: ' . $e->getMessage(),
            'codigo' => -1
        ];
    }
}

// Función alternativa para limpiar cache manualmente
function limpiarCacheManual() {
    $resultados = [];
    
    // 1. Limpiar cache de configuración
    $configPath = __DIR__ . '/bootstrap/cache/config.php';
    if (file_exists($configPath)) {
        if (unlink($configPath)) {
            $resultados[] = "✅ Cache de configuración eliminado: $configPath";
        } else {
            $resultados[] = "❌ No se pudo eliminar cache de configuración: $configPath";
        }
    } else {
        $resultados[] = "ℹ️ No existe cache de configuración: $configPath";
    }
    
    // 2. Limpiar cache de rutas
    $routesPath = __DIR__ . '/bootstrap/cache/routes-v7.php';
    if (file_exists($routesPath)) {
        if (unlink($routesPath)) {
            $resultados[] = "✅ Cache de rutas eliminado: $routesPath";
        } else {
            $resultados[] = "❌ No se pudo eliminar cache de rutas: $routesPath";
        }
    } else {
        $resultados[] = "ℹ️ No existe cache de rutas: $routesPath";
    }
    
    // 3. Limpiar cache de aplicación
    $cacheDirs = [
        __DIR__ . '/storage/framework/cache/data',
        __DIR__ . '/storage/framework/views'
    ];
    
    foreach ($cacheDirs as $dir) {
        if (is_dir($dir)) {
            $files = glob($dir . '/*');
            $eliminados = 0;
            foreach ($files as $file) {
                if (is_file($file) && basename($file) !== '.gitignore') {
                    if (unlink($file)) {
                        $eliminados++;
                    }
                }
            }
            $resultados[] = "✅ Eliminados $eliminados archivos de cache en: $dir";
        } else {
            $resultados[] = "ℹ️ Directorio no existe: $dir";
        }
    }
    
    return $resultados;
}

echo "<h2>🔧 1. Limpieza de Cache de Configuración</h2>";

$resultado = ejecutarComandoLaravel('config:clear');

if ($resultado['exito']) {
    mostrarInfo("✅ Config Cache Limpiado", $resultado['output'], 'success');
} else {
    mostrarInfo("❌ Error en Config Clear", $resultado['output'], 'error');
    
    // Intentar limpieza manual
    echo "<h3>🛠️ Intentando Limpieza Manual...</h3>";
    $resultadosManual = limpiarCacheManual();
    mostrarInfo("Limpieza Manual de Cache", implode("\n", $resultadosManual), 'info');
}

echo "<h2>🗑️ 2. Limpieza de Cache de Aplicación</h2>";

$resultado = ejecutarComandoLaravel('cache:clear');

if ($resultado['exito']) {
    mostrarInfo("✅ Application Cache Limpiado", $resultado['output'], 'success');
} else {
    mostrarInfo("❌ Error en Cache Clear", $resultado['output'], 'error');
}

echo "<h2>🔄 3. Limpieza de Cache de Rutas (Opcional)</h2>";

$resultado = ejecutarComandoLaravel('route:clear');

if ($resultado['exito']) {
    mostrarInfo("✅ Route Cache Limpiado", $resultado['output'], 'success');
} else {
    mostrarInfo("⚠️ Route Clear", $resultado['output'] ?: 'No hay cache de rutas para limpiar', 'info');
}

echo "<h2>🎨 4. Limpieza de Cache de Vistas (Opcional)</h2>";

$resultado = ejecutarComandoLaravel('view:clear');

if ($resultado['exito']) {
    mostrarInfo("✅ View Cache Limpiado", $resultado['output'], 'success');
} else {
    mostrarInfo("⚠️ View Clear", $resultado['output'] ?: 'No hay cache de vistas para limpiar', 'info');
}

echo "<h2>📧 5. Verificación de Configuración de Correo</h2>";

// Verificar que la configuración se haya actualizado
if (file_exists('.env.local')) {
    $envContent = file_get_contents('.env.local');
    $mailHost = '';
    $mailUsername = '';
    
    if (preg_match('/MAIL_HOST=(.+)/', $envContent, $matches)) {
        $mailHost = trim($matches[1]);
    }
    if (preg_match('/MAIL_USERNAME=(.+)/', $envContent, $matches)) {
        $mailUsername = trim($matches[1]);
    }
    
    $configInfo = "Configuración actual en .env.local:\n";
    $configInfo .= "MAIL_HOST = $mailHost\n";
    $configInfo .= "MAIL_USERNAME = $mailUsername\n\n";
    
    if ($mailHost === 'jaeccba.org' && $mailUsername === 'no-reply@jaeccba.org') {
        $configInfo .= "✅ Configuración CORRECTA para envío de correos";
        mostrarInfo("Configuración de Correo", $configInfo, 'success');
    } else {
        $configInfo .= "❌ Configuración INCORRECTA\n";
        $configInfo .= "Debería ser:\n";
        $configInfo .= "MAIL_HOST = jaeccba.org\n";
        $configInfo .= "MAIL_USERNAME = no-reply@jaeccba.org";
        mostrarInfo("Configuración de Correo", $configInfo, 'error');
    }
} else {
    mostrarInfo("⚠️ Archivo .env.local no encontrado", "No se pudo verificar la configuración de correo", 'error');
}

echo "<h2>✅ 6. Resumen y Siguientes Pasos</h2>";

$resumen = "LIMPIEZA DE CACHE COMPLETADA\n\n";
$resumen .= "Pasos realizados:\n";
$resumen .= "✅ Cache de configuración limpiado\n";
$resumen .= "✅ Cache de aplicación limpiado\n";
$resumen .= "✅ Cache de rutas limpiado (si existía)\n";
$resumen .= "✅ Cache de vistas limpiado (si existía)\n\n";
$resumen .= "SIGUIENTES PASOS:\n";
$resumen .= "1. Registra un nuevo reintegro desde una cuenta de escuela\n";
$resumen .= "2. Verifica que lleguen correos a administradores y médicos auditores\n";
$resumen .= "3. Si no llegan correos, ejecuta diagnostico-correo-laravel.php\n\n";
$resumen .= "ARCHIVOS DE DIAGNÓSTICO DISPONIBLES:\n";
$resumen .= "• diagnostico-correo-laravel.php - Verificar configuración\n";
$resumen .= "• test-correo-laravel.php - Probar envío de correos\n";

mostrarInfo("Proceso Completado", $resumen, 'success');

echo "<hr>";
echo "<p><strong>Script completado:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><em>Ahora puedes probar el registro de reintegros para verificar el envío de correos.</em></p>";

// Botón para ejecutar diagnóstico
echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<a href='diagnostico-correo-laravel.php' style='background: #339966; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔍 Ejecutar Diagnóstico</a>";
echo "<a href='test-correo-laravel.php' style='background: #0284c7; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>📧 Probar Correos</a>";
echo "</div>";
?>