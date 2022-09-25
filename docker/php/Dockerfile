FROM php:fpm-alpine

RUN apk --update --no-cache add git bash autoconf g++ make
RUN git config --global --add safe.directory /var/www/current

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/current

WORKDIR /var/www/current

CMD composer install ; php-fpm

EXPOSE 9000
