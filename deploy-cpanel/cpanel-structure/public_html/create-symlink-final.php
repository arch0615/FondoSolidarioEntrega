<?php
/**
 * Script FINAL para crear el enlace simbólico
 * EJECUTAR DESPUÉS DE ELIMINAR LA CARPETA storage DE public
 */

echo "<h2>Creando enlace simbólico de Storage</h2>";

$publicPath = __DIR__;
$storagePath = '../storage/app/public';
$storageLink = $publicPath . '/storage';

// Verificar que no existe nada llamado storage
if (file_exists($storageLink)) {
    die("<p>❌ ERROR: Todavía existe algo llamado 'storage' en public. Por favor elimínalo primero desde cPanel.</p>");
}

// Crear el enlace simbólico
echo "<p>Creando enlace simbólico...</p>";
if (@symlink($storagePath, $storageLink)) {
    echo "<p>✅ <strong>¡Enlace simbólico creado exitosamente!</strong></p>";
    
    // Verificar que funciona
    if (file_exists($storageLink . '/archivos_documentos')) {
        echo "<p>✅ Las carpetas de archivos son accesibles</p>";
        
        // Probar con el archivo específico
        $testFile = '/storage/archivos_documentos/Ch4h22zmwdRI9lMn2SPkFUJW5GzELj2pvi08044A.png';
        echo "<p>✅ Tus archivos ahora deberían ser accesibles en:</p>";
        echo "<p><a href='$testFile' target='_blank'>$testFile</a></p>";
    }
} else {
    echo "<p>❌ No se pudo crear el enlace simbólico.</p>";
    echo "<p>Alternativa manual desde SSH:</p>";
    echo "<pre>";
    echo "cd /home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/public\n";
    echo "ln -s ../storage/app/public storage";
    echo "</pre>";
}

echo "<hr>";
echo "<h3>✅ Si todo salió bien:</h3>";
echo "<ul>";
echo "<li>Los archivos serán accesibles en /storage/archivos_documentos/...</li>";
echo "<li>Las nuevas subidas funcionarán correctamente</li>";
echo "<li>Tu aplicación estará 100% funcional</li>";
echo "</ul>";
echo "<p><strong style='color: red;'>⚠️ ELIMINA ESTE ARCHIVO DESPUÉS</strong></p>";
?>