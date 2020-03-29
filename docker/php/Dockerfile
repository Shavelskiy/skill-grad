ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-fpm AS php

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./conf.d/php.ini $PHP_INI_DIR/conf.d/php.ini
COPY ./remote-xdebug.ini /usr/local/etc/php/conf.d/remote-xdebug.ini

RUN apt-get update \
  && apt-get install -y \
             vim \
             libfreetype6-dev \
             libjpeg62-turbo-dev \
             libmcrypt-dev \
             libpng-dev \
             zlib1g-dev \
             libxml2-dev \
             libzip-dev \
             libonig-dev \
             graphviz \
             libcurl4-openssl-dev \
             pkg-config \
             libpq-dev

RUN docker-php-ext-install pgsql \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install intl \
  && docker-php-ext-install zip \
  && docker-php-ext-install exif \
  && docker-php-ext-install opcache \
  && docker-php-source delete

#RUN pecl install xdebug-2.9.2 \
#    && docker-php-ext-enable xdebug

WORKDIR /application
CMD ["php-fpm"]
