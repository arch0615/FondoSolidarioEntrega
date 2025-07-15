# Guía de Deployment a cPanel - Fondo Solidario JAEC

## 📋 Requisitos Previos

1. **Acceso a cPanel** con los siguientes permisos:
   - Administrador de archivos
   - MySQL Database
   - Terminal (opcional pero recomendado)
   
2. **En tu máquina local**:
   - Node.js y npm instalados
   - Composer instalado
   - Git (opcional)

## 🔧 Paso 1: Preparar el Proyecto Localmente

### 1.1 Instalar Dependencias

```bash
# Instalar dependencias de PHP
composer install --optimize-autoloader --no-dev

# Instalar dependencias de Node.js
npm install
```

### 1.2 Compilar Assets para Producción

```bash
# Compilar CSS y JavaScript con Vite
npm run build
```

Esto generará los archivos optimizados en `public/build/`.

### 1.3 Configurar el Archivo .env

Crea un archivo `.env` basado en `.env.example` con la configuración de producción:

```env
APP_NAME="Fondo Solidario JAEC"
APP_ENV=production
APP_KEY=base64:TU_CLAVE_SEGURA_AQUI
APP_DEBUG=false
APP_URL=https://tudominio.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nombre_base_datos_cpanel
DB_USERNAME=usuario_base_datos_cpanel
DB_PASSWORD=contraseña_base_datos

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 1.4 Optimizar Laravel para Producción

```bash
# Limpiar cachés anteriores
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 📦 Paso 2: Preparar Archivos para Subida

### 2.1 Archivos y Carpetas a Subir

Debes subir las siguientes carpetas y archivos:

```
/app
/bootstrap
/config
/database
/public
/resources
/routes
/storage (con permisos especiales)
/vendor (si no tienes acceso a terminal en cPanel)
.env
artisan
composer.json
composer.lock
package.json
```

### 2.2 Archivos a NO Subir

```
/node_modules
/.git
/tests
.env.example
*.log
/storage/app/public/* (contenido, no la carpeta)
/storage/framework/cache/data/* (contenido)
/storage/framework/sessions/* (contenido)
/storage/framework/views/* (contenido)
/storage/logs/* (contenido)
```

## 🚀 Paso 3: Subir a cPanel

### 3.1 Crear Base de Datos en cPanel

1. Ir a **MySQL Database Wizard**
2. Crear nueva base de datos
3. Crear usuario de base de datos
4. Asignar TODOS los privilegios al usuario
5. Guardar las credenciales para el archivo .env

### 3.2 Subir Archivos

#### Opción A: Usando File Manager de cPanel

1. Acceder al **File Manager** de cPanel
2. Navegar a la carpeta `public_html` o tu carpeta de dominio
3. Subir el contenido de la carpeta `public` de Laravel a `public_html`
4. Crear una carpeta llamada `laravel` (o el nombre que prefieras) al mismo nivel que `public_html`
5. Subir el resto de archivos y carpetas del proyecto a esta carpeta `laravel`

La estructura debería quedar así:
```
/home/usuario/
├── public_html/
│   ├── index.php
│   ├── .htaccess
│   ├── build/
│   ├── favicon.ico
│   └── robots.txt
└── laravel/
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

#### Opción B: Usando FTP

1. Conectar vía FTP con las credenciales de cPanel
2. Seguir la misma estructura de carpetas mencionada arriba

### 3.3 Modificar index.php

Editar el archivo `public_html/index.php` para apuntar a la carpeta correcta:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ajustar las rutas para apuntar a la carpeta laravel
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../laravel/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### 3.4 Configurar Permisos

Usando el File Manager de cPanel o terminal SSH:

```bash
# Permisos para storage
chmod -R 775 storage
chmod -R 775 storage/framework
chmod -R 775 storage/logs
chmod -R 775 bootstrap/cache
```

### 3.5 Crear Enlace Simbólico para Storage

Si tienes acceso a terminal en cPanel:

```bash
cd ~/laravel
php artisan storage:link
```

Si NO tienes acceso a terminal, crea un archivo PHP temporal:

```php
<?php
// crear_storage_link.php
$targetFolder = '../laravel/storage/app/public';
$linkFolder = 'storage';
symlink($targetFolder, $linkFolder);
echo 'Enlace simbólico creado exitosamente';
```

Súbelo a `public_html`, accede a él desde el navegador y luego elimínalo.

## 🔍 Paso 4: Verificación y Solución de Problemas

### 4.1 Verificar la Instalación

1. Visita tu dominio
2. Deberías ver la página principal del sistema

### 4.2 Problemas Comunes

#### Error 500
- Verificar permisos de carpetas
- Revisar el archivo `.env`
- Verificar logs en `storage/logs/laravel.log`

#### Página en blanco
- Activar temporalmente `APP_DEBUG=true` en `.env`
- Verificar que `APP_KEY` esté configurada

#### Assets no cargan
- Verificar que la carpeta `build` esté en `public_html`
- Revisar la configuración de `APP_URL` en `.env`

### 4.3 Comandos Útiles (si tienes terminal)

```bash
# Regenerar clave de aplicación
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📝 Notas Adicionales

1. **Backups**: Siempre realiza backups antes de actualizar
2. **SSL**: Configura SSL en cPanel y actualiza `APP_URL` a `https://`
3. **Cron Jobs**: Si necesitas tareas programadas, configúralas en cPanel
4. **Email**: Configura los parámetros SMTP en `.env` con los datos de tu hosting

## 🔄 Actualizaciones Futuras

Para actualizar el sitio:

1. Realiza los cambios localmente
2. Compila assets: `npm run build`
3. Sube solo los archivos modificados
4. Limpia cachés en el servidor

---

**¡Listo!** Tu aplicación Laravel debería estar funcionando en cPanel.