FROM php:8.1-cli-alpine
#Env Variable
ENV \
    APP_DIR="/app" \
    APP_PORT="5758"
ENV COMPOSER_ALLOW_SUPPER_USER = 1
#Env Variable
#Copy ENV
COPY . $APP_DIR
COPY .env.example $APP_DIR/.env
#Copy ENV

#MYSQL
#RUN docker-php-ext-install mysql mysqli
#MYSQL

#ext
#RUN apt-get update -y && apt-get install -y sendmail libpng-dev
#RUN docker-php-ext-install gd
#RUN docker-php-ext-install zip
#ext

#Install on Linux
RUN apk add && apk add --no-cache \
    curl \
    php \
    php-opcache \
    php-openssl \
    php-pdo \
    php-gd \
    php-intl \
    php-xsl \
    php-zip \
    php-json \
    php-phar \
    php-dom \
    && rm -rf /var/cache/apk/*


#Install on Linux

#Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=usr/bin --filename=composer

#Install Composer

# Run Composer
ENV COMPOSER_ALLOW_SUPPERUSER = 1
RUN set -eux
RUN cd $APP_DIR && composer updgrade
RUN cd $APP_DIR && php artisan key:generate
# Run Composer

#EntryPoint
WORKDIR $APP_DIR
#EntryPoint

# Run Laravel
CMD php artisan serve --host=0.0.0.0 --port=$APP_PORT
# Run Laravel

#Exectute port
EXPOSE $APP_PORT
#Exectute port

