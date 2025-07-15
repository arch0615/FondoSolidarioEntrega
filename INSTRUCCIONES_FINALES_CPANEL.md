# Instrucciones Finales - Subir a carpeta fondosolidario

## ⚠️ IMPORTANTE: TODO va dentro de la carpeta fondosolidario

Según tu imagen de cPanel, la estructura debe ser:

```
/home/tu_usuario/
└── fondosolidario/         ← AQUÍ VA TODO
    ├── public/             ← Contenido web público
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── artisan
```

## 📋 Pasos para subir:

### 1. Subir TODO a la carpeta fondosolidario

Desde la carpeta `deploy-cpanel/cpanel-structure/`:

- **Sube el contenido de `public_html/`** → dentro de `fondosolidario/public/`
- **Sube el contenido de `laravel/`** → directamente dentro de `fondosolidario/`

### 2. Configurar el dominio en cPanel

En cPanel, debes configurar tu dominio para que apunte a:
- Document Root: `/home/tu_usuario/fondosolidario/public`

Esto se hace en:
- **Domains** o **Addon Domains** en cPanel
- Cambiar el "Document Root" a `/fondosolidario/public`

### 3. Ajustar archivos

Como todo está dentro de fondosolidario, el index.php debe ajustarse:

```php
<?php
// En fondosolidario/public/index.php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Las rutas ahora son relativas desde public
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### 4. Archivo para storage link

El archivo create_storage_link.php también debe ajustarse:

```php
<?php
// En fondosolidario/public/create_storage_link.php

$targetFolder = '../storage/app/public';
$linkFolder = 'storage';

if (file_exists($linkFolder)) {
    echo "El enlace simbólico ya existe.";
} else {
    symlink($targetFolder, $linkFolder);
    echo "Enlace simbólico creado exitosamente. Por favor, elimina este archivo.";
}
```

### 5. Configurar .env

En `fondosolidario/.env`:
- Actualiza las credenciales de base de datos
- Cambia APP_ENV=production
- Cambia APP_DEBUG=false
- Actualiza APP_URL con tu dominio

### 6. Permisos

Dar permisos 755 a:
- `fondosolidario/storage`
- `fondosolidario/bootstrap/cache`

## ✅ Resumen

1. Sube TODO dentro de la carpeta `fondosolidario`
2. La carpeta `public` debe estar dentro de `fondosolidario`
3. Configura el dominio para que apunte a `/fondosolidario/public`
4. Ajusta permisos y configuración

¡Eso es todo!