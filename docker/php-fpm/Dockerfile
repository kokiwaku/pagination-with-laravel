FROM php:8.3.0-fpm-bullseye

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y libpq-dev \
    git \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo pgsql pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./ini /usr/local/etc/php/conf.d/

WORKDIR /workspace