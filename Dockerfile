FROM composer:2.3 AS composer
FROM php:8.0-alpine

RUN apk --no-cache add openssl-dev imap-dev && \
    docker-php-ext-configure imap --with-imap --with-imap-ssl && \
    docker-php-ext-install imap

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /app/

WORKDIR /app

RUN composer install
