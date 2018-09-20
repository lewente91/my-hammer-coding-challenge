FROM php:7.2-fpm

LABEL maintainer="Levente-Balazs Molnar <levente.molnar91@gmail.com>"

RUN apt-get update \
    && apt-get install -y --no-install-recommends libyaml-dev curl git zip unzip ssh \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl channel-update pecl.php.net \
    && pecl install yaml-2.0.0 \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable yaml \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo_mysql

COPY config/php.ini /usr/local/etc/php/php.ini

RUN chown -R www-data /var/www

WORKDIR /var/www/my_hammer
