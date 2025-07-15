<?php
/**
 * Script para ejecutar migraciones de Laravel
 * IMPORTANTE: ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

// Aumentar límites para evitar timeouts
set_time_limit(300);
ini_set('memory_limit', '256M');

echo "<h2>Ejecutando migraciones de Laravel</h2>";
echo "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ddd;'>";

try {
    // Cargar Laravel
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Inicializar el kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Verificar conexión a base de datos
    echo "Verificando conexión a base de datos...\n";
    try {
        DB::connection()->getPdo();
        echo "✅ Conexión exitosa a la base de datos\n\n";
    } catch (\Exception $e) {
        die("❌ Error de conexión: " . $e->getMessage());
    }
    
    // Mostrar estado actual de migraciones
    echo "Estado actual de migraciones:\n";
    echo "=====================================\n";
    Artisan::call('migrate:status');
    echo Artisan::output();
    echo "\n";
    
    // Ejecutar migraciones
    echo "Ejecutando migraciones pendientes...\n";
    echo "=====================================\n";
    $exitCode = Artisan::call('migrate', [
        '--force' => true, // Forzar en producción
        '--verbose' => true
    ]);
    
    echo Artisan::output();
    
    if ($exitCode === 0) {
        echo "\n✅ <strong>Migraciones ejecutadas exitosamente</strong>\n";
    } else {
        echo "\n❌ Error al ejecutar migraciones\n";
    }
    
    // Mostrar nuevo estado
    echo "\nEstado final de migraciones:\n";
    echo "=====================================\n";
    Artisan::call('migrate:status');
    echo Artisan::output();
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString();
}

echo "</pre>";

echo "<hr>";
echo "<h3>✅ Próximos pasos:</h3>";
echo "<ol>";
echo "<li>Si las migraciones se ejecutaron correctamente, tu sitio ya debería funcionar</li>";
echo "<li>Intenta iniciar sesión nuevamente</li>";
echo "<li><strong style='color: red;'>⚠️ ELIMINA ESTE ARCHIVO INMEDIATAMENTE por seguridad</strong></li>";
echo "</ol>";

echo "<p><a href='/' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Ir al sitio</a></p>";
?>