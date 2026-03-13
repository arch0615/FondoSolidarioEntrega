<?php
// Archivo temporal para depurar variables de entorno en Railway
// ELIMINAR DESPUÉS DE RESOLVER EL PROBLEMA

echo "<h2>Variables de entorno de base de datos:</h2>";
echo "<pre>";

// Variables de entorno del sistema
echo "=== VARIABLES DE ENTORNO DEL SISTEMA ===\n";
echo "DATABASE_URL: " . getenv('DATABASE_URL') . "\n";
echo "DB_CONNECTION: " . getenv('DB_CONNECTION') . "\n";
echo "DB_HOST: " . getenv('DB_HOST') . "\n";
echo "DB_PORT: " . getenv('DB_PORT') . "\n";
echo "DB_DATABASE: " . getenv('DB_DATABASE') . "\n";
echo "DB_USERNAME: " . getenv('DB_USERNAME') . "\n";
echo "DB_PASSWORD: " . (getenv('DB_PASSWORD') ? '[OCULTO]' : '[NO DEFINIDO]') . "\n";

echo "\n=== VARIABLES $_ENV ===\n";
echo "DB_CONNECTION: " . ($_ENV['DB_CONNECTION'] ?? '[NO DEFINIDO]') . "\n";
echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? '[NO DEFINIDO]') . "\n";
echo "DB_PORT: " . ($_ENV['DB_PORT'] ?? '[NO DEFINIDO]') . "\n";
echo "DB_DATABASE: " . ($_ENV['DB_DATABASE'] ?? '[NO DEFINIDO]') . "\n";
echo "DB_USERNAME: " . ($_ENV['DB_USERNAME'] ?? '[NO DEFINIDO]') . "\n";
echo "DB_PASSWORD: " . (isset($_ENV['DB_PASSWORD']) ? '[OCULTO]' : '[NO DEFINIDO]') . "\n";

echo "\n=== ARCHIVO .env ===\n";
if (file_exists('../.env')) {
    $env_content = file_get_contents('../.env');
    $lines = explode("\n", $env_content);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0) {
            if (strpos($line, 'DB_PASSWORD') !== false) {
                echo "DB_PASSWORD=[OCULTO]\n";
            } else {
                echo $line . "\n";
            }
        }
    }
} else {
    echo ".env no encontrado\n";
}

echo "\n=== TODAS LAS VARIABLES DE ENTORNO (Railway) ===\n";
foreach ($_ENV as $key => $value) {
    if (strpos($key, 'DATABASE') !== false || strpos($key, 'DB_') !== false || strpos($key, 'MYSQL') !== false) {
        if (strpos($key, 'PASSWORD') !== false) {
            echo "$key=[OCULTO]\n";
        } else {
            echo "$key=$value\n";
        }
    }
}

echo "</pre>";
?>