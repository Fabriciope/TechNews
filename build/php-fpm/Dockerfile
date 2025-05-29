FROM php:8.4.6-fpm

ENV DEBIAN_FRONTEND=noninteractive

RUN rm /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini-development

COPY php-fpm.conf /usr/local/etc/php-fpm.conf
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/technews

COPY ./../../. .

RUN apt-get update && apt install -y libzip-dev unzip libcurl4-openssl-dev libonig-dev && \
    pecl install ds && \
    docker-php-ext-install pdo_mysql zip opcache curl mbstring && \
    docker-php-ext-enable pdo_mysql zip opcache curl mbstring ds && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer:2.2.6 /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
# TODO: install composer dependencies
