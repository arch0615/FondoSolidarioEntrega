@echo off
REM Script de deployment para cPanel - Fondo Solidario JAEC
REM Este script prepara tu proyecto Laravel para ser subido a cPanel

echo.
echo ===================================================
echo   DEPLOYMENT A CPANEL - FONDO SOLIDARIO JAEC
echo ===================================================
echo.

REM Verificar si existe .env
if not exist .env (
    echo ERROR: No se encontro archivo .env
    echo Por favor, crea un archivo .env basado en .env.example
    pause
    exit /b 1
)

REM Paso 1: Instalar dependencias
echo.
echo [1/5] Instalando dependencias de Composer...
echo ------------------------------------------------
call composer install --optimize-autoloader --no-dev

echo.
echo [2/5] Instalando dependencias de NPM...
echo ------------------------------------------------
call npm install

REM Paso 2: Compilar assets
echo.
echo [3/5] Compilando assets para produccion...
echo ------------------------------------------------
call npm run build

REM Paso 3: Optimizar Laravel
echo.
echo [4/5] Optimizando Laravel para produccion...
echo ------------------------------------------------

REM Limpiar caches
call php artisan cache:clear
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear

REM Cachear configuraciones
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache
call php artisan optimize

REM Paso 4: Crear carpeta de deployment
echo.
echo [5/5] Creando carpeta de deployment...
echo ------------------------------------------------

set DEPLOY_DIR=deploy-cpanel

REM Eliminar carpeta anterior si existe
if exist %DEPLOY_DIR% rmdir /s /q %DEPLOY_DIR%

REM Crear estructura de carpetas
mkdir %DEPLOY_DIR%\cpanel-structure\public_html
mkdir %DEPLOY_DIR%\cpanel-structure\laravel

echo Copiando archivos del proyecto...

REM Copiar carpetas principales a laravel
xcopy /E /I /Q app %DEPLOY_DIR%\cpanel-structure\laravel\app
xcopy /E /I /Q bootstrap %DEPLOY_DIR%\cpanel-structure\laravel\bootstrap
xcopy /E /I /Q config %DEPLOY_DIR%\cpanel-structure\laravel\config
xcopy /E /I /Q database %DEPLOY_DIR%\cpanel-structure\laravel\database
xcopy /E /I /Q resources %DEPLOY_DIR%\cpanel-structure\laravel\resources
xcopy /E /I /Q routes %DEPLOY_DIR%\cpanel-structure\laravel\routes
xcopy /E /I /Q storage %DEPLOY_DIR%\cpanel-structure\laravel\storage
xcopy /E /I /Q vendor %DEPLOY_DIR%\cpanel-structure\laravel\vendor

REM Copiar contenido de public a public_html
xcopy /E /I /Q public %DEPLOY_DIR%\cpanel-structure\public_html

REM Copiar archivos individuales
copy .env %DEPLOY_DIR%\cpanel-structure\laravel\
copy artisan %DEPLOY_DIR%\cpanel-structure\laravel\
copy composer.json %DEPLOY_DIR%\cpanel-structure\laravel\
copy composer.lock %DEPLOY_DIR%\cpanel-structure\laravel\

echo Limpiando carpetas de storage...

REM Limpiar storage
del /Q %DEPLOY_DIR%\cpanel-structure\laravel\storage\app\public\* 2>nul
del /Q %DEPLOY_DIR%\cpanel-structure\laravel\storage\framework\cache\data\* 2>nul
del /Q %DEPLOY_DIR%\cpanel-structure\laravel\storage\framework\sessions\* 2>nul
del /Q %DEPLOY_DIR%\cpanel-structure\laravel\storage\framework\views\* 2>nul
del /Q %DEPLOY_DIR%\cpanel-structure\laravel\storage\logs\* 2>nul

echo Creando archivos de configuracion...

REM Crear .htaccess
echo ^<IfModule mod_rewrite.c^> > %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     ^<IfModule mod_negotiation.c^> >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo         Options -MultiViews -Indexes >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     ^</IfModule^> >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo. >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteEngine On >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo. >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     # Handle Authorization Header >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteCond %%{HTTP:Authorization} . >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteRule .* - [E=HTTP_AUTHORIZATION:%%{HTTP:Authorization}] >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo. >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     # Redirect Trailing Slashes If Not A Folder... >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteCond %%{REQUEST_FILENAME} !-d >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteCond %%{REQUEST_URI} (.+)/$ >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteRule ^^ %%1 [L,R=301] >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo. >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     # Send Requests To Front Controller... >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteCond %%{REQUEST_FILENAME} !-d >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteCond %%{REQUEST_FILENAME} !-f >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo     RewriteRule ^^ index.php [L] >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess
echo ^</IfModule^> >> %DEPLOY_DIR%\cpanel-structure\public_html\.htaccess

REM Modificar index.php para cPanel
(
echo ^<?php
echo.
echo use Illuminate\Http\Request;
echo.
echo define('LARAVEL_START', microtime(true^)^);
echo.
echo // Ajustar las rutas para apuntar a la carpeta laravel
echo if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php'^)^) {
echo     require $maintenance;
echo }
echo.
echo require __DIR__.'/../laravel/vendor/autoload.php';
echo.
echo $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
echo.
echo $kernel = $app-^>make(Illuminate\Contracts\Http\Kernel::class^);
echo.
echo $response = $kernel-^>handle(
echo     $request = Request::capture(^)
echo ^)-^>send(^);
echo.
echo $kernel-^>terminate($request, $response^);
) > %DEPLOY_DIR%\cpanel-structure\public_html\index.php

REM Crear archivo para generar storage link
(
echo ^<?php
echo // Archivo temporal para crear enlace simbolico de storage
echo // IMPORTANTE: Eliminar este archivo despues de ejecutarlo
echo.
echo $targetFolder = '../laravel/storage/app/public';
echo $linkFolder = 'storage';
echo.
echo if (file_exists($linkFolder^)^) {
echo     echo "El enlace simbolico ya existe.";
echo } else {
echo     symlink($targetFolder, $linkFolder^);
echo     echo "Enlace simbolico creado exitosamente. Por favor, elimina este archivo.";
echo }
) > %DEPLOY_DIR%\cpanel-structure\public_html\create_storage_link.php

echo.
echo ===================================================
echo   PREPARACION COMPLETADA!
echo ===================================================
echo.
echo INSTRUCCIONES SIGUIENTES:
echo.
echo 1. Los archivos estan listos en: %DEPLOY_DIR%\cpanel-structure\
echo 2. Sube el contenido de "public_html" a la carpeta public_html de tu cPanel
echo 3. Sube el contenido de "laravel" a una carpeta llamada "laravel" 
echo    al mismo nivel que public_html
echo 4. Configura la base de datos en cPanel y actualiza el archivo .env
echo 5. Accede a tudominio.com/create_storage_link.php para crear el enlace de storage
echo 6. Elimina el archivo create_storage_link.php despues de usarlo
echo.
echo NO OLVIDES:
echo - Configurar los permisos 775 para las carpetas storage y bootstrap/cache
echo - Actualizar el archivo .env con las credenciales de produccion
echo - Configurar SSL en cPanel
echo.
echo Presiona cualquier tecla para finalizar...
pause >nul