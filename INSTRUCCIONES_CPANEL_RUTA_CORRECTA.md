# Instrucciones para subir a cPanel - Ruta Correcta

## 📁 Estructura de tu servidor:

```
/home/jaec/
└── public_html/
    └── fondosolidario.jaeccba.org/
        └── fondosolidario/         ← AQUÍ VA TODO TU PROYECTO
            ├── public/             ← Carpeta pública de Laravel
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

## 🚀 Pasos para subir:

### 1. Desde tu carpeta local `deploy-cpanel/cpanel-structure/`:

- **Sube `public_html/`** → a `/home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/public/`
- **Sube `laravel/`** → a `/home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/`

### 2. Configuración del dominio

El dominio `fondosolidario.jaeccba.org` debe apuntar a:
- Document Root: `/home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/public`

### 3. Ajustar el archivo .htaccess en la raíz

Crea un archivo `.htaccess` en `/home/jaec/public_html/fondosolidario.jaeccba.org/` con:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ fondosolidario/public/$1 [L]
</IfModule>
```

### 4. Verificar index.php

El archivo `index.php` en la carpeta `public` ya está configurado correctamente con rutas relativas:

```php
// Las rutas son relativas desde public
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

### 5. Configurar .env

En `/home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/.env`:

```env
APP_NAME="Fondo Solidario JAEC"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://fondosolidario.jaeccba.org

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_de_datos
DB_USERNAME=tu_usuario_db
DB_PASSWORD=tu_contraseña_db
```

### 6. Permisos

Configura permisos 755 para:
- `/home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/storage`
- `/home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/bootstrap/cache`

### 7. Crear enlace simbólico

Accede a: `https://fondosolidario.jaeccba.org/create_storage_link.php`
Luego elimina el archivo.

## 📋 Resumen de rutas:

- **URL del sitio**: https://fondosolidario.jaeccba.org
- **Ruta completa en servidor**: /home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/
- **Carpeta pública**: /home/jaec/public_html/fondosolidario.jaeccba.org/fondosolidario/public/

## 🔧 Si usas File Manager de cPanel:

1. Navega a: `/home/jaec/public_html/fondosolidario.jaeccba.org/`
2. Crea la carpeta `fondosolidario` si no existe
3. Sube los archivos dentro de ella manteniendo la estructura

¡Con esto debería funcionar correctamente!