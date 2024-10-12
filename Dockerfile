FROM php:8.0-apache
RUN apt-get update && apt-get install -y zip unzip
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql
RUN composer require firebase/php-jwt
COPY ./src /var/www/html
# COPY index.php index.php
# COPY index.html index.html
EXPOSE 80
