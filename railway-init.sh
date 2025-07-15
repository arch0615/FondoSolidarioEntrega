#!/bin/bash

# Script de inicialización para Railway
echo "Iniciando configuración de Railway..."

# Limpiar variables de entorno conflictivas
echo "Limpiando TODAS las variables de entorno de Railway..."
unset DATABASE_URL
unset DATABASE_HOST
unset DATABASE_PORT
unset DATABASE_NAME
unset DATABASE_USER
unset DATABASE_PASSWORD
unset DB_HOST
unset DB_PORT
unset DB_DATABASE
unset DB_USERNAME
unset DB_PASSWORD
unset DB_CONNECTION

# Crear .env completamente desde cero con credenciales hardcodeadas
echo "Creando .env hardcodeado desde cero..."
cat > .env << 'EOF'
APP_NAME="Fondo Solidario JAEC"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://web-production-97c9.up.railway.app

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=sql5.freesqldatabase.com
DB_PORT=3306
DB_DATABASE=sql5786391
DB_USERNAME=sql5786391
DB_PASSWORD=Ds1MD1Neh8

BROADCAST_DRIVER=log
CACHE_DRIVER=file
CACHE_PREFIX=fondo_solidario_cache
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Fondo Solidario JAEC"
EOF

# Exportar las variables de entorno correctas para forzarlas
export DB_CONNECTION=mysql
export DB_HOST=sql5.freesqldatabase.com
export DB_PORT=3306
export DB_DATABASE=sql5786391
export DB_USERNAME=sql5786391
export DB_PASSWORD=Ds1MD1Neh8

# Verificar que .env fue creado
if [ -f ".env" ]; then
    echo ".env creado exitosamente desde cero"
    echo "Configuración de base de datos HARDCODEADA:"
    grep "DB_" .env
    echo ""
    echo "Variables de entorno exportadas:"
    echo "DB_HOST=$DB_HOST"
    echo "DB_DATABASE=$DB_DATABASE"
    echo "DB_USERNAME=$DB_USERNAME"
    echo ""
    echo "Variables de entorno limpiadas y reconfiguradas - Laravel usará SOLO este .env"
else
    echo "Error: .env no fue creado"
    exit 1
fi

echo "Configuración de Railway completada con .env hardcodeado y variables exportadas"