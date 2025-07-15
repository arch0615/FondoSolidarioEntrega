<?php
/**
 * Diagnóstico completo del problema de base de datos
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Diagnóstico de problema de conexión a base de datos</h2>";

echo "<h3>1. Verificando configuración actual en .env:</h3>";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    preg_match_all('/^(DB_[A-Z_]+)=(.*)$/m', $envContent, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        $key = $match[1];
        $value = trim($match[2], " \t\n\r\0\x0B\"'");
        if ($key === 'DB_PASSWORD') {
            echo "$key = " . str_repeat('*', strlen($value)) . " (longitud: " . strlen($value) . ")<br>";
        } else {
            echo "$key = $value<br>";
        }
    }
} else {
    echo "❌ No se encontró el archivo .env<br>";
}

echo "<br><h3>2. Verificando el usuario en cPanel:</h3>";
echo "<p>Por favor verifica en cPanel:</p>";
echo "<ol>";
echo "<li>Ve a <strong>MySQL® Databases</strong></li>";
echo "<li>En la sección <strong>'Current Users'</strong>, busca el usuario <code>jaec_fondosolidario</code></li>";
echo "<li>Verifica que el usuario esté asociado a la base de datos <code>jaec_fondosolidario</code></li>";
echo "<li>Si no está asociado, en la sección <strong>'Add User To Database'</strong>:";
echo "<ul>";
echo "<li>Selecciona el usuario: <code>jaec_fondosolidario</code></li>";
echo "<li>Selecciona la base de datos: <code>jaec_fondosolidario</code></li>";
echo "<li>Click en 'Add'</li>";
echo "<li>En la siguiente pantalla, marca <strong>ALL PRIVILEGES</strong></li>";
echo "<li>Click en 'Make Changes'</li>";
echo "</ul></li>";
echo "</ol>";

echo "<h3>3. Posibles soluciones:</h3>";

echo "<h4>Opción A: Verificar permisos del usuario</h4>";
echo "<p>El error 'Access denied' generalmente significa:</p>";
echo "<ul>";
echo "<li>El usuario no tiene permisos en la base de datos</li>";
echo "<li>La contraseña es incorrecta</li>";
echo "<li>El usuario no existe</li>";
echo "</ul>";

echo "<h4>Opción B: Crear un nuevo usuario</h4>";
echo "<p>Si el problema persiste, puedes crear un nuevo usuario en cPanel:</p>";
echo "<ol>";
echo "<li>En <strong>MySQL® Databases</strong></li>";
echo "<li>Sección <strong>'MySQL Users'</strong></li>";
echo "<li>Crear nuevo usuario (ej: <code>jaec_fondo2</code>)</li>";
echo "<li>Usar una contraseña simple sin caracteres especiales</li>";
echo "<li>Asociar el usuario a la base de datos con TODOS los privilegios</li>";
echo "</ol>";

echo "<h4>Opción C: Usar phpMyAdmin</h4>";
echo "<p>Puedes verificar el acceso desde phpMyAdmin:</p>";
echo "<ol>";
echo "<li>Abre phpMyAdmin desde cPanel</li>";
echo "<li>Intenta acceder con las credenciales</li>";
echo "<li>Si funciona ahí, el problema es de configuración en Laravel</li>";
echo "</ol>";

echo "<br><h3>4. Script para actualizar .env con nuevas credenciales:</h3>";
echo "<p>Si creas un nuevo usuario, actualiza el .env con este código:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo htmlspecialchars('<?php
// update-env-credentials.php
$newUsername = "jaec_NUEVO_USUARIO";
$newPassword = "NUEVA_CONTRASEÑA";

$envPath = __DIR__ . "/../.env";
$content = file_get_contents($envPath);
$content = preg_replace(\'/^DB_USERNAME=.*/m\', "DB_USERNAME=$newUsername", $content);
$content = preg_replace(\'/^DB_PASSWORD=.*/m\', "DB_PASSWORD=$newPassword", $content);
file_put_contents($envPath, $content);

// Limpiar caché
@unlink(__DIR__ . "/../bootstrap/cache/config.php");
echo "✅ Credenciales actualizadas";
?>');
echo "</pre>";

echo "<hr>";
echo "<p><strong>⚠️ ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO</strong></p>";
?>