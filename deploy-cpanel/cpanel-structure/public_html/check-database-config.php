<?php
/**
 * Script para verificar la configuración de base de datos
 * Sube este archivo a la carpeta public y accede desde el navegador
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Verificación de configuración de base de datos</h2>";

// Cargar el archivo .env
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    die("❌ ERROR: No se encontró el archivo .env en: " . dirname($envPath));
}

echo "<h3>1. Leyendo archivo .env:</h3>";
$envContent = file_get_contents($envPath);
$lines = explode("\n", $envContent);
$dbConfig = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line) || strpos($line, '#') === 0) continue;
    
    if (strpos($line, 'DB_') === 0) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        $dbConfig[$key] = $value;
        
        // Ocultar la contraseña para seguridad
        if ($key === 'DB_PASSWORD') {
            echo "✅ $key = " . str_repeat('*', strlen($value)) . "<br>";
        } else {
            echo "✅ $key = $value<br>";
        }
    }
}

echo "<h3>2. Verificando valores de configuración:</h3>";

// Verificar que no sean los valores por defecto
$issues = [];
if ($dbConfig['DB_HOST'] === '127.0.0.1') {
    $issues[] = "DB_HOST está configurado como 127.0.0.1, debería ser 'localhost' para cPanel";
}
if ($dbConfig['DB_USERNAME'] === 'root') {
    $issues[] = "DB_USERNAME no debe ser 'root' en producción";
}
if (empty($dbConfig['DB_PASSWORD'])) {
    $issues[] = "DB_PASSWORD está vacía";
}

if (count($issues) > 0) {
    echo "<div style='background: #fee; padding: 10px; border: 1px solid #fcc;'>";
    echo "<strong>⚠️ Problemas encontrados:</strong><br>";
    foreach ($issues as $issue) {
        echo "- $issue<br>";
    }
    echo "</div>";
} else {
    echo "✅ La configuración parece correcta<br>";
}

echo "<h3>3. Probando conexión a base de datos:</h3>";

try {
    $dsn = "mysql:host={$dbConfig['DB_HOST']};dbname={$dbConfig['DB_DATABASE']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['DB_USERNAME'], $dbConfig['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ <strong>Conexión exitosa a la base de datos</strong><br>";
    
    // Verificar si existe la tabla usuarios
    $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
    if ($stmt->rowCount() > 0) {
        echo "✅ La tabla 'usuarios' existe<br>";
        
        // Contar usuarios
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Total de usuarios en la base de datos: {$result['total']}<br>";
    } else {
        echo "❌ La tabla 'usuarios' NO existe. ¿Has ejecutado las migraciones?<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong>Error de conexión:</strong> " . $e->getMessage() . "<br>";
}

echo "<h3>4. Configuración esperada en .env:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo "DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=jaec_fondosolidario
DB_USERNAME=jaec_fondosolidario
DB_PASSWORD=*2024Juntadev
</pre>";

echo "<h3>5. Si necesitas ejecutar migraciones:</h3>";
echo "<p>Si tienes acceso SSH, ejecuta:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo "cd /home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario
php artisan migrate
</pre>";

echo "<p>Si NO tienes SSH, crea un archivo 'migrate.php' en public con:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo htmlspecialchars('<?php
require __DIR__."/../vendor/autoload.php";
$app = require_once __DIR__."/../bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Artisan::call("migrate", ["--force" => true]);
echo "<pre>" . Artisan::output() . "</pre>";
?>');
echo "</pre>";

echo "<hr>";
echo "<p><strong>⚠️ IMPORTANTE: Elimina este archivo después de usarlo</strong></p>";
?>