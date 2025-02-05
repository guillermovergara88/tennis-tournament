FROM php:8.1-fpm

# Instalar dependencias del sistema, incluyendo libsqlite3-dev
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip \
    git

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar e instalar dependencias de Composer
COPY . .
RUN composer install

# Instalar la extensión PDO SQLite
RUN docker-php-ext-install pdo_sqlite

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]

EXPOSE 9000
