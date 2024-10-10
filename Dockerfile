FROM php:8.0-apache
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer require firebase/php-jwt
COPY index.php index.php
COPY index.html index.html
EXPOSE 80
