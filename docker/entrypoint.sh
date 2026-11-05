#!/bin/sh
set -e

echo "==> [Coffee Startup] Configurando permisos y enlaces de almacenamiento..."
php artisan storage:link || true

echo "==> [Coffee Startup] Optimizando configuraciones y rutas de Laravel..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "==> [Coffee Startup] Sincronizando base de datos (migraciones)..."
php artisan migrate --force || echo "==> [Coffee Startup] Advertencia: Las migraciones no se ejecutaron completamente."

echo "==> [Coffee Startup] Sembrando datos iniciales de la tienda (categorías, productos, imágenes)..."
php artisan db:seed --force || echo "==> [Coffee Startup] Advertencia: No se pudieron sembrar datos iniciales."

echo "==> [Coffee Startup] Iniciando servidor Nginx..."
nginx

echo "==> [Coffee Startup] Iniciando PHP-FPM..."
exec php-fpm

