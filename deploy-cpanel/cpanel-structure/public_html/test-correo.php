<?php
/**
 * Script de Diagnóstico de Correos - Fondo Solidario
 * 
 * Este script diagnostica problemas con el envío de correos en el sistema de reintegros
 * Autor: Sistema de Diagnóstico
 * Fecha: 2025-09-15
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Intentar cargar el autoloader de Composer (Laravel)
$autoloaderPaths = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php'
];

$autoloaderCargado = false;
foreach ($autoloaderPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $autoloaderCargado = true;
        break;
    }
}

// Si no se puede cargar Composer, intentar cargar PHPMailer manualmente
if (!$autoloaderCargado) {
    // Rutas comunes donde podría estar PHPMailer
    $phpmailerPaths = [
        __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php',
        __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php',
        __DIR__ . '/PHPMailer/src/PHPMailer.php'
    ];
    
    foreach ($phpmailerPaths as $path) {
        if (file_exists($path)) {
            require_once dirname($path) . '/PHPMailer.php';
            require_once dirname($path) . '/SMTP.php';
            require_once dirname($path) . '/Exception.php';
            break;
        }
    }
}

echo "<h1>🔍 Diagnóstico de Correos - Fondo Solidario</h1>";
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

// CONFIGURACIÓN DEL PROVEEDOR (PROBANDO DOMINIO ORIGINAL)
$envVars = [
    'APP_NAME' => 'Fondo Solidario JAEC',
    'APP_ENV' => 'local',
    'APP_DEBUG' => 'true',
    'APP_URL' => 'http://localhost',
    
    // 📧 CONFIGURACIÓN DE CORREO - PROBANDO jaeccba.org con usuario correcto
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'jaeccba.org',                    // Dominio original que SÍ resuelve
    'MAIL_PORT' => '465',
    'MAIL_USERNAME' => 'no-reply@jaeccba.org',       // ✅ Usuario correcto del proveedor
    'MAIL_PASSWORD' => '9l3S.YodfWeq',
    'MAIL_ENCRYPTION' => 'ssl',
    'MAIL_FROM_ADDRESS' => 'no-reply@jaeccba.org',   // ✅ Email FROM correcto
    'MAIL_FROM_NAME' => 'Fondo Solidario JAEC'
];

// 1. MOSTRAR CONFIGURACIÓN HARDCODEADA
echo "<h2>⚙️ 1. Configuración Hardcodeada</h2>";

mostrarInfo("� Configuración utilizada", "Los valores están hardcodeados en el script.\nModifica las variables \$envVars en el código para usar la configuración real del servidor.", 'info');

// 2. MOSTRAR CONFIGURACIÓN DE CORREO
echo "<h2>📧 2. Configuración de Correo</h2>";

$mailConfig = [
    'MAIL_MAILER' => $envVars['MAIL_MAILER'] ?? 'No configurado',
    'MAIL_HOST' => $envVars['MAIL_HOST'] ?? 'No configurado',
    'MAIL_PORT' => $envVars['MAIL_PORT'] ?? 'No configurado',
    'MAIL_USERNAME' => $envVars['MAIL_USERNAME'] ?? 'No configurado',
    'MAIL_PASSWORD' => !empty($envVars['MAIL_PASSWORD']) ? '*** (Configurado)' : 'No configurado',
    'MAIL_ENCRYPTION' => $envVars['MAIL_ENCRYPTION'] ?? 'No configurado',
    'MAIL_FROM_ADDRESS' => $envVars['MAIL_FROM_ADDRESS'] ?? 'No configurado',
    'MAIL_FROM_NAME' => $envVars['MAIL_FROM_NAME'] ?? 'No configurado'
];

$configTexto = "";
foreach ($mailConfig as $clave => $valor) {
    $configTexto .= "$clave = $valor\n";
}

mostrarInfo("Configuración actual de correo", $configTexto);

// 3. VERIFICAR FUNCIONES DE PHP
echo "<h2>🔧 3. Verificación de Funciones PHP</h2>";

$phpInfo = "Versión PHP: " . PHP_VERSION . "\n";
$phpInfo .= "Función mail(): " . (function_exists('mail') ? '✅ Disponible' : '❌ No disponible') . "\n";
$phpInfo .= "Extensión OpenSSL: " . (extension_loaded('openssl') ? '✅ Cargada' : '❌ No cargada') . "\n";
$phpInfo .= "Extensión SMTP: " . (extension_loaded('smtp') ? '✅ Cargada' : '❌ No cargada') . "\n";
$phpInfo .= "allow_url_fopen: " . (ini_get('allow_url_fopen') ? '✅ Habilitado' : '❌ Deshabilitado') . "\n";

mostrarInfo("Información del entorno PHP", $phpInfo);

// 4. VERIFICAR CONEXIÓN AL SERVIDOR DE CORREO
echo "<h2>🌐 4. Verificación de Conexión al Servidor</h2>";

if (!empty($envVars['MAIL_HOST']) && $envVars['MAIL_HOST'] !== 'mailpit') {
    $host = $envVars['MAIL_HOST'];
    $puerto = $envVars['MAIL_PORT'] ?? 587;
    
    $conexion = @fsockopen($host, $puerto, $errno, $errstr, 10);
    
    if ($conexion) {
        mostrarInfo("✅ Conexión al servidor exitosa", "Host: $host\nPuerto: $puerto", 'success');
        fclose($conexion);
    } else {
        mostrarInfo("❌ Error de conexión al servidor", "Host: $host\nPuerto: $puerto\nError: $errstr ($errno)", 'error');
    }
} else {
    mostrarInfo("⚠️ Configuración de desarrollo detectada", "MAIL_HOST: " . ($envVars['MAIL_HOST'] ?? 'No configurado') . "\nEsto parece ser configuración local/desarrollo", 'info');
}

// 5. INTENTAR ENVÍO DE CORREO DE PRUEBA
echo "<h2>✉️ 5. Prueba de Envío de Correo</h2>";

$destinatario = 'rcastanonr@gmail.com';
$asunto = 'Prueba de Correo - Fondo Solidario - ' . date('Y-m-d H:i:s');
$mensaje = "
<html>
<head>
    <title>Prueba de Correo - Fondo Solidario</title>
</head>
<body>
    <h2>🧪 Correo de Prueba - Sistema Fondo Solidario</h2>
    <p><strong>Fecha/Hora:</strong> " . date('Y-m-d H:i:s') . "</p>
    <p><strong>Servidor:</strong> " . ($_SERVER['SERVER_NAME'] ?? 'No disponible') . "</p>
    <p><strong>IP del servidor:</strong> " . ($_SERVER['SERVER_ADDR'] ?? 'No disponible') . "</p>
    
    <h3>Configuración utilizada:</h3>
    <ul>
        <li><strong>MAIL_MAILER:</strong> " . ($envVars['MAIL_MAILER'] ?? 'No configurado') . "</li>
        <li><strong>MAIL_HOST:</strong> " . ($envVars['MAIL_HOST'] ?? 'No configurado') . "</li>
        <li><strong>MAIL_PORT:</strong> " . ($envVars['MAIL_PORT'] ?? 'No configurado') . "</li>
        <li><strong>MAIL_FROM_ADDRESS:</strong> " . ($envVars['MAIL_FROM_ADDRESS'] ?? 'No configurado') . "</li>
    </ul>
    
    <p>Si recibiste este correo, la configuración básica está funcionando correctamente.</p>
    
    <p><em>Este es un correo generado automáticamente por el script de diagnóstico.</em></p>
</body>
</html>
";

// Preparar headers
$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=UTF-8';
$headers[] = 'From: ' . ($envVars['MAIL_FROM_ADDRESS'] ?? 'test@ejemplo.com');
$headers[] = 'Reply-To: ' . ($envVars['MAIL_FROM_ADDRESS'] ?? 'test@ejemplo.com');
$headers[] = 'X-Mailer: PHP/' . phpversion();

$headersString = implode("\r\n", $headers);

// Intentar envío con función mail() de PHP
echo "<h3>🚀 Intento 1: Usando función mail() de PHP</h3>";

if (function_exists('mail')) {
    $resultado = @mail($destinatario, $asunto, $mensaje, $headersString);
    
    if ($resultado) {
        mostrarInfo("✅ Correo enviado exitosamente", "Destinatario: $destinatario\nAsunto: $asunto", 'success');
    } else {
        $error = error_get_last();
        mostrarInfo("❌ Error al enviar correo", "Error: " . ($error['message'] ?? 'Error desconocido'), 'error');
    }
} else {
    mostrarInfo("❌ Función mail() no disponible", "La función mail() de PHP no está disponible en este servidor", 'error');
}

// 6. INTENTO SMTP MANUAL (HARDCODEADO)
echo "<h2>📬 6. Prueba SMTP Manual</h2>";

echo "<h3>🔧 Intento 2: SMTP Directo con credenciales reales</h3>";

try {
    // CREDENCIALES HÍBRIDAS: dominio que resuelve + usuario correcto
    $smtp_host = 'jaeccba.org';           // ✅ Dominio que SÍ resuelve DNS  
    $smtp_port = 465;                     // ✅ Puerto SSL correcto
    $smtp_user = 'no-reply@jaeccba.org';  // ✅ Usuario correcto del proveedor
    $smtp_pass = '9l3S.YodfWeq';          // Contraseña
    $from_email = 'no-reply@jaeccba.org'; // ✅ Email FROM correcto
    $from_name = 'Fondo Solidario JAEC';
    
    // Función para leer respuesta SMTP completa (soluciona respuestas multi-línea)
    function leerRespuestaSMTP($connection) {
        $response = '';
        do {
            $line = fgets($connection, 515);
            if ($line === false) break;
            $response .= $line;
            // Continuar leyendo si el 4to caracter es '-' (indica más líneas)
            $trimmed = trim($line);
            $continue = (strlen($trimmed) >= 4 && $trimmed[3] == '-');
        } while ($continue);
        return trim($response);
    }
    
    mostrarInfo("🔗 Intentando conexión SMTP SSL", "Host: $smtp_host\nPuerto: $smtp_port\nUsuario: $smtp_user");
    
    // Conectar con SSL
    $connection = fsockopen("ssl://$smtp_host", $smtp_port, $errno, $errstr, 30);
    
    if (!$connection) {
        throw new Exception("Error conectando: $errstr ($errno)");
    }
    
    // Leer respuesta inicial COMPLETA
    $response = leerRespuestaSMTP($connection);
    mostrarInfo("📥 Bienvenida del servidor (completa)", $response);
    
    // EHLO
    fputs($connection, "EHLO $smtp_host\r\n");
    $response = leerRespuestaSMTP($connection);
    mostrarInfo("📥 EHLO respuesta (completa)", $response);
    
    // AUTH LOGIN
    fputs($connection, "AUTH LOGIN\r\n");
    $response = leerRespuestaSMTP($connection);
    mostrarInfo("📥 AUTH LOGIN respuesta", $response);
    
    if (strpos($response, '334') !== false) {
        // Usuario
        fputs($connection, base64_encode($smtp_user) . "\r\n");
        $response = fgets($connection, 515);
        mostrarInfo("📥 Usuario enviado", trim($response));
        
        // Contraseña  
        fputs($connection, base64_encode($smtp_pass) . "\r\n");
        $response = fgets($connection, 515);
        mostrarInfo("📥 Contraseña enviada", trim($response));
        
        if (strpos($response, '235') !== false) {
            mostrarInfo("✅ ¡AUTENTICACIÓN EXITOSA!", "Las credenciales SMTP funcionan correctamente", 'success');
            
            // MAIL FROM
            fputs($connection, "MAIL FROM: <$from_email>\r\n");
            $response = fgets($connection, 515);
            mostrarInfo("📥 MAIL FROM", trim($response));
            
            // RCPT TO
            fputs($connection, "RCPT TO: <$destinatario>\r\n");
            $response = fgets($connection, 515);
            mostrarInfo("📥 RCPT TO", trim($response));
            
            // DATA
            fputs($connection, "DATA\r\n");
            $response = fgets($connection, 515);
            mostrarInfo("📥 DATA comando", trim($response));
            
            if (strpos($response, '354') !== false) {
                // Construir el correo
                $email_data = "From: $from_name <$from_email>\r\n";
                $email_data .= "To: $destinatario\r\n";
                $email_data .= "Subject: $asunto (SMTP Manual SSL)\r\n";
                $email_data .= "MIME-Version: 1.0\r\n";
                $email_data .= "Content-Type: text/html; charset=UTF-8\r\n";
                $email_data .= "\r\n";
                $email_data .= $mensaje;
                $email_data .= "\r\n.\r\n";
                
                fputs($connection, $email_data);
                $response = fgets($connection, 515);
                mostrarInfo("📥 Envío final", trim($response));
                
                if (strpos($response, '250') !== false) {
                    mostrarInfo("🎉 ¡CORREO ENVIADO EXITOSAMENTE!", 
                        "El correo se envió correctamente usando SMTP SSL.\n" .
                        "Revisa tu bandeja de entrada y spam en: $destinatario", 'success');
                } else {
                    mostrarInfo("❌ Error en envío", "El servidor rechazó el correo: " . trim($response), 'error');
                }
            }
        } else {
            mostrarInfo("❌ Error de autenticación", "Credenciales incorrectas: " . trim($response), 'error');
        }
    } else {
        mostrarInfo("❌ Error AUTH", "El servidor no acepta AUTH LOGIN: " . trim($response), 'error');
    }
    
    // QUIT
    fputs($connection, "QUIT\r\n");
    fclose($connection);
    
} catch (Exception $e) {
    mostrarInfo("❌ Error en conexión SMTP", "Error: " . $e->getMessage(), 'error');
}

// 7. RECOMENDACIONES
echo "<h2>💡 7. Recomendaciones y Siguientes Pasos</h2>";

$recomendaciones = "
DIAGNÓSTICO COMPLETADO - RECOMENDACIONES:

1. VERIFICAR CONFIGURACIÓN:
   - Asegúrate de que el archivo .env tiene la configuración correcta del servidor SMTP
   - Si usas un proveedor como Gmail, Outlook, etc., verifica las credenciales

2. CONFIGURACIÓN COMÚN PARA GMAIL:
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=tu-email@gmail.com
   MAIL_PASSWORD=tu-password-de-aplicación
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=tu-email@gmail.com

3. PROBLEMAS COMUNES:
   - Contraseñas de aplicación requeridas para Gmail (no la contraseña normal)
   - Firewall bloqueando puertos SMTP (587, 465, 25)
   - Configuración SSL/TLS incorrecta
   - Función mail() deshabilitada en el hosting

4. VERIFICAR LOGS:
   - Revisar logs de Laravel en storage/logs/
   - Revisar logs del servidor web
   - Verificar logs del sistema de correo

5. CONTACTAR PROVEEDOR DE HOSTING:
   - Si el problema persiste, contactar al proveedor de hosting
   - Verificar que el envío de correos esté habilitado
   - Confirmar configuración SMTP requerida

6. ALTERNATIVAS:
   - Usar servicios como SendGrid, Mailgun, Amazon SES
   - Configurar un relay SMTP autorizado
";

mostrarInfo("📋 Plan de Acción", $recomendaciones);

echo "<hr>";
echo "<p><strong>Script completado:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><em>Si el correo fue enviado exitosamente, revisa tu bandeja de entrada y spam en rcastanonr@gmail.com</em></p>";
?>
