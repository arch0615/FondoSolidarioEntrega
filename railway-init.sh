#!/bin/bash

# Script de inicialización para Railway
echo "Iniciando configuración de Railway..."

# Verificar que .env.example existe
if [ ! -f ".env.example" ]; then
    echo "Error: .env.example no encontrado"
    exit 1
fi

# Copiar .env.example a .env con credenciales hardcodeadas
echo "Copiando .env.example a .env..."
cp .env.example .env

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