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

RUN docker-php-ext-install pgsql \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install intl \
  && docker-php-ext-install zip \
  && docker-php-ext-install exif \
  && docker-php-ext-install opcache \
  && docker-php-ext-install sockets \
  && docker-php-ext-install dom \
  && docker-php-ext-install xml

RUN pecl install memcached
RUN docker-php-ext-enable memcached

RUN pecl install xdebug-2.9.2 \
    && docker-php-ext-enable xdebug

RUN docker-php-source delete

RUN apt-get update \
  && apt-get install -y \
             libfontconfig \
             wkhtmltopdf

RUN apt-get update && apt-get -y install cron

COPY docker/php/skill-grad-cron /etc/cron.d/skill-grad-cron
RUN chmod 0644 /etc/cron.d/skill-grad-cron
RUN crontab /etc/cron.d/skill-grad-cron

COPY docker/php/entypoint.sh /scripts/entypoint.sh
RUN chmod 755 /scripts/*.sh

WORKDIR /application

ENTRYPOINT ["/scripts/entypoint.sh"]
