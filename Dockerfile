FROM composer:2.3 AS composer
FROM php:8.0-alpine

RUN apk --no-cache add openssl-dev imap-dev gnupg icu-dev && \
    docker-php-ext-configure imap --with-imap --with-imap-ssl && \
    docker-php-ext-install imap intl && \
    wget -O phive.phar "https://phar.io/releases/phive.phar" && \
    wget -O phive.phar.asc "https://phar.io/releases/phive.phar.asc" && \
    gpg --keyserver hkps://keys.openpgp.org --recv-keys 0x6AF725270AB81E04D79442549D8A98B29B2D5D79 && \
    gpg --verify phive.phar.asc phive.phar && \
    rm phive.phar.asc && \
    chmod +x phive.phar && \
    mv phive.phar /usr/local/bin/phive

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /app/
WORKDIR /app

RUN composer install && \
    phive install --force-accept-unsigned --trust-gpg-keys 0xE82B2FB314E9906E
