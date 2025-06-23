#!/bin/bash

# Script de inicialización para Railway
echo "Iniciando configuración de Railway..."

# Verificar que .env.example existe
if [ ! -f ".env.example" ]; then
    echo "Error: .env.example no encontrado"
    exit 1
fi

# Limpiar variables de entorno conflictivas
echo "Limpiando variables de entorno de Railway..."
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

# Copiar .env.example a .env con credenciales hardcodeadas
echo "Copiando .env.example a .env..."
cp .env.example .env

# Verificar que .env fue creado
if [ -f ".env" ]; then
    echo ".env creado exitosamente"
    echo "Configuración de base de datos desde .env:"
    grep "DB_" .env | head -6
    echo ""
    echo "Variables de entorno limpiadas - Laravel usará solo .env"
else
    echo "Error: .env no fue creado"
    exit 1
fi

echo "Configuración de Railway completada"