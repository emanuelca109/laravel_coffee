# Stage 1: Dependencias de Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

# Stage 2: Compilación de Vite (Frontend)
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci || npm install
COPY . .
COPY --from=vendor /app/vendor ./vendor
RUN npm run build

# Stage 3: Imagen de Producción (PHP 8.3 FPM + Nginx)
FROM php:8.3-fpm-alpine

# Instalar Nginx y dependencias de sistema
RUN apk add --no-cache \
    nginx \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    ca-certificates

# Extensiones de PHP requeridas por Laravel y TiDB
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql bcmath gd zip opcache

WORKDIR /var/www/html

# Copiar aplicación y assets compilados
COPY --from=frontend /app /var/www/html

# Copiar configuración de Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Permisos para storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Iniciar Nginx y PHP-FPM con optimizaciones de Laravel
CMD sh -c "php artisan storage:link || true && php artisan config:cache && php artisan route:cache && php artisan view:cache && nginx && php-fpm"
