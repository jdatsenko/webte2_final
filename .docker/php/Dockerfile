FROM php:8.3-fpm

RUN apt update -y && apt upgrade -y
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli