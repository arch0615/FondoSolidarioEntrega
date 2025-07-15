<?php
/**
 * Script para crear el enlace simbólico de storage
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Creando enlace simbólico para Storage</h2>";

// Rutas
$targetFolder = '../storage/app/public';
$linkFolder = 'storage';

echo "<p>Verificando configuración...</p>";
echo "<ul>";
echo "<li>Carpeta origen: <code>$targetFolder</code></li>";
echo "<li>Enlace a crear: <code>$linkFolder</code></li>";
echo "</ul>";

// Verificar si el enlace ya existe
if (file_exists($linkFolder)) {
    if (is_link($linkFolder)) {
        echo "<p>⚠️ El enlace simbólico ya existe.</p>";
        
        // Verificar si apunta al lugar correcto
        $currentTarget = readlink($linkFolder);
        echo "<p>Apunta a: <code>$currentTarget</code></p>";
        
        if ($currentTarget !== $targetFolder) {
            echo "<p>❌ El enlace existe pero apunta a un lugar incorrecto.</p>";
            echo "<p>Eliminando enlace anterior...</p>";
            unlink($linkFolder);
            
            echo "<p>Creando nuevo enlace...</p>";
            if (symlink($targetFolder, $linkFolder)) {
                echo "<p>✅ Enlace simbólico recreado exitosamente.</p>";
            } else {
                echo "<p>❌ Error al crear el enlace simbólico.</p>";
            }
        } else {
            echo "<p>✅ El enlace ya está configurado correctamente.</p>";
        }
    } else {
        echo "<p>❌ Existe un archivo o carpeta llamada 'storage' que no es un enlace simbólico.</p>";
        echo "<p>Por favor, elimínala manualmente y vuelve a ejecutar este script.</p>";
    }
} else {
    echo "<p>Creando enlace simbólico...</p>";
    
    if (symlink($targetFolder, $linkFolder)) {
        echo "<p>✅ <strong>Enlace simbólico creado exitosamente.</strong></p>";
    } else {
        echo "<p>❌ Error al crear el enlace simbólico.</p>";
        echo "<p>Posibles causas:</p>";
        echo "<ul>";
        echo "<li>El servidor no permite crear enlaces simbólicos</li>";
        echo "<li>La carpeta de origen no existe</li>";
        echo "<li>Permisos insuficientes</li>";
        echo "</ul>";
    }
}

// Verificar que la carpeta de archivos existe
echo "<h3>Verificando carpetas de storage:</h3>";

$storagePaths = [
    '../storage/app/public',
    '../storage/app/public/archivos_documentos',
    '../storage/app/public/archivos_accidentes',
    '../storage/app/public/archivos_reintegros'
];

foreach ($storagePaths as $path) {
    if (is_dir($path)) {
        echo "<p>✅ Existe: <code>$path</code></p>";
        
        // Verificar permisos
        if (is_writable($path)) {
            echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;✅ Con permisos de escritura</p>";
        } else {
            echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;❌ Sin permisos de escritura</p>";
        }
    } else {
        echo "<p>❌ No existe: <code>$path</code></p>";
        
        // Intentar crear la carpeta
        if (mkdir($path, 0755, true)) {
            echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;✅ Carpeta creada</p>";
        } else {
            echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;❌ No se pudo crear la carpeta</p>";
        }
    }
}

// Probar acceso a un archivo
echo "<h3>Prueba de acceso:</h3>";
echo "<p>URL de ejemplo: <code>https://fondosolidario.jaeccba.org/storage/archivos_documentos/test.txt</code></p>";

// Crear archivo de prueba
$testFile = '../storage/app/public/test.txt';
file_put_contents($testFile, 'Archivo de prueba - Si puedes ver esto, el storage funciona correctamente.');
echo "<p>✅ Archivo de prueba creado</p>";

echo "<p><a href='/storage/test.txt' target='_blank'>Click aquí para probar el acceso al storage</a></p>";

echo "<hr>";
echo "<h3>Resultado:</h3>";
echo "<p>Si el enlace se creó correctamente, ya deberías poder ver los archivos subidos.</p>";
echo "<p>Prueba accediendo nuevamente a tu archivo:</p>";
echo "<p><a href='/storage/archivos_documentos/Ch4h22zmwdRI9lMn2SPkFUJW5GzELj2pvi08044A.png' target='_blank'>Ver archivo</a></p>";
echo "<p><strong style='color: red;'>⚠️ ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO</strong></p>";
?>