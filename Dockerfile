ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-fpm AS php

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/php.ini $PHP_INI_DIR/conf.d/php.ini
COPY docker/php/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini
COPY docker/php/remote-xdebug.ini $PHP_INI_DIR/conf.d/remote-xdebug.ini

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
             libz-dev \
             libmemcached-dev \
             pkg-config \
             libpq-dev

RUN docker-php-source extract \
  && mkdir -p /usr/src/php/ext/redis \
  && curl -fsSL https://github.com/phpredis/phpredis/archive/4.3.0.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
  && docker-php-ext-configure redis

RUN docker-php-ext-install pgsql \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install intl \
  && docker-php-ext-install zip \
  && docker-php-ext-install exif \
  && docker-php-ext-install opcache \
  && docker-php-ext-install sockets \
  && docker-php-ext-install redis \
  && docker-php-ext-install dom \
  && docker-php-ext-install xml

RUN pecl install memcached
RUN docker-php-ext-enable memcached

RUN pecl install xdebug-2.9.2 \
    && docker-php-ext-enable xdebug

RUN docker-php-source delete

RUN apt-get update \
  && apt-get install -y \
             xvfb \
             libfontconfig \
             wkhtmltopdf

WORKDIR /application
CMD ["php-fpm"]
