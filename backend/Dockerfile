FROM php:8.0.3-fpm-buster

ARG user
ARG uid

WORKDIR /var/www

RUN docker-php-ext-install bcmath pdo_mysql

RUN apt-get update
RUN apt-get install -y git zip unzip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -r -u $uid -g www-data $user
 
RUN chown -R $user /var/www
 
USER $user

EXPOSE 9000