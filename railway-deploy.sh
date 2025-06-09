#!/bin/bash

# Script de deployment para Railway
echo "🚀 Iniciando deployment de Laravel..."

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js
echo "📦 Instalando dependencias de Node.js..."
npm ci

# Construir assets
echo "🔨 Construyendo assets..."
npm run build

# Generar clave de aplicación si no existe
echo "🔑 Configurando clave de aplicación..."
php artisan key:generate --force

# Optimizar configuración
echo "⚡ Optimizando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders (solo en primera instalación)
if [ "$RAILWAY_STATIC_URL" != "" ]; then
    echo "🌱 Ejecutando seeders..."
    php artisan db:seed --force
fi

echo "✅ Deployment completado!"