<?php
/**
 * Script para arreglar TODOS los campos auto-increment
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Arreglando campos auto-increment en todas las tablas</h2>";
echo "<pre style='background: #f0f0f0; padding: 10px; border: 1px solid #ddd;'>";

try {
    // Cargar Laravel
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Lista COMPLETA de tablas y sus campos ID
    $tables = [
        'accidentes' => 'id_accidente',
        'accidente_alumnos' => 'id_accidente_alumno',
        'alumnos' => 'id_alumno',
        'alumnos_salidas' => 'id_alumno_salida',
        'archivos_adjuntos' => 'id_archivo',
        'auditoria_sistema' => 'id_auditoria',
        'beneficiarios_svo' => 'id_beneficiario',
        'cat_estados_accidentes' => 'id_estado',
        'cat_estados_reintegros' => 'id_estado',
        'cat_estados_solicitudes' => 'id_estado',
        'cat_parentescos' => 'id_parentesco',
        'cat_tipos_documentos' => 'id_tipo_documento',
        'cat_tipos_gastos' => 'id_tipo_gasto',
        'cat_tipos_prestadores' => 'id_tipo_prestador',
        'derivaciones' => 'id_derivacion',
        'documentos_institucionales' => 'id_documento',
        'empleados' => 'id_empleado',
        'escuelas' => 'id_escuela',
        'fallecimientos' => 'id_fallecimiento',
        'notificaciones' => 'id_notificacion',
        'pasantias' => 'id_pasantia',
        'prestadores' => 'id_prestador',
        'reintegros' => 'id_reintegro',
        'roles' => 'id_rol',
        'salidas_educativas' => 'id_salida',
        'solicitudes_info_auditor' => 'id_solicitud',
        'usuarios' => 'id'
    ];
    
    echo "Verificando y arreglando " . count($tables) . " tablas...\n\n";
    
    $fixed = 0;
    $errors = 0;
    
    foreach ($tables as $table => $idField) {
        echo "Tabla: $table\n";
        
        if (Schema::hasTable($table)) {
            echo "  ✅ Existe\n";
            
            // Verificar si el campo existe y es auto-increment
            $result = DB::select("SHOW COLUMNS FROM $table WHERE Field = '$idField'");
            
            if (empty($result)) {
                echo "  ❌ Falta el campo $idField\n";
                echo "  🔧 Agregando campo...\n";
                
                try {
                    DB::statement("ALTER TABLE $table ADD $idField BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
                    echo "  ✅ Campo agregado exitosamente\n";
                    $fixed++;
                } catch (\Exception $e) {
                    echo "  ❌ Error: " . $e->getMessage() . "\n";
                    $errors++;
                }
            } else {
                $column = $result[0];
                if (strpos($column->Extra, 'auto_increment') === false) {
                    echo "  ⚠️ El campo existe pero NO es auto-increment\n";
                    echo "  🔧 Convirtiendo a auto-increment...\n";
                    
                    try {
                        // Primero eliminar cualquier clave primaria existente
                        try {
                            DB::statement("ALTER TABLE $table DROP PRIMARY KEY");
                        } catch (\Exception $e) {
                            // Ignorar si no hay clave primaria
                        }
                        
                        // Modificar el campo para que sea auto-increment
                        DB::statement("ALTER TABLE $table MODIFY $idField BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY");
                        echo "  ✅ Campo convertido a auto-increment\n";
                        $fixed++;
                    } catch (\Exception $e) {
                        echo "  ❌ Error: " . $e->getMessage() . "\n";
                        $errors++;
                    }
                } else {
                    echo "  ✅ Campo $idField es auto-increment\n";
                }
            }
        } else {
            echo "  ❌ La tabla no existe\n";
        }
        echo "\n";
    }
    
    echo "=====================================\n";
    echo "✅ Proceso completado\n";
    echo "   - Tablas arregladas: $fixed\n";
    echo "   - Errores: $errors\n\n";
    
    // Verificar tablas críticas
    echo "Verificación de tablas críticas:\n";
    $criticalTables = ['empleados', 'auditoria_sistema', 'usuarios', 'alumnos'];
    
    foreach ($criticalTables as $table) {
        echo "\nEstructura de '$table':\n";
        $columns = DB::select("SHOW COLUMNS FROM $table");
        foreach ($columns as $column) {
            if ($column->Key == 'PRI' || strpos($column->Extra, 'auto_increment') !== false) {
                echo sprintf("  %-20s %-15s %s %s\n", 
                    $column->Field, 
                    $column->Type, 
                    $column->Key == 'PRI' ? 'PRIMARY KEY' : '',
                    $column->Extra
                );
            }
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error general: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

echo "</pre>";

echo "<hr>";
echo "<h3>✅ Resultado:</h3>";
echo "<p>Si el proceso se completó correctamente:</p>";
echo "<ul>";
echo "<li>Todos los campos ID ahora son auto-increment</li>";
echo "<li>Puedes crear empleados, alumnos, etc. sin problemas</li>";
echo "<li>El sistema de auditoría funcionará correctamente</li>";
echo "<li>Puedes cerrar sesión sin errores</li>";
echo "</ul>";
echo "<p><strong style='color: red;'>⚠️ ELIMINA ESTE ARCHIVO INMEDIATAMENTE</strong></p>";
echo "<p><a href='/' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Ir al sitio</a></p>";
?>