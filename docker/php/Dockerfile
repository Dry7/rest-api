FROM php:7.4.1-fpm-alpine3.10

RUN apk add --no-cache $PHPIZE_DEPS postgresql-dev \
    && apk add --no-cache libpq \
    && pecl install xdebug-2.9.0 \
    && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer

RUN addgroup -S rest-api && adduser -S rest-api -G rest-api -u 1000

USER rest-api
