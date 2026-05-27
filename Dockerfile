# Use PHP 8.4 CLI (not FPM)
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD php artisan config:clear; php artisan migrate --force || true; php artisan db:seed --force || true; php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
