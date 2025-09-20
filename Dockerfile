FROM composer:2.3 AS composer
FROM php:8.0-alpine

RUN apk --no-cache add icu-dev && \
    docker-php-ext-install intl

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /app/
WORKDIR /app

RUN composer install

ENTRYPOINT [ "/app/bin/console" ]
CMD [ "list" ]
