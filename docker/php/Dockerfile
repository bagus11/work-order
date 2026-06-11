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
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        gd \
        opcache \
        mbstring \
        exif \
        pcntl \
        bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files terlebih dahulu untuk memanfaatkan cache Docker
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# Copy seluruh source code
COPY . .

# Set permission Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Laravel optimization (opsional)
RUN php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true

EXPOSE 9000

CMD ["php-fpm"]
