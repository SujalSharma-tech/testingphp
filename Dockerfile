FROM php:8.0-apache
WORKDIR /var/www/html
COPY index.php index.php
COPY index.html index.html
COPY firebase/ firebase
EXPOSE 80