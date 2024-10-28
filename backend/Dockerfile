FROM php:8.2-fpm

# Установка необходимых зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копирование файлов проекта
WORKDIR /var/www/html
COPY . /var/www/html

# Установка прав
RUN chown -R www-data:www-data /var/www/html

# Установка зависимостей проекта
RUN composer install

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

