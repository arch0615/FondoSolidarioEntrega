<?php
/**
 * Script para corregir las credenciales de base de datos en .env
 * Sube este archivo a la carpeta public y accede desde el navegador
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Corrección de credenciales de base de datos en .env</h2>";

$envPath = __DIR__ . '/../.env';

// Hacer backup del .env actual
$backupPath = __DIR__ . '/../.env.backup.' . date('Y-m-d-H-i-s');
if (copy($envPath, $backupPath)) {
    echo "✅ Backup creado en: " . basename($backupPath) . "<br><br>";
} else {
    die("❌ Error al crear backup del .env");
}

// Leer el contenido actual
$content = file_get_contents($envPath);

// Configuración correcta para producción
$replacements = [
    '/^DB_HOST=.*/m' => 'DB_HOST=localhost',
    '/^DB_DATABASE=.*/m' => 'DB_DATABASE=jaec_fondosolidario',
    '/^DB_USERNAME=.*/m' => 'DB_USERNAME=jaec_fondosolidario',
    '/^DB_PASSWORD=.*/m' => "DB_PASSWORD='k4\\vtA{D4EGqXfW"
];

echo "<h3>Aplicando cambios:</h3>";
foreach ($replacements as $pattern => $replacement) {
    $oldContent = $content;
    $content = preg_replace($pattern, $replacement, $content);
    if ($oldContent !== $content) {
        echo "✅ Actualizado: $replacement<br>";
    }
}

// Guardar el archivo actualizado
if (file_put_contents($envPath, $content)) {
    echo "<br>✅ <strong>Archivo .env actualizado correctamente</strong><br>";
} else {
    die("❌ Error al guardar el archivo .env");
}

// Limpiar caché de configuración
echo "<br><h3>Limpiando caché de configuración:</h3>";

$configPath = __DIR__ . '/../bootstrap/cache/config.php';
if (file_exists($configPath)) {
    if (unlink($configPath)) {
        echo "✅ Caché de configuración eliminada<br>";
    }
}

// Verificar la nueva configuración
echo "<br><h3>Verificando nueva configuración:</h3>";
$newContent = file_get_contents($envPath);
preg_match_all('/^(DB_[A-Z_]+)=(.*)$/m', $newContent, $matches, PREG_SET_ORDER);

foreach ($matches as $match) {
    $key = $match[1];
    $value = trim($match[2], " \t\n\r\0\x0B\"'");
    if ($key === 'DB_PASSWORD') {
        echo "✅ $key = " . str_repeat('*', strlen($value)) . "<br>";
    } else {
        echo "✅ $key = $value<br>";
    }
}

// Probar conexión
echo "<br><h3>Probando conexión con las nuevas credenciales:</h3>";
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=jaec_fondosolidario;charset=utf8mb4",
        "jaec_fondosolidario",
        "'k4\\vtA{D4EGqXfW"
    );
    echo "✅ <strong>¡Conexión exitosa a la base de datos!</strong><br>";
    
    // Verificar tablas
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<br>Tablas encontradas: " . count($tables) . "<br>";
    
    if (count($tables) == 0) {
        echo "⚠️ No hay tablas en la base de datos. Necesitas ejecutar las migraciones.<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    echo "<br>⚠️ Si el error persiste, verifica que las credenciales sean correctas en cPanel.<br>";
}

echo "<hr>";
echo "<p><strong>Próximos pasos:</strong></p>";
echo "<ol>";
echo "<li>Recarga tu sitio web para verificar que funcione</li>";
echo "<li>Si necesitas ejecutar migraciones, usa el script migrate.php mencionado anteriormente</li>";
echo "<li><strong>ELIMINA ESTE ARCHIVO INMEDIATAMENTE</strong></li>";
echo "</ol>";
?>