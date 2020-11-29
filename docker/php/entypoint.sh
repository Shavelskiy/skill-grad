#!/usr/bin/env bash

set -m

service cron start

/usr/local/bin/php /application/bin/console app:chat:start & php-fpm
