FROM php:8.0-apache
RUN apt-get update && apt-get install -y zip unzip
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mysqli
RUN composer require firebase/php-jwt
COPY ./src /var/www/html
# COPY index.php index.php
# COPY index.html index.html
# RUN docker-compose up -d
EXPOSE 80
