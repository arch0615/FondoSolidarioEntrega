#!/bin/bash

# Script de deployment para cPanel - Fondo Solidario JAEC
# Este script prepara tu proyecto Laravel para ser subido a cPanel

echo "🚀 Iniciando preparación para deployment a cPanel..."

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Verificar si existe .env
if [ ! -f .env ]; then
    echo -e "${RED}❌ Error: No se encontró archivo .env${NC}"
    echo "Por favor, crea un archivo .env basado en .env.example"
    exit 1
fi

# Paso 1: Instalar dependencias
echo -e "\n${YELLOW}📦 Instalando dependencias de Composer...${NC}"
composer install --optimize-autoloader --no-dev

echo -e "\n${YELLOW}📦 Instalando dependencias de NPM...${NC}"
npm install

# Paso 2: Compilar assets
echo -e "\n${YELLOW}🔨 Compilando assets para producción...${NC}"
npm run build

# Paso 3: Optimizar Laravel
echo -e "\n${YELLOW}⚡ Optimizando Laravel para producción...${NC}"

# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cachear configuraciones
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Paso 4: Crear carpeta de deployment
echo -e "\n${YELLOW}📁 Creando carpeta de deployment...${NC}"

DEPLOY_DIR="deploy-cpanel"
rm -rf $DEPLOY_DIR
mkdir -p $DEPLOY_DIR

# Copiar archivos necesarios
echo -e "${YELLOW}📋 Copiando archivos del proyecto...${NC}"

# Carpetas principales
cp -r app $DEPLOY_DIR/
cp -r bootstrap $DEPLOY_DIR/
cp -r config $DEPLOY_DIR/
cp -r database $DEPLOY_DIR/
cp -r public $DEPLOY_DIR/
cp -r resources $DEPLOY_DIR/
cp -r routes $DEPLOY_DIR/
cp -r storage $DEPLOY_DIR/
cp -r vendor $DEPLOY_DIR/

# Archivos individuales
cp .env $DEPLOY_DIR/
cp artisan $DEPLOY_DIR/
cp composer.json $DEPLOY_DIR/
cp composer.lock $DEPLOY_DIR/

# Limpiar storage
echo -e "${YELLOW}🧹 Limpiando carpetas de storage...${NC}"
rm -rf $DEPLOY_DIR/storage/app/public/*
rm -rf $DEPLOY_DIR/storage/framework/cache/data/*
rm -rf $DEPLOY_DIR/storage/framework/sessions/*
rm -rf $DEPLOY_DIR/storage/framework/views/*
rm -rf $DEPLOY_DIR/storage/logs/*

# Crear archivo .htaccess para public_html si no existe
echo -e "${YELLOW}📝 Creando archivo .htaccess...${NC}"
cat > $DEPLOY_DIR/public/.htaccess << 'EOL'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOL

# Crear estructura de carpetas para cPanel
echo -e "\n${YELLOW}📂 Organizando para estructura de cPanel...${NC}"
mkdir -p $DEPLOY_DIR/cpanel-structure/public_html
mkdir -p $DEPLOY_DIR/cpanel-structure/laravel

# Mover contenido de public a public_html
cp -r $DEPLOY_DIR/public/* $DEPLOY_DIR/cpanel-structure/public_html/

# Mover el resto a carpeta laravel
mv $DEPLOY_DIR/app $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/bootstrap $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/config $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/database $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/resources $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/routes $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/storage $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/vendor $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/.env $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/artisan $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/composer.json $DEPLOY_DIR/cpanel-structure/laravel/
mv $DEPLOY_DIR/composer.lock $DEPLOY_DIR/cpanel-structure/laravel/

# Modificar index.php para cPanel
echo -e "${YELLOW}🔧 Modificando index.php para cPanel...${NC}"
cat > $DEPLOY_DIR/cpanel-structure/public_html/index.php << 'EOL'
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
EOL

# Crear archivo para generar storage link
echo -e "${YELLOW}🔗 Creando script para storage link...${NC}"
cat > $DEPLOY_DIR/cpanel-structure/public_html/create_storage_link.php << 'EOL'
<?php
// Archivo temporal para crear enlace simbólico de storage
// IMPORTANTE: Eliminar este archivo después de ejecutarlo

$targetFolder = '../laravel/storage/app/public';
$linkFolder = 'storage';

if (file_exists($linkFolder)) {
    echo "El enlace simbólico ya existe.";
} else {
    symlink($targetFolder, $linkFolder);
    echo "Enlace simbólico creado exitosamente. Por favor, elimina este archivo.";
}
EOL

# Limpiar carpetas temporales
rm -rf $DEPLOY_DIR/public

echo -e "\n${GREEN}✅ ¡Preparación completada!${NC}"
echo -e "\n${YELLOW}📋 Instrucciones siguientes:${NC}"
echo "1. Los archivos están listos en la carpeta: ${GREEN}$DEPLOY_DIR/cpanel-structure/${NC}"
echo "2. Sube el contenido de ${GREEN}public_html${NC} a la carpeta public_html de tu cPanel"
echo "3. Sube el contenido de ${GREEN}laravel${NC} a una carpeta llamada 'laravel' al mismo nivel que public_html"
echo "4. Configura la base de datos en cPanel y actualiza el archivo .env"
echo "5. Accede a ${GREEN}tudominio.com/create_storage_link.php${NC} para crear el enlace de storage"
echo "6. Elimina el archivo create_storage_link.php después de usarlo"
echo -e "\n${YELLOW}⚠️  No olvides:${NC}"
echo "- Configurar los permisos 775 para las carpetas storage y bootstrap/cache"
echo "- Actualizar el archivo .env con las credenciales de producción"
echo "- Configurar SSL en cPanel"
echo -e "\n${GREEN}¡Buena suerte con tu deployment! 🚀${NC}"