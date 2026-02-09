FROM php:8.3-fpm

ARG DEBIAN_FRONTEND=noninteractive

COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libonig-dev \
    unzip \
    zlib1g-dev

RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    mbstring \
    bcmathFROM

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www


