# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.4-fpm-buster
ARG TIMEZONE

MAINTAINER Makhtar <maxtar.diakhate@gmail.com>
RUN apt-get update && apt-get install -y \
    openssl \
    git \
    zlib1g-dev \
     libicu-dev \
      g++ \
        libzip-dev \
    libjpeg-dev\
     libfreetype6-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

RUN echo "upload_max_filesize = 8M" > /usr/local/etc/php/conf.d/upload_max_filesize.ini
RUN echo "post_max_size = 8M" > /usr/local/etc/php/conf.d/post_max_size.ini
RUN echo "memory_limit = 1024M" > /usr/local/etc/php/conf.d/memory_limit.ini

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN pecl install redis-5.1.1 \
    && pecl install  \
    && docker-php-ext-enable redis

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

USER www-data
WORKDIR /app
