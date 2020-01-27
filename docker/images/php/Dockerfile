ARG TIMEZONE_CUSTOM

FROM php:7.2-fpm-alpine

ARG TIMEZONE_CUSTOM

RUN set -ex \
  	&& apk update \
    && apk add --no-cache git mysql-client curl openssh-client icu libpng freetype libjpeg-turbo postgresql-dev libffi-dev libsodium \
    && apk add --no-cache --virtual build-dependencies icu-dev libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf libsodium-dev\
    && docker-php-source extract \
    && pecl install xdebug redis libsodium \
    && docker-php-ext-enable xdebug redis sodium \
    && docker-php-source delete \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) pdo pgsql pdo_mysql pdo_pgsql intl zip gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && cd  / && rm -fr /src \
    && apk del build-dependencies \
    && rm -rf /tmp/*

RUN echo  -e "[Date]\ndate.timezone = $TIMEZONE_CUSTOM\n" > /usr/local/etc/php/php.ini
WORKDIR /app
STOPSIGNAL SIGQUIT

EXPOSE 9000
CMD ["php-fpm"]