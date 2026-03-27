FROM php:8.4-cli

# Install dependencies + intl
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Laravel setup
RUN cp .env.example .env || true
RUN php artisan key:generate || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080