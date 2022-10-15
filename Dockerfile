FROM php:8.1-cli

RUN set -ex \
  && apt update \
  && apt install bash zip \
  && docker-php-ext-install pdo pdo_mysql \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

