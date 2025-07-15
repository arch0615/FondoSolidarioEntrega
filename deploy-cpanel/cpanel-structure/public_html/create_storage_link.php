<?php
// Archivo temporal para crear enlace simbólico de storage
// IMPORTANTE: Eliminar este archivo después de ejecutarlo

$targetFolder = '../storage/app/public';
$linkFolder = 'storage';

if (file_exists($linkFolder)) {
    echo "El enlace simbólico ya existe.";
} else {
    symlink($targetFolder, $linkFolder);
    echo "Enlace simbólico creado exitosamente. Por favor, elimina este archivo.";
}