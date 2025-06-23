#!/bin/bash

# Script de inicialización para Railway
echo "Iniciando configuración de Railway..."

# Verificar que .env.example existe
if [ ! -f ".env.example" ]; then
    echo "Error: .env.example no encontrado"
    exit 1
fi

# Copiar .env.example a .env
echo "Copiando .env.example a .env..."
cp .env.example .env

# Reemplazar variables de entorno de Railway
echo "Reemplazando variables de entorno de Railway..."

# Reemplazar variables de base de datos
if [ ! -z "$DATABASE_HOST" ]; then
    sed -i "s/\${DATABASE_HOST}/$DATABASE_HOST/g" .env
    echo "DATABASE_HOST configurado: $DATABASE_HOST"
fi

if [ ! -z "$DATABASE_PORT" ]; then
    sed -i "s/\${DATABASE_PORT}/$DATABASE_PORT/g" .env
    echo "DATABASE_PORT configurado: $DATABASE_PORT"
fi

if [ ! -z "$DATABASE_NAME" ]; then
    sed -i "s/\${DATABASE_NAME}/$DATABASE_NAME/g" .env
    echo "DATABASE_NAME configurado: $DATABASE_NAME"
fi

if [ ! -z "$DATABASE_USER" ]; then
    sed -i "s/\${DATABASE_USER}/$DATABASE_USER/g" .env
    echo "DATABASE_USER configurado: $DATABASE_USER"
fi

if [ ! -z "$DATABASE_PASSWORD" ]; then
    sed -i "s/\${DATABASE_PASSWORD}/$DATABASE_PASSWORD/g" .env
    echo "DATABASE_PASSWORD configurado"
fi

# Reemplazar URL de Railway
if [ ! -z "$RAILWAY_STATIC_URL" ]; then
    sed -i "s/\${RAILWAY_STATIC_URL}/$RAILWAY_STATIC_URL/g" .env
    echo "RAILWAY_STATIC_URL configurado: $RAILWAY_STATIC_URL"
fi

# Reemplazar DATABASE_URL si existe
if [ ! -z "$DATABASE_URL" ]; then
    echo "DATABASE_URL=$DATABASE_URL" >> .env
    echo "DATABASE_URL agregado desde Railway"
fi

# Verificar que .env fue creado
if [ -f ".env" ]; then
    echo ".env creado exitosamente"
    echo "Configuración de base de datos:"
    grep "DB_" .env | head -6
else
    echo "Error: .env no fue creado"
    exit 1
fi

echo "Configuración de Railway completada"