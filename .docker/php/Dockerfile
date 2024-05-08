FROM php:8.3-fpm

RUN apt-get update && apt-get install -y nodejs npm
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# COPY . /var/www
# RUN npm install
# RUN npm run build