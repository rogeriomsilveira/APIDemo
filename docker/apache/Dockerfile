FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

RUN a2enmod rewrite

RUN service apache2 restart