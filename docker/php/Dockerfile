ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-fpm-alpine AS php

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./conf.d/php.ini $PHP_INI_DIR/conf.d/php.ini
COPY ./remote-xdebug.ini /usr/local/etc/php/conf.d/remote-xdebug.ini

RUN apk add --no-cache \
    bash \
    su-exec

RUN apk --update add wget \
  curl \
  git \
  grep \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  imagemagick-dev \
  pcre-dev \
  libtool \
  make \
  autoconf \
  g++ \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor

RUN docker-php-ext-install mysqli pdo pdo_mysql tokenizer xml

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.9.2 \
    && docker-php-ext-enable xdebug

WORKDIR /application
CMD ["php-fpm"]
