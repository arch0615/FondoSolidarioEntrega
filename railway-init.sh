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
if [ ! -z "$DATABASE_URL" ]; then
    echo "Configurando DATABASE_URL desde Railway..."
    echo "DATABASE_URL=$DATABASE_URL" >> .env
fi

# Verificar que .env fue creado
if [ -f ".env" ]; then
    echo ".env creado exitosamente"
    echo "Primeras 5 líneas de .env:"
    head -5 .env
else
    echo "Error: .env no fue creado"
    exit 1
fi

echo "Configuración de Railway completada"