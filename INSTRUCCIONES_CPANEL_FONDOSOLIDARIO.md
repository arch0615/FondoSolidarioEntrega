# Instrucciones para subir a cPanel - Carpeta fondosolidario

## Estructura de tu cPanel

Según tu imagen, debes usar la siguiente estructura:

```
/home/tu_usuario/
├── public_html/           (aquí va el contenido de la carpeta public)
└── fondosolidario/        (aquí va el resto de Laravel)
```

## Pasos para subir los archivos

Una vez que el script termine de ejecutarse, tendrás una carpeta `deploy-cpanel` con dos subcarpetas:

### 1. Subir contenido público
- **Origen**: `deploy-cpanel/cpanel-structure/public_html/`
- **Destino en cPanel**: `public_html/`
- Sube TODO el contenido (index.php, .htaccess, build/, etc.)

### 2. Subir aplicación Laravel
- **Origen**: `deploy-cpanel/cpanel-structure/laravel/`
- **Destino en cPanel**: `fondosolidario/`
- Sube TODO el contenido (app/, vendor/, storage/, etc.)

### 3. Modificar index.php

Después de subir los archivos, edita el archivo `public_html/index.php` en cPanel y cambia esta línea:

```php
// Cambiar de:
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {

// A:
if (file_exists($maintenance = __DIR__.'/../fondosolidario/storage/framework/maintenance.php')) {
```

Y también:

```php
// Cambiar de:
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

// A:
require __DIR__.'/../fondosolidario/vendor/autoload.php';
$app = require_once __DIR__.'/../fondosolidario/bootstrap/app.php';
```

### 4. Crear enlace simbólico

Modifica también el archivo `create_storage_link.php` en `public_html`:

```php
<?php
$targetFolder = '../fondosolidario/storage/app/public';
$linkFolder = 'storage';

if (file_exists($linkFolder)) {
    echo "El enlace simbólico ya existe.";
} else {
    symlink($targetFolder, $linkFolder);
    echo "Enlace simbólico creado exitosamente. Por favor, elimina este archivo.";
}
```

### 5. Configurar .env

En la carpeta `fondosolidario`, actualiza el archivo `.env` con:

```env
APP_NAME="Fondo Solidario JAEC"
APP_ENV=production
APP_KEY=base64:VTgsybSY9gYMv7v9RCmpfwtee1C84weP5K6W1x7aaVQ=
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_de_datos_cpanel
DB_USERNAME=tu_usuario_db_cpanel
DB_PASSWORD=tu_contraseña_db
```

### 6. Permisos

Usando el File Manager de cPanel, cambia los permisos a 755 para:
- `fondosolidario/storage`
- `fondosolidario/storage/framework`
- `fondosolidario/storage/logs`
- `fondosolidario/bootstrap/cache`

## ¡Importante!

Como estás usando la carpeta `fondosolidario` en lugar de `laravel`, asegúrate de actualizar todas las referencias en los archivos PHP.