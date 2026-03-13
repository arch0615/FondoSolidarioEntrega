<?php
// Archivo temporal para crear enlace simbolico de storage
// IMPORTANTE: Eliminar este archivo despues de ejecutarlo

$targetFolder = '../laravel/storage/app/public';
$linkFolder = 'storage';

if (file_exists($linkFolder)) {
    echo "El enlace simbolico ya existe.";
} else {
    symlink($targetFolder, $linkFolder);
    echo "Enlace simbolico creado exitosamente. Por favor, elimina este archivo.";
}
