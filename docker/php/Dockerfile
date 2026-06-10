FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    gd \
    opcache

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files dulu (biar cache layer optimal)
COPY composer.json composer.lock ./

# Install dependencies dulu
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Baru copy source code
COPY . .

# Fix permission Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Cache Laravel (opsional tapi recommended kalau production build)
RUN php artisan config:clear || true \
    && php artisan cache:clear || true

EXPOSE 9000

CMD ["php-fpm"]
