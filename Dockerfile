FROM php:8-cli
RUN apt-get update -yqq
RUN apt-get install git -yqq
RUN pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /var/www/

ENTRYPOINT ["docker-php-entrypoint"]
