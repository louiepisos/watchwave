FROM php:8.2-apache

RUN docker-php-ext-install mysqli

WORKDIR /var/www/html
COPY . /var/www/html/

COPY php.ini /usr/local/etc/php/conf.d/watchwave.ini

RUN mkdir -p profile vid \
    && chown -R www-data:www-data /var/www/html/profile /var/www/html/vid \
    && a2enmod rewrite

EXPOSE 80
