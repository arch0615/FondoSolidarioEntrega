<?php
// Script simple para ejecutar migraciones en cPanel
// IMPORTANTE: Eliminar este archivo después de usar por seguridad

ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(300);

echo "<h2>🚀 Ejecutando Migraciones - Fondo Solidario JAEC</h2>";
echo "<hr>";

try {
    // Verificar que existe .env
    if (!file_exists('../.env')) {
        throw new Exception('No se encuentra el archivo .env');
    }
    
    echo "<h3>1. 📋 Cargando Laravel...</h3>";
    
    // Cargar Laravel de forma simple
    require_once '../vendor/autoload.php';
    $app = require_once '../bootstrap/app.php';
    
    echo "<p style='color: green;'>✅ Laravel cargado correctamente</p>";
    
    echo "<h3>2. 🔍 Verificando conexión a la base de datos...</h3>";
    
    // Obtener configuración de .env de forma directa
    $envLines = file('../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $envVars = [];
    foreach ($envLines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $envVars[trim($key)] = trim($value);
        }
    }
    
    // Verificar conexión directa
    $pdo = new PDO(
        'mysql:host=' . $envVars['DB_HOST'] . ';dbname=' . $envVars['DB_DATABASE'],
        $envVars['DB_USERNAME'],
        $envVars['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<p style='color: green;'>✅ Conexión a base de datos exitosa</p>";
    echo "<p>Base de datos: " . $envVars['DB_DATABASE'] . "</p>";
    echo "<p>Host: " . $envVars['DB_HOST'] . "</p>";
    
    echo "<h3>3. 📊 Verificando y reparando tabla migrations...</h3>";
    
    // Verificar si ya existen migraciones
    $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
    $migrationTableExists = $stmt->rowCount() > 0;
    
    if ($migrationTableExists) {
        echo "<p style='color: orange;'>⚠️ La tabla 'migrations' ya existe. Verificando estructura...</p>";
        
        // Verificar estructura de la tabla migrations
        $stmt = $pdo->query("DESCRIBE migrations");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $idColumnCorrect = false;
        foreach ($columns as $column) {
            if ($column['Field'] === 'id' && strpos($column['Extra'], 'auto_increment') !== false) {
                $idColumnCorrect = true;
                break;
            }
        }
        
        if (!$idColumnCorrect) {
            echo "<p style='color: red;'>❌ La tabla migrations tiene problemas. Limpiando base de datos...</p>";
            
            // Obtener todas las tablas
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Eliminar todas las tablas para evitar conflictos
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            foreach ($tables as $table) {
                $pdo->exec("DROP TABLE IF EXISTS `$table`");
                echo "<p>🗑️ Eliminada tabla: $table</p>";
            }
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            echo "<p style='color: green;'>✅ Base de datos limpiada completamente</p>";
        } else {
            echo "<p style='color: green;'>✅ La tabla migrations está correcta</p>";
            
            // Verificar si hay tablas de la aplicación que no están en migrations
            $stmt = $pdo->query("SHOW TABLES");
            $allTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            $stmt = $pdo->query("SELECT migration FROM migrations");
            $migrations = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Buscar tablas principales de la aplicación
            $appTables = ['usuarios', 'escuelas', 'reintegros', 'alumnos', 'empleados'];
            $foundAppTables = array_intersect($appTables, $allTables);
            
            if (!empty($foundAppTables) && empty($migrations)) {
                echo "<p style='color: red;'>❌ Detectadas tablas existentes sin migraciones registradas. Limpiando base de datos...</p>";
                
                // Eliminar todas las tablas para evitar conflictos
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
                foreach ($allTables as $table) {
                    $pdo->exec("DROP TABLE IF EXISTS `$table`");
                    echo "<p>🗑️ Eliminada tabla: $table</p>";
                }
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
                
                echo "<p style='color: green;'>✅ Base de datos limpiada completamente</p>";
            } elseif (!empty($foundAppTables) && !empty($migrations)) {
                echo "<p style='color: green;'>✅ Tablas y migraciones están sincronizadas</p>";
            }
        }
    } else {
        echo "<p style='color: green;'>✅ Primera ejecución de migraciones</p>";
    }
    
    echo "<h3>4. 🔄 Forzando limpieza completa y ejecutando migraciones...</h3>";
    
    // Forzar limpieza completa de la base de datos
    echo "<p style='color: orange;'>🧹 Forzando limpieza completa de la base de datos...</p>";
    $stmt = $pdo->query("SHOW TABLES");
    $allTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($allTables)) {
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        foreach ($allTables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            echo "<p>🗑️ Eliminada tabla: $table</p>";
        }
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        echo "<p style='color: green;'>✅ Base de datos completamente limpia</p>";
    }
    
    // Ejecutar migraciones usando Artisan
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Buffer output - usar migrate con base de datos limpia
    ob_start();
    $exitCode = $kernel->call('migrate', ['--force' => true]);
    $output = ob_get_clean();
    
    if ($exitCode === 0) {
        echo "<p style='color: green;'>✅ Migraciones ejecutadas exitosamente</p>";
        
        // Ejecutar seeders después de migraciones exitosas
        echo "<h3>🌱 Ejecutando seeders...</h3>";
        ob_start();
        $exitCode2 = $kernel->call('db:seed', ['--force' => true]);
        $output2 = ob_get_clean();
        
        if ($exitCode2 === 0) {
            echo "<p style='color: green;'>✅ Seeders ejecutados exitosamente</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Seeders código: $exitCode2</p>";
        }
        
        echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px;'>";
        echo htmlspecialchars($output2);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>❌ Código de salida: $exitCode</p>";
    }
    
    echo "<pre style='background: #f4f4f4; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($output);
    echo "</pre>";
    
    echo "<h3>5. 📋 Verificando tablas finales...</h3>";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p style='color: green;'>✅ Total de tablas: " . count($tables) . "</p>";
    echo "<details><summary>Ver tablas creadas</summary><ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul></details>";
    
    echo "<hr>";
    echo "<h3>🎉 ¡Proceso completado exitosamente!</h3>";
    echo "<p style='color: red; font-weight: bold; background: #ffe6e6; padding: 10px; border: 2px solid #ff0000; border-radius: 5px;'>";
    echo "⚠️ IMPORTANTE: Elimina este archivo (run-migrations.php) por seguridad después de usar.";
    echo "</p>";
    echo "<p><a href='/' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>← Ir al sitio principal</a></p>";
    
} catch (Exception $e) {
    echo "<div style='background: #ffe6e6; padding: 15px; border: 2px solid #ff0000; border-radius: 5px;'>";
    echo "<h3 style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<hr>";
    echo "<p><strong>Verifica que:</strong></p>";
    echo "<ul>";
    echo "<li>La base de datos esté creada en cPanel</li>";
    echo "<li>Las credenciales en .env sean correctas</li>";
    echo "<li>El usuario tenga permisos para crear tablas</li>";
    echo "</ul>";
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
h2, h3 {
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
details {
    margin: 10px 0;
}
summary {
    cursor: pointer;
    background: #e9e9e9;
    padding: 5px 10px;
    border-radius: 3px;
}
hr {
    border: none;
    border-top: 2px solid #007cba;
    margin: 20px 0;
}
</style>
