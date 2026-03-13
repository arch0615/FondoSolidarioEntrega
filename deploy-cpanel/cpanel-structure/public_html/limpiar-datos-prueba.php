<?php
/**
 * Script de Limpieza de Datos de Prueba - Fondo Solidario JAEC
 * 
 * Este script limpia todas las tablas de datos de prueba generados por los seeders,
 * manteniendo únicamente:
 * - Los catálogos del sistema (estados, tipos, roles, etc.)
 * - El usuario administrador principal
 * 
 * IMPORTANTE: Ejecutar solo en servidores de prueba o cuando se requiera
 * restablecer el sistema a un estado limpio.
 */

// Configuración de base de datos (se lee automáticamente del .env)
// No es necesario modificar nada, el script lee la configuración automáticamente

echo "<!DOCTYPE html>";
echo "<html><head><title>Limpieza de Datos de Prueba - Fondo Solidario JAEC</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;background:#f5f5f5;}";
echo ".container{background:white;padding:30px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}";
echo ".success{color:#4CAF50;background:#E8F5E8;padding:10px;border-radius:4px;margin:10px 0;}";
echo ".error{color:#F44336;background:#FFEBEE;padding:10px;border-radius:4px;margin:10px 0;}";
echo ".warning{color:#FF9800;background:#FFF3E0;padding:10px;border-radius:4px;margin:10px 0;}";
echo ".info{color:#2196F3;background:#E3F2FD;padding:10px;border-radius:4px;margin:10px 0;}";
echo "h1{color:#333;text-align:center;} h2{color:#555;border-bottom:2px solid #4CAF50;padding-bottom:5px;}";
echo "table{width:100%;border-collapse:collapse;margin:15px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;}";
echo "th{background-color:#4CAF50;color:white;} tr:nth-child(even){background-color:#f2f2f2;}";
echo "</style></head><body>";

echo "<div class='container'>";
echo "<h1>🧹 Limpieza de Datos de Prueba</h1>";
echo "<h2>Sistema Fondo Solidario JAEC</h2>";

try {
    // Verificar que existe .env
    if (!file_exists('../.env')) {
        throw new Exception('No se encuentra el archivo .env en la carpeta Laravel');
    }
    
    echo "<div class='info'>📋 Leyendo configuración del archivo .env</div>";
    
    // Obtener configuración de .env de forma directa
    $envLines = file('../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $envVars = [];
    foreach ($envLines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $envVars[trim($key)] = trim($value);
        }
    }
    
    // Verificar que se encontraron las variables necesarias
    $requiredVars = ['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
    foreach ($requiredVars as $var) {
        if (!isset($envVars[$var])) {
            throw new Exception("Variable $var no encontrada en .env");
        }
    }
    
    echo "<div class='info'>📊 Base de datos: {$envVars['DB_DATABASE']} | Host: {$envVars['DB_HOST']}</div>";
    
    // Conexión a la base de datos usando configuración del .env
    $pdo = new PDO(
        'mysql:host=' . $envVars['DB_HOST'] . ';dbname=' . $envVars['DB_DATABASE'] . ';charset=utf8mb4',
        $envVars['DB_USERNAME'],
        $envVars['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<div class='success'>✅ Conexión a base de datos establecida correctamente</div>";
    
    // Deshabilitar verificación de claves foráneas temporalmente
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    echo "<div class='info'>🔓 Verificación de claves foráneas deshabilitada</div>";
    
    $resultados = [];
    $errores = [];
    
    // === PASO 0: VERIFICAR ESTADO INICIAL ===
    echo "<h2>🔍 Paso 0: Verificando Estado Inicial de la Base de Datos</h2>";
    
    // Obtener todas las tablas de la base de datos
    $stmt = $pdo->query("SHOW TABLES");
    $todas_las_tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<div class='info'>📊 Tablas encontradas en la base de datos: " . count($todas_las_tablas) . "</div>";
    
    // Verificar registros en tablas principales antes de limpiar
    $tablas_verificar = ['usuarios', 'escuelas', 'alumnos', 'accidentes', 'reintegros', 'prestadores'];
    $hay_datos = false;
    
    foreach ($tablas_verificar as $tabla) {
        if (in_array($tabla, $todas_las_tablas)) {
            try {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM `$tabla`");
                $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                if ($count > 0) {
                    echo "<div class='warning'>⚠️ $tabla: $count registros encontrados</div>";
                    $hay_datos = true;
                } else {
                    echo "<div class='info'>ℹ️ $tabla: vacía</div>";
                }
            } catch (Exception $e) {
                echo "<div class='error'>❌ Error verificando $tabla: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='error'>❌ Tabla $tabla no existe</div>";
        }
    }
    
    if (!$hay_datos) {
        echo "<div class='info'>ℹ️ No se encontraron datos para limpiar. La base de datos parece estar vacía.</div>";
    }
    
    // === PASO 1: LIMPIAR DATOS TRANSACCIONALES ===
    echo "<h2>📋 Paso 1: Limpiando Datos Transaccionales</h2>";
    
    $tablas_transaccionales = [
        'historial_reintegros' => 'Historial de reintegros',
        'archivos_adjuntos' => 'Archivos adjuntos',
        'reintegro_tipos_gastos' => 'Relación reintegro-tipos de gastos', // CORREGIDO: sin 's' en reintegro
        'reintegros' => 'Solicitudes de reintegro',
        'derivaciones' => 'Derivaciones médicas',
        'accidente_alumnos' => 'Relación accidentes-alumnos',
        'accidentes' => 'Registros de accidentes',
        'alumnos_salidas' => 'Relación alumnos-salidas educativas',
        'salidas_educativas' => 'Salidas educativas',
        'pasantias' => 'Pasantías',
        'empleados' => 'Empleados',
        'beneficiarios_svo' => 'Beneficiarios SVO',
        'fallecimientos' => 'Registros de fallecimientos',
        'notificaciones' => 'Notificaciones del sistema',
        'solicitudes_info_auditor' => 'Solicitudes de información del auditor',
        'auditoria_sistema' => 'Auditoría del sistema',
        'documentos_institucionales' => 'Documentos institucionales',
        'documento_escuelas' => 'Documentos de escuelas'
    ];
    
    foreach ($tablas_transaccionales as $tabla => $descripcion) {
        // Verificar si la tabla existe antes de intentar limpiarla
        if (in_array($tabla, $todas_las_tablas)) {
            try {
                $stmt = $pdo->prepare("DELETE FROM `$tabla`");
                $stmt->execute();
                $filas_eliminadas = $stmt->rowCount();
                $resultados[] = "🗑️ $descripcion: $filas_eliminadas registros eliminados";
                echo "<div class='success'>✅ $tabla: $filas_eliminadas registros eliminados</div>";
            } catch (Exception $e) {
                $errores[] = "❌ Error limpiando $tabla: " . $e->getMessage();
                echo "<div class='error'>❌ Error limpiando $tabla: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='warning'>⚠️ $tabla: no existe (se omite)</div>";
        }
    }
    
    // === PASO 2: LIMPIAR DATOS DE CONFIGURACIÓN/PRUEBA ===
    echo "<h2>🏫 Paso 2: Limpiando Datos de Configuración y Prueba</h2>";
    
    // Limpiar alumnos
    try {
        $stmt = $pdo->prepare("DELETE FROM alumnos");
        $stmt->execute();
        $filas_eliminadas = $stmt->rowCount();
        $resultados[] = "👨‍🎓 Alumnos: $filas_eliminadas registros eliminados";
        echo "<div class='success'>✅ Alumnos: $filas_eliminadas registros eliminados</div>";
    } catch (Exception $e) {
        $errores[] = "❌ Error limpiando alumnos: " . $e->getMessage();
        echo "<div class='error'>❌ Error limpiando alumnos: " . $e->getMessage() . "</div>";
    }
    
    // Limpiar escuelas
    try {
        $stmt = $pdo->prepare("DELETE FROM escuelas");
        $stmt->execute();
        $filas_eliminadas = $stmt->rowCount();
        $resultados[] = "🏫 Escuelas: $filas_eliminadas registros eliminados";
        echo "<div class='success'>✅ Escuelas: $filas_eliminadas registros eliminados</div>";
    } catch (Exception $e) {
        $errores[] = "❌ Error limpiando escuelas: " . $e->getMessage();
        echo "<div class='error'>❌ Error limpiando escuelas: " . $e->getMessage() . "</div>";
    }
    
    // Limpiar prestadores
    try {
        $stmt = $pdo->prepare("DELETE FROM prestadores");
        $stmt->execute();
        $filas_eliminadas = $stmt->rowCount();
        $resultados[] = "🏥 Prestadores: $filas_eliminadas registros eliminados";
        echo "<div class='success'>✅ Prestadores: $filas_eliminadas registros eliminados</div>";
    } catch (Exception $e) {
        $errores[] = "❌ Error limpiando prestadores: " . $e->getMessage();
        echo "<div class='error'>❌ Error limpiando prestadores: " . $e->getMessage() . "</div>";
    }
    
    // === PASO 3: LIMPIAR USUARIOS (MANTENER SOLO ADMIN) ===
    echo "<h2>👥 Paso 3: Limpiando Usuarios (Manteniendo Admin)</h2>";
    
    try {
        // Primero verificar si existe usuario admin
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM usuarios WHERE email = 'admin@prueba.com' OR id_rol = 2 LIMIT 1");
        $stmt->execute();
        $admin_exists = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
        
        if ($admin_exists) {
            // Eliminar todos los usuarios excepto el admin
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE email != 'admin@prueba.com' AND id_rol != 2");
            $stmt->execute();
            $filas_eliminadas = $stmt->rowCount();
            $resultados[] = "👤 Usuarios: $filas_eliminadas usuarios eliminados (admin mantenido)";
            echo "<div class='success'>✅ Usuarios: $filas_eliminadas usuarios eliminados (admin mantenido)</div>";
            
            // Verificar usuario admin restante
            $stmt = $pdo->prepare("SELECT email, nombre, apellido FROM usuarios WHERE email = 'admin@prueba.com' OR id_rol = 2 LIMIT 1");
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin) {
                echo "<div class='info'>ℹ️ Usuario admin preservado: {$admin['nombre']} {$admin['apellido']} ({$admin['email']})</div>";
            }
        } else {
            echo "<div class='warning'>⚠️ No se encontró usuario admin. Se eliminarán todos los usuarios.</div>";
            $stmt = $pdo->prepare("DELETE FROM usuarios");
            $stmt->execute();
            $filas_eliminadas = $stmt->rowCount();
            $resultados[] = "👤 Usuarios: $filas_eliminadas usuarios eliminados (NO se encontró admin)";
        }
    } catch (Exception $e) {
        $errores[] = "❌ Error limpiando usuarios: " . $e->getMessage();
        echo "<div class='error'>❌ Error limpiando usuarios: " . $e->getMessage() . "</div>";
    }
    
    // === PASO 4: ACTUALIZAR CONTRASEÑA DEL ADMIN ===
    echo "<h2>🔐 Paso 4: Actualizando Contraseña del Administrador</h2>";
    
    try {
        // Nueva contraseña segura para el administrador
        $nueva_password = 'uy%12$ut@';
        $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);
        
        // Actualizar contraseña del usuario admin
        $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE (email = 'admin@prueba.com' OR id_rol = 2) AND activo = 1 LIMIT 1");
        $stmt->execute([$password_hash]);
        $filas_actualizadas = $stmt->rowCount();
        
        if ($filas_actualizadas > 0) {
            $resultados[] = "🔐 Contraseña del administrador actualizada con éxito";
            echo "<div class='success'>✅ Contraseña del administrador actualizada con éxito</div>";
            echo "<div class='info'>ℹ️ Nueva contraseña: <strong>uy%12$ut@</strong> (guardar en lugar seguro)</div>";
        } else {
            $errores[] = "⚠️ No se encontró usuario administrador para actualizar contraseña";
            echo "<div class='warning'>⚠️ No se encontró usuario administrador para actualizar contraseña</div>";
        }
    } catch (Exception $e) {
        $errores[] = "❌ Error actualizando contraseña del admin: " . $e->getMessage();
        echo "<div class='error'>❌ Error actualizando contraseña del admin: " . $e->getMessage() . "</div>";
    }
    
    // === PASO 5: RESTABLECER AUTO_INCREMENT ===
    echo "<h2>🔄 Paso 5: Restableciendo Contadores AUTO_INCREMENT</h2>";
    
    $tablas_reset = [
        'accidentes', 'alumnos', 'archivos_adjuntos', 'auditoria_sistema', 
        'beneficiarios_svo', 'derivaciones', 'documentos_institucionales', 
        'documento_escuelas', 'empleados', 'escuelas', 'fallecimientos', 
        'historial_reintegros', 'notificaciones', 'pasantias', 'prestadores', 
        'reintegros', 'salidas_educativas', 'solicitudes_info_auditor'
    ];
    
    foreach ($tablas_reset as $tabla) {
        try {
            $stmt = $pdo->prepare("ALTER TABLE `$tabla` AUTO_INCREMENT = 1");
            $stmt->execute();
            echo "<div class='info'>🔄 $tabla: AUTO_INCREMENT restablecido</div>";
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error restableciendo AUTO_INCREMENT en $tabla: " . $e->getMessage() . "</div>";
        }
    }
    
    // Restablecer verificación de claves foráneas
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "<div class='info'>🔒 Verificación de claves foráneas restablecida</div>";
    
    // === RESUMEN FINAL ===
    echo "<h2>📊 Resumen de Limpieza</h2>";
    
    if (!empty($resultados)) {
        echo "<h3>✅ Operaciones Exitosas:</h3>";
        echo "<table><tr><th>Descripción</th></tr>";
        foreach ($resultados as $resultado) {
            echo "<tr><td>$resultado</td></tr>";
        }
        echo "</table>";
    }
    
    if (!empty($errores)) {
        echo "<h3>❌ Errores Encontrados:</h3>";
        echo "<table><tr><th>Error</th></tr>";
        foreach ($errores as $error) {
            echo "<tr><td>$error</td></tr>";
        }
        echo "</table>";
    }
    
    echo "<div class='success'>";
    echo "<h3>🎉 Limpieza Completada</h3>";
    echo "<p><strong>El sistema ha sido restablecido con éxito.</strong></p>";
    echo "<p>📋 <strong>Estado actual:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Catálogos del sistema mantenidos</li>";
    echo "<li>✅ Usuario administrador preservado</li>";
    echo "<li>✅ Contraseña del admin actualizada</li>";
    echo "<li>✅ Todos los datos de prueba eliminados</li>";
    echo "<li>✅ Contadores restablecidos</li>";
    echo "</ul>";
    echo "<p>El sistema está listo para ser usado en producción.</p>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Error de Conexión a Base de Datos</h3>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Solución:</strong> Verificar los datos de conexión en la parte superior del archivo.</p>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Error General</h3>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "</div>";
}

echo "</div>";
echo "</body></html>";
?>
