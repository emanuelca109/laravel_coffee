# Stage 1: Dependencias de Composer (sin scripts para evitar que busque 'artisan')
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts --ignore-platform-reqs

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

# Copiar aplicación completa y assets de Vite
COPY --from=frontend /app /var/www/html

# Copiar binario de composer y generar el autoloader final con package:discover
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize --no-dev

# Copiar configuración de Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Permisos para storage, bootstrap/cache y script de arranque
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && sed -i 's/\r$//' /var/www/html/docker/entrypoint.sh \
    && chmod +x /var/www/html/docker/entrypoint.sh

EXPOSE 80

# Iniciar aplicación mediante entrypoint automatizado
CMD ["/bin/sh", "/var/www/html/docker/entrypoint.sh"]
