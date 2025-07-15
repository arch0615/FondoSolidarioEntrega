<?php
/**
 * Script para arreglar el enlace simbólico de storage
 * ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO
 */

echo "<h2>Arreglando el enlace simbólico de Storage</h2>";

$publicPath = __DIR__;
$storagePath = dirname(__DIR__) . '/storage/app/public';
$storageLink = $publicPath . '/storage';

echo "<h3>1. Situación actual:</h3>";
echo "<p>❌ Tienes carpetas individuales en public (archivos_documentos, etc.)</p>";
echo "<p>❌ No hay un enlace simbólico correcto</p>";

echo "<h3>2. Limpiando estructura incorrecta:</h3>";

// Eliminar carpetas incorrectas de public
$foldersToRemove = [
    'archivos_documentos',
    'archivos_accidentes',
    'archivos_reintegros'
];

foreach ($foldersToRemove as $folder) {
    $path = $publicPath . '/' . $folder;
    if (is_dir($path) && !is_link($path)) {
        echo "<p>Eliminando carpeta incorrecta: $folder</p>";
        // No eliminar para no perder archivos, solo informar
        echo "<p>⚠️ ADVERTENCIA: La carpeta $folder no debería estar aquí</p>";
    }
}

// Eliminar storage si existe y no es un enlace
if (file_exists($storageLink)) {
    if (is_link($storageLink)) {
        echo "<p>Eliminando enlace simbólico anterior...</p>";
        unlink($storageLink);
    } else {
        echo "<p>❌ Existe una carpeta 'storage' que no es un enlace simbólico</p>";
        echo "<p>Por favor, elimínala manualmente desde el File Manager de cPanel</p>";
        die();
    }
}

echo "<h3>3. Creando enlace simbólico correcto:</h3>";

// Crear el enlace simbólico
if (symlink($storagePath, $storageLink)) {
    echo "<p>✅ Enlace simbólico creado exitosamente</p>";
    echo "<p>public/storage → storage/app/public</p>";
} else {
    echo "<p>❌ Error al crear el enlace simbólico</p>";
    echo "<p>Alternativa: Intenta crear el enlace desde SSH con:</p>";
    echo "<pre>cd " . $publicPath . "\nln -s ../storage/app/public storage</pre>";
}

echo "<h3>4. Verificación:</h3>";

// Verificar que funciona
$testFile = $storageLink . '/archivos_documentos/Ch4h22zmwdRI9lMn2SPkFUJW5GzELj2pvi08044A.png';
if (file_exists($testFile)) {
    echo "<p>✅ El enlace funciona correctamente</p>";
    echo "<p>✅ Los archivos son accesibles</p>";
    echo "<p><a href='/storage/archivos_documentos/Ch4h22zmwdRI9lMn2SPkFUJW5GzELj2pvi08044A.png' target='_blank'>Click aquí para ver tu archivo</a></p>";
} else {
    echo "<p>❌ El enlace no está funcionando correctamente</p>";
}

echo "<h3>5. Estructura correcta:</h3>";
echo "<pre>";
echo "public/
├── storage (enlace simbólico → ../storage/app/public)
│   ├── archivos_documentos/
│   ├── archivos_accidentes/
│   └── archivos_reintegros/
├── index.php
├── .htaccess
└── (otros archivos...)
</pre>";

echo "<hr>";
echo "<p><strong>IMPORTANTE:</strong></p>";
echo "<ol>";
echo "<li>Si hay una carpeta 'storage' en public que no es un enlace, elimínala desde cPanel</li>";
echo "<li>Las carpetas archivos_* NO deben estar directamente en public</li>";
echo "<li>Todo debe accederse a través de /storage/archivos_*</li>";
echo "</ol>";
echo "<p><strong style='color: red;'>⚠️ ELIMINA ESTE ARCHIVO DESPUÉS DE USARLO</strong></p>";
?>